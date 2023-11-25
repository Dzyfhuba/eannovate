<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Model\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $classId = $request->query('class');

            $students = Student::query()
                ->select([
                    'id',
                    'username',
                    'age',
                    'phone_number',
                    'picture'
                ])
                ->where(function ($query) use ($classId) {
                    if ($classId) {
                        $query->whereHas('class', function ($query) use ($classId) {
                            $query->where('classes.id', $classId);
                        });
                    }
                })
                ->get();
            $students->load([
                'class' => function ($query) {
                    $query->select([
                        'classes.id',
                        'name',
                        'major',
                    ]);
                }
            ]);

            // delete pivot in students class
            foreach ($students as $student) {
                foreach ($student->class as $class) {
                    unset($class->pivot);
                }
            }
            return response([
                'status' => 200,
                'data' => $students
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
