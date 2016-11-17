<?php namespace Modules\Village\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Log;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Services\FileService;

trait MediaSave
{

    private function saveFiles(Model $model, $files)
    {
        if (count($files)) {
            foreach ($files as $file) {
                try {
                    // DI for FileService class.
                    $savedFile = new FileService(app(FileRepository::class), app(FilesystemManager::class));
                    $savedFile = $savedFile->store($file);
                    if (is_object($savedFile)) {
                        $model->files()->attach($savedFile->id, ['imageable_type' => get_class($model), 'zone' => 'media']);
                    }
                } catch (Exeption $e) {
                    Log::critical(__CLASS__ . ' method: ' . __FUNCTION__ . ' File save problem: ' . $e->getMessage());
                    return false;
                }
            }
        }
        return true;
    }
}
