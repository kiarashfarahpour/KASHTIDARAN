<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const STATUS_DRAFT       = false;
    public const STATUS_PUBLISHED   = true;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image_id',
        'content',
        'css',
        'js',
        'meta_keywords',
        'meta_description',
        'form_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeDraft($query)
    {
        return $query->whereStatus(self::STATUS_DRAFT);
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::STATUS_PUBLISHED);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function delete()
    {
        unlink($this->image->name);
        return parent::delete();
    }
}
