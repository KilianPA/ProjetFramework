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


class HomeController extends Controller
{

    public function ShowAllGalerieAction(Request $request) {


        $em = $this->getDoctrine()->getManager();
        $galeries = $em->getRepository(Galerie::class)->findAll();


        if (!$galeries){

            return new Response('Pas de galerie trouvée');
        }

        return $this->render('Home/AllGalerie.html.twig', array('galeries' => $galeries));




    }

    public function ShowRandomGalerieAction() {

        $arrId = [];
        $galeries =$this->getDoctrine()->getRepository('AppBundle:Galerie')->findAll();
        foreach($galeries as $galerie)
        {
            $id = $galerie->getId();

            if ($id == 0){

            } else {

                array_push($arrId, $id);
            }


        }

        $randomId= array_rand($arrId, 1);

        $galerieSend = $this->getDoctrine()->getRepository('AppBundle:Galerie')->find($arrId[$randomId]);
        $photo = $this->getDoctrine()->getRepository("AppBundle:Photo")->findBy(array('galerie' => $galerieSend), array('ordrePhoto' => 'asc'));
        return $this->render('Home/RandomGalerie.html.twig', array('galeries' => $galerieSend, 'photos' => $photo));

    }


}
