<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'students_courses', 'student_id', 'course_id');
    }
}
