<?php

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Entity\Galerie;
use AppBundle\Repository\GalerieRepository;
use AppBundle\Entity\Photo;
use AppBundle\Form\GalerieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class GalerieController extends Controller
{



    public function choosePhotoAction(Request $request)
    {
        if($request->request->get('array_photo')){

            $id_photo = $request->request->get('array_photo');
            $arrData = [];

            foreach ($id_photo as $value){

                $photo = $this->getDoctrine()->getRepository("AppBundle:Photo")->findBy(array('id' => $value));
                array_push($arrData, $photo);
            }

            if (!$arrData){

                return new Response('Pas de photo choisies');

            } else {

                return $this->render('Galerie/photoChoose.html.twig', array('photos' => $arrData));

            }



        }

        return new Response('');
    }

    public function addPhotoToGalerieAction(Request $request)
    {
        if($request->request->get('array_photo')){

            $id_photo = $request->request->get('array_photo');
            $id_galerie = $request->request->get('idgalerie');
            $arrData = [];

            $em = $this->getDoctrine()->getManager();
            $galerie = $em->getRepository(Galerie::class)->find($id_galerie);

            if (!$galerie) {
                return new Response('Erreur : Pas de galerie trouvée');
            }

            foreach ($id_photo as $value){

                $photo = $em->getRepository(Photo::class)->find($value['id_photo']);

                if (!$photo) {

                    return new Response('Erreur : Pas de photo trouvée');

                } else {

                    $photo->setGalerie($galerie);
                    $photo->setOrdrePhoto($value['order']);
                    $em->flush();
                }

//
//
//
//
//                array_push($arrData, $value['id_photo']);
//                array_push($arrData, $value['order']);
            }

            return new Response('OK');

        }

        return new Response('');
    }



}