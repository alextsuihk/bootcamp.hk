<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [];

    /**
     * Attachment belongs to Course
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Attachment has many (attachment) revisions
     *
     * @return mixed
     */
    public function attachment_revisions()
    {
        return $this->hasMany(AttachmentRevision::class);
    }
}
