<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

trait UserPresenter
{
    /**
     * The default avatar used when there is no avatar for the user.
     *
     * @var string
     */
    protected string $defaultAvatar = '/images/avatar.png';

    /**
     * Get the user's username.
     *
     * @return Attribute
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->trashed() ? 'Deleted' : $value
        );
    }

    /**
     * Get the status of the user : online or offline
     *
     * @return Attribute
     */
    protected function online(): Attribute
    {
        $sessionLifetime = config('session.lifetime') * 60;

        $expirationTime = time() - $sessionLifetime;

        $online = DB::table(config('session.table'))
            ->where('user_id', $this->id)
            ->where('last_activity', '>=', $expirationTime)
            ->first();

        return Attribute::make(
            get: fn () => !is_null($online)
        );
    }

    /**
     * Get the max role level of the user.
     *
     * @return Attribute
     */
    protected function level(): Attribute
    {
        return Attribute::make(
            get: fn () => ($role = $this->roles->sortByDesc('level')->first()) ? $role->level : 0
        );
    }

    /**
     * Parse a media and return it if isset or return the default avatar.
     *
     * @param string $type The type of the media to get.
     *
     * @return string
     */
    protected function parseMedia(string $type): string
    {
        if (isset($this->getMedia('avatar')[0])) {
            return $this->getMedia('avatar')[0]->getUrl($type);
        }

        return $this->defaultAvatar;
    }

    /**
     * Parse an attribute and return its value or empty if null.
     *
     * @param Object|null $relation The relation or the user object.
     *       Can be `$this` or `$this->account` for exemple
     * @param string|null $attribute The attribute to parse.
     *
     * @return string
     */
    protected function parse(?object $relation, ?string $attribute): string
    {
        if ($relation === null || $relation->{$attribute} === null) {
            return '';
        }

        return $relation->{$attribute};
    }

    /**
     * Get the profile url.
     *
     * @return Attribute
     */
    protected function showUrl(): Attribute
    {
        $slug = $this->trashed() ? mb_strtolower($this->username) : $this->slug;

        return Attribute::make(
            get: fn () => route('user.show', ['slug' => $slug])
        );
    }

    /**
     * Get the account facebook.
     *
     * @return Attribute
     */
    protected function facebook(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parse($this->account, 'facebook')
        );
    }

    /**
     * Get the account twitter.
     *
     * @return Attribute
     */
    protected function twitter(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parse($this->account, 'twitter')
        );
    }

    /**
     * Get the account biography.
     *
     * @return Attribute
     */
    protected function biography(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parse($this->account, 'biography')
        );
    }

    /**
     * Get the account signature.
     *
     * @return Attribute
     */
    protected function signature(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parse($this->account, 'signature')
        );
    }

    /**
     * Get the small avatar.
     *
     * @return Attribute
     */
    protected function avatarSmall(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parseMedia('thumbnail.small')
        );
    }

    /**
     * Get the medium avatar.
     *
     * @return Attribute
     */
    protected function avatarMedium(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parseMedia('thumbnail.medium')
        );
    }

    /**
     * Get the big avatar.
     *
     * @return Attribute
     */
    protected function avatarBig(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parseMedia('thumbnail.big')
        );
    }

    /**
     * Get the account first name.
     *
     * @return Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parse($this->account, 'first_name')
        );
    }

    /**
     * Get the account last name.
     *
     * @return Attribute
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->parse($this->account, 'last_name')
        );
    }

    /**
     * Get whatever the user has rubies or not.
     *
     * @return Attribute
     */
    protected function hasRubies(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->rubies_total > 0
        );
    }

    /**
     * Get the account full name. Return the username if the user
     * has not set his first name and last name.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->trashed()) {
                    return $this->username;
                }

                $fullName = $this->parse($this->account, 'first_name') . ' ' . $this->parse($this->account, 'last_name');

                return empty(mb_trim($fullName)) ? $this->username : $fullName;
            }
        );
    }
}
