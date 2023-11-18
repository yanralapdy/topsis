<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiCriteriaRequest;
use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\CriteriaResource;
use App\Http\Resources\SubjectResource;
use App\Models\Criteria;
use App\Models\Subject;
use App\Models\SubjectItem;
use Inertia\Inertia;

class SubjectItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiSubjectItemRequest $request)
    {
        SubjectItem::create($request->all());
        return redirect()->route('subject.edit', $request->subject_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectItem $subjectItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiSubjectItemRequest $request, $id)
    {
        $subjectItem = SubjectItem::find($id);
        $subjectItem?->update($request->all());

        return redirect()->route('subject.edit', $subjectItem->subject_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subjectItem = SubjectItem::findOrFail($id);
        $subject_id = $subjectItem->subject_id;
        $subjectItem->delete();

        return redirect()->route('subject.edit', $subject_id);
    }
}
