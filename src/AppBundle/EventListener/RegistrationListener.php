<?php
/**
 * Created by PhpStorm.
 * User: kilia
 * Date: 06/12/2017
 * Time: 20:22
 */

namespace AppBundle\EventListener;



use AppBundle\Entity\Galerie;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\User;

class RegistrationListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // only act on some "Product" entity
        if ($entity instanceof User) {

            $galerie = new Galerie();
            $galerie->setName('Ma Galerie');
            $galerie->setUtilisateur($entity);
            $entityManager->persist($galerie);
            $entityManager->flush();
        }



    }

}

