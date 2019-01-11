<?php
namespace App\Listener;

use App\Entity\Picture;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{

    /**
     * $cacheManager
     *
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * $uploaderHelper
     *
     * @var UploaderHelper
     */
    private $uploaderHelper;

    /**
     * __construct
     *
     * @param CacheManager $cacheManager
     * @param UploaderHelper $uploaderHelper
     * @return void
     */
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager=$cacheManager;
        $this->uploaderHelper=$uploaderHelper;
    }


    /**
     * getSubscriberEvents
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    /**
     * preRemove
     *
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity=$args->getEntity();
        if (!$entity instanceof Picture) // Si l'entité n'est pas une Picture, on ne fait rien
        {
            return;
        }
        // Sinon on supprimer la miniature
        $this->cacheManager->remove( $this->uploaderHelper->asset( $entity,'imageFile') );
    }

    /**
     * preUpdate
     *
     * @param PreUpdateEventArgs $args
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        // dump($args->getEntity());
        // dump($args->getObject());

        $entity=$args->getEntity();
        if (!$entity instanceof Picture) // Si l'entité n'est pas une Picture, on ne fait rien
        {
            return;
        }
        // Sinon on supprimer l'ancienne miniature
        if ($entity->getImageFile() instanceof File) {
            $this->cacheManager->remove( $this->uploaderHelper->asset( $entity,'imageFile') );
        }

    }
}