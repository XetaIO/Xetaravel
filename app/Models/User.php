<?php
namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Eloquence\Behaviours\Sluggable;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Xetaravel\Utility\UserUtility;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use Notifiable,
        SoftDeletes,
        Sluggable,
        HasRoleAndPermission;

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
        return $this->hasMany('Xetaravel\Models\Comment');
    }

    /**
     * Get the articles for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('Xetaravel\Models\Article');
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
}
