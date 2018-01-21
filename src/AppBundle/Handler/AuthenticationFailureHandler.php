<?php


// AuthenticationListener.php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;


class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{



    public function onAuthenticationFailure(\Symfony\Component\HttpFoundation\Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'authenticated' => false,
                'username' => $exception->getToken()->getUsername(),
            ));
        }

        return parent::onAuthenticationFailure($request, $exception);
    }
}