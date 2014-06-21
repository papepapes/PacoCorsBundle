<?php
namespace Paco\Bundle\CorsBundle\EventSubscribers;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Response;

class CorsSubscriber implements EventSubscriberInterface
{
    
    protected $allowed_origin;
    protected $allowed_methods;
    protected $allowed_headers;
    protected $preflight_max_age;
    protected $exposed_headers;
    
    public function __construct($allowed_origin, $allowed_methods, $allowed_headers, $max_age, $exposed_headers) {
        $this->allowed_origin = $allowed_origin;
        $this->allowed_methods = $allowed_methods;
        $this->allowed_headers = $allowed_headers;
        $this->preflight_max_age = $max_age;
        $this->exposed_headers = $exposed_headers;
    }
    
    public function onKernelRequest(GetResponseEvent $event) {
        
        //We're only looking for Master requests
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        
        //At this point an OPTIONS Request is a preflight request
        if ($event->getRequest()->getMethod() == 'OPTIONS') {
            $response = new Response('', 200);

            $event->setResponse($response);

            $this->setAllowedOrigin($event);
            $this->setCrendentialsPermission($event);
            
            //Set the right headers
            $this->setAllowedMethods($event);
            $this->setAllowedHeaders($event);
            
            //set the preflight cache settings
            if ($this->preflight_max_age !== null) {
                $event->getResponse()->headers->add('Acces-Control-Max-Age', $this->preflight_max_age);
            }
            return $response;
        }
    }
    
    public function onKernelResponse(FilterResponseEvent $event) {
        $this->setAllowedOrigin($event);
        $this->setCrendentialsPermission($event);
    }
    
    public static function getSubscribedEvents() {
        return array(KernelEvents::REQUEST => array(array('onKernelRequest', 17)), KernelEvents::RESPONSE => array(array('onKernelResponse', 17)),);
    }
    
    protected function setAllowedOrigin(KernelEvent $event) {
        
        if ($event->getRequest()->headers->has('Origin')) {
            
            //set the allowed origin
            if ($this->allowed_origin === '*') $event->getResponse()->headers->set('Access-Control-Allow-Origin', $event->getRequest()->headers->get('Origin'));
            else $event->getResponse()->headers->set('Access-Control-Allow-Origin', $this->allowed_origin);
        }
    }
    
    protected function setCrendentialsPermission(KernelEvent $event) {
        if ($event->getRequest()->cookies != null && $event->getRequest()->cookies->count() > 0) {
            $event->getResponse()->headers->set('Accss-Control-Allow-Credentials', true);
        }
    }
    
    protected function setAllowedHeaders(GetResponseEvent $event) {
        
        //set the allowed headers
        if ($this->allowed_headers === '*') {
            if ($event->getRequest()->headers->has('Access-Control-Request-Headers')) $event->getResponse()->headers->set('Access-Control-Allow-Headers', $event->getRequest()->headers->get('Access-Control-Request-Headers'));
        } else {
            $event->getResponse()->headers->set('Access-Control-Allow-Headers', $this->allowed_headers);
        }
    }
    
    protected function setAllowedMethods(GetResponseEvent $event) {
        
        //set the allowed methods
        if ($this->allowed_methods === '*') {
            if ($event->getRequest()->headers->has('Access-Control-Request-Method')) $event->getResponse()->headers->set('Access-Control-Allow-Methods', $event->getRequest()->headers->get('Access-Control-Request-Method'));
        } else {
            $event->getResponse()->headers->set('Access-Control-Allow-Methods', $this->allowed_methods);
        }
    }
    
    protected function setExposedHeaders(GetResponseEvent $event) {
        if ($this->exposed_headers !== null) {
            $event->getResponse()->headers->set('Access-Control-Expose-Headers', $this->exposed_headers);
        }
    }
}
