<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function getStudent()
    {
        try {
            $data = Student::where('isDelete', 'false')
                ->get();

            if ($data != '[]') {
                return response()
                    ->json([
                        'status' => true,
                        'data' => $data
                    ], 200);
            } else {
                return response()
                    ->json([
                        'status' => false,
                        'data' => 'no data'
                    ], 400);
            }
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e
                ], 500);
        }
    }

    public function getOnlyStudent(string $id)
    {
        try {
            $data = Student::where('stu_id', $id)
                ->where('isDelete', 'false')
                ->get();

            if ($data != '[]') {
                return response()
                    ->json([
                        'status' => true,
                        'data' => $data
                    ], 200);
            } else {
                return response()
                    ->json([
                        'status' => false,
                        'data' => 'no data'
                    ], 400);
            }
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e
                ], 500);
        }
    }

    public function createStudent(Request $request)
    {
        try {
            $filename = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = 'photo' . time() . '.' . $file
                    ->getClientOriginalExtension();
                $file->move(public_path('photo'), $filename);
            }

            $valid = $request->validate([
                'fname' => 'required',
                'lname' => 'required',
                'gender' => 'required',
                'enrollment' => 'required|date',
                'cou_id' => 'integer',
            ]);

            $data = Student::create([
                'photo' => $filename,
                'fname' => $valid['fname'],
                'lname' => $valid['lname'],
                'gender' => $valid['gender'],
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'enrollment' => $valid['enrollment'],
                'cou_id' => $request->cou_id,
                'status' => 'active',
                'isDelete' => 'false',
            ]);

            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e
                ], 400);
        }
    }

    public function updateStudent(Request $request, string $id)
    {
        try {
            $data = Student::findOrFail($id);
            $filename = $data->photo;

            if ($request->hasFile('photo')) {
                $old = public_path('photo/' . $filename);
                File::delete($old);

                $file = $request->file('photo');
                $filename = 'photo' . time() . '.' . $file
                    ->getClientOriginalExtension();
                $file->move(public_path('photo'), $filename);
            }

            $valid = $request->validate([
                'fname' => 'required',
                'lname' => 'required',
                'gender' => 'required',
                'enrollment' => 'required|date',
                'cou_id' => 'integer',
            ]);



            $data->update([
                'photo' => $filename,
                'fname' => $valid['fname'],
                'lname' => $valid['lname'],
                'gender' => $valid['gender'],
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'enrollment' => $valid['enrollment'],
                'cou_id' => $request->cou_id,
                'status' => $request->status,
                'isDelete' => 'false',
            ]);

            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e
                ], 400);
        }
    }

    public function deleteStudent(string $id)
    {
        try {
            $data = Student::findOrFail($id);
            if ($data->isDelete != 'true') {
                $data->update([
                    'isDelete' => 'true',
                ]);
            } else {
                $data->update([
                    'isDelete' => 'false'
                ]);
            }
            return response()->json([
                'status' => true,
                'data' => $data->isDelete,
            ], 200);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e
                        ->__tostring()
                ], 400);
        }
    }

    public function destroyStudent(string $id)
    {
        try {
            $data = Student::findOrFail($id);
            if ($data)
                $data
                    ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Student deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e
                        ->__toString()
                ]);
        }
    }
}
