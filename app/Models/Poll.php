<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $table = 'polls';

    protected $fillable = [
        'name_polls',
        'describe',
        'date_start',
        'date_end'
    ];

    public function question()
    {
        return $this->hasMany(Question::class, 'poll_id', 'id');
    }
    
    public $timestamp = true;
}
