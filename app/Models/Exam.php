<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ["classroom","subject","date"]; 
    public function student()
    {
        return $this -> belongsTo(Student::class);
    }
}
