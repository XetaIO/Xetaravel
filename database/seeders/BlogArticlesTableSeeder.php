<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Xetaravel\Models\BlogArticle;

class BlogArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();
        $articles = [
            [
                'user_id' => 1,
                'blog_category_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
                'slug' => 'lorem-ipsum-dolor-sit-amet-consectetuer-adipiscing-elit',
                'content' => '**Lorem ipsum** dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.

[http://exemple.com](http://exemple.com)

> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.

Duis autem vel eum iriure *dolor in hendrerit* in vulputate velit esse molestie consequat :&nbsp;


- vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto
- odio dignissim qui blandit praesent luptatum zzril
- delenit augue duis dolore te feugait nulla facilisi

Odio dignissim qui `{!! Markdown::convert($article->content) !!}` te feugait nulla facilisi. :fr:

* Reworked the Comments UI and added the possibility to delete a BlogComment in Blog https://github.com/XetaIO/Xetaravel/pull/73
* Reworked the Author bloc in Blog to follow the same design as Comments https://github.com/XetaIO/Xetaravel/commit/06e9f79f67cecbca7648dac3d7922fa849803d9a

- [x] Discuss namespace
- [ ] Flood system on Threads and Comments
- [ ] CKEditor on Threads and Comments
- [ ] Tagged User system

Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. :hushed:

| Feugiat | Vulputate |
| ---- | ---- |
| nostrud | lobortis |
| aliquam | molestie |

```php
<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\Gates\CommentGate;
use Xetaravel\Models\User;

class BlogComment extends Model
{
    use Countable,
        CommentGate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        \'article_id\',
        \'user_id\',
        \'content\'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            User::class,
            BlogArticle::class
        ];
    }

    /**
     * Get the user that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the article that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(BlogArticle::class);
    }
}
```',
                'blog_comment_count' => 1,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('blog_articles')->insert($articles);

        // Update avatars
        foreach ($articles as $article) {
            $model = BlogArticle::where('slug', $article['slug'])->first();
            $model->addMedia(public_path('images/articles/default_banner.jpg'))
                ->preservingOriginal()
                ->setName(mb_substr(md5($article['slug']), 0, 10))
                ->setFileName(mb_substr(md5($article['slug']), 0, 10) . '.jpg')
                ->toMediaCollection('article');
        }
    }
}
