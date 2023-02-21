<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public $timestamp = true;

    protected $table = 'answers';
    protected $fillable = [
        'user_id',
        'text_answer',
        'position_answer',
        'num_survey'
    ];

    public function AccountUsers()
    {
        return $this->belongsTo(AccountUser::class, 'id', 'user_id');
    }
}
