<?php
/**
 * Project: Quantox.
 * User: Dusan Vlahovic
 * Date: 4/10/17
 * Time: 1:33 PM
 */

namespace Framework;


/**
 * Class DB
 * @method static select($query, $data = [], $object = false)
 * @method static insert($query, $data = [])
 * @package Framework
 */
class DB
{
    private static $instance;
    private $connection;
    private $password;
    private $user;
    private $host;
    private $db;

    private function __construct()
    {

        $dbConfig = Config::get('database');
        $this->user = $dbConfig['user'];
        $this->password = $dbConfig['pass'];
        $this->host = $dbConfig['host'];
        $this->db = $dbConfig['db'];

        $this->connection = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->password);

    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    private function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getConnection()
    {
        return self::getInstance()->connection;
    }

    private function select_static($query, $data = [], $object = \stdClass::class)
    {
        $sth = $this->getConnection()->prepare($query);
        foreach ($data as $key => $value)
            $sth->bindParam($key, $value);
        if (!$sth->execute())
            return false;

        return $sth->fetchAll(\PDO::FETCH_OBJ);
    }

    private function insert_static($query, $data){
        $sth = $this->getConnection()->prepare($query);

        return $sth->execute($data);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    static public function __callStatic($name, $arguments)
    {
        if(method_exists(__CLASS__,$name.'_static')){
            if(!isset(self::$instance)){
                self::$instance = new DB();
            }
            return call_user_func_array([self::$instance, $name.'_static'],$arguments);
        }
        throw new \Exception('Method '.$name.' not exists in '.__CLASS__);
    }

}