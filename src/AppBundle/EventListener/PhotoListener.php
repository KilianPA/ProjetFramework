<?php
/**
 * Created by PhpStorm.
 * User: kilia
 * Date: 06/12/2017
 * Time: 20:22
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Photo;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\User;

class PhotoListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // only act on some "Product" entity
        if ($entity instanceof Photo) {
            $date = date('Y/m/d');
            $entity->setFileSize(filesize($entity->getAbsolutePath()));
            $entity->setDateUpload(new \DateTime($date));
            $entityManager->persist($entity);
            $entityManager->flush();
        }



    }

}

