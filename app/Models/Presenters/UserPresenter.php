<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Xetaravel\Models\Session;

trait UserPresenter
{
    /**
     * The default avatar used when there is no avatar for the user.
     *
     * @var string
     */
    protected string $defaultAvatar = '/images/avatar.png';

    /**
     * Get the status of the user : online or offline
     *
     * @return Attribute
     */
    protected function online(): Attribute
    {
        $online = Session::expires()->where('user_id', $this->id)->first();

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
    protected function parse($relation, $attribute): string
    {
        if ($relation === null || $relation->{$attribute} === null) {
            return '';
        }

        return $relation->{$attribute};
    }

    /**
     * Get the account first name.
     *
     * @return string
     */
    public function getFirstNameAttribute(): string
    {
        return $this->parse($this->account, 'first_name');
    }

    /**
     * Get the account last name.
     *
     * @return string
     */
    public function getLastNameAttribute(): string
    {
        return $this->parse($this->account, 'last_name');
    }

    /**
     * Get whatever the user has rubies or not.
     *
     * @return boolean
     */
    public function getHasRubiesAttribute(): bool
    {
        return $this->rubies_total > 0;
    }

    /**
     * Get the account full name. Return the username if the user
     * has not set his first name and last name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $fullName = $this->parse($this->account, 'first_name') . ' ' . $this->parse($this->account, 'last_name');

        if (empty(mb_trim($fullName))) {
            return $this->username;
        }

        return $fullName;
    }

    /**
     * Get the account facebook.
     *
     * @return string
     */
    public function getFacebookAttribute(): string
    {
        return $this->parse($this->account, 'facebook');
    }

    /**
     * Get the account twitter.
     *
     * @return string
     */
    public function getTwitterAttribute(): string
    {
        return $this->parse($this->account, 'twitter');
    }

    /**
     * Get the account biography.
     *
     * @return string
     */
    public function getBiographyAttribute(): string
    {
        return $this->parse($this->account, 'biography');
    }

    /**
     * Get the account signature.
     *
     * @return string
     */
    public function getSignatureAttribute(): string
    {
        return $this->parse($this->account, 'signature');
    }

    /**
     * Get the small avatar.
     *
     * @return string
     */
    public function getAvatarSmallAttribute(): string
    {
        return $this->parseMedia('thumbnail.small');
    }

    /**
     * Get the medium avatar.
     *
     * @return string
     */
    public function getAvatarMediumAttribute(): string
    {
        return $this->parseMedia('thumbnail.medium');
    }

    /**
     * Get the big avatar.
     *
     * @return string
     */
    public function getAvatarBigAttribute(): string
    {
        return $this->parseMedia('thumbnail.big');
    }

    /**
     * Get the profile url.
     *
     * @return string
     */
    public function getProfileUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        return route('users.user.show', ['slug' => $this->slug]);
    }
}
