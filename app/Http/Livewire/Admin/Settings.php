<?php

namespace Xetaravel\Http\Livewire\Admin;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Xetaravel\Http\Livewire\Traits\WithCachedRows;
use Xetaravel\Http\Livewire\Traits\WithSorting;
use Xetaravel\Http\Livewire\Traits\WithBulkActions;
use Xetaravel\Http\Livewire\Traits\WithPerPagePagination;
use Xetaravel\Models\Setting;

class Settings extends Component
{
    use WithPagination;
    use WithSorting;
    use WithCachedRows;
    use WithBulkActions;
    use WithPerPagePagination;

    /**
     * The string to search.
     *
     * @var string
     */
    public string $search = '';

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = [
        'sortField' => ['as' => 'f'],
        'sortDirection' => ['as' => 'd'],
        'search' => ['except' => '', 'as' => 's']
    ];

    /**
     * The model used in the component.
     *
     * @var Setting
     */
    public Setting $model;

    /**
     * Used to show the Edit/Create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    /**
     * Used to show the delete modal.
     *
     * @var bool
     */
    public bool $showDeleteModal = false;

    /**
     * Used to set the modal to Create action (true) or Edit action (false).
     * @var bool
     */
    public bool $isCreating = false;

    /**
     * Number of rows displayed on a page.
     * @var int
     */
    public int $perPage = 10;

    public string $slug = '';

    public $type = 'value_bool';
    public $value = '';

    /**
     * The Livewire Component constructor.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->model = $this->makeBlankModel();
    }

    /**
     * Rules used for validating the model.
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'model.name' => 'required|min:5|max:30|unique:settings,name,' . $this->model->id,
            'value' => 'required',
            'type' => 'required|in:' . collect(Setting::TYPES)->keys()->implode(','),
            'model.description' => 'required|min:5|max:150',
            'model.is_deletable' => 'required|boolean',
        ];
    }

    /**
     * Create a blank model and return it.
     *
     * @return Setting
     */
    public function makeBlankModel(): Setting
    {
        return Setting::make();
    }

    /**
     * Generate the slug from the name and assign it to the slug variable.
     *
     * @return void
     */
    public function generateName(): void
    {
        $this->slug = Str::slug($this->model->name, '.');
    }

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.admin.settings', [
            'settings' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = Setting::query()
            ->search('name', $this->search);

        return $this->applySorting($query);
    }

    /**
     * Build the query or get it from the cache and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getRowsProperty(): LengthAwarePaginator
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    public function create(): void
    {
        $this->isCreating = true;
        $this->useCachedRows();

        // Reset the model to a blank model before showing the creating modal.
        if ($this->model->getKey()) {
            $this->model = $this->makeBlankModel();
            $this->value = '';
            $this->type = 'value_bool';
            //Reset the slug too.
            $this->generateName();
        }
        $this->showModal = true;
    }

    /**
     * Set the model (used in modal) to the setting we want to edit.
     *
     * @param Setting $setting The setting id to update.
     * (Livewire will automatically fetch the model by the id)
     *
     * @return void
     */
    public function edit(Setting $setting): void
    {
        $this->isCreating = false;
        $this->useCachedRows();

        // Set the model to the setting we want to edit.
        if ($this->model->isNot($setting)) {
            $this->model = $setting;
            $this->type = $this->model->type;
            $this->value = $this->model->value;
            $this->generateName();
        }
        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->model->name = $this->slug;

        $this->validate();
        $this->model = Setting::castValue($this->value, $this->type, $this->model);

        unset($this->model->type, $this->model->value);

        if ($this->model->save()) {
            $this->fireFlash('save', 'success');
        } else {
            $this->fireFlash('save', 'danger');
        }
        $this->showModal = false;
    }

    /**
     * Display a flash message regarding the action that fire it and the type of the message, then emit an
     * `alert ` event.
     *
     * @param string $action The action that fire the flash message.
     * @param string $type The type of the message, success or danger.
     * @param int $deleteCount If set, the number of rows that has been deleted.
     *
     * @return void
     */
    public function fireFlash(string $action, string $type, int $deleteCount = 0)
    {
        switch ($action) {
            case 'save':
                if ($type == 'success') {
                    session()->flash(
                        'success',
                        $this->isCreating ? "The setting has been created successfully !" :
                            "The setting <b>{$this->model->title}</b> has been edited successfully !"
                    );
                } else {
                    session()->flash('danger', "An error occurred while saving the setting !");
                }
                break;

            case 'delete':
                if ($type == 'success') {
                    session()->flash('success', "<b>{$deleteCount}</b> settings has been deleted successfully !");
                } else {
                    session()->flash('danger', "An error occurred while deleting the settings !");
                }
                break;
        }

        // Emit the alert event to the front so the DIsmiss can trigger the flash message.
        $this->emit('alert');
    }

    /**
     * Get all select rows that are deletable by their id, preparing for deleting them.
     *
     * @return mixed
     */
    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))
            ->where('is_deletable', '=', true);
    }
}
