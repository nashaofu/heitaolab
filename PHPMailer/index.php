<?php
	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.mxhichina.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'master@heitaolab.com';                 // SMTP username
	$mail->Password = 'Heitaolab274394';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('master@heitaolab.com', '黑桃Lab管理员');
	//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	$mail->addAddress('752283320@qq.com');               // Name is optional
	$mail->addReplyTo('master@heitaolab.com', '黑桃Lab管理员');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = '测试';
	$mail->Body    = 'HTML测试 <b>in bold!</b><a href="http://www.heitaolab.com">heitaolab</a>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	    echo '发送失败！';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo '发送成功！';
	}
?>