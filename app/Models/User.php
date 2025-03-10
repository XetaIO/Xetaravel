<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Xetaravel\Models\Presenters\UserPresenter;
use Xetaravel\Notifications\Auth\ResetPassword;
use Xetaravel\Notifications\Auth\VerifyEmail;
use Xetaravel\Observers\UserObserver;

#[ObservedBy([UserObserver::class])]
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, HasMedia, MustVerifyEmailContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasRoles;
    use InteractsWithMedia;
    use MustVerifyEmail;
    use Notifiable;
    use UserPresenter;

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
        'last_login_date',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        'twitter',

        // Session Model
        'online',

        // Role Model
        'level',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_date' => 'datetime',
        ];
    }

    /**
     * Register the related to the Model.
     */
    public function registerMediaConversions(?Media $media = null): void
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
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the articles for the user.
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the account for the user.
     *
     * @return HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }

    /**
     * Get the badges for the user.
     *
     * @return BelongsToMany
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    /**
     * Get the notifications for the user.
     *
     * @return MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('read_at', 'asc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the discuss posts for the user.
     *
     * @return HasMany
     */
    public function discussPosts(): HasMany
    {
        return $this->hasMany(DiscussPost::class);
    }

    /**
     * Get the discuss conversations for the user.
     *
     * @return HasMany
     */
    public function discussConversations(): HasMany
    {
        return $this->hasMany(DiscussConversation::class);
    }

    /**
     * Get the discuss users for the user.
     *
     * @return HasMany
     */
    public function discussUsers(): HasMany
    {
        return $this->hasMany(DiscussUser::class);
    }

    /**
     * Get the discuss logs for the user.
     *
     * @return HasMany
     */
    public function discussLogs(): HasMany
    {
        return $this->hasMany(DiscussLog::class);
    }

    /**
     * Get the rubies for the user.
     *
     * @return HasMany
     */
    public function rubies(): HasMany
    {
        return $this->hasMany(Ruby::class);
    }

    /**
     * Get the experiences for the user.
     *
     * @return HasMany
     */
    public function experiences(): HasMany
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
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * Get the setting for the user.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'model');
    }
}
