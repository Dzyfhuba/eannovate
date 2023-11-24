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
    public function edit()
    {
        return view('students.form');
    }

    public function join()
    {
        Editor::inst(\DB::class);
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

        return redirect()->route('student.index');
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
