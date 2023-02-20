<?php

namespace Xetaravel\Http\Livewire\Discuss;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Xetaravel\Http\Livewire\Traits\WithSorting;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;

class Conversation extends Component
{
    use WithPagination;
    use WithSorting;

    /**
     * The string to search.
     *
     * @var string
     */
    public string $search = '';

    /**
     * Categories used for sorting.
     *
     * @var Collection
     */
    public $categories;

    /**
     * The category selected in the select menu.
     *
     * 0 = all categories
     *
     * @var int
     */
    public $category = 0;

    /**
     * Tell if the categories select menu is open or not.
     *
     * @var bool
     */
    public $open = false;

    /**
     * The number of conversation limited per page.
     *
     * @var null|int
     */
    public $limit = null;

    /**
     * The default number used to limit conversations per page.
     *
     * @var int[]
     */
    public $perPage = [
        10,
        25,
        50
    ];

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'search' => ['except' => '', 'as' => 's'],
        'category' => ['except' => 'all', 'as' => 'c'],
        'limit' => ['as' => 'l']
    ];

    /**
     * The theme used for pagination.
     *
     * @var string
     */
    protected string $paginationTheme = 'tailwind';

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        // Create the categories list for the select and push the `All Categories` into it at the first position.
        $categories = collect();
        $categories->push([
            'id' => 0,
            'icon' => 'fa-solid fa-list',
            'title' => 'All Categories',
            'color' => 'currentColor'
        ]);

        // Get and push all the discuss categories.
        $categoriesAll = DiscussCategory::orderBy('id', 'asc')->get();
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

        // Set the allowed fields.
        $this->allowedFields += ['created_at', 'is_solved', 'is_locked', 'post_count'];

        // Check if the field is allowed before setting it.
        if (!in_array($this->sortField, $this->allowedFields)) {
            $this->sortField = 'created_at';
        }

        // Check if the category exist, else set the all categories.
        if (!$this->categories->has($this->category)) {
            $this->category = 0;
        }
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.discuss.conversation', [
            'conversations' => $this->conversations
        ]);
    }

    /**
     * Create and return the query for the conversations.
     *
     * @return Builder
     */
    public function getConversationsQueryProperty(): Builder
    {
        $search = $this->search;
        $query = DiscussConversation::query()
            ->with(['User', 'Category', 'FirstPost', 'LastPost', 'Users' => function ($query) {
                return $query->with('User')->limit(4);
            }])
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('posts', function ($query) use ($search) {
                        return $query->where('content', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('is_pinned', 'desc');

        // If the `selected` == 0, we display all categories so no condition applied.
        if ($this->category != 0) {
            $query = $query->where('category_id', $this->category);
        }

        return $this->applySorting($query);
    }

    /**
     * Build the query and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getConversationsProperty(): LengthAwarePaginator
    {
        return $this->conversationsQuery->paginate($this->limit);
    }

    /**
     * Toggle open/close the categories select menu.
     *
     * @return void
     */
    public function toggle(): void
    {
        $this->open = !$this->open;
    }

    /**
     * The user selected a category in the menu.
     *
     * @param int $category
     *
     * @return void
     */
    public function select(int $category): void
    {
        $this->category = $category;

        // Check if the category exist, else set the all categories.
        if ($this->categories->has($category) === false) {
            $this->category = 0;
        }

        // We close the menu after selected a category.
        if ($this->open == true) {
            $this->open = false;
        }
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

    /**
     * Filter the field regarding the allowed fields.
     *
     * @param string $field
     *
     * @return void
     */
    public function updatedSortField(string $field): void
    {
        if (!in_array($field, $this->allowedFields)) {
            $this->sortField = 'created_at';
        }
    }
}
