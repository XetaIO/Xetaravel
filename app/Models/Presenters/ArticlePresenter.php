<?php
namespace Xetaravel\Models\Presenters;

trait ArticlePresenter
{
    /**
     * The default banner used when there is no banner for the article.
     *
     * @var string
     */
    protected $defaultBanner = '/images/articles/default_banner.jpg';

    /**
     * Get the article url.
     *
     * @return string
     */
    public function getArticleUrlAttribute(): string
    {
        if (!isset($this->slug) || $this->getKey() == null) {
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
}
