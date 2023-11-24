<?php

namespace App\Http\Controllers;

use App\Model\Student;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class StudentController extends Controller
{
    public function index ()
    {
        $students = Student::orderBy('updated_at', 'desc')->get();
        return view('students.view', [
            'students' => $students
        ]);
    }
    public function create ()
    {
        return view('students.form');
    }
    public function edit()
    {
        return view('students.form');
    }
    public function store(Request $request)
    {
        $filename = Uuid::uuid4();
        $request->file('picture')->move(storage_path('picture'), $filename);

        Student::create(array_merge($request->all(), [
            'picture' => $filename,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name
        ]));
        return redirect()->route('student.index');
    }
}
