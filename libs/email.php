<?php


class Email extends Base
{

    public function __construct($host,$port,$user,$password)
    {
        $this->Mail = new PHPMailer;
        $this->Mail->Host = $host;
        $this->Mail->Port = $port;
        $this->Mail->Username = $user;
        $this->Mail->Password = $password;
    }
    
    public function SendActivationLink($to)
    {
        $this->Send($to,$this->Msg('_ACTIVATION_LINK_','Activation Link'));
    }
    
    public function Send($from,$to, $subject, $message)
    {
    

    //$mail->SMTPDebug = 3;                                 // Enable verbose debug output

    $this->Mail->CharSet = 'UTF-8';
    $this->Mail->isSMTP();                                        // Set mailer to use SMTP
    //$this->mail->Host =  SMTP_HOST;                               // Specify main and backup SMTP servers
    $this->Mail->SMTPAuth = true;                                 // Enable SMTP authentication
    //$this->mail->Username = SMTP_USER;                            // SMTP username
    //$this->mail->Password = SMTP_PASSWORD;                        // SMTP password
    $this->mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
    //$this->mail->Port = 587;                                      // TCP port to connect to
    $this->Mail->SMTPOptions = array
    (
        'ssl' => array
        (
            'verify_peer' => true,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $this->Mail->setFrom($from, '');
    $this->Mail->addAddress($to);                                 // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $this->Mail->isHTML(true);                                    // Set email format to HTML

    $this->Mail->Subject = $subject;
    $this->Mail->Body    = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if($this->Mail->send())
    {
        echo 'Message has been sent';
        return true;
        
    } else {
        
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $this->Mail->ErrorInfo;
        $this->LastError = $this->Mail->ErrorInfo;
        return false;
        
    }
    }
    
     
  

}
