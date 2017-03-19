<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 09.02.2017
 * Time: 15:32
 */

namespace BookLibraryBundle\EventListener;

use BookLibraryBundle\Entity\Book;
use BookLibraryBundle\FileUploader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;


class BookSubscriber implements EventSubscriber
{
    private $containerFileUploader;
    private $containerCache;

    public function __construct(FileUploader $containerFileUploader, FilesystemCache $containerCache)
    {
        $this->containerFileUploader = $containerFileUploader;
        $this->containerCache = $containerCache;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'preRemove',
            'onFlush'
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        if($entity instanceof Book){
            if($entity->getFilePath()){
                $entity->setFilePath($this->containerFileUploader->bookUpload($entity->getFilePath()));
            }
            if($entity->getCoverPath()){
                $entity->setCoverPath($this->containerFileUploader->coverUpload($entity->getCoverPath()));
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        if($entity instanceof Book) {
            $em = $args->getEntityManager();
            $arChangeSet = $em->getUnitOfWork()->getEntityChangeSet($entity);

            if(array_key_exists("coverPath", $arChangeSet)){
                if($entity->getCoverPath()){
                    $entity->setCoverPath($this->containerFileUploader->coverUpload($entity->getCoverPath()));
                    $this->containerFileUploader->coverRemove($arChangeSet["coverPath"][0]);
                }
                else{
                    $entity->setCoverPath($arChangeSet["coverPath"][0]);
                }
            }

            if(array_key_exists("filePath", $arChangeSet)){
                if($entity->getFilePath()){
                    $entity->setFilePath($this->containerFileUploader->bookUpload($entity->getFilePath()));
                    $this->containerFileUploader->bookRemove($arChangeSet["filePath"][0]);
                }
                else{
                    $entity->setFilePath($arChangeSet["filePath"][0]);
                }
            }
        }
    }

    public function  preRemove(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        if($entity instanceof Book) {
            $this->containerFileUploader->coverRemove($entity->getCoverPath());
            $this->containerFileUploader->bookRemove($entity->getFilePath());
        }
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $this->containerCache->delete('books');
    }
}