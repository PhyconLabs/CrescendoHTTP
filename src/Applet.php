<?php
namespace Crescendo\HTTP;

class Applet extends \Crescendo\Applet
{
    public function onRegister()
    {
        var_dump("`crescendo/http` has been registered.");
        
        return parent::onRegister();
    }
    
    public function getName()
    {
        return "crescendo/http";
    }
}