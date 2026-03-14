<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $table = 'courses';

    protected $fillable = ['name'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'students_courses', 'course_id', 'student_id');
    }
}
