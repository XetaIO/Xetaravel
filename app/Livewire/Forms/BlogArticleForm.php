<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogCategory;
use Throwable;

class BlogArticleForm extends Form
{
    /**
     * The article to update.
     *
     * @var BlogArticle|null
     */
    public ?BlogArticle $blogArticle = null;

    /**
     * The title of the article.
     *
     * @var string|null
     */
    #[Validate('required|min:5')]
    public ?string $title = null;

    /**
     * The category of the article
     *
     * @var int|null
     */
    #[Validate('required|numeric|exists:blog_categories,id')]
    public ?int $blog_category_id = null;

    /**
     * The published date of the article.
     *
     * @var string|null
     */
    #[Validate('nullable|date_format:Y-m-d H:i')]
    public ?string $published_at = null;

    /**
     * The content of the post, only when creating.
     *
     * @var string|null
     */
    #[Validate('required|min:10')]
    public ?string $content = null;

    /**
     * The banner of the article.
     *
     * @var TemporaryUploadedFile|null
     */
    #[Validate('nullable|image|max:10240')]
    public ?TemporaryUploadedFile $banner = null;

    /**
     * The categories used in choice.
     *
     * @var Collection|array
     */
    public Collection|array $categoriesSearchable = [];

    /**
     * Function to store the model.
     *
     * @return BlogArticle
     *
     * @throws Throwable
     */
    public function create(): BlogArticle
    {
        return DB::transaction(function () {
            $properties = [
                'blog_category_id',
                'title',
                'content'
            ];
            if ($this->published_at) {
                $properties[] = 'published_at';
            }

            $blogArticle = BlogArticle::create($this->only($properties));

            $parser = new MentionParser($blogArticle, [
                'regex' => config('mentions.regex')
            ]);
            $content = $parser->parse($blogArticle->content);

            $blogArticle->content = $content;
            $blogArticle->save();

            // Default banner for the article.
            $banner = public_path('images/articles/default_banner.jpg');

            if (!is_null($this->banner)) {
                $banner = $this->banner;
            }

            $blogArticle->clearMediaCollection('article');
            $blogArticle->addMedia($banner)
                ->preservingOriginal()
                ->setName(mb_substr(md5($blogArticle->title), 0, 10))
                ->setFileName(mb_substr(md5($blogArticle->title), 0, 10) . '.' . (is_string($banner) ? 'jpg' : $banner->getClientOriginalExtension()))
                ->toMediaCollection('article');

            return $blogArticle;
        });
    }

    /**
     * Function to update the model.
     *
     * @return BlogArticle
     *
     * @throws Throwable
     */
    public function update(): BlogArticle
    {
        return DB::transaction(function () {
            $this->blogArticle->title = $this->title;
            $this->blogArticle->blog_category_id = $this->blog_category_id;
            $this->blogArticle->published_at = $this->published_at;

            $parser = new MentionParser($this->blogArticle, [
                'regex' => config('mentions.regex')
            ]);
            $content = $parser->parse($this->content);

            $this->blogArticle->content = $content;
            $this->blogArticle->save();

            if (!is_null($this->banner)) {
                $this->blogArticle->clearMediaCollection('article');
                $this->blogArticle->addMedia($this->banner)
                    ->preservingOriginal()
                    ->setName(mb_substr(md5($this->blogArticle->title), 0, 10))
                    ->setFileName(mb_substr(md5($this->blogArticle->title), 0, 10) . '.' . $this->banner->getClientOriginalExtension())
                    ->toMediaCollection('article');
            }

            return $this->blogArticle;
        });
    }

    /**
     * Function to search categories.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchCategories(string $value = ''): void
    {
        $selectedOption = BlogCategory::where('id', $this->blog_category_id)->get();

        $categories = BlogCategory::query()
            ->where('title', 'like', "%$value%");

        $this->categoriesSearchable = $categories->take(10)
            ->orderBy('title')
            ->get()
            ->merge($selectedOption);
    }
}
