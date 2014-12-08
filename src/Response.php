<?php
namespace Crescendo\HTTP;

interface Response
{
    public function flush();
    
    public function getCode();
    
    public function setCode($code);
    
    public function getHeaders();
    
    public function setHeaders(array $headers);
    
    public function getHeader($header, $default = null);
    
    public function setHeader($header, $value);
    
    public function unsetHeader($header);
    
    public function hasHeader($header);
    
    public function getCookies();
    
    public function setCookies(array $cookies);
    
    public function getCookie($name, $default = null);
    
    public function setCookie($name, $cookie);
    
    public function unsetCookie($name);
    
    public function hasCookie($name);
    
    public function getBody();
    
    public function setBody($body);
    
    public function redirect($url, $code = 307);
    
    public function redirectBack($fallbackUrl = null, $code = 307);
    
    public function temporaryRedirect($url);
    
    public function permanentRedirect($url);
}