<?php

namespace App\Http\Controllers;

use App\Model\Student;
use App\Model\StudentClass;
use DataTables\Editor;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('updated_at', 'desc')
            ->select(["*", 'id as DT_RowID'])->get();
        // dd(Str::random(80));
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
        return view('students.switch');
    }
    public function edit($id)
    {
        $student = Student::find($id);
        return view('students.switch', [
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

    public function room($id)
    {
        $data = StudentClass::query()
            ->join('classes', 'classes.id', '=', 'student_classes.class_id')
            ->where('student_classes.student_id', $id)
            ->select(['classes.name', 'classes.major', 'classes.created_by', 'classes.created_at'])
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function assignClass(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'class_id' => 'required|integer|exists:classes,id'
            ]);
            $exists = StudentClass::where('student_id', $request->student_id)
            ->where('class_id', $request->class_id)
            ->exists();

            if ($exists) {
                return response([
                    'status' => 'error',
                    'message' => 'Class already assigned.'
                ], 400);
            }

            StudentClass::create([
                'student_id' => $request->student_id,
                'class_id' => $request->class_id,
                'created_by' => auth()->user()->name
            ]);


            return response([
                'status' => 'success',
                'exists' => $exists
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
