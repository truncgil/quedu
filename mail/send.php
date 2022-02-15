<?php

/////////////////DIKKAT-DIKKAT/////////////////////////////
//ALTTAKi BOLUME MAiL ADRESiNiZ VE MAiL SiFRENiZi YAZINIZ//
///////////////////////////////////////////////////////////

$mail_adresiniz	= "noreply@ijem.co";
$mail_sifreniz	= "Fp8mRJXE";
$gidecek_adres	= "umit.tunc@truncgil.com";
$domain_adresi	= "ijem.co";	//www olmadan yazýnýz

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////


require("include/class.php");
$mail = new PHPMail();
$mail->Host       = "smtp.".$domain_adresi;
$mail->SMTPAuth   = true;
$mail->IsHTML();
$mail->Username   = $mail_adresiniz;
$mail->Password   = $mail_sifreniz;
$mail->IsSMTP();
$mail->AddAddress($gidecek_adres);
$mail->From       = $mail_adresiniz;
$mail->FromName   = $mail_adresiniz;
$mail->Subject    = $_POST["MailKonu"];
$mail->Body       = $_POST["mailadresi"]."\n".$_POST["Mail"];
$mail->AltBody    = "";

if(!$mail->Send()){
   echo "<html>\n";
   echo "<head>\n";
   echo "<meta http-equiv=\"Content-Language\" content=\"tr\">\n";
   echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1254\">\n";
   echo "<meta name=\"Author\" content=\"IsimTescil Destek\">\n";
   echo "<title> IsimTescil - Destek </title>\n";
   echo "</head>\n";
   echo "<body>\n";
   echo "<center>\n";
   echo "<hr width=\"500\" color=\"#C0C0C0\" style=\"border-style: double; border-width: 3px\">\n";
   echo "<font face=\"Verdana\" style=\"font-size: 8pt\"><b>[</b> <font color=\"#0000FF\">\n";
   echo "Mesajýnýz Gönderilirken bir hata oluþtu. Sunucudan gelen cevap aþaðýdaki gibidir:\n";
   echo "</font> <b>]</b></font>\n";
   echo "<br><font face=\"Verdana\" style=\"font-size: 8pt\"><b>[</b> <font color=\"#0000FF\">\n";
   echo "Hata: " . $mail->ErrorInfo;
   echo "</font> <b>]</b></font>\n";
   echo "<hr width=\"500\" color=\"#C0C0C0\" style=\"border-style: double; border-width: 3px\">\n";
   echo "</center>\n";
   echo "</body>\n";
   echo "</html>\n";
   exit;
}

   echo "<html>\n";
   echo "<head>\n";
   echo "<meta http-equiv=\"Content-Language\" content=\"tr\">\n";
   echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1254\">\n";
   echo "<meta name=\"Author\" content=\"IsimTescil Destek\">\n";
   echo "<title> IsimTescil - Destek </title>\n";
   echo "</head>\n";
   echo "<body>\n";
   echo "<center>\n";
   echo "<hr width=\"500\" color=\"#C0C0C0\" style=\"border-style: double; border-width: 3px\">\n";
   echo "<font face=\"Verdana\" style=\"font-size: 8pt\"><b>[</b> <font color=\"#0000FF\">\n";
   echo "Mesajýnýz Gönderilmiþtir.\n";
   echo "</font> <b>]</b></font>\n";
   echo "<hr width=\"500\" color=\"#C0C0C0\" style=\"border-style: double; border-width: 3px\">\n";
   echo "</center>\n";
   echo "</body>\n";
   echo "</html>\n";

?>