<?php
namespace Xetaravel\Models\Entities;

use Xetaravel\Utility\UserUtility;

trait UserEntity
{
    /**
     * Get the small avatar.
     *
     * @return string
     */
    public function getAvatarSmallAttribute(): string
    {
        return $this->getMedia('avatar')[0]->getUrl('thumbnail.small');
    }

    /**
     * Get the medium avatar.
     *
     * @return string
     */
    public function getAvatarMediumAttribute(): string
    {
        return $this->getMedia('avatar')[0]->getUrl('thumbnail.medium');
    }

    /**
     * Get the big avatar.
     *
     * @return string
     */
    public function getAvatarBigAttribute(): string
    {
        return $this->getMedia('avatar')[0]->getUrl('thumbnail.big');
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
}
