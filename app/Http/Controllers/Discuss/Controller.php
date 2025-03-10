<?php

namespace Xetaravel\Http\Controllers\Discuss;

use Xetaravel\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('<i class="fa-regular fa-comments mr-2"></i>' .
        ' Discuss', route('discuss.index'));
    }
}
