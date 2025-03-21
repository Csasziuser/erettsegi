<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate([
                "class"=>"min:2|max:3|string|required",
                "student_name"=>"string|max:255|required"
            ],[
                "max"=>":attribute nem lehet nagyobb mint :max",
                "min"=>":attribute nem lehet kisebb mint :min",
                "required"=>":attribute megadása kötelező",
                "string"=>":attribute mezőnek szöveget kell tartalmaznia"
            ],[
                "class"=>"Osztály",
                "student_name"=>"Tanuló neve"
            ]);
        } catch (ValidationException $e) {
            return response()->json(["message"=>$e->getMessage()], 400, options:JSON_UNESCAPED_UNICODE);
        };
        $student = Student::create(["class"=>$request->class, "student_name"=>$request->student_name]);
        if (!$student) {
            return response()->json(["Sikertelen adatfelvitel"], 418, options:JSON_UNESCAPED_UNICODE);
        }
        return response()->json(["Sikeresen felvitte az új tanulót"], 418, options:JSON_UNESCAPED_UNICODE);
    }

    public function index(){
        $students = Student::all();
        $strippedStudents =[];
        foreach ($students as $s) {
            array_push($strippedStudents, ["student_name"=>$s->student_name,"class"=> $s->class,"id"=>$s->id]);
        }
        

        return response()->json(["students" => $strippedStudents], 200, options:JSON_UNESCAPED_UNICODE);

    }
        
}
