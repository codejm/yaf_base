<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      首页
 *      $Id: Index.php 2014-07-27 18:10:47 codejm $
 */

class IndexController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {
        $mail = new PHPMailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.163.com;';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'codejm@163.com';                 // SMTP username
        $mail->Password = 'password';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->From = 'codejm@163.com';
        $mail->FromName = 'codejm';
        $mail->addAddress('codejm@qq.com', 'codejm');     // Add a recipient

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
        exit;
    }

    public function testAction() {
        echo $this->geta('name');
        exit;
    }
}

?>
