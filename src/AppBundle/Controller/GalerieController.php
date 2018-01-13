<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Galerie;
use AppBundle\Form\GalerieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GalerieController extends Controller
{

    /**
     *
     * @Route("/addgalerie" , name="addGalerie")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */

    public function addAction(Request $request)
    {
//    On crée la photo
        $galerie = new Galerie();
        $user = $this->getUser();

//        On recupère le formulaire

        $form = $this->createForm(GalerieType::class, $galerie);


        $form->handleRequest($request);

        //si le formulaire à été soumis

        if($form->isSubmitted()){
            $galerie->setUtilisateur($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($galerie);
            $em->flush();

            return new Response('Galerie Ajoutée (c\'est faux mais l\idée est là)');


        }


        $formView = $form->createView();

//        On rend la vue

        return $this->render('Galerie\galerieAdd.html.twig' , array(

            'form'=>$formView

        ));

    }

}