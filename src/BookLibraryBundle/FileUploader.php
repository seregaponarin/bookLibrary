<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 09.02.2017
 * Time: 13:11
 */

namespace BookLibraryBundle;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $coversUploadPath;
    private $booksUploadPath;

    public function __construct($absoluteUploadPath, $booksUploadPath, $coversUploadPath)
    {
        $this->coversUploadPath = $absoluteUploadPath.$coversUploadPath;
        $this->booksUploadPath = $absoluteUploadPath.$booksUploadPath;
    }

    public function getCoversUploadPath()
    {
        return $this->coversUploadPath;
    }

    public function getBooksUploadPath(){
        return $this->booksUploadPath;
    }

    public function bookUpload(UploadedFile $file)
    {
        return $this->fileUpload($file, $this->booksUploadPath);
    }

    public function coverUpload(UploadedFile $file)
    {
        return $this->fileUpload($file, $this->coversUploadPath);
    }

    public function bookRemove($fileName)
    {
        $this->fileRemove($this->getBooksUploadPath().$fileName);
    }

    public function coverRemove($fileName)
    {
        $this->fileRemove($this->getCoversUploadPath().$fileName);
    }

    private function fileUpload(UploadedFile $file, $targetDir)
    {
        $fileName = md5(uniqid()).".".$file->guessExtension();
        $file->move($targetDir, $fileName);
        return $fileName;
    }

    private function fileRemove($filePath)
    {
        $fs = new Filesystem();
        if(is_file($filePath)){
            $fs->remove($filePath);
        }
    }

}