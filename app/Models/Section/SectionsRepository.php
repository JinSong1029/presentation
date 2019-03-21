<?php
/**
 * Created by PhpStorm.
 * User: ����
 * Date: 21.09.2015
 * Time: 8:26
 */

namespace App\Models\Section;


use App\Models\Presentation\DefaultSections;
use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;

class SectionsRepository
{
    /**
     * @var Section
     */
    private $section;
    /**
     * @var DefaultSections
     */
    private $defaults;
    /**
     * @var Collection
     */
    private $collection;


    /**
     * SectionsRepository constructor.
     * @param Section $section
     * @param DefaultSections $defaults
     * @param Collection $collection
     */
    public function __construct(Section $section, DefaultSections $defaults, Collection $collection)
    {
        $this->section    = $section;
        $this->defaults   = $defaults;
        $this->collection = $collection;
    }

    public function createSection($name, $ordering)
    {
        $this->section->name     = $name;
        $this->section->ordering = $ordering;
        $this->section->save();

        return $this->section;
    }

    public function copyDefaults()
    {
        $sections = [];

        $defaults = $this->defaults->orderBy('ordering', 'ASC')->get();
//dd($defaults);
        foreach ($defaults as $default) {

            $section = $this->section->create([
                'name'       => $default->name,
                'ordering'   => $default->ordering,
                'additional' => $default->additional,
            ]);

            $this->collection->add($section);
        }

        return $this->collection;
    }

    public function getAll()
    {
        return $this->section->all();
    }
}