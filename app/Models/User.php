<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Xetaravel\Models\Presenters\UserPresenter;
use Xetaravel\Notifications\ResetPasswordNotification;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    HasRoleAndPermissionContract,
    HasMedia
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        Notifiable,
        Sluggable,
        HasRoleAndPermission,
        HasMediaTrait,
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
        'github_id',
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
        'profile_url',

        // Media Model
        'avatar_small',
        'avatar_medium',
        'avatar_big',
        'avatar_primary_color',

        // Account Model
        'first_name',
        'last_name',
        'full_name',
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
        'last_login'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->generateSlug();
        });

        static::deleting(function ($model) {
            foreach ($model->discussPosts as $post) {
                $post->delete();
            }

            foreach ($model->discussUsers as $user) {
                $user->delete();
            }

            foreach ($model->discussConversations as $conversation) {
                $conversation->delete();
            }
        });
    }

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
    public function registerMediaConversions(Media $media = null)
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
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the articles for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the account for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * Get the roles for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Get the badges for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    /**
     * Get the notifications for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
                        ->orderBy('read_at', 'asc')
                        ->orderBy('created_at', 'desc');
    }

    /**
     * Get the discuss posts for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussPosts()
    {
        return $this->hasMany(DiscussPost::class);
    }

    /**
     * Get the discuss conversations for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussConversations()
    {
        return $this->hasMany(DiscussConversation::class);
    }

    /**
     * Get the discuss users for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussUsers()
    {
        return $this->hasMany(DiscussUser::class);
    }

    /**
     * Get the discuss logs for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussLogs()
    {
        return $this->hasMany(DiscussLog::class);
    }

    /**
     * Get the rubies for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rubies()
    {
        return $this->hasMany(Ruby::class);
    }

    /**
     * Get the experiences for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get all permissions from roles.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rolePermissions(): Builder
    {
        $permissionModel = app(config('roles.models.permission'));

        return $permissionModel
            ::select([
                'permissions.*',
                'permission_role.created_at as pivot_created_at',
                'permission_role.updated_at as pivot_updated_at'
            ])
            ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
            ->join('roles', 'roles.id', '=', 'permission_role.role_id')
            ->whereIn('roles.id', $this->getRoles()->pluck('id')->toArray())
            ->orWhere('roles.level', '<', $this->level())
            ->groupBy([
                'permissions.id',
                'permissions.name',
                'permissions.slug',
                'permissions.description',
                'permissions.model',
                'permissions.created_at',
                'permissions.updated_at',
                'permissions.is_deletable',
                'pivot_created_at',
                'pivot_updated_at'
            ]);
    }
}
