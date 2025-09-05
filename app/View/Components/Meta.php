<?php

declare(strict_types=1);

namespace Xetaravel\View\Components;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;
use Closure;

class Meta extends Component
{
    /**
     * The title.
     *
     * @var string
     */
    public string $title;

    /**
     * The author.
     *
     * @var string
     */
    public string $author;

    /**
     * The description.
     *
     * @var string
     */
    public string $description;

    /**
     * The url.
     *
     * @var string
     */
    public string $url;

    /**
     * The image.
     *
     * @var string
     */
    public string $image;

    /**
     * The copyright.
     *
     * @var string
     */
    public string $copyright;

    /**
     * The type of content.
     *
     * @var string
     */
    public string $type;

    /**
     * The published time of the article.
     *
     * @var null|string
     */
    public null|string $publishedTime;

    /**
     * The last modified time of the article.
     *
     * @var null|string
     */
    public null|string $modifiedTime;

    /**
     * The author of the article.
     *
     * @var null|string
     */
    public null|string $articleAuthorUrl;

    /**
     * The section of the article.
     *
     * @var null|string
     */
    public null|string $articleSection;

    /**
     * Create a new meta component instance.
     *
     * @return void
     */
    public function __construct(
        string $title = null,
        string $author = null,
        string $url = null,
        string $description = null,
        string $image = null,
        string $type = null,
        string $publishedTime = null,
        string $modifiedTime = null,
        string $articleAuthorUrl = null,
        string $articleSection = null
    ) {
        $this->title = $title ? Str::of($title)->limit(60, '...') . ' - Xetaravel' : config('xetaravel.site.title');
        $this->author = $author ?? config('xetaravel.site.copyright');
        $this->url = $url ?? URL::full();
        $this->description =
            $description ? Str::of(strip_tags($description))->limit(150, '...')->toString() : config('xetaravel.site.description');
        $this->copyright = config('xetaravel.site.copyright');
        $this->image = $image ?? URL::asset('images/logo300x300.png');
        $this->type = $type ?? 'website';
        $this->publishedTime = $publishedTime;
        $this->modifiedTime = $modifiedTime;
        $this->articleAuthorUrl = $articleAuthorUrl;
        $this->articleSection = $articleSection;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render()
    {
        return view('components.meta');
    }
}
