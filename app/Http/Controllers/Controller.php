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
        $this->breadcrumbs = new Breadcrumbs;
        $this->breadcrumbs->addCrumb('Home', route('page.index'));
    }
}
