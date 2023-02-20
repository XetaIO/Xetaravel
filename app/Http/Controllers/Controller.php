<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Xety\Breadcrumbs\Breadcrumbs;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The current Breadcrumbs instance.
     *
     * @var \Xety\Breadcrumbs\Breadcrumbs
     */
    protected $breadcrumbs;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs([], [
            // Whether to enable or not the `data-position` attribute.
            'position' => false,
            // The divider symbol between the crumbs or `null` to disable it.
            'divider' => '<i class="fa-solid fa-chevron-right mx-2"></i>',
            // The DOM-Element used to generate the divider element.
            'dividerElement' => 'li',
            // Classes applied to the item `dividerElement` element.
            'dividerElementClasses' => [
                'inline-flex items-center'
            ],
            // The DOM-Element used to generate the container element.
            'listRootElement' => 'nav',
            // Classes applied to the main `listElement` container element.
            'listRootElementClasses' => [
                'flex border border-gray-200 p-3 px-5 rounded-lg dark:bg-base-300 dark:border-gray-700 truncate'
            ],
            // The DOM-Element used to generate the container element.
            'listElement' => 'ol',
            // Classes applied to the main `listElement` container element.
            'listElementClasses' => [
                'inline-flex items-center space-x-1 md:space-x-3'
            ],
            // The DOM-Element used to generate the list item.
            'listItemElement' => 'li',
            // Classes applied to the list item `listItemElement` element.
            'listItemElementClasses' => [
                'inline-flex items-center'
            ],
            // The DOM-Element used to generate the list item.
            'listItemLinkElement' => 'a',
            // Classes applied to the list item `listItemElement` element.
            'listItemLinkElementClasses' => [
                'text-sm inline-flex items-center dark:hover:text-white link-hover'
            ],
            // The DOM-Element used to generate the active list item.
            'listActiveElement' => 'li',
            // Classes applied to the active item `listActiveElement` element.
            'listActiveElementClasses' => [
                'text-sm text-gray-400 inline-flex items-center dark:text-gray-500 ml-1 font-medium'
            ]
        ]);
        $this->breadcrumbs->addCrumb('<i class="fa-solid fa-house-chimney mr-2"></i> Home', route('page.index'));
    }
}
