<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

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

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'username' => 'required',
                'age' => 'required',
                'phone_number' => 'required',
                'email' => 'required|email|unique:students,email',
                'class_id' => 'required|array',
                'picture' => 'max:2048|image',
            ]);

            if ($validated->fails()) {
                return response([
                    'status' => 400,
                    'message' => $validated->errors()
                ], 400);
            }

            $filename = '';
            if ($request->hasFile('picture')) {
                $filename = Uuid::uuid4();
                $request->file('picture')->move(public_path('pictures'), $filename);
            }

            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->first();

            Student::create([
                'username' => $request->username,
                'age' => $request->age,
                'phone_number' => $request->phone_number,
                'picture' => $filename,
                'email' => $request->email,
                'created_by' => $user->name,
                'updated_by' => $user->name,
            ])->class()->attach($request->class_id, [
                        'created_by' => $user->name,
                        'created_at' => now(),
                    ]);

            $student = Student::query()
                ->select([
                    'id',
                    'username',
                    'age',
                    'phone_number',
                    'picture'
                ])
                ->where('email', $request->email)
                ->first();

            $student->load([
                'class' => function ($query) {
                    $query->select([
                        'classes.id',
                        'name',
                        'major',
                    ]);
                }
            ]);

            // delete pivot in students class
            foreach ($student->class as $class) {
                unset($class->pivot);
            }

            return response([
                'status' => 201,
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
