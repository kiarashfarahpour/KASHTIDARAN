<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherItem extends Model
{
    public const METHOD_NO_UPDATE       = 0;
    public const METHOD_GET_FILE        = 1;
    public const METHOD_FIND_IN_ELEMENT = 2;
    public const METHOD_GET_CONTENT     = 3;
    public const METHOD_FIND_FROM_LINK  = 4;
    
    protected $fillable = [
        'title',
        'file',
        'url',
        'link',
        'suffix',
        'method',
        'element',
        'duration',
        'site',
        'last_link',
        'last_link_element',
        'content',
        'contents',
        'image_id',
        'sort_order'
    ];

    public function weather()
    {
        return $this->belongsTo(Weather::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    
    /**
     * Serialize contents to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setContentsAttribute($value)
    {
        $this->attributes['contents'] = serialize($value);
    }

    /**
     * @param $contents
     * @return mixed
     */
    public function getContentsAttribute($contents)
    {
        return unserialize($contents);
    }
}
