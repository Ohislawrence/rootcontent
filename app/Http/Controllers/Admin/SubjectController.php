<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects.
     */
    public function index()
    {
        $subjects = Subject::withCount('contents')
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(15);

        $categories = [
            'core' => 'Core Subjects',
            'science' => 'Science',
            'arts' => 'Arts & Humanities',
            'commercial' => 'Commercial',
            'technical' => 'Technical/Vocational',
            'other' => 'Other Subjects'
        ];

        return view('admin.subjects.index', compact('subjects', 'categories'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        $categories = [
            'core' => 'Core Subjects',
            'science' => 'Science',
            'arts' => 'Arts & Humanities',
            'commercial' => 'Commercial',
            'technical' => 'Technical/Vocational',
            'other' => 'Other Subjects'
        ];

        $gradeLevels = \App\Models\GradeLevel::orderBy('level')->orderBy('order')->get();

        return view('admin.subjects.create', compact('categories', 'gradeLevels'));
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subjects',
            'category' => 'required|string|in:core,science,arts,commercial,technical,other',
            'grade_levels' => 'nullable|array',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Subject::create([
            'name' => $request->name,
            'category' => $request->category,
            'grade_levels' => $request->grade_levels ?? [],
            'description' => $request->description,
            'icon' => $request->icon ?? 'book-open',
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        $subject->load(['contents' => function($query) {
            $query->with(['gradeLevel', 'user'])
                  ->latest()
                  ->limit(10);
        }]);

        $totalViews = optional($subject->resources)->sum('views_count') ?? 0;

        return view('admin.subjects.show', compact('subject','totalViews'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Subject $subject)
    {
        $categories = [
            'core' => 'Core Subjects',
            'science' => 'Science',
            'arts' => 'Arts & Humanities',
            'commercial' => 'Commercial',
            'technical' => 'Technical/Vocational',
            'other' => 'Other Subjects'
        ];

        $gradeLevels = \App\Models\GradeLevel::orderBy('level')->orderBy('order')->get();

        return view('admin.subjects.edit', compact('subject', 'categories', 'gradeLevels'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'category' => 'required|string|in:core,science,arts,commercial,technical,other',
            'grade_levels' => 'nullable|array',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subject->update([
            'name' => $request->name,
            'category' => $request->category,
            'grade_levels' => $request->grade_levels ?? [],
            'description' => $request->description,
            'icon' => $request->icon ?? 'book-open',
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy(Subject $subject)
    {
        // Check if subject has content
        if ($subject->contents()->count() > 0) {
            return redirect()->route('admin.subjects.index')
                ->with('error', 'Cannot delete subject with associated content. Please reassign or delete the content first.');
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }

    /**
     * Bulk delete subjects.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        // Check if any subject has content
        $subjectsWithContent = Subject::whereIn('id', $ids)
            ->has('contents')
            ->count();

        if ($subjectsWithContent > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete subjects with associated content.'
            ], 422);
        }

        Subject::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subjects deleted successfully.'
        ]);
    }

    /**
     * Toggle subject active status.
     */
    public function toggleStatus(Subject $subject)
    {
        $subject->update([
            'is_active' => !$subject->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Subject status updated successfully.');
    }
}
