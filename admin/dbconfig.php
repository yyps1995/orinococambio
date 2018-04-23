<?php
    $mysql=new mysqli("localhost","root","","orinocobd");
        if ($mysql->connect_error){
            die("no se puede conectar a la base de datos");

        }
class Database
{
     
    private $host = "localhost";
    private $db_name = "orinocobd";
    private $username = "root";
    private $password = "";
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }


}
?>