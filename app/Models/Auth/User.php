<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use App\Models\Auth\Traits\Scope\UserScope;
use Storage;
/**
 * Class User.
 */
class User extends BaseUser
{
    use UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;

    protected $hidden = ['pivot', 'password', 'password_changed_at', 'confirmation_code', 'remember_token'];

    public function properties()
    {
        return $this->hasMany('App\Models\Property', 'user_id', 'id');
    }




}
