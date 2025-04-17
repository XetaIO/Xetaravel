<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Admin;

use Xetaravel\Http\Controllers\Controller as BaseController;
use Xety\Breadcrumbs\Breadcrumbs;

class Controller extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

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
                'flex p-3 px-5 bg-base-100 dark:bg-base-300 shadow-md rounded-lg mb-3 truncate'
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
        $this->breadcrumbs->addCrumb(
            '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg> Dashboard',
            route('admin.page.index')
        );
    }
}
