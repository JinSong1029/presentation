<?php
namespace App\CustomValidators;

use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CustomValidator extends Validator
{
    protected function validateMaxMeg($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'max_meg');

        if ($value instanceof UploadedFile && ! $value->isValid()) {
            return false;
        }

        return $this->getSizeMeg($attribute, $value) <= $parameters[0];
    }
    protected function getSizeMeg($attribute, $value)
    {
        $hasNumeric = $this->hasRule($attribute, $this->numericRules);

        // This method will determine if the attribute is a number, string, or file and
        // return the proper size accordingly. If it is a number, then number itself
        // is the size. If it is a file, we take kilobytes, and for a string the
        // entire length of the string will be considered the attribute size.
        if (is_numeric($value) && $hasNumeric) {
            return Arr::get($this->data, $attribute);
        } elseif (is_array($value)) {
            return count($value);
        } elseif ($value instanceof File) {
            return $value->getSize() / 1024 / 1024;
        }

        return mb_strlen($value);
    }

}
