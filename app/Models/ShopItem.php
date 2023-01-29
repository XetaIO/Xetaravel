<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\Sluggable;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Presenters\ShopItemPresenter;

class ShopItem extends Model implements HasMedia
{
    use Countable,
        Sluggable,
        ShopItemPresenter,
        HasMentionsTrait,
        InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'content',
        'price',
        'discount',
        'quantity',
        'is_display',
        'start_at',
        'end_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'item_url',

        // Media Model
        'item_icon'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_at',
        'end_at'
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

        // Set the user id to the new item before saving it.
        static::creating(function ($model) {
            $model->user_id = Auth::id();
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
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            User::class,
            ShopCategory::class
        ];
    }

    /**
     * Register the related to the Model.
     *
     * @param Media|null $media
     * @return void
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('item.icon')
                ->width(100)
                ->height(100)
                ->keepOriginalImageFormat();

        $this->addMediaConversion('original')
                ->keepOriginalImageFormat();
    }

    /**
     * Get the category that owns the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shopCategory()
    {
        return $this->belongsTo(ShopCategory::class);
    }

    /**
     * Get the users that owns the items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTomany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if the given user has unlocked this item.
     *
     * @param User $user The user to check.
     *
     * @return bool
     */
    public function hasUser(User $user): bool
    {
        return $this->users()
            ->where('user_id', $user->getKey())
            ->exists();
    }
}
