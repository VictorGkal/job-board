<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_post_id',
        'cover_letter',
        'cv_path',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}