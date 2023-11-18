<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiCriteriaRequest;
use App\Http\Resources\CriteriaResource;
use App\Http\Resources\SubjectResource;
use App\Models\Criteria;
use App\Models\Subject;
use Inertia\Inertia;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteria = Criteria::orderBy('created_at', 'desc')->get();
        $criteria->load('subject');
        return Inertia::render('Criteria/Index', [
            'criteria' => CriteriaResource::collection($criteria),
            'subject' => SubjectResource::collection(Subject::orderBy('created_at', 'desc')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiCriteriaRequest $request)
    {
        Criteria::create($request->all());
        return redirect()->route('criteria.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiCriteriaRequest $request, $id)
    {
        $criteria = Criteria::find($id);
        $criteria?->update($request->all());

        return redirect()->route('criteria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->delete();

        return redirect()->route('criteria.index');
    }
}
