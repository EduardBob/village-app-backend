<?php namespace Modules\Village\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Log;
use Modules\Media\Entities\File;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository;
use Modules\Media\Services\FileService;

trait MediaSave
{
    private function saveFiles(Model $model, $files)
    {
        global $app;
        //Log::info('Debug: ' . print_r($files, true));
        if (count($files)) {
            // TODO use transaction if possible (now is not possible).
            foreach ($files as $file) {
                $savedFile    = new FileService(new EloquentFileRepository(new File()), new FilesystemManager($app));
                $savedFile    = $savedFile->store($file);
                $model->files()->attach($savedFile->id, ['imageable_type' => get_class($model), 'zone' => 'media']);
            }
        }
    }
}

