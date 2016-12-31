<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
  endHere();
}

// Reqired facebook classes
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

FacebookSession::setDefaultApplication( FACEBOOK_APP_ID, FACEBOOK_APP_SECRET );

$params = array(
    'scope' => 'email, public_profile'
);

$helper = new FacebookRedirectLoginHelper( FACEBOOK_REDIRECT_URL );
$loginUrl = $helper->getLoginUrl( $params );

header( 'Location: ' . $loginUrl );
endHere();
exit();