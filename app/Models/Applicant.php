<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicant_id';

    protected $fillable = [
        'user_id',
        'job_id',
        'institute',
        'degree',
        'cgpa',
        'passing_year',
        'experience',
        'applied_date'
    ];

    protected $dates = [
        'applied_date'
    ];

    // Relationship with User (Aspirant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
} 