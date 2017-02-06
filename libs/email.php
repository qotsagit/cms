<?php


class Email extends Base
{

    public function __construct()
    {
       
    }
    
    public function SendActivationLink($to)
    {
        $this->Send($to,$this->Msg('_ACTIVATION_LINK_','Activation Link'));
    }
    
    public function Send($to, $subject, $message)
    {

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                                 // Enable verbose debug output

    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();                                        // Set mailer to use SMTP
    $mail->Host =  SMTP_HOST;                               // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                 // Enable SMTP authentication
    $mail->Username = SMTP_USER;                            // SMTP username
    $mail->Password = SMTP_PASSWORD;                        // SMTP password
    $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                      // TCP port to connect to

    $mail->setFrom(SMTP_FROM, '');
    $mail->addAddress($to);                                 // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                    // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if($mail->send())
    {
        return true;
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        $this->LastError = $mail->ErrorInfo;
        
    } else {
        
        return false;
        echo 'Message has been sent';
    }
    } 
    
     
    /*
    public function Send($to, $subject, $message)
    {
        $from = SMTP_FROM;
        $host = SMTP_HOST;
        $username = SMTP_USER;
        $password = SMTP_PASSWORD;
        $headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject);
        
        print_r($headers);
        $smtp = Mail::factory('smtp',   array ('host' => $host,'debug' => true, 'auth' => true, 'username' => $username, 'password' => $password)); 
        $mail = $smtp->send($to, $headers, $message); 

        if (PEAR::isError($mail)) 
        {
            echo("<p>" . $mail->getMessage() . "</p>");
            print $mail->getUserInfo();
            return false;
        } else {
            echo("<p>Message successfully sent!</p>");
            return true;
        }

    }
    */

}
