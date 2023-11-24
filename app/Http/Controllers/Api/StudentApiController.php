<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentApiController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if (count($students)) {
            return response()->json([
                'data' => $students
            ]);
        } else {
            return response()->json([
                'data' => 'not found'
            ]);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'course' => 'required | string | max:255',
            'email' => 'required | string | email | max:255',
            'phone' => 'required | digits:11',
            'address' => 'required | string | max:255',
        ]);

        // return $validator;

        if ($validator->fails()) {
            return response()->json([
                'success' => true,
                'message' => 'Validation Error',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $data = $validator->validated();

        // $data['slug'] = Str::slug($data['title']);

        // if (array_key_exists('photo', $data)) {
        //     $data['photo'] = Storage::putFile('', $data['photo']);
        // }

        Student::create($data);

        return response()->json([
            'data' => $data
        ]);
    }

    public function show($id)
    {

        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'data' => $student
            ]);
        } else {
            return response()->json([
                'data' => 'not found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'course' => 'required | string | max:255',
            'email' => 'required | string | email | max:255',
            'phone' => 'required | digits:11',
            'address' => 'required | string | max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->getMessageBag(),
            ], 422);
        } else {
            $student = Student::find($id);

            if ($student) {

                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Student updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not updated',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {

        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not deleted',
            ], 404);
        }
    }

    public function search($name) {

        // $search = $name->search;

        // dd($search);

        $students = Student::where('name', 'like', '%' . $name . '%')->get();
        // $students = Student::where('name', $name)->get();

        if (count($students)) {
            return response()->json([
                'data' => $students
            ]);
        } else {
            return response()->json([
                'data' => 'not found'
            ]);
        }
    }
}
