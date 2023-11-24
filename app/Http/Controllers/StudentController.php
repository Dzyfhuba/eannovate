<?php

namespace App\Http\Controllers;

use App\Model\Student;
use DataTables\Editor;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('updated_at', 'desc')
            ->select(["*", 'id as DT_RowID'])->get();
        // dd($students);
        return view('students.view', [
            'students' => $students
        ]);
    }

    public function json()
    {
        $students = Student::orderBy('updated_at', 'desc')
            ->select(["*", 'id as DT_RowID'])->get();
        return response()->json([
            'data' => $students
        ]);
    }
    public function create()
    {
        return view('students.form');
    }
    public function edit($id)
    {
        $student = Student::find($id);
        return view('students.form', [
            'student' => $student
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:64',
            'email' => 'required|email',
            'age' => 'required|integer|min:0',
            'phone_number' => 'required|min:8|max:16',
            'picture' => 'required|max:2048'
        ]);

        $filename = Uuid::uuid4();
        $request->file('picture')->move(public_path('pictures'), $filename);

        Student::create(array_merge($request->all(), [
            'picture' => $filename,
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name
        ]));

        return redirect()->route('student.index')->with('success', 'Student created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:64',
            'email' => 'required|email',
            'age' => 'required|integer|min:0',
            'phone_number' => 'required|min:8|max:16',
            'picture' => 'max:2048'
        ]);

        $filename = '';
        if ($request->hasFile('picture')) {
            $filename = Uuid::uuid4();
            $request->file('picture')->move(public_path('pictures'), $filename);
        }

        $student = Student::find($id);
        $student->username = $request->username;
        $student->email = $request->email;
        $student->age = $request->age;
        $student->phone_number = $request->phone_number;
        $student->picture = $filename;
        $student->updated_by = auth()->user()->name;
        $student->save();

        return redirect()->route('student.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();

        return response([
            'status' => 'success'
        ]);
    }
}
