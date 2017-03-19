<?php

namespace BookLibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="`book`")
 * @ORM\Entity(repositoryClass="BookLibraryBundle\Repository\BookRepository")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="cover_path", type="string", length=100, nullable=true)
     */
    private $coverPath;

    /**
     * @var string
     *
     * @ORM\Column(name="file_path", type="string", length=50, nullable=true)
     */
    private $filePath;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="readed_date", type="date")
     */
    private $readedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="allow_download", type="boolean")
     */
    private $allowDownload;


    /**
     * Get id
     *
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Book
     */
    public function setName($name){
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Book
     */
    public function setAuthor($author){
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor(){
        return $this->author;
    }

    /**
     * Set coverPath
     *
     * @param string $coverPath
     *
     * @return Book
     */
    public function setCoverPath($coverPath){
        $this->coverPath = $coverPath;

        return $this;
    }

    /**
     * Get coverPath
     *
     * @return string
     */
    public function getCoverPath(){
        return $this->coverPath;
    }

    /**
     * Set filePath
     *
     * @param string $filePath
     *
     * @return Book
     */
    public function setFilePath($filePath){
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath
     *
     * @return string
     */
    public function getFilePath(){
        return $this->filePath;
    }

    /**
     * Set readedDate
     *
     * @param \DateTime $readedDate
     *
     * @return Book
     */
    public function setReadedDate($readedDate){
        $this->readedDate = $readedDate;

        return $this;
    }

    /**
     * Get readedDate
     *
     * @return \DateTime
     */
    public function getReadedDate(){
        return $this->readedDate;
    }

    /**
     * Set allowDownload
     *
     * @param string $allowDownload
     *
     * @return Book
     */
    public function setAllowDownload($allowDownload){
        $this->allowDownload = $allowDownload;

        return $this;
    }

    /**
     * Get allowDownload
     *
     * @return string
     */
    public function getAllowDownload(){
        return $this->allowDownload;
    }
}

