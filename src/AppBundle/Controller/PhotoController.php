<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Photo;
use AppBundle\Form\PhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
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


        $form->handleRequest($request);

        //si le formulaire à été soumis

        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $photo->upload();
                $photo->setPhotoUser($this->getUser());

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
}