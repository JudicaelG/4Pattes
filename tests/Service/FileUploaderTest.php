<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class FileUploaderTest extends WebTestCase
{
    private $uploader;

    protected function setUp(): void
    {
        // Crée un double pour l'interface SluggerInterface
        $slugger = $this->createMock(SluggerInterface::class);
        
        // Configure le double pour retourner le même nom de fichier sécurisé
        $slugger->method('slug')
            ->willReturnCallback(function ($originalFilename) {
                return new UnicodeString('secure_filename');
            });

        // Instancie FileUploader avec un répertoire cible fictif et le double de SluggerInterface
        $this->uploader = new FileUploader('%kernel.project_dir%/public/uploads/animals/profilephoto', $slugger);
    }

    public function testUpload()
    {
        // Crée un objet UploadedFile fictif
        $uploadedFile = $this->createMock(UploadedFile::class);
        $uploadedFile->method('getClientOriginalName')->willReturn('example.txt');
        $uploadedFile->method('guessExtension')->willReturn('txt');

        // Exécute la méthode upload
        $result = $this->uploader->upload($uploadedFile);

        // Vérifie que le nom de fichier retourné correspond à ce qui est attendu
        $this->assertStringStartsWith('secure_filename-', $result);
    }

    public function testExceptionThrown()
    {
        // Crée un objet UploadedFile fictif
        $uploadedFile = $this->createMock(UploadedFile::class);
        $uploadedFile->method('getClientOriginalName')->willReturn('example.txt');
        $uploadedFile->method('guessExtension')->willReturn('txt');

        // Force une exception lors du déplacement du fichier
        $uploadedFile->expects($this->once())
            ->method('move')
            ->willThrowException(new FileException());

        // Exécute la méthode upload
        $result = $this->uploader->upload($uploadedFile);

        // Vérifie que la méthode renvoie une chaîne vide en cas d'exception
        $this->assertEquals('', $result);
    }
}
