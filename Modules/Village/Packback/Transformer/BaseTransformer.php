<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Media\Entities\File;

class BaseTransformer extends TransformerAbstract
{
    /**
     * @param File  $image
     *
     * @return array|null
     */
    public function getImage(File $image = null)
    {
        if (!$image) return null;

        $formats = config('asgard.media.thumbnails');

        $imageWithFormats = [
            'formats' => []
        ];
        $imageWithFormats['formats']['original'] = $image->path;
        foreach ($formats as $name => $format) {
            $imageWithFormats['formats'][$name] = \Imagy::getThumbnail($image->path, $name);
        }

        return $imageWithFormats;
    }
}