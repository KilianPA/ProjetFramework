<?php


namespace AppBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Request;

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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setPlainPassword('null');




        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                $password = substr(hash('sha512',rand()),0,12);
                $user->setPassword($password);
                $user->setPlainPassword($password);
                $user->setEnabled(true);
                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }


                $message = \Swift_Message::newInstance()
                    ->setSubject('Inscription sur mon super site')
                    ->setFrom('kilian.pasini@outlook.fr')
                    ->setTo($user->getEmail())
                    ->setTo('kilianpasini@hotmail.fr')
                    ->setBody(
                        $this->renderView(
                            'mail/mailRegister.html.twig',
                            array('pass' => $password, 'name' => $user->getUsername())
                        )
                    )
                ;
                $this->get('mailer')->send($message);

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $string = (string) $form->getErrors(true, false);
            return new Response($string);

//            $event = new FormEvent($form, $request);
//            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);
//
//            if (null !== $response = $event->getResponse()) {
//                return $response;
//            }
        }

        $response = parent::registerAction( $request );
        return $response;
    }
}