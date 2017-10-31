<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachmentRevision extends Model
{
    protected $guarded = [];

    /**
     * AttachmentRevision belongs to a File
     *
     * @return mixed
     */
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
