<?php
namespace Crescendo\HTTP;

class Applet extends \Crescendo\Applet
{
    public function onRegister()
    {
        $application = $this->getApplication();
        $container = $application->getContainer();
        
        if (!$container->isBound("Crescendo\\HTTP\\Request")) {
            $container->bind("Crescendo\\HTTP\\Request", "Crescendo\\HTTP\\Request\\Request");
        }
        
        if (!$container->isBound("Crescendo\\HTTP\\CurrentRequest")) {
            $container->bindSingleton("Crescendo\\HTTP\\CurrentRequest", function() {
                return Request\Request::createFromCurrent();
            });
        }
        
        return parent::onRegister();
    }
    
    public function getName()
    {
        return "crescendo/http";
    }
}