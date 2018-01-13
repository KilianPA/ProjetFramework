<?php

/**
 * Created by PhpStorm.
 * User: kilia
 * Date: 17/12/2017
 * Time: 15:21
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Photo;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PhotoData extends AbstractFixture implements OrderedFixtureInterface
{



    public function load(ObjectManager $manager)
    {
        $Photo1 = new Photo();
        $Photo1->setGalerie($this->getReference('Galerie1'));
        $Photo1->setNom('Photo1');
        $Photo1->setUrl('photo1.jpeg');
        $manager->persist($Photo1);

        $Photo2 = new Photo();
        $Photo2->setGalerie($this->getReference('Galerie1'));
        $Photo2->setNom('Photo2');
        $Photo2->setUrl('photo2.jpeg');
        $manager->persist($Photo2);

        $Photo3 = new Photo();
        $Photo3->setGalerie($this->getReference('Galerie1'));
        $Photo3->setNom('Photo3');
        $Photo3->setUrl('photo3.jpeg');
        $manager->persist($Photo3);


        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}