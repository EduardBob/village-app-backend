<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Media\Entities\File;

class BaseTransformer extends TransformerAbstract
{

    /**
     * @param File $image
     *
     * @return array|null
     */
    public function getImage(File $image = null)
    {
        if (!$image) {
            return null;
        }
        $formats          = config('asgard.media.thumbnails');
        $imageWithFormats = [
          'formats' => []
        ];
        $imageWithFormats['formats']['original'] = '/api/file/'. md5($image->path) . '.' . $image->extension;
        foreach ($formats as $name => $format) {
            $imageWithFormats['formats'][$name] = \Imagy::getThumbnail($image->path, $name);
        }
        $imageWithFormats['formats']['extension'] = $image->extension;
        return $imageWithFormats;
    }

    /**
     * @param File $file
     *
     * @return array|null
     */
    public function getFile(File $file = null)
    {
        if (!$file) {
            return null;
        }
        $image_types = explode(',', config('asgard.media.config.imagetypes'));
        if (in_array($file->extension, $image_types)) {
            return $this->getImage($file);
        }
        $fileWithFormats['formats']['original']  = '/api/file/'. md5($file->path) . '.' . $file->extension;
        $fileWithFormats['formats']['extension'] = $file->extension;
        return $fileWithFormats;
    }
}
