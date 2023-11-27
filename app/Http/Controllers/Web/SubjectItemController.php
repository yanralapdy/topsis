<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiSubjectItemRequest;
use App\Http\Resources\SubjectItemResource;
use App\Models\SubjectItem;
use Inertia\Inertia;

class SubjectItemController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjectItem = SubjectItem::orderBy('created_at', 'desc')->get();
        return Inertia::render('SubjectItem/Index', [
            'subjectItem' => SubjectItemResource::collection($subjectItem),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiSubjectItemRequest $request)
    {
        SubjectItem::create($request->all());
        return redirect()->route('subject-item.index');
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

        return redirect()->route('subject-item.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subjectItem = SubjectItem::findOrFail($id);
        $subjectItem->delete();

        return redirect()->route('subject-item.index');
    }
}
