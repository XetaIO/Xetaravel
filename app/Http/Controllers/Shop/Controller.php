<?php
namespace Xetaravel\Http\Controllers\Shop;

use Xetaravel\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->removeListElementClasses('breadcrumb');
        $this->breadcrumbs->addCrumb('Shop', route('shop.index'));
    }
}
