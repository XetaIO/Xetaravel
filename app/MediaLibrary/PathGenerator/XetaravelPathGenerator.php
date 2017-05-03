<?php
namespace Xetaravel\MediaLibrary\PathGenerator;

use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class XetaravelPathGenerator implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @return string
     */
    public function getPath(Media $media) : string
    {
        return $media->collection_name . '/' . $media->id . '/';
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.

     * @return string
     */
    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media) . 'conversions/';
    }
}
