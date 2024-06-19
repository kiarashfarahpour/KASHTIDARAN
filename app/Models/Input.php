<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    protected $fillable = [
        'form_id',
        'type',
        'label',
        'placeholder',
        'sort_order',
        'values',
        'rules',
        'options',
    ];

    protected $appends = ['options', 'values', 'rules'];

    protected $casts = [
        'sort_order'  => 'integer',
    ];

    /**
     * The "booting" method of the Field model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort_order', function (Builder $builder) {
            $builder->latest('sort_order');
        });
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class)->withPivot('value');
    }

    /**
     * Serialize options to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize($value);
    }

    /**
     * @param $options
     * @return mixed
     */
    public function getOptionsAttribute($options)
    {
        return unserialize($options);
    }

    /**
     * Serialize values to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setValuesAttribute($value)
    {
        $this->attributes['values'] = serialize($value);
    }

    /**
     * @param $values
     * @return mixed
     */
    public function getValuesAttribute($values)
    {
        return unserialize($values);
    }

    /**
     * Serialize rules to save.
     *
     * @param  string  $value
     * @return void
     */
    public function setRulesAttribute($value)
    {
        $this->attributes['rules'] = serialize($value);
    }

    /**
     * @param $rules
     * @return mixed
     */
    public function getRulesAttribute($rules)
    {
        return unserialize($rules);
    }
}
