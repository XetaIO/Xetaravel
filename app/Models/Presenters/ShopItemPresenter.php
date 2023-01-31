<?php

namespace Xetaravel\Models\Presenters;

trait ShopItemPresenter
{
    /**
     * The default banner used when there is no banner for the item.
     *
     * @var string
     */
    protected string $defaultIcon = '/images/shop/default_icon.svg';

    /**
     * Get the icon.
     *
     * @return string
     */
    public function getItemIconAttribute(): string
    {
        return $this->parseMedia('item.icon');
    }

    /**
     * Parse a media and return it if isset or return the default banner.
     *
     * @param string $type The type of the media to get.
     *
     * @return string
     */
    protected function parseMedia(string $type): string
    {
        if (isset($this->getMedia('item')[0])) {
            return $this->getMedia('item')[0]->getFullUrl();
        }

        return $this->defaultIcon;
    }
}
