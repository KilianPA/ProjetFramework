<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('homepage.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/", name="admin_page")
     */

    public function adminPageAction() {

        return $this->render('admin.html.twig');

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route ("/client/", name="client_page")
     */

    public function clientPageAction() {

        return $this->render('client.html.twig');

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route ("login_ok", name="login_ok")
     *
     * @Security("has_role('ROLE_USER')")
     */

    public function showfosUserAction() {

        return $this->render('login_success.html.twig');

    }

    /**
     *
     * @Route ("/user", name="user_info")
     *
     * @Security ("is_granted('IS_AUTHENTICATED_FULLY')")
     */

    public function showUserAction () {

        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            return $this->render('admin.html.twig');

        }

        if($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {

            return $this->render('client.html.twig');

        }

    }


}
