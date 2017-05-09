<?php
namespace Xetaravel\Models\Entities;

use Xetaravel\Utility\UserUtility;

trait UserEntity
{
    /**
     * The default avatar used when there is no avatar for the user.
     *
     * @var string
     */
    protected $defaultAvatar = '/images/avatar.png';

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
     * Get the porofile background.
     *
     * @return string
     */
    public function getProfileBackgroundAttribute(): string
    {
        return UserUtility::getProfileBackground();
    }

    protected function parseMedia(string $type): string
    {
        if (isset($this->getMedia('avatar')[0])) {
            return $this->getMedia('avatar')[0]->getUrl($type);
        }

        return $this->defaultAvatar;
    }
}
