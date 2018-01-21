<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $user1 = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneBy(array('username' => $lastUsername ));

        if (!$user1){


        } else {
            $compteur = $user1->getLoginFail();

            if($user1->isEnabled()) {

                $em = $this->getDoctrine()->getManager();

                if ($compteur == 2) {

                    $user = $this->getDoctrine()->getRepository(User::class)->find($user1->getId());
                    $user->setLoginFail(0);
                    $user->setEnabled(false);
                    $em->flush();

                    $csrfToken = $this->has('security.csrf.token_manager')
                        ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
                        : null;

                    return $this->renderLogin(array(
                        'last_username' => $lastUsername,
                        'error' => $error,
                        'compteur' => 4,
                        'csrf_token' => $csrfToken,
                    ));


                } else {

                    $compteur = $compteur + 1;

                    $user = $this->getDoctrine()->getRepository(User::class)->find($user1->getId());
                    $user->setLoginFail($compteur);
                    $em->flush();

                    $csrfToken = $this->has('security.csrf.token_manager')
                        ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
                        : null;

                    return $this->renderLogin(array(
                        'last_username' => $lastUsername,
                        'error' => $error,
                        'compteur' => $compteur,
                        'csrf_token' => $csrfToken,
                    ));

                }

            } else {


            }

        }

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));



    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('@FOSUser/Security/login.html.twig', $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}