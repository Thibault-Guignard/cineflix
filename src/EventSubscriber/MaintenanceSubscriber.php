<?php

namespace App\EventSubscriber;

use DateTime;
use DateTimeZone;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private $displayMessageMaintenanceActive;
    private $displayMessageMaintenanceDate;

    public function __construct($displayMessageMaintenanceActive , $displayMessageMaintenanceDate) {
        $this->displayMessageMaintenanceActive = $displayMessageMaintenanceActive;
        $this->displayMessageMaintenanceDate = $displayMessageMaintenanceDate;
    }
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$this->displayMessageMaintenanceActive) {
            return;
        }
        
        dump($this->displayMessageMaintenanceDate);
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

        $date = new DateTime(explode('/',$this->displayMessageMaintenanceDate)[0]); 
        $hour = explode('/',$this->displayMessageMaintenanceDate)[1]; 

        //on modifie le contenut de la repon
        $content = str_replace(
            '</nav>',
            '</nav><div class="container alert alert-danger mt-3">Maintenance prévue '. $date->format('l d F').' à ' . $hour . '</div>',
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
