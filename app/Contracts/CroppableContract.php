<?php

namespace App\Contracts;


interface CroppableContract
{
    public function getFolder();
    public function getFilename();
    public function getCropSizes();
}