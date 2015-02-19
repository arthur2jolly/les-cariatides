<?
reset($HTTP_POST_VARS);
while (list($key, $val) = each($HTTP_POST_VARS)) {
  $$key = $val;
  if (!empty($val)) {
    $msg .= "$key = $val<br>";
  }
}

//$mail_reception = "frederiqueneri@aol.com";
$mail_reception = "contact@les-cariatides.com";
$subject = "Formulaire de contact";
$option = "From: ";
$defaut = "les-cariatides";
if ($name) {$option .= $name;}
if ($email) {$option .= "<$email>";}
if (!$email AND !$name) {$option .= $defaut;}
$option .= "\nContent-type: text/html";
if ($email AND $name)
{
	mail($mail_reception, $subject, "DE : ". $email . "<br><br>" . stripslashes(nl2br($message)), $option);
	header("Location: merci.html");
} else {
	header("Location: contact.html");
}
?>