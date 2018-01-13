<?php
// src/Acme/UserBundle/Controller/RegistrationController.php

namespace AppBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\RegistrationController as BaseController;


class RegistrationController extends BaseController
{
    public function registeruserAction(Request $request){
        $succesfullyRegistered = $this->register("demo@email.com","demoUsername","demoPassword");

        if($succesfullyRegistered){
            // the user is now registered !
        }else{
            // the user exists already !
        }
    }

    /**
     * This method registers an user in the database manually.
     *
     * @return boolean User registered / not registered
     **/
    private function register($email,$username){
        $userManager = $this->get('fos_user.user_manager');

        // Or you can use the doctrine entity manager if you want instead the fosuser manager
        // to find
        //$em = $this->getDoctrine()->getManager();
        //$usersRepository = $em->getRepository("mybundleuserBundle:User");
        // or use directly the namespace and the name of the class
        // $usersRepository = $em->getRepository("mybundle\userBundle\Entity\User");
        //$email_exist = $usersRepository->findOneBy(array('email' => $email));

        $email_exist = $userManager->findUserByEmail($email);

        // Check if the user exists to prevent Integrity constraint violation error in the insertion
        if($email_exist){
            return false;
        }

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setLocked(0); // don't lock the user
        $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
        // this method will encrypt the password with the default settings :)
        $user->setPlainPassword('test');
        $userManager->updateUser($user);

        return true;
    }
}