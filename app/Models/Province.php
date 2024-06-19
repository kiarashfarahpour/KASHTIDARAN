<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude'];
    
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    
    public function getRouteKeyName()
    {
        return 'code';
    }
}
