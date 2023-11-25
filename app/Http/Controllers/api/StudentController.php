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
            $students = Student::query()
                ->select([
                    'id',
                    'username',
                    'age',
                    'phone_number',
                    'picture'
                ])
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
