<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'form_id',
        'user_id',
        'page_id',
        'user_agent',
        'ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function inputs()
    {
        return $this->belongsToMany(Input::class)->withPivot('value');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
