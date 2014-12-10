<?php
namespace Crescendo\HTTP;

interface Request
{
    public function __construct(array $parts = []);
    
    public function getMethod();
    
    public function setMethod($method);
    
    public function isGet();
    
    public function isPost();
    
    public function isPut();
    
    public function isDelete();
    
    public function isMethod($method);
    
    public function getUrl();
    
    public function setUrl(URL $url);
    
    public function getParameters($method);
    
    public function setParameters($method, array $parameters);
    
    public function getParameter($method, $parameter, $default = null);
    
    public function setParameter($method, $parameter, $value);
    
    public function removeParameter($method, $parameter);
    
    public function hasParameter($method, $parameter);
    
    public function getFiles();
    
    public function setFiles(array $files);
    
    public function getFile($name, $default = null);
    
    public function setFile($name, $file);
    
    public function removeFile($name);
    
    public function hasFile($name);
    
    public function getHeaders();
    
    public function setHeaders(array $headers);
    
    public function getHeader($header, $default = null);
    
    public function setHeader($header, $value);
    
    public function removeHeader($header);
    
    public function hasHeader($header);
    
    public function getCookies();
    
    public function setCookies(array $cookies);
    
    public function getCookie($name, $default = null);
    
    public function setCookie($name, $cookie);
    
    public function removeCookie($name);
    
    public function hasCookie($name);
    
    public function isAjax();
    
    public function setIsAjax($isAjax);
}