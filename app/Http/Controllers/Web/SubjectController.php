<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiSubjectRequest;
use App\Http\Resources\CriteriaResource;
use App\Http\Resources\SubjectResource;
use App\Models\Criteria;
use App\Models\Subject;
use Inertia\Inertia;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Subject/Index', [
            'subject' => SubjectResource::collection(Subject::orderBy('created_at', 'desc')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiSubjectRequest $request)
    {
        Subject::create($request->all());
        return redirect()->route('subject.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);

        $data = [
            'subject' => new SubjectResource($subject),
        ];

        return Inertia::render('Subject/Detail', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiSubjectRequest $request, $id)
    {
        $subject = Subject::find($id);
        $subject?->update($request->all());

        return redirect()->route('subject.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.index');
    }
}
