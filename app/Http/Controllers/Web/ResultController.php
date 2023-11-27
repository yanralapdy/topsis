<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiResultRequest;
use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\ResultResource;
use App\Models\Criteria;
use App\Models\Result;
use App\Models\ResultSubjectItem;
use App\Models\ResultSubjectItemNormalizedMatrik;
use App\Models\SubjectItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ResultController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $result = Result::orderBy('created_at', 'desc')->get();
        return Inertia::render('Result/Index', [
            'result' => ResultResource::collection($result),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            DB::BeginTransaction();
            $result = Result::create(['title' => 'Hasil Perhitungan ' . Carbon::now()->format('d-m-Y H:i:s')]);
            $sbjctItm = SubjectItem::all();
            $criteria = Criteria::all();
            $criteriaWithNormalizedValue = [];
            // normalize criteria value with sigma
            foreach ($criteria as $key => $value) {
                $criteriaWithNormalizedValue[$key]['title'] = $value->title;
                $criteriaWithNormalizedValue[$key]['slug'] = $value->slug;
                $criteriaWithNormalizedValue[$key]['value'] = $value->value / $criteria->sum('value');
            }

            $result->resultSubjectItems()->createMany($sbjctItm->toArray());
            $normalizedMatrik = [];
            $valueSigmaCriteria = [
                'price' => 0,
                'rating' => 0,
                'star' => 0,
                'facility' => 0,
            ];


            foreach ($sbjctItm as $key => $value) {
                if ($key == $sbjctItm->count() - 1) {
                    $valueSigmaCriteria['price'] = ($valueSigmaCriteria['price'] + $value->price ** 2) ** 0.5;
                    $valueSigmaCriteria['rating'] = ($valueSigmaCriteria['rating'] + $value->rating ** 2) ** 0.5;
                    $valueSigmaCriteria['star'] = ($valueSigmaCriteria['star'] + $value->star ** 2) ** 0.5;
                    $valueSigmaCriteria['facility'] = ($valueSigmaCriteria['facility'] + $value->facility ** 2) ** 0.5;
                } else {
                    $valueSigmaCriteria['price'] += $value->price ** 2;
                    $valueSigmaCriteria['rating'] += $value->rating ** 2;
                    $valueSigmaCriteria['star'] += $value->star ** 2;
                    $valueSigmaCriteria['facility'] += $value->facility ** 2;
                }
            }

            foreach ($sbjctItm as $key => $value) {
                $normalizedMatrik[$key]['title'] = $value->title;
                $normalizedMatrik[$key]['descriptions'] = $value->descriptions;
                $normalizedMatrik[$key]['facility'] = $value->facility / $valueSigmaCriteria['facility'];
                $normalizedMatrik[$key]['star'] = $value->star / $valueSigmaCriteria['star'];
                $normalizedMatrik[$key]['price'] = $value->price / $valueSigmaCriteria['price'];
                $normalizedMatrik[$key]['rating'] = $value->rating / $valueSigmaCriteria['rating'];
            }

            $result->resultSubjectItemNormalizedMatriks()->createMany($normalizedMatrik);

            $weightedNormalizedMatrik = [];
            $ideal_best = [
                'facility' => null,
                'star' => null,
                'price' => null,
                'rating' => null,
            ];

            $ideal_worst = [
                'facility' => null,
                'star' => null,
                'price' => null,
                'rating' => null,
            ];

            foreach ($normalizedMatrik as $key => $value) {
                $weightedNormalizedMatrik[$key]['title'] = $value['title'];
                $weightedNormalizedMatrik[$key]['descriptions'] = $value['descriptions'];
                $weightedNormalizedMatrik[$key]['facility'] = $value['facility'] *
                    $criteriaWithNormalizedValue[0]['value'];
                $weightedNormalizedMatrik[$key]['star'] = $value['star'] *
                    $criteriaWithNormalizedValue[1]['value'];
                $weightedNormalizedMatrik[$key]['price'] = $value['price'] *
                    $criteriaWithNormalizedValue[2]['value'];
                $weightedNormalizedMatrik[$key]['rating'] = $value['rating'] *
                    $criteriaWithNormalizedValue[3]['value'];

                $ideal_best['facility'] = $ideal_best['facility'] == null ?
                    $weightedNormalizedMatrik[$key]['facility'] :
                    $this->idealBest($weightedNormalizedMatrik[$key]['facility'], $ideal_best['facility']);

                $ideal_best['star'] = $ideal_best['star'] == null ?
                    $weightedNormalizedMatrik[$key]['star'] :
                    $this->idealBest($weightedNormalizedMatrik[$key]['star'], $ideal_best['star']);

                $ideal_best['price'] = $ideal_best['price'] == null ?
                    $weightedNormalizedMatrik[$key]['price'] :
                    $this->idealBest($weightedNormalizedMatrik[$key]['price'], $ideal_best['price'], false);

                $ideal_best['rating'] = $ideal_best['rating'] == null ?
                    $weightedNormalizedMatrik[$key]['rating'] :
                    $this->idealBest($weightedNormalizedMatrik[$key]['rating'], $ideal_best['rating']);

                $ideal_worst['facility'] = $ideal_worst['facility'] == null ?
                    $weightedNormalizedMatrik[$key]['facility'] :
                    $this->idealWorst($weightedNormalizedMatrik[$key]['facility'], $ideal_worst['facility']);

                $ideal_worst['star'] = $ideal_worst['star'] == null ?
                    $weightedNormalizedMatrik[$key]['star'] :
                    $this->idealWorst($weightedNormalizedMatrik[$key]['star'], $ideal_worst['star']);

                $ideal_worst['price'] = $ideal_worst['price'] == null ?
                    $weightedNormalizedMatrik[$key]['price'] :
                    $this->idealWorst($weightedNormalizedMatrik[$key]['price'], $ideal_worst['price'], false);

                $ideal_worst['rating'] = $ideal_worst['rating'] == null ?
                    $weightedNormalizedMatrik[$key]['rating'] :
                    $this->idealWorst($weightedNormalizedMatrik[$key]['rating'], $ideal_worst['rating']);
            }

            $result->resultCriterias()->createMany([
                array_merge($criteriaWithNormalizedValue[0], [
                    'ideal_best_value' => $ideal_best['facility'],
                    'ideal_worst_value' => $ideal_worst['facility'],
                ]),
                array_merge($criteriaWithNormalizedValue[1], [
                    'ideal_best_value' => $ideal_best['star'],
                    'ideal_worst_value' => $ideal_worst['star'],
                ]),
                array_merge($criteriaWithNormalizedValue[2], [
                    'ideal_best_value' => $ideal_best['price'],
                    'ideal_worst_value' => $ideal_worst['price'],
                ]),
                array_merge($criteriaWithNormalizedValue[3], [
                    'ideal_best_value' => $ideal_best['rating'],
                    'ideal_worst_value' => $ideal_worst['rating'],
                ]),
            ]);

            foreach ($weightedNormalizedMatrik as $key => $value) {
                $weightedNormalizedMatrik[$key]['si_plus'] = (($value['facility'] - $ideal_best['facility']) ** 2 +
                    ($value['star'] - $ideal_best['star']) ** 2 +
                    ($value['price'] - $ideal_best['price']) ** 2 +
                    ($value['rating'] - $ideal_best['rating']) ** 2) ** 0.5;

                $weightedNormalizedMatrik[$key]['si_min'] = (($value['facility'] - $ideal_worst['facility']) ** 2 +
                    ($value['star'] - $ideal_worst['star']) ** 2 +
                    ($value['price'] - $ideal_worst['price']) ** 2 +
                    ($value['rating'] - $ideal_worst['rating']) ** 2) ** 0.5;

                $weightedNormalizedMatrik[$key]['pi'] = $weightedNormalizedMatrik[$key]['si_min'] /
                    ($weightedNormalizedMatrik[$key]['si_min'] + $weightedNormalizedMatrik[$key]['si_plus']);
            }

            $result->resultSubjectItemWeightedNormalizedMatriks()->createMany($weightedNormalizedMatrik);

            DB::commit();
            return redirect()->route('result.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $result = Result::findOrFail($id);

        $data = [
            'result' => new ResultResource($result),
        ];

        return Inertia::render('Result/Detail', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiResultRequest $request, $id)
    {
        $result = Result::find($id);
        $result?->update($request->all());

        return redirect()->route('result.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return redirect()->route('result.index');
    }

    private function idealBest($newValue, $currentValue, $beneficial = true)
    {
        if ($beneficial) {
            return $newValue > $currentValue ? $newValue : $currentValue;
        }

        return $newValue < $currentValue ? $newValue : $currentValue;
    }

    private function idealWorst($newValue, $currentValue, $beneficial = true)
    {
        if ($beneficial) {
            return $newValue < $currentValue ? $newValue : $currentValue;
        }

        return $newValue > $currentValue ? $newValue : $currentValue;
    }
}
