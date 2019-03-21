<?php


namespace App\Models\Images;


use File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageHandler
{

    public function uploadImage(UploadedFile $file, $folder)
    {
        $filename = time() . '-' . clean_string($file->getClientOriginalName());

        if ( !File::exists(base_path('img/' . $folder . '/'))) {
            File::makeDirectory(base_path('img/' . $folder . '/'));
        }
        $path = base_path('img/' . $folder . '/');
        $file->move($path, $filename);

        return $filename;
    }

    public function replaceImage($oldImage, $newImage, $folder)
    {
        $this->deleteImage($oldImage, $folder);

        $filename = $this->uploadImage($newImage, $folder);

        return $filename;
    }

    public function checkForUpdate($object, $image, $folder, $type='image')
    {

        if ($image instanceof UploadedFile) {

            if ( !$object->{$type}) {
                $checkedImage = $this->uploadImage($image, $folder);
            } else {
                \Log::info('no image of type ' . $type);
                \Log::info('image is  ' . $image);
                $checkedImage = $this->replaceImage($object->{$type}, $image, $folder);
            }
        } else {
            $checkedImage = $object->{$type};
        }

        return $checkedImage;

    }

    public function deleteImage($image, $folder)
    {
        if ($image) {
            if (\DB::table($folder)->where('image', '=', $image)->count() < 2) {
                if (File::exists(base_path('img/' . $folder . '/' . $image))) {
                    File::delete(base_path('img/' . $folder . '/' . $image));
                }
            }
        }
    }


}