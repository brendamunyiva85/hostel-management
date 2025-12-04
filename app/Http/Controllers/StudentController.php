<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::query()->with('hostel');

        // Search by name or registration number
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('reg_number', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by hostel
        if ($request->filled('hostel_id')) {
            $query->where('hostel_id', $request->hostel_id);
        }

        $students = $query->latest()->paginate(15)->withQueryString();
        $hostels = Hostel::orderBy('name')->get();

        return view('students.index', compact('students', 'hostels'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $hostels = Hostel::orderBy('name')->get();
        return view('students.create', compact('hostels'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'reg_number'    => 'required|string|unique:students,reg_number',
            'email'         => 'required|email|unique:students,email',
            'phone'         => 'required|string|max:20',
            'hostel_id'     => 'nullable|exists:hostels,id',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
                         ->with('success', 'Student added successfully!');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('hostel');
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the student.
     */
    public function edit(Student $student)
    {
        $hostels = Hostel::orderBy('name')->get();
        return view('students.edit', compact('student', 'hostels'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'reg_number'    => ['required', 'string', Rule::unique('students')->ignore($student->id)],
            'email'         => ['required', 'email', Rule::unique('students')->ignore($student->id)],
            'phone'         => 'required|string|max:20',
            'hostel_id'     => 'nullable|exists:hostels,id',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')
                         ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', 'Student deleted successfully!');
    }

    /**
     * Student Dashboard (My Hostel)
     */
    public function dashboard()
    {
        // Change this line based on how you link User → Student
        // Option 1: You have a student_id in users table
        // $student = auth()->user()->student;

        // Option 2: Match by email (most common)
        $student = Student::where('email', auth()->user()->email)->firstOrFail();

        return view('students.dashboard', compact('student'));
    }
}