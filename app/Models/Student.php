<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;

class Student extends Model
{
    protected $fillable = ["student_name","class"];
    public function exams()
    {
        return $this -> hasMany(Exam::class);
    }
}
