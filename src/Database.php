<?php declare(strict_types=1);

namespace Database; 
use \PDO; 
use \PDOException;

class Database {
    
    private $pdo; 
    private $isConnected;
    private $statement;
    protected $settings = [];
    private $params = [];
    
   
    public function __construct( array $settings) 
    {

        $this->settings = $settings;

        $this->connect();
       
    }

    public function connect() 
    {
        
        $dsn = $this->settings['driver']. ":host=". $this->settings['host'] .";dbname=". $this->settings['db_name'];
    try{ 
        $this->pdo = new PDO($dsn, $this->settings['db_user'], $this->settings['db_password'], 
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->settings['charset']]); 

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $this->isConnected = true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        
    }

    public function close() 
    {
       
        $this->pdo = null;
    }

    private function init(string $query, array $params = []) 
    {
        if (!$this->isConnected) {
            $this->connect();
        }

        try {
            $this->statement = $this->pdo->prepare($query);

            $this->bind($params);
            
            if (!empty($this->params)) {
                foreach($this->params as $param => $key) {
                    if (is_int($key[1])) {
                        $type = PDO::PARAM_INT; 
                    } elseif (is_bool($key[1])) {
                        $type = PDO::PARAM_BOOL;
                    } elseif (is_null($key[1])) {
                        $type = PDO::PARAM_NULL;
                    } else {
                        $type = PDO::PARAM_STR;
                    }

                    $this->statement->bindValue($key[0], $key[1], $type);

                }
            }
            $this->statement->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        
    }

    private function bind(array $params) : void 
    {
        if (!empty($params) and is_array($params)) {
            $columns = array_keys($params);
            
            foreach ($columns as $i => &$column) {
                $this->params[sizeof($this->params)] = [
                    ":" .$column, 
                    $params[$column]
                ];
            }
            
        }
    }

    public function query(string $query, array $params = [], $mode = PDO::FETCH_ASSOC)
    {
        $query = trim(str_replace('\r', ' ', $query));
       
        $this->init($query, $params); 
        
        $rowStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));
        
        
        $statement = strtolower($rowStatement[0]); 
        
        
        if ($statement == 'select' || $statement == 'show') {
            
            return $this->statement->fetchAll($mode);
        } elseif ($statement == 'insert' || $statement == 'update'|| $statement == 'delete') {
            
            return $this->statement->rowCount();
        } else {
            return null;
        }
    }

    public function lastInsertId() 
    {
        $this->pdo->lastInsertId();
    }

}


?>