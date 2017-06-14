<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Presenters\DiscussCategoryPresenter;

class DiscussCategory extends Model
{
    use Sluggable,
        DiscussCategoryPresenter;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'category_url'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy(): string
    {
        return 'title';
    }

    /**
     * Get the conversations for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversations()
    {
        return $this->hasMany(DiscussConversation::class);
    }

    /**
     * Pluck the categories by the given fields and the locked state.
     *
     * @param string $value
     * @param string|null $column
     *
     * @return \Illuminate\Support\Collection
     */
    public static function pluckLocked($value, $column = null): Collection
    {
        if (Auth::user()->hasPermission('manage.discuss.conversations')) {
            return self::pluck($value, $column);
        }

        return self::where('is_locked', false)->pluck($value, $column);
    }
}
