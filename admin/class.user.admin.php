<?php

require_once '../dbconfig.php';

class ADMIN
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
	
	public function login($useradmin,$passadmin)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM admin WHERE user=:admin");
			$stmt->execute(array(":admin"=>$useradmin));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{

					if($userRow['passadmin']==$passadmin)
					{
						$_SESSION['adminSession'] = $userRow['adminID'];
						return true;
					}
					else
					{
						header("Location: ../admin/login-admin.php?error");
						exit;
					}
				
			}
			else
			{
				header("Location: ../admin/login-admin.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['adminSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		
		unset($_SESSION['adminSession']);
	}	
	
	function send_mail($email,$message,$subject)
	{						
		require_once('../../mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "mail.orinococambio.com";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username="noreply@orinococambio.com";  
		$mail->Password= "8490560jfR";            
		$mail->SetFrom('noreply@orinococambio.com','Orinoco');
		$mail->AddReplyTo("noreply@orinococambio.com","Orinoco");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		if(!$mail->Send()) {
		    return false;
		} 
		else {
		    return true;
		}
	}	
}