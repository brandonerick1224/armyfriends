<?php

namespace App\Miscellaneous;

use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\BasePathGenerator;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class MediaPathGenerator extends BasePathGenerator implements PathGenerator
{
    /**
     * Get a (unique) base path for the given media.
     *
     * @param \Spatie\MediaLibrary\Media $media
     *
     * @return string
     */
    protected function getBasePath(Media $media)
    {
        // Uploads 10000 files per dir
        $dir  = floor($media->id / 10000);

        return $dir . DIRECTORY_SEPARATOR .$media->getKey();
    }
}
