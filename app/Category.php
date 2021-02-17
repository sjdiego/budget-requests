<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property string name
 * @property string description
 * @property string slug
 * @property integer parent_id
 *
 * @package App
 */
class Category extends Model
{
    protected $fillable = [
        'name', 'description', 'slug', 'parent_id'
    ];

    /**
     * Relationship between Category and its Budgets
     *
     * @return HasMany
     */
    public function budgets() : HasMany
    {
        return $this->hasMany('App\Budget');
    }

    /**
     * Relationship between Category and its parent category
     *
     * @return HasOne
     */
    public function parent() : HasOne
    {
        return $this->hasOne('App\Category', 'parent_id');
    }

    /**
     * Relationship between Category and its children categories
     *
     * @return HasMany
     */
    public function children() : HasMany
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
}
