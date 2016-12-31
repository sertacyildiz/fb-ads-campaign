<?php

if (!isset($_POST['name'])) {
    endHere();
    exit;
}

$name = sanitize_string($_POST['name']);
$email = sanitize_string($_POST['email']);
$message = sanitize_string($_POST['message']);

$emrEmail = new emrEmail();
$emrEmail->SetTo( FORM_EMAIL );
$emrEmail->SetFrom( $email );
$emrEmail->SetMessageTEXT( $message );
$emrEmail->SetReplyTo( $email );
$emrEmail->SetSubject( SMTP_MESSAGE_SUBJECT );

if (!$emrEmail->send()) {
    echo "Mailer Error";
} else {
    echo "Message sent!";
}