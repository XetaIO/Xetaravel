<?php
namespace Xetaravel\Http\Controllers;

use Creitive\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->setListElement('nav');
        $this->breadcrumbs->addCrumb('Home', route('page.index'));
    }
}
