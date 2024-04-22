<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
    ){}

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFilename);
        $fileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();

        try{
            $file->move($this->getTargetDirectory(),$fileName);
        }catch(FileException $e){
            return '';
        }

        return $fileName;
    }

    public function getTargetDirectory(): string {
        return $this->targetDirectory;
    }

}