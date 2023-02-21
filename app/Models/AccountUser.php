<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountUser extends Model
{
    use HasFactory;

    protected $table = 'account_users';
    protected $fillable = [];

    public function answer()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    public $timestamp = true;
}
