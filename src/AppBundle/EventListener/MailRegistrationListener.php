<?php
///**
// * Created by PhpStorm.
// * User: kilia
// * Date: 14/01/2018
// * Time: 15:29
// */
//
//namespace AppBundle\EventListener;
//
//use FOS\UserBundle\FOSUserEvents;
//use FOS\UserBundle\Event\FormEvent;
//
//use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
//use Symfony\Bundle\TwigBundle\TwigEngine;
//
///**
// * Listener responsible to change the redirection at the end of registration and add default role
// */
//class MailRegistrationListener implements EventSubscriberInterface
//{
//    private $router;
//    private $templating;
//    private $mailer;
//
//    public function __construct(
//        UrlGeneratorInterface $router,
//        TwigEngine $templating,
//        \Swift_Mailer $mailer
//    ) {
//        $this->router = $router;
//        $this->templating = $templating;
//        $this->mailer = $mailer;
//    }
//
//    public static function getSubscribedEvents(){
//
//        return array(
//            FOSUserEvents::REGISTRATION_SUCCESS => 'onUserCreated',
//        );
//    }
//
//    public function onUserCreated(FormEvent $event){
//
//        $rolesArr = array('ROLE_XXX');
//        $user = $event->getForm()->getData();
//        $user->setRoles($rolesArr);
//
//        $text = "Email : ".$user->getEmail();
//
//        $message = \Swift_Message::newInstance()
//            ->setSubject("Listener onUserCreated : ".$user->getEmail())
//            ->setFrom('kilian.pasini@gmail.com')
//            ->setTo($user->getEmail())
//            ->setBody(
//                $this->templating->render(
//                    'mail/mailRegister.html.twig', [
//                        'pseudo' => $user->getUsername(),
//                        'password' => $user->getPlainPassword()
//                    ]
//                )
//            )
//            ->setContentType("text/html")
//        ;
//
//        $this->mailer->send($message);
//
//        $url = $this->router->generate('homepage');
//
//        $event->setResponse(new RedirectResponse($url));
//    }
//}