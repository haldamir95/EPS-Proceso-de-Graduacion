<?php

namespace App\Controller;

use App\Model\ModeloSeguridad;
use App\Service\ConsultorFotos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/verifica", name="verifica")
     */
    public function verifica(Request $request, ModeloSeguridad $modelo, SessionInterface $session)
    {
         
        /*$contents = dirname(__DIR__);
        $response = new Response($contents);
        return $response;*/
        return $this->render(
            'base.html.twig'
        );
    }

    /**
     * @Route("/procesaFoto", name="foto")
     */
    public function procesaFoto(ConsultorFotos $consultorFotos) {
        /*$ssoHelper = new SSOHelper();
        $carnetSSO = $ssoHelper->obtenerParametroSSO('uniqueIdentifier');*/

        $registroAcademico = "sinfoto00";
        $contents = $consultorFotos->obtenerFoto($registroAcademico); //$carnetSSO;
        $response = new Response($contents);
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->headers->set('Cache-Control', ['no-cache', 'no-store', 'must-revalidate']);
        return $response;
    }

}
