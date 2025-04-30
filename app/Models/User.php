<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\HasSlugs;
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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\Fit;
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
    use HasSlugs;
    use InteractsWithMedia;
    use MustVerifyEmail;
    use Notifiable;
    use SoftDeletes;
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
        'show_url',

        // Media Model
        'avatar_small',
        'avatar_medium',
        'avatar_big',

        // Account Model
        'first_name',
        'last_name',
        'full_name',
        'biography',
        'signature',
        'facebook',
        'twitter',

        // Session Model
        //'online',

        // Role Model
        //'level',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'experiences_total' => 'integer',
            'email_verified_at' => 'datetime',
            'last_login_date' => 'datetime',
            'password' => 'hashed',
            'rubies_total' => 'integer',
        ];
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
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail.small')
            ->fit(Fit::Contain, 100, 100)
            ->keepOriginalImageFormat()
            ->nonQueued();

        $this->addMediaConversion('thumbnail.medium')
            ->fit(Fit::Contain, 200, 200)
            ->keepOriginalImageFormat()
            ->nonQueued();

        $this->addMediaConversion('thumbnail.big')
            ->fit(Fit::Contain, 300, 300)
            ->keepOriginalImageFormat()
            ->nonQueued();
    }

    /**
     * Get the comments for the user.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Get the articles for the user.
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(BlogArticle::class);
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
     * Get the setting for the user.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'model');
    }

    /**
     * Get the user that deleted the user.
     *
     * @return HasOne
     */
    public function deletedUser(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'deleted_user_id')->withTrashed();
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
}
