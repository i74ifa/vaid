<?php


namespace I74ifa\Vaid\Helpers;


/**
 * get project type for directory
 * 
 * * 1 = php
 * * 2 = php with public ```this project like (symfony, laravel, etc..)``` 
 * * 3 = another projects
 * @static ITS_PHP = 1
 * @static ITS_PUBLIC = 2
 * @static ITS_UNKNOWN = 3
 *
 */
class TypeProject
{
    public const ITS_PHP = 1;
    public const ITS_PUBLIC = 2;
    public const ITS_UNKNOWN = 3;
    public $directory;


    protected $type = null;

    public function __construct(string $directory)
    {
        $this->directory = scandir($directory);
        $this->type();
    }

    protected function type(): void
    {
        if (array_search('public', $this->directory)){
            $this->type =  self::ITS_PUBLIC;
        }else if (array_search('index.php', $this->directory)) {
            $this->type =  self::ITS_PHP;
        }else {
            $this->type =  self::ITS_UNKNOWN;
        }

    }

    public function getType()
    {
        return $this->type;
    }
}