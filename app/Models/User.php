<?php

namespace App\Models;

use App\Utility\UserUtility;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Eloquence\Behaviours\Sluggable;

class User extends Authenticatable
{
    use Notifiable,
        SoftDeletes,
        Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'slug', 'register_ip', 'last_login_ip', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_background'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy()
    {
        return 'username';
    }

    /**
     * Get the comments for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Get the articles for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    /**
     * Get the porofile background.
     *
     * @return string
     */
    public function getProfileBackgroundAttribute()
    {
        return UserUtility::getProfileBackground();
    }

    /**
     * Return whatever if the user is admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
