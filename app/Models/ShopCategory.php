<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Xetaravel\Models\Presenters\ShopCategoryPresenter;

class ShopCategory extends Model
{
    use Sluggable,
        ShopCategoryPresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'is_display'
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
    protected static function boot(): void
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
     * Get the shop items for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopItems()
    {
        return $this->hasMany(ShopItem::class);
    }
}
