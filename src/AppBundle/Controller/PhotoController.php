<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Galerie;
use AppBundle\Entity\Photo;
use AppBundle\Form\PhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{

//    /**
//     *
//     * @Route("/addphoto" , name="addProduct")
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     *
//     */

    public function addAction(Request $request)
    {
//    On crée la photo
        $photo = new Photo();
        $user = $this->getUser();

//        On recupère le formulaire

        $form = $this->createForm(PhotoType::class, $photo);
        $galerie = $this->getDoctrine()->getRepository("AppBundle:Galerie")->find(1);

        $form->handleRequest($request);

        //si le formulaire à été soumis

        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $photo->upload();
                $photo->setPhotoUser($this->getUser());
                $photo->setGalerie($galerie);

                $em->persist($photo);
                $em->flush();




                return new Response('Photo bien uploadé');
            }
            else {

                $string = (string) $form->getErrors(true, false);
                return new Response($string);

            }
        }

        $formView = $form->createView();

//        On rend la vue

        return $this->render('Galerie\photoAdd.html.twig' , array(

            'form'=>$formView

        ));
    }


    public function showPhotoAction () {

        $user = $this->getUser();
        $photo = $this->getDoctrine()->getRepository("AppBundle:Photo")->findBy(array('photoUser' => $user, 'galerie' => array(1,null) ));

        if (!$photo) {
            return new Response('Aucune photo');
        }

        return $this->render('Galerie/gridPhoto.html.twig', array('photos' => $photo));

    }

    public function showGalerieAction() {

        $user = $this->getUser();
        $galerie = $this->getDoctrine()->getRepository("AppBundle:Galerie")->findBy(array('utilisateur' => $user));


        if (!$galerie) {
            return new Response('Aucune galerie trouvée');
        }

        $photo = $this->getDoctrine()->getRepository("AppBundle:Photo")->findBy(array('galerie' => $galerie), array('ordrePhoto' => 'asc'));


        if (!$photo) {
            return $this->render('Galerie/gridGalerie.html.twig', array('galeries' => $galerie));
        }

        return $this->render('Galerie/gridGalerie.html.twig', array('photos' => $photo, 'galeries' => $galerie));

    }

    public function DeletePhotoFromGalerieAction(Request $request) {

        if($request->request->get('id_photo')){

            $idPhoto = $request->request->get('id_photo');
            $em = $this->getDoctrine()->getManager();

            $galerie = $this->getDoctrine()->getRepository("AppBundle:Galerie")->find(1);

            $photo = $this->getDoctrine()->getRepository("AppBundle:Photo")->find($idPhoto);
            $photo->setGalerie($galerie);
            $em->flush();

            return new Response('Photo bien supprimée de la galerie');

        }


    }

    public function DeletePhotoAction(Request $request) {

        if($request->request->get('id_photo')){

            $idPhoto = $request->request->get('id_photo');
            $em = $this->getDoctrine()->getManager();
            $photo = $this->getDoctrine()->getRepository("AppBundle:Photo")->find($idPhoto);

            if(!$photo) {

                return new Response('Erreur');

            }




            $em->remove($photo);
            $em->flush();

            return new Response('Photo bien supprimée');

        }


    }



}

