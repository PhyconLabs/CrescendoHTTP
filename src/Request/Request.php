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
    
    public static function createFromCurrent()
    {
        return new static;
    }
    
    public function __construct()
    {
        $this->parameters = [];
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
        //
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
        //
    }
    
    public function unsetParameter($method, $parameter)
    {
        //
    }
    
    public function hasParameter($method, $parameter)
    {
        //
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
    
    public function unsetFile($name)
    {
        //
    }
    
    public function hasFile($name)
    {
        //
    }
    
    public function getHeaders()
    {
        //
    }
    
    public function setHeaders(array $headers)
    {
        //
    }
    
    public function getHeader($header, $default = null)
    {
        //
    }
    
    public function setHeader($header, $value)
    {
        //
    }
    
    public function unsetHeader($header)
    {
        //
    }
    
    public function hasHeader($header)
    {
        //
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
    
    public function unsetCookie($name)
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
}