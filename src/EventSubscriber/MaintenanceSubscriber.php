<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        //si ca n'est pas la requete principale on ne fait rien
        if (!$event->isMainRequest()) {
            // don't do anything if it's not the main request
            return;
        }

        //on exclut les routes du profiler et la WDT
        //la REGEX se trouve entre '/REGEX/'
        if (preg_match('/^\/(_profiler|_wdt)/', $event->getRequest()->getPathInfo())) {
            return;
        }

        // Requete XHR/Fetch ? (AJAX)
        if ($event->getRequest()->isXmlHttpRequest()){
            return;
        }

        //dump('Suscriber appelé ...', $event);

        $response = $event->getResponse();
        //contenur de la réponse 
        $content = $response->getContent();

        //on modifie le contenut de la repon
        $content = str_replace(
            '<body>',
            '<body><div class="alert alert-danger mt-3">Maintenance prévue mardi 10 janvier à 17h00</div>',
            $content
            );

        //on remplace le conteu de la réponse d'origine
        $response->setContent($content);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
