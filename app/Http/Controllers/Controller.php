<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Xety\Breadcrumbs\Breadcrumbs;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * The current Breadcrumbs instance.
     *
     * @var Breadcrumbs
     */
    protected Breadcrumbs $breadcrumbs;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs([], [
            // Whether to enable or not the `data-position` attribute.
            'position' => false,
            // The divider symbol between the crumbs or `null` to disable it.
            'divider' => '<svg class="h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path></svg>',
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
                'flex p-3 px-5 rounded-lg dark:bg-base-300 border border-gray-200 dark:border-gray-700 truncate'
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
                'text-sm text-gray-400 inline-flex items-center ml-1 font-medium'
            ]
        ]);
        $this->breadcrumbs->addCrumb(
            '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Home',
            route('page.index')
        );
    }
}
