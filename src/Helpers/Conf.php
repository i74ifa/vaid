<?php

namespace I74ifa\Vaid\Helpers;
/**
 * Simple class to create virtual host file for apache2 server
 * 
 */
class Conf
{
    private $domain;

    private string $options;
    
    private string $content;
    
    private $dir;

    public function __construct(string $domain)
    {
        $this->domain = $domain;
        $this->options = '';
        $this->content = '';
        $this->content .= "\tServerName " . $this->domain . "\n";
    }


    
    public static function instance($domain)
    {
        return new Conf($domain);
    }

    public function documentRoot($field)
    {
        $this->dir = $field;

        $this->content .= "\tDocumentRoot \"$field\" \n";  
        return $this;
    }
    
    public function serverAdmin($field)
    {
        $this->content .= "\tServerAdmin " . $field . "\n";  

        return $this;
    }


    // options

    public function options()
    {
        $this->options .= "\tOptions All" . PHP_EOL;
        return $this;
    }

    public function allowOverride()
    {
        $this->options .= "\tAllowOverride All" . PHP_EOL;
        return $this;
    }

    public function requireGranted()
    {
        $this->options .= "\tRequire all granted" . PHP_EOL;
        return $this;
    }

    protected function append()
    {
        $start = "\n<VirtualHost 127.0.0.1:80>" . PHP_EOL;
        $start .= $this->content;
        $doc = "<Directory \"$this->dir\">" . PHP_EOL;

        $doc .= $this->options;

        $doc .= "</Directory>" . PHP_EOL;
        $doc .= "</VirtualHost>";
        $this->content = $start . $doc;

        $this->content .= PHP_EOL;
    }


    public function getContent(): string
    {
        $this->append();

        if (! $this->dir) {
            throw new \Exception('the documentRoot is require Please run it');
        }

        return $this->content;
    }
}
