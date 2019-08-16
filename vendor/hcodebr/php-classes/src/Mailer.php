<?php

namespace Hcode; 

use Rain\Tpl; 

class Mailer{

    const USERNAME = "ecommercehcodeprojeto@gmail.com";
    const PASSWORD = "projet0h0c0de"; 
    const NAME_FROM = "WebJump Store";

    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {
        $config = array(
            "tpl_dir"    => $_SERVER["DOCUMENT_ROOT"] . '/views/email/',
            "cache_dir"  => $_SERVER["DOCUMENT_ROOT"] . "/views-cache/",
            "debug"      => false // set to false to improve the speed
        );

        Tpl::configure( $config );

        $tpl = new Tpl;

        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
        }

        $html = $tpl->draw($tplName, true);

        $this->mail = new \PHPMailer;
        
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Mailer::USERNAME;
        $this->mail->Password = Mailer::PASSWORD;
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
        $this->mail->addAddress($toAddress, $toName);
        $this->mail->Subject = $subject;
        $this->mail->msgHTML($html);
         $this->mail->AltBody = 'html não funcionou :(';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

/*
        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Message sent!";
       }
*/

//function save_mail($mail)
//{
//    //You can change 'Sent Mail' to any other folder or tag
//    $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
//    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
//    $imapStream = imap_open($path, $mail->Username, $mail->Password);
//    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
//    imap_close($imapStream);
//    return $result;
//}

    }

    public function send()
    {
        return $this->mail->send();
    }
}

?>