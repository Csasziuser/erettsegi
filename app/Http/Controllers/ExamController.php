<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\ValidationException;
use App\Models\Exam;


class ExamController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                "student_id" => "integer|required|exists:students,id",
                "classroom" => "string|max:255|required",
                "subject" => "string|max:255|required",
                "date" => "date|required"
            ], [
                "max" => ":attribute nem lehet nagyobb mint :max",
                "required" => ":attribute megadása kötelező",
                "string" => ":attribute mezőnek szöveget kell tartalmaznia",
                "integer" => ":attribute mezőnek számot kell tartalmaznia",
                "date" => ":attribute mezőnek dátumot kell tartalmaznia",
                "exists" => ":attribute nem létezik"
            ], [
                "classroom" => "Osztály",
                "student_id" => "Tanuló azonosító",
                "subject" => "Tantárgy",
                "date" => "Dátum"
            ]);
        } catch (ValidationException $e) {
            return response()->json(["message" => $e->getMessage()], 400, options: JSON_UNESCAPED_UNICODE);
        }
        ;

        $exam = Exam::create([
            "student_id" => $request->student_id,
            "classroom" => $request->classroom,
            "subject" => $request->subject,
            "date" => $request->date
        ]);
        if (!$exam) {
            return response()->json(["Sikertelen adatfelvitel"], 418, options: JSON_UNESCAPED_UNICODE);
        }

        return response()->json(["Sikeresen felvitte az új terembeosztast!"], 418, options: JSON_UNESCAPED_UNICODE);
    }

    public function index()
    {
        $exams = Exam::all();
        $result =[];
        foreach ($exams as $exam) {
            array_push($result, ["student"=>$exam->student->student_name . ' - ' . $exam->student->class,"classroom"=> $exam->classroom,"subject"=>$exam->subject,"date"=>$exam->date,"id"=>$exam->id]);
        }
        return response()->json($result, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request) 

    {
     try {
        $request -> validate([
            "id" => "required|integer|exists:exams,id"
        ]);
        $exam = Exam::findOrFail($request->id);
        if ($exam->delete()) {
            return response()->json(["message"=>"Vizsga törölve"], 200, options:JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(["message"=>"Sikertelen törlés"], 500, options:JSON_UNESCAPED_UNICODE);
        }
     } catch (ValidationException $e) {
        return response()->json(["message"=>$e->getMessage()], 400, options:JSON_UNESCAPED_UNICODE);
     }
    }
}
