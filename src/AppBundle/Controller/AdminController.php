<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Galerie;
use AppBundle\Entity\Photo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends Controller
{

    public function indexAction()
    {

        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return $this->render('Admin/adminIndex.html.twig', array('users' => $users));


    }

    public function DeleteAccountAction(Request $request)
    {

        if ($request->request->get('idaccount')) {

            $idUser = $request->request->get('idaccount');
            $em = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()->getRepository("AppBundle:User")->find($idUser);

            if (!$user) {

                return new Response('Erreur');

            }

            $em->remove($user);
            $em->flush();

            return new Response('Utilisateur bien supprimée');

        }

    }

    public function EnableAccountAction(Request $request)
    {

        if ($request->request->get('idaccount')) {

            $idUser = $request->request->get('idaccount');
            $em = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()->getRepository("AppBundle:User")->find($idUser);

            if (!$user) {

                return new Response('Erreur');

            }

            if ($user->isEnabled()) {

                $user->setEnabled(false);
                $em->flush();

            } else {

                $user->setEnabled(true);
                $em->flush();

            }



            return new Response('Utilisateur bien mis à jour');

        }

    }

}
