<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'poll_id',
        'type_q'
    ];

    public function polls()
    {
        return $this->belongsTo(Poll::class, 'id', 'poll_id');
    }
}
