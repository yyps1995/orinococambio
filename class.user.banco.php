<?php
require_once 'dbconfig.php';

class BANCO

{


	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

public function banco($unombre,$uapellido,$email,$banco,$tipobanco,$nrocuenta,$cedula)
	{
		try
		{							
			$stmt = $this->conn->prepare("INSERT INTO banco(nombre,apellido,user_email,banco,bancotipo,nrocuenta,cedula) 
			                                             VALUES(,:user_nombre, :user_apellido, :user_mail, :user_banco, :user_tipobanco, :user_nrocuenta, :user_cedula)");
			$stmt->bindparam(":user_nombre",$unombre);
			$stmt->bindparam(":user_apellido",$uapellido);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_banco",$banco);
			$stmt->bindparam(":user_tipobanco",$tipobanco);
			$stmt->bindparam(":user_nrocuenta",$nrocuenta);
			$stmt->bindparam(":user_cedula",$cedula);

			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

}