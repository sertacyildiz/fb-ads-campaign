<?php

class emrEmail
{
  /**
   * @var PHPMailer;
   */
  private $mailer;

  function __construct ()
  {
    $this->mailer = new PHPMailer();

    $this->mailer->IsSMTP();                  // Send via SMTP
    $this->mailer->Host = FORM_SMTP;          // SMTP servers
    $this->mailer->SMTPAuth = true;           // turn on SMTP authentication
    $this->mailer->Username = FORM_USERNAME;  // SMTP username
    $this->mailer->Password = FORM_PASSWORD;  // SMTP password
    $this->mailer->Port = 25;

    $this->mailer->WordWrap = 80;
  }

  public function SetTo ( $to, $name = "" )
  {
    $this->mailer->ClearAddresses();
    $this->mailer->AddAddress( trim( $to ), trim( $name ) );
  }

  public function SetFrom ( $from, $name = "" )
  {
    $this->mailer->From = $from;
    $this->mailer->FromName = $name;
  }

  public function SetReplyTo ( $replyTo )
  {
    $this->mailer->AddReplyTo( $replyTo );
  }

  public function SetSubject ( $subject )
  {
    $this->mailer->Subject = $subject;
  }

  public function SetMessageTEXT ( $message )
  {
    $this->mailer->AltBody = $message;
  }

  public function SetMessageHTML ( $message )
  {
    $this->mailer->IsHTML( true );
    $this->mailer->Body = $message;
  }

  function Send ()
  {
    if ( !$this->mailer->Send() ) {
      return false;
    }
    return true;
  }

  public function getError()
  {
    return $this->mailer->ErrorInfo;
  }

}