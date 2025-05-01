<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadsController extends Controller
{
    /**
     * Download a file.
     *
     * @param string $fileName
     *
     * @return BinaryFileResponse
     */
    public function download(string $fileName)
    {
        $filePath = public_path('files/'.$fileName);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }
}
