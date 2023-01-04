<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $propertyImageDirectory;
    private $propertyImagePublicPath;
    private $slugger;

    public function __construct($propertyImageDirectory, $propertyImagePublicPath, SluggerInterface $slugger)
    {
        $this->propertyImageDirectory = $propertyImageDirectory;
        $this->propertyImagePublicPath = $propertyImagePublicPath;
        $this->slugger = $slugger;
    }

    public function uploadPropertyImage(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->propertyImageDirectory, $fileName);
        } catch(FileException $e) {
            throw new FileException('Le fichier n\'a pas pu etre sauvegardé.');
        }

        return $this->propertyImagePublicPath.'/'.$fileName;
    }
}