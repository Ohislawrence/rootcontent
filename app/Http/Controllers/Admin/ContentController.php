<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\GradeLevel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::with(['user', 'gradeLevel', 'subject'])->latest()->get();
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('admin.contents.create', compact('gradeLevels', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt,ppsx,zip|max:20480', // 20MB max
            'grade_level_id' => 'required|exists:grade_levels,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('contents', 'public');

        Content::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'grade_level_id' => $request->grade_level_id,
            'subject_id' => $request->subject_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content uploaded successfully.');
    }

    public function show(Content $content)
    {
        return view('admin.contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('admin.contents.edit', compact('content', 'gradeLevels', 'subjects'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt,ppsx,zip|max:10240',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'grade_level_id' => $request->grade_level_id,
            'subject_id' => $request->subject_id,
        ];

        // Handle file update if new file is uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($content->file_path);

            $file = $request->file('file');
            $filePath = $file->store('contents', 'public');

            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $content->update($data);

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        Storage::disk('public')->delete($content->file_path);
        $content->delete();

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content deleted successfully.');
    }

    public function download(Content $content)
    {
        // Track download (if you have download tracking)
        // ContentDownload::create(['content_id' => $content->id, 'user_id' => auth()->id()]);

        return Storage::disk('public')->download($content->file_path, $content->title . '.' . $content->file_type);
    }
}
