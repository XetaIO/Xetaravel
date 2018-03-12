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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'color',
        'is_locked',
        'description'
    ];

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

        // Reset the last_conversation_id field and handle the conversations deleting.
        static::deleting(function ($model) {
            $model->last_conversation_id = null;
            $model->save();

            foreach ($model->conversations as $conversation) {
                $conversation->delete();
            }
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
        return $this->hasMany(DiscussConversation::class, 'category_id', 'id');
    }

    /**
     * Get the last conversation of the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastConversation()
    {
        return $this->hasOne(DiscussConversation::class, 'id', 'last_conversation_id');
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
        if (Auth::user() && Auth::user()->hasPermission('manage.discuss.conversations')) {
            return self::pluck($value, $column);
        }

        return self::where('is_locked', false)->pluck($value, $column);
    }
}
