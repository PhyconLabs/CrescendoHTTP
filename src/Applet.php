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
            $container->bindSingleton("Crescendo\\HTTP\\CurrentRequest", function() use ($container) {
                return $container->make("Crescendo\\HTTP\\Request");
            });
        }
        
        if (!$container->isBound("Crescendo\\HTTP\\URL")) {
            $container->bind("Crescendo\\HTTP\\URL", "Crescendo\\HTTP\\Request\\URL");
        }
        
        return parent::onRegister();
    }
    
    public function getName()
    {
        return "crescendo/http";
    }
}