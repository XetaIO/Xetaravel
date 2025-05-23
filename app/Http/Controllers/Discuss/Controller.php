<?php

declare(strict_types=1);

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

        $this->breadcrumbs->addCrumb('<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>' .
        ' Discuss', route('discuss.index'));
    }
}
