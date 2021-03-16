<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\emailsController;

class emailsController extends Controller
{
	
    public function project_invitation($name, $email, $sname, $semail, $project_id, $user_id, $invited_by)
    {
	
		require 'vendor/autoload.php';

    	$host = env("MAIL_HOST", "default");
    	$port = env("MAIL_PORT", "465");
    	$username = env("MAIL_USERNAME", "default");
    	$password = env("MAIL_PASSWORD", "default");
    	$from = env("MAIL_FROM_ADDRESS", "default");
    	$fromName = env("MAIL_FROM_NAME", "default");
    	$domain = env("APP_URL", "http://127.0.0.1:8000/");

    	$mail = new PHPMailer(true);

		try {
		   //Server settings
		   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
		   // $mail->isSMTP();                  
		   $mail->Host       = $host;                  
		   $mail->SMTPAuth   = true; 
		   $mail->Username   = $username;
		   $mail->Password   = $password;
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		   $mail->Port       = $port;

		    //Recipients
		    $mail->setFrom($from, $fromName);
		    $mail->addAddress($email);     // Add a recipient
		    $mail->addReplyTo($from, $fromName);
		    
		
		    $mail->isHTML(true);

		    $mail->Subject = 'New Project Invitation';
		    $mail->Body    = '<p>Hello '.$name.',<br>You have recieved a new project Invitation. <a href="'.$domain.'projects/'.$project_id.'/invite/'.$user_id.'/'.$invited_by.'/accept" target="_blank">Click here</a> to accept.</p>';

		    $mail->send();
		    

		} catch (Exception $e) {
		   return $e;
		}
    }
    public function recover_user_password($name, $email, $id)
    {
    	require 'vendor/autoload.php';

    	$host = env("MAIL_HOST", "default");
    	$port = env("MAIL_PORT", "465");
    	$username = env("MAIL_USERNAME", "default");
    	$password = env("MAIL_PASSWORD", "default");
    	$from = env("MAIL_FROM_ADDRESS", "default");
    	$fromName = env("MAIL_FROM_NAME", "default");
    	$domain = env("APP_URL", "http://127.0.0.1:8000/");

    	$user_salt = uniqid(rand(99,999)).'.'.$id.uniqid(rand(99,999));

        $randstring = md5(uniqid());
  

    	$mail = new PHPMailer(true);

		try {
		   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
		  // $mail->isSMTP();                  
		   $mail->Host       = $host;                  
		   $mail->SMTPAuth   = true; 
		   $mail->Username   = $username;
		   $mail->Password   = $password;
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		   $mail->Port       = $port;

		    //Recipients
		    $mail->setFrom($from, $fromName);
		    $mail->addAddress($email, $name);
		    $mail->addReplyTo($from, $fromName);
		    

		    // Content
		    $mail->isHTML(true);
		    $mail->Subject = 'Recover your password';
		    $mail->Body    = '<p>Hello '.$name.',<br>Copy and paste the below URL to recover your password, or <a href="'.$domain.'recover/password?s='.$randstring.'&r='.$user_salt.'" target="_blank">Click here</a>.</p><p>'.$domain.'recover/password?s='.$randstring.'&r='.$user_salt.'</p>';

		    $mail->send();
		    

		} catch (Exception $e) {
		   return $e;
		}
    }
    public function signup_verification_email($name, $email){

    	require 'vendor/autoload.php';

    	$host = env("MAIL_HOST", "default");
    	$port = env("MAIL_PORT", "465");
    	$username = env("MAIL_USERNAME", "default");
    	$password = env("MAIL_PASSWORD", "default");
    	$from = env("MAIL_FROM_ADDRESS", "default");
    	$fromName = env("MAIL_FROM_NAME", "default");
    	$domain = env("APP_URL", "http://127.0.0.1:8000/");

    	$user_salt = uniqid(rand(99,999)).'urlsalter'.$email.'urlsalter'.uniqid(rand(99,999));

        $randstring = md5(uniqid());
   

    	$mail = new PHPMailer(true);

		try {
		   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
		  // $mail->isSMTP();                  
		   $mail->Host       = $host;                  
		   $mail->SMTPAuth   = true; 
		   $mail->Username   = $username;
		   $mail->Password   = $password;
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		   $mail->Port       = $port;

		    //Recipients
		    $mail->setFrom($from, $fromName);
		    $mail->addAddress($email, $name);
		    $mail->addReplyTo($from, $fromName);
		    

		    // Content
		    $mail->isHTML(true);
		    $mail->Subject = 'Activate your account.';
		    $mail->Body    = '<p>Hello '.$name.',<br>Copy and paste the below URL to active your account, or <a href="'.$domain.'account/activate?user='.$email.'&s='.$randstring.'&r='.$user_salt.'" target="_blank">Click here</a>.</p><p>'.$domain.'account/activate?user='.$email.'&s='.$randstring.'&r='.$user_salt.'</p>';

		    $mail->send();
		    

		} catch (Exception $e) {
		   return $e;
		}

    }
    public function template_sharing_invitation($name, $email, $sname, $semail, $template_salt, $user_id, $invited_by)
    {
	
		require 'vendor/autoload.php';

    	$host = env("MAIL_HOST", "default");
    	$port = env("MAIL_PORT", "465");
    	$username = env("MAIL_USERNAME", "default");
    	$password = env("MAIL_PASSWORD", "default");
    	$from = env("MAIL_FROM_ADDRESS", "default");
    	$fromName = env("MAIL_FROM_NAME", "default");
    	$domain = env("APP_URL", "http://127.0.0.1:8000/");

    	$mail = new PHPMailer(true);

		try {
		    //Server settings
		   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
		  // $mail->isSMTP();                  
		   $mail->Host       = $host;                  
		   $mail->SMTPAuth   = true; 
		   $mail->Username   = $username;
		   $mail->Password   = $password;
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		   $mail->Port       = $port;

		    //Recipients
		    $mail->setFrom($from, $fromName);
		    $mail->addAddress($email);
		    $mail->addReplyTo($from, $fromName);
		    
		    $mail->isHTML(true);

		    $mail->Subject = 'New Template Invitation';
		    $mail->Body    = '<p>Hello '.$name.',<br>You have recieved a new template invitation. <a href="'.$domain.'templates/'.$template_salt.'/invite/'.$user_id.'/'.$invited_by.'/accept" target="_blank">Click here</a> to accept.</p>';

		    $mail->send();
		    

		} catch (Exception $e) {
		   return $e;
		}
    }
    public function user_invitation($name, $email, $invited_by, $user_name){

    	require 'vendor/autoload.php';

    	$host = env("MAIL_HOST", "default");
    	$port = env("MAIL_PORT", "465");
    	$username = env("MAIL_USERNAME", "default");
    	$password = env("MAIL_PASSWORD", "default");
    	$from = env("MAIL_FROM_ADDRESS", "default");
    	$fromName = env("MAIL_FROM_NAME", "default");
    	$domain = env("APP_URL", "http://127.0.0.1:8000/");

    	$user_salt = uniqid(rand(99,999)).'urlsalter'.$email.'urlsalter'.uniqid(rand(99,999));

        $randstring = md5(uniqid());
        
    	$mail = new PHPMailer(true);

		try {
		   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
		  // $mail->isSMTP();                  
		   $mail->Host       = $host;                  
		   $mail->SMTPAuth   = true; 
		   $mail->Username   = $username;
		   $mail->Password   = $password;
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		   $mail->Port       = $port;

		    //Recipients
		    $mail->setFrom($from, $fromName);
		    $mail->addAddress($email, $name);
		    $mail->addReplyTo($from, $fromName);
		    

		    // Content
		    $mail->isHTML(true);
		    $mail->Subject = 'Groundplan Invitation';
		    $mail->Body    = '<p>Hello '.$name.',<br><b>'.$user_name.'</b> invited you to join Groundplan. <a href="'.$domain.'user/join?user='.$email.'&s='.$randstring.'&r='.$user_salt.'" target="_blank">Click here</a> to join now.</p><p>'.$domain.'user/join?user='.$email.'&s='.$randstring.'&r='.$user_salt.'</p>';

		    $mail->send();
		    

		} catch (Exception $e) {

		}

    }
}
