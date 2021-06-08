<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Models\CourseOutline;
use Illuminate\Http\Resources\Json\JsonResource;

class LibraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'progress' => $this->progress,
            'course_id' => $this->course_id,
            'user_id' => $this->user_id,
            'course' => Course::find($this->course_id)->load('modules', 'courseoutline')

        ];
    }
}
