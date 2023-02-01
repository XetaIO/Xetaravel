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
            'divider' => '<svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns=' .
            '"http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586' .
            ' 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd">' .
            '</path></svg>',
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
        $this->breadcrumbs->addCrumb('<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"' .
        ' xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414' .
        ' 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1' .
        ' 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg> Home', route('page.index'));
    }
}
