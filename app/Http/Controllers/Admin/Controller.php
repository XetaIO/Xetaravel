<?php
namespace Xetaravel\Http\Controllers\Admin;

use Creitive\Breadcrumbs\Breadcrumbs;
use Xetaravel\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->setListElement('nav');
        $this->breadcrumbs->setCssClasses('breadcrumb');
        $this->breadcrumbs->addCrumb('Dashboard', route('admin.page.index'));
    }
}
