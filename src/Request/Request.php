<?php
namespace Crescendo\HTTP\Request;

class Request implements \Crescendo\HTTP\Request
{
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "DELETE";
    const METHOD_HEAD = "HEAD";
    const METHOD_OPTIONS = "OPTIONS";
    
    protected $method;
    protected $url;
    protected $parameters;
    protected $files;
    protected $headers;
    protected $cookies;
    protected $isAjax;
    
    public function __construct(array $parts = [])
    {
        $this->parameters = [];
        $this->headers = new Collection();
        
        if (!isset($parts["method"])) {
            $parts["method"] = $this->getCurrentMethod();
        }
        
        if (!isset($parts["url"])) {
            $parts["url"] = $this->getCurrentUrl();
        }
        
        if (!isset($parts["headers"])) {
            $parts["headers"] = $this->getCurrentHeaders();
        }
        
        $this
            ->setMethod($parts["method"])
            ->setUrl($parts["url"])
            ->setHeaders($parts["headers"]);
    }
    
    public function __get($property)
    {
        if ($property === "isAjax") {
            return $this->isAjax();
        } elseif($property === "method") {
            return $this->getMethod();
        } elseif ($property === "parameters") {
            return $this->ensureMethodParameters($this->getMethod());
        } elseif (in_array($property, [ "files", "headers", "cookies" ])) {
            return $this->{$property};
        } elseif (strlen($property) > 10 && substr($property, -10) === "Parameters") {
            $method = substr($property, 0, -10);
            $method = $this->normalizeMethod($method);
            
            return $this->ensureMethodParameters($method);
        } else {
            $class = get_class($this);
            
            throw new Exceptions\UnsupportedPropertyException(
                "Property `{$class}::\${$property}` isn't accessible."
            );
        }
    }
    
    public function __set($property, $value)
    {
        if ($property === "isAjax") {
            $this->setIsAjax($value);
        } elseif($property === "method") {
            return $this->setMethod($value);
        } elseif ($property === "parameters") {
            $this->setParameters($this->getMethod(), $value);
        } elseif ($property === "files") {
            $this->setFiles($value);
        } elseif ($property === "headers") {
            $this->setHeaders($value);
        } elseif ($property === "cookies") {
            $this->setCookies($value);
        } elseif (strlen($property) > 10 && substr($property, -10) === "Parameters") {
            $method = substr($property, 0, -10);
            $method = $this->normalizeMethod($method);
            
            $this->setParameters($method, $value);
        } else {
            $class = get_class($this);
            
            throw new Exceptions\UnsupportedPropertyException(
                "Property `{$class}::\${$property}` isn't writable."
            );
        }
        
        return $this;
    }
    
    public function __unset($property)
    {
        //
    }
    
    public function __isset($property)
    {
        //
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function setMethod($method)
    {
        $this->method = $this->normalizeMethod($method);;
        
        return $this;
    }
    
    public function isGet()
    {
        return $this->isMethod(static::METHOD_GET);
    }
    
    public function isPost()
    {
        return $this->isMethod(static::METHOD_POST);
    }
    
    public function isPut()
    {
        return $this->isMethod(static::METHOD_PUT);
    }
    
    public function isDelete()
    {
        return $this->isMethod(static::METHOD_DELETE);
    }
    
    public function isMethod($method)
    {
        return ($this->getMethod() === $this->normalizeMethod($method));
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setUrl(\Crescendo\HTTP\URL $url)
    {
        $this->url = $url;
        
        return $this;
    }
    
    public function getParameters($method)
    {
        $method = $this->normalizeMethod($method);
        
        if (isset($this->parameters[$method])) {
            return $this->parameters[$method]->toArray();
        } else {
            return [];
        }
    }
    
    public function setParameters($method, array $parameters)
    {
        $this
            ->ensureMethodParameters($method)
            ->replaceArray($parameters);
        
        return $this;
    }
    
    public function getParameter($method, $parameter, $default = null)
    {
        $method = $this->normalizeMethod($method);
        
        if (isset($this->parameters[$method])) {
            return $this->parameters[$method]->get($parameter, $default);
        } else {
            return $default;
        }
    }
    
    public function setParameter($method, $parameter, $value)
    {
        $this
            ->ensureMethodParameters($method)
            ->set($parameter, $value);
        
        return $this;
    }
    
    public function removeParameter($method, $parameter)
    {
        $this
            ->ensureMethodParameters($method)
            ->remove($parameter);
        
        return $this;
    }
    
    public function hasParameter($method, $parameter)
    {
        $method = $this->normalizeMethod($method);
        
        if (isset($this->parameters[$method])) {
            return $this->parameters[$method]->has($parameter);
        } else {
            return false;
        }
    }
    
    public function getFiles()
    {
        //
    }
    
    public function setFiles(array $files)
    {
        //
    }
    
    public function getFile($name, $default = null)
    {
        //
    }
    
    public function setFile($name, $file)
    {
        //
    }
    
    public function removeFile($name)
    {
        //
    }
    
    public function hasFile($name)
    {
        //
    }
    
    public function getHeaders()
    {
        return $this->headers->toArray();
    }
    
    public function setHeaders(array $headers)
    {
        $this->headers->replaceArray($headers);
        
        return $this;
    }
    
    public function getHeader($header, $default = null)
    {
        return $this->headers->get($header, $default);
    }
    
    public function setHeader($header, $value)
    {
        $this->headers->set($header, $value);
        
        return $this;
    }
    
    public function removeHeader($header)
    {
        $this->headers->remove($header);
        
        return $this;
    }
    
    public function hasHeader($header)
    {
        return $this->headers->has($header);
    }
    
    public function getCookies()
    {
        //
    }
    
    public function setCookies(array $cookies)
    {
        //
    }
    
    public function getCookie($name, $default = null)
    {
        //
    }
    
    public function setCookie($name, $cookie)
    {
        //
    }
    
    public function removeCookie($name)
    {
        //
    }
    
    public function hasCookie($name)
    {
        //
    }
    
    public function isAjax()
    {
        return $this->isAjax;
    }
    
    public function setIsAjax($isAjax)
    {
        $this->isAjax = (bool) $isAjax;
        
        return $this;
    }
    
    protected function normalizeMethod($method)
    {
        $method = strtoupper($method);
        
        return $method;
    }
    
    protected function ensureMethodParameters($method)
    {
        $method = $this->normalizeMethod($method);
        
        if (!isset($this->parameters[$method])) {
            $this->parameters[$method] = new Collection();
        }
        
        return $this->parameters[$method];
    }
    
    protected function getCurrentMethod()
    {
        return !empty($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : static::METHOD_GET;
    }
    
    protected function getCurrentUrl()
    {
        return \Crescendo\IoC\make("Crescendo\\HTTP\\URL");
    }
    
    protected function getCurrentParameters()
    {
        //
    }
    
    public function getCurrentFiles()
    {
        //
    }
    
    public function getCurrentHeaders()
    {
        if (!function_exists("getallheaders") || ($headers = getallheaders()) === false) {
            $headers = [];
            
            foreach ($_SERVER as $key => $value) {
                if (strpos($key, "HTTP_") === 0) {
                    $key = substr($key, 5);
                    $key = strtolower($key);
                    $key = str_replace("_", " ", $key);
                    $key = ucwords($key);
                    $key = str_replace(" ", "-", $key);
                    
                    $headers[$key] = $value;
                }
            }
        }
        
        return $headers;
    }
    
    public function getCurrentCookies()
    {
        //
    }
    
    public function getCurrentIsAjax()
    {
        //
    }
}