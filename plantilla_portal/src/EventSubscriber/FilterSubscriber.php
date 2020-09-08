<?php

namespace App\EventSubscriber;

use App\Controller\FilterInterface;
use App\Security\SSOHelper;
use App\Model\ModeloCarrera;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class FilterSubscriber implements EventSubscriberInterface {
    private $modeloCarrera;
    private $session;

    public function __construct(ModeloCarrera $modelo, SessionInterface $session)
    {
        $this->modeloCarrera = $modelo;
        $this->session = $session;
    }

    public function onKernelController(FilterControllerEvent $event){
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }
        if ($controller[0] instanceof FilterInterface) {
            if (!$this->session->has('carrera') || !$this->session->has('carnet')) {
                throw new AccessDeniedHttpException('No ha iniciado sesión');
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
