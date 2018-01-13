<?php
/**
 * Created by PhpStorm.
 * User: kilia
 * Date: 17/12/2017
 * Time: 15:21
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new User();
        $utilisateur1->setUsername('Albert');
        $utilisateur1->setEmail('Albert@monaco.com');
        $utilisateur1->setEnabled(1);
        $utilisateur1->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('test',$utilisateur1->getSalt()));
        $manager->persist($utilisateur1);
        $manager->flush();


        $this->addReference('utilisateur1', $utilisateur1);
    }

    public function getOrder()
    {
        return 1;
    }
}