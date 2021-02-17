<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 *
 * @property string email
 * @property string address
 * @property string phone
 *
 * @package App
 */
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'address', 'phone'
    ];

    /**
     * Relationship between User and its requested Budgets
     *
     * @return HasMany;
     */
    public function budgets() : HasMany
    {
        return $this->hasMany('App\Budget');
    }
}
