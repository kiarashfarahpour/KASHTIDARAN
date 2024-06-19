<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public const GUEST  = false;
    public const AUTH   = true;

    protected $fillable = ['user_id', 'name', 'authenticated'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function scopeGuest($query)
    {
        return $query->where('is_auth', self::GUEST);
    }

    public function scopeAuth($query)
    {
        return $query->where('is_auth', self::AUTH);
    }
}
