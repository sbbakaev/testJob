<?php

/**
 * Class Init a class whitch could not be inherited and contains methods for working whith DB
 *
 * @author Sergey Bakaev <sbbakaev@gmail.com>
 * @version 1.0
 */
final class Init
{
    private $db;
    private $table;
    private $connect = null;

    /**
     * Init constructor.
     * @throws exception if connection error
     */
    function __construct($host, $user, $pass, $db = "testDB", $table = "test")
    {
        $this->db = $db;
        $this->table = $table;
        $this->connect = new mysqli($host, $user, $pass);

        if ($this->connect->connect_error) {
            throw new Exception('Connection error (' . $this->connect->connect_errno . ') '
                . $this->connect->connect_error);
        }
    }

    /**
     * Create DB if it doesn't exist
     *
     * @access private
     * @throws exception if creating db has error
     */
    private function createDB()
    {
        /* Create database */
        if (!$this->connect->real_query("CREATE DATABASE IF NOT EXISTS $this->db")) {
            throw new Exception('Creation DB error (' . $this->connect->errno . ') '
                . $this->connect->error);
        }
    }

    /**
     * Create table if it doesn't exist
     *
     * @@access private
     * @throws exception if creating table has error
     */
    private function create()
    {
        $this->selectDb();
        $queryText = "CREATE TABLE IF NOT EXISTS $this->table (
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        script_name VARCHAR(25),
                        strart_time DATETIME,
                        end_time DATETIME,
                        result enum('normal', 'illegal', 'failed', 'success')
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        if(!$this->connect->query($queryText)){
            throw new Exception('Creation table error (' . $this->connect->errno . ') '
                . $this->connect->error);
        }
    }

    /**
     * Fills table with random data
     *
     * @param int $count Count to fill rows
     * @access private
     * @throws exception if filling table has error
     */
    private function fill($count = 100)
    {
        $this->selectDb();
        $resultVariables = array("normal", "illegal", "failed", "success");
        /* Fill table */
        $queryText = "INSERT INTO $this->table (id, script_name, strart_time, end_time, result) VALUES ";
        for($i = 0; $i < $count; $i++){
            $result = $resultVariables[rand(0,3)];
            $dateTime = new DateTime();
            $dateStr = $dateTime->format("Y-m-d H:i:s");
            $queryText = $queryText." (null, \"script name $i\", \"$dateStr\", \"$dateStr\", \"$result\")";
            if($i < $count-1){
                $queryText = $queryText.", ";
            }
        }
        if(!$this->connect->real_query($queryText)){
            throw new Exception('Filling table error (' . $this->connect->errno . ') '
                . $this->connect->error);
        }
    }

    /**
     * Select data from table where “result” is only “normal” or “success”
     *
     * @param $hasMysqlnd boolean if installed Mysqlnd true
     * @return array
     * @access public
     * @throws exception if select data from table has error
     */
    public function get($hasMysqlnd = false){
        $this->selectDb();
        $data = array();

        /* Get data */
        $queryText = "SELECT * FROM $this->table WHERE result in ('normal','success')";
        if($result = $this->connect->query($queryText)){

            // notice. You need install mysqlnd http://php.net/manual/en/mysqlnd.install.php if you want use fetch_all.
            if($hasMysqlnd){
                $data = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                while ($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $data[] = $row;
                }
            }
            $result->close();
        } else {
            throw new Exception('Get data error (' . $this->connect->errno . ') '
                . $this->connect->error);
        }

        return $data;
    }

    /**
     * Drop DB
     *
     * @access public
     * @throws exception if drop db has error
     */
    public function drop() {
        /* Drop database */
        if (!$this->connect->real_query("DROP DATABASE IF EXISTS $this->db")) {
            throw new Exception('Creation DB error (' . $this->connect->errno . ') '
                . $this->connect->error);
        }
    }

    /**
     * Closes a previously opened database connection
     * @return bool true on success or false on failure.
     */
    public function closeConnect() {
        return $this->connect->close();
    }

    /**
     * select db method
     *
     * @throws exception if select db has error
     */
    private function selectDb(){
        if(!$this->connect->select_db($this->db)){
            throw new Exception('Select Db error (' . $this->connect->errno . ') '
                . $this->connect->error);
        }
    }
}
