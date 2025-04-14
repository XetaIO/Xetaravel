<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait ArticlePresenter
{
    /**
     * The default banner used when there is no banner for the article.
     *
     * @var string
     */
    protected string $defaultBanner = '/images/articles/default_banner.jpg';

    /**
     * Get the is_display field.
     *
     * @return Attribute
     */
    protected function isDisplay(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !(is_null($this->published_at) || $this->published_at > now())
        );
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
        if (isset($this->getMedia('article')[0])) {
            return $this->getMedia('article')[0]->getUrl($type);
        }

        return $this->defaultBanner;
    }

    /**
     * Get the show url.
     *
     * @return string
     */
    public function getShowUrlAttribute(): string
    {
        if (!isset($this->slug) || $this->getKey() === null) {
            return '';
        }

        return route('blog.article.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }

    /**
     * Get the small avatar.
     *
     * @return string
     */
    public function getArticleBannerAttribute(): string
    {
        return $this->parseMedia('article.banner');
    }
}
