<?php
namespace Xetaravel\Http\Controllers\Discuss;

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

        $this->breadcrumbs->addCrumb('Discuss', route('discuss.index'));
    }
}
