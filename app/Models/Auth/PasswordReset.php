<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset.
 */

class PasswordReset extends Model
{
    protected $primaryKey = 'email';
    public $timestamps = false;
    protected $fillable = [
        'email', 'token'
    ];
}
