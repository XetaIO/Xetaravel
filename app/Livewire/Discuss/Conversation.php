<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Xetaravel\Livewire\Traits\WithCachedRows;
use Xetaravel\Livewire\Traits\WithSorting;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;

class Conversation extends Component
{
    use AuthorizesRequests;
    use Toastable;
    use WithCachedRows;
    use WithSorting;

    /**
     * Categories used for sorting.
     *
     * @var Collection
     */
    public Collection $categories;

    /**
     * The default number used to limit conversations per page.
     *
     * @var int[]
     */
    public array $perPage = [
        10,
        25,
        50
    ];

    /**
     * The field to sort by.
     *
     * @var string
     */
    #[Url(as: 'f', except: 'created_at')]
    public string $sortField = 'created_at';

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    #[Url(as: 'd')]
    public string $sortDirection = 'desc';

    /**
     * The number of conversation limited per page.
     *
     * @var null|int
     */
    #[Url(as: 'l', except: 15)]
    public ?int $limit = null;

    /**
     * The category selected in the select menu.
     *
     * 0 = all categories
     *
     * @var int
     */
    #[Url(as: 'c', except: 0)]
    public int $category = 0;

    /**
     * The string to search.
     *
     * @var string
     */
    #[Url(as: 's', except: '')]
    public string $search = '';

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'post_count',
        'is_locked',
        'is_solved',
        'created_at'
    ];

    /**
     * Tell if the categories select menu is open or not.
     *
     * @var bool
     */
    public $open = false;

    public function mount(): void
    {
        // Create the categories list for the select and push the `All Categories` into it at the first position.
        $categories = collect();
        $categories->push([
            'id' => 0,
            'icon' => 'fas-list',
            'title' => 'All Categories',
            'color' => 'currentColor'
        ]);

        // Get and push all the discuss categories.
        $categoriesAll = DiscussCategory::orderBy('id')->get();
        $categoriesAll->each(function ($item) use ($categories) {
            $categories->push([
                'id' => $item->id,
                'icon' => $item->icon,
                'title' => $item->title,
                'color' => $item->color
            ]);
        });
        // Reorder the collection by `id` key and convert to array.
        $this->categories = $categories->keyBy('id');

        // Add the default perPage setting to the array.
        $this->perPage[] = config('xetaravel.pagination.discuss.conversation_per_page');
        // Re-order the array by `asc`.
        sort($this->perPage);

        // Set the limit to the default config if the limit is not in the array.
        if (!in_array($this->limit, $this->perPage)) {
            $this->limit = config('xetaravel.pagination.discuss.conversation_per_page');
        }

        // Check if the category exist, else set the all categories.
        if (!$this->categories->has($this->category)) {
            $this->category = 0;
        }
    }

    public function render()
    {
        return view('livewire.discuss.conversation', [
            'conversations' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = DiscussConversation::query()
            ->with(['user', 'category', 'firstPost', 'lastPost', 'lastPost.user', 'lastPost.user.account', 'users', 'users.user', 'users.user.account'])
            ->when($this->search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('posts', function ($query) use ($search) {
                        return $query->where('content', 'like', '%' . $search . '%');
                    });
            })
            // If the `category` == 0, we display all categories so no condition applied.
            ->when($this->category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->orderBy('is_pinned', 'desc');

        return $this->applySorting($query);
    }

    /**
     * Build the query and paginate it.
     *
     * @return LengthAwarePaginator
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRowsProperty(): LengthAwarePaginator
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate($this->limit);
        });
    }

    /**
     *  Check the value received by the front if it's a valid value, else set the default value.
     *
     * @param mixed $limit
     *
     * @return void
     */
    public function updatedLimit(int $limit): void
    {
        // Set the limit to the default config if the limit is not in the array.
        // Prevent people that modify the HTML value of the <option> to set a high value.
        if (!in_array($limit, $this->perPage)) {
            $this->limit = config('xetaravel.pagination.discuss.conversation_per_page');
        }
    }
}
