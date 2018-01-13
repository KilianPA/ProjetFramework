<?php
/**
 * Created by PhpStorm.
 * User: kilia
 * Date: 17/12/2017
 * Time: 15:21
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Galerie;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GalerieData extends AbstractFixture implements OrderedFixtureInterface
{



    public function load(ObjectManager $manager)
    {
        $Galerie1 = new Galerie();
        $Galerie1->setUtilisateur($this->getReference('utilisateur1'));
        $Galerie1->setName('Galerie1');
        $manager->persist($Galerie1);
        $manager->flush();

        $this->addReference('Galerie1', $Galerie1);
    }

    public function getOrder()
    {
        return 3;
    }
}