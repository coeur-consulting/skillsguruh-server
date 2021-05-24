<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['module', 'modules', 'cover_image', 'organization_id', 'course_id', 'facilitator_id'];


    public  function course()
    {
        return $this->belongsTo(Course::class);
    }
    public  function facilitator()
    {
        return $this->belongsTo(Facilitator::class);
    }

    public  function courseoutline()
    {
        return $this->belongsTo(CourseOutline::class);
    }
}
