<?php

namespace Xetaravel\View\Components;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class Meta extends Component
{
    /**
     * The meta title.
     *
     * @var string
     */
    public $title;

    /**
     * The meta author.
     *
     * @var string
     */
    public $author;

    /**
     * The meta description.
     *
     * @var string
     */
    public $description;

    /**
     * The meta url.
     *
     * @var string
     */
    public $url;

    /**
     * The meta image.
     *
     * @var string
     */
    public $image;

    /**
     * The meta copyright.
     *
     * @var string
     */
    public $copyright;

    /**
     * Create a new meta component instance.
     *
     * @return void
     */
    public function __construct(
        string $title = null,
        string $author = null,
        string $url = null,
        string $description = null
    ) {
        $this->title = $title ? Str::of($title)->limit(60, '...') . ' - Xetaravel' : config('xetaravel.site.title');
        $this->author = $author ?? config('xetaravel.site.copyright');
        $this->url = $url ?? URL::full();
        $this->description =
            $description ? Str::of(strip_tags($description))->limit(150, '...') : config('xetaravel.site.description');
        $this->copyright = config('xetaravel.site.copyright');
        $this->image = URL::asset('images/logo300x300.png');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.meta');
    }
}
