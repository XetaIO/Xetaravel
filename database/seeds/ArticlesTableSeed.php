<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
                'slug' => 'lorem-ipsum-dolor-sit-amet-consectetuer-adipiscing-elit',
                'content' => '**Lorem ipsum** dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.

[http://exemple.com](http://exemple.com)

> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.

Duis autem vel eum iriure *dolor in hendrerit* in vulputate velit esse molestie consequat :&nbsp;


- vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto
- odio dignissim qui blandit praesent luptatum zzril
- delenit augue duis dolore te feugait nulla facilisi

Odio dignissim qui `{!! Markdown::convertToHtml($article->content) !!}` te feugait nulla facilisi. :fr:

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
use Xetaravel\Models\Article;
use Xetaravel\Models\Gates\CommentGate;
use Xetaravel\Models\User;

class Comment extends Model
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
            Article::class
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
        return $this->belongsTo(Article::class);
    }
}
```',
                'comment_count' => 1,
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}
