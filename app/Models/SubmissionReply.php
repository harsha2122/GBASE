<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionReply extends Model
{
    protected $fillable = ['submission_id', 'message', 'sent_email'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
