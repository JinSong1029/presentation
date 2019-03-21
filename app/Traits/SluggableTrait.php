<?php

namespace App\Traits;


use App\Exceptions\NoSlugParamsException;

trait SluggableTrait
{
    public static function boot()
    {
        parent::boot();

        static::created(function ($entity) {
            if ( !$entity->sluggable) {
                throw new NoSlugParamsException(get_class($entity) . ' use SluggableTrait but has no sluggable param');
            }
            $stringToSlug                            = $entity->{$entity->sluggable['build_from']};
            $entity->{$entity->sluggable['save_to']} = str_slug($stringToSlug) . '-' . $entity->id;
            $entity->update();

        });
    }
}