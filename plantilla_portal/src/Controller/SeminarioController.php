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

class SeminarioController extends AbstractController
{
    /**
     * @Route("/curso_seminario", name="curso_seminario")
     */
    public function curso_seminario(Request $request, ModeloSeguridad $modelo, SessionInterface $session)
    {
         
        /*$contents = dirname(__DIR__);
        $response = new Response($contents);
        return $response;*/
        return $this->render(
            'seminarioEstudiante/inicioEstudiante.html.twig'
        );
    }

    /**
     * @Route("/curso_seminario/formularioTituloTrabajoDeGraduacion", name="formularioTituloTrbajoDeGraduacion")
     */
    public function formularioTituloTrabajoDeGraduacion(Request $request, ModeloSeguridad $modelo, SessionInterface $session)
    {
         
        /*$contents = dirname(__DIR__);
        $response = new Response($contents);
        return $response;*/
        return $this->render(
            'seminarioEstudiante/formularioTituloTrabajoDeGraduacion.html.twig'
        );
    }


}
