<?php
require_once 'dbconfig.php';

class USER
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
	
	public function register($unombre,$uapellido,$email,$upass,$code,$telefono)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(nombre,apellido,user_email,userPass,tokenCode,telefono) 
			                                             VALUES( :user_nombre, :user_apellido, :user_mail, :user_pass, :active_code, :user_telefono)");
			$stmt->bindparam(":user_nombre",$unombre);
			$stmt->bindparam(":user_apellido",$uapellido);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":user_telefono",$telefono);



			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	
	public function login($user,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE user_email=:user");
			$stmt->execute(array(":user"=>$user));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: ?error");
						exit;
					}
				}
				else
				{
					header("Location: ?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: ?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function logan($user,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE user_email=:user");
			$stmt->execute(array(":user"=>$user));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: signup.php?error");
						exit;
					}
				}
				else
				{
					header("Location: signup.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: signup.php?error");
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
		if(isset($_SESSION['userSession']))
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
		unset($_SESSION['userSession']);
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
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
?>