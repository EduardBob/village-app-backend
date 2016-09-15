<?php

namespace Modules\Village\Http\Controllers\Api\V1;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Media\Entities\File;
use Illuminate\Support\Facades\DB;

class FileController extends ApiController
{
    /**
     * Get file by md5 of filepath.
     * @return Response
     */
    public function show($id)
    {
        $path = explode('.', $id);
        $path = $path[0];
        $fileFinal = File::where(DB::raw('md5(path)'), '=', $path);
        if ($fileFinal->first()) {
            $originalFile = $fileFinal->first();
            $fullPath     = base_path('public' . $originalFile->path);
            if (file_exists($fullPath)) {
                header("Cache-Control: public"); // needed for internet explorer
                header("Content-Type: " . $originalFile->mimetype);
                header("Content-Transfer-Encoding: Binary");
                header("Content-Length:" . filesize($fullPath));
                header("Content-Disposition: filename=" . $id);
                readfile($fullPath);
                die();
            }
        }
        header($_SERVER["SERVER_PROTOCOL"] . " 404");
        die("Error: File not found.");
    }
}
