<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\HasSlugs;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Presenters\DiscussCategoryPresenter;
use Xetaravel\Observers\DiscussCategoryObserver;

#[ObservedBy([DiscussCategoryObserver::class])]
class DiscussCategory extends Model
{
    use DiscussCategoryPresenter;
    use HasSlugs;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'color',
        'is_locked',
        'level',
        'icon',
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
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_locked' => 'boolean'
        ];
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
     * @return HasMany
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(DiscussConversation::class, 'category_id', 'id');
    }

    /**
     * Get the last conversation of the category.
     *
     * @return HasOne
     */
    public function lastConversation(): HasOne
    {
        return $this->hasOne(DiscussConversation::class, 'id', 'last_conversation_id');
    }

    /**
     * Pluck the categories by the given fields and the locked state.
     *
     * @param string $value
     * @param string|null $column
     *
     * @return Collection
     */
    public static function pluckLocked(string $value, string $column = null): Collection
    {
        if (Auth::user() && Auth::user()->hasPermission('manage.discuss.conversations')) {
            return self::pluck($value, $column);
        }

        return self::where('is_locked', false)->pluck($value, $column);
    }
}
