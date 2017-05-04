<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Xetaravel\Models\Entities\UserEntity;
use Xetaravel\Models\Presenters\UserPresenter;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    HasRoleAndPermissionContract,
    HasMediaConversions
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        Notifiable,
        SoftDeletes,
        Sluggable,
        HasRoleAndPermission,
        HasMediaTrait,
        UserEntity,
        UserPresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'slug',
        'register_ip',
        'last_login_ip',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_background',
        
        // Media Model
        'avatar_small',
        'avatar_medium',
        'avatar_big',
        
        // Account Model
        'first_name',
        'last_name',
        'biography',
        'signature',
        'facebook',
        'twitter'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy(): string
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
     * Get the account for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne('Xetaravel\Models\Account');
    }

    /**
     * Get the roles for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('Ultraware\Roles\Models\Role');
    }
}
