<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:36 PM
 */

namespace Framework;


/**
 * Class Config
 * @method static Config get(string $name)
 * @package Framework
 */
class Config
{
    use CallStatic;
    /**
     * @var mixed
     */
    private $parameters;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->parameters = require base_path().'/Config/app.php';
    }

    /**
     * Get config by name
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    private function get_static($name)
    {
        if(isset($this->parameters[$name]))
            return $this->parameters[$name];

        throw new \Exception('Config not exists.');
    }


}