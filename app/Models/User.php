<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Xetaravel\Utility\UserUtility;

class User extends Authenticatable implements HasRoleAndPermissionContract, HasMediaConversions
{
    use Notifiable,
        SoftDeletes,
        Sluggable,
        HasRoleAndPermission,
        HasMediaTrait;

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
        'profile_background',
        'avatar_small',
        'avatar_medium',
        'avatar_big'
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
     * Register the related to the Model.
     *
     * @return void
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumbnail.small')
              ->width(100)
              ->height(100)
              ->keepOriginalImageFormat();
        
        $this->addMediaConversion('thumbnail.medium')
              ->width(200)
              ->height(200)
              ->keepOriginalImageFormat();
        
        $this->addMediaConversion('thumbnail.big')
              ->width(300)
              ->height(300)
              ->keepOriginalImageFormat();
        
        $this->addMediaConversion('original')
              ->keepOriginalImageFormat();
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
     * Get the small avatar.
     *
     * @return string
     */
    public function getAvatarSmallAttribute()
    {
        return $this->getMedia('avatar')[0]->getUrl('thumbnail.small');
    }

    /**
     * Get the medium avatar.
     *
     * @return string
     */
    public function getAvatarMediumAttribute()
    {
        return $this->getMedia('avatar')[0]->getUrl('thumbnail.medium');
    }

    /**
     * Get the big avatar.
     *
     * @return string
     */
    public function getAvatarBigAttribute()
    {
        return $this->getMedia('avatar')[0]->getUrl('thumbnail.big');
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
