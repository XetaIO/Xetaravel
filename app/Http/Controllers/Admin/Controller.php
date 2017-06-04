<?php
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

        $this->breadcrumbs = new Breadcrumbs;
        $this->breadcrumbs->setListElementClasses('breadcrumb breadcrumb-inverse bg-inverse');
        $this->breadcrumbs->addCrumb('Dashboard', route('admin.page.index'));
    }
}
