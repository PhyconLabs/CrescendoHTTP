<?php
namespace Crescendo\HTTP\Request;

class URL implements \Crescendo\HTTP\URL
{
    const SCHEME_HTTP = "http";
    const SCHEME_HTTPS = "https";
    
    protected $scheme;
    protected $host;
    protected $port;
    protected $path;
    protected $query;
    protected $fragment;
    
    public function __construct(array $parts = [])
    {
        //
    }
    
    public function getScheme()
    {
        return $this->scheme;
    }
    
    public function setScheme($scheme)
    {
        $this->scheme = (string) $scheme;
        
        return $this;
    }
    
    public function getHost()
    {
        return $this->host;
    }
    
    public function setHost($host)
    {
        $this->host = (string) $host;
        
        return $this;
    }
    
    public function getPort()
    {
        return $this->port;
    }
    
    public function setPort($port)
    {
        $this->port = (int) $port;
        
        return $this;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function setPath($path)
    {
        $this->path = trim($path, "/");
        
        return $this;
    }
    
    public function getQuery()
    {
        return $this->query;
    }
    
    public function setQuery($query)
    {
        //
    }
    
    public function getFragment()
    {
        return $this->fragment;
    }
    
    public function setFragment($fragment)
    {
        $this->fragment = (string) $fragment;
        
        return $this;
    }
}