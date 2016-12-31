<?php

/**
 * Session and login checker
 * @author emrahgunduz
 */
class emrSession
{
  /**
   * @var emrMongo
   */
  private $mongo;
  /**
   * @var emrRandom
   */
  private $randomString;

  private $username;
  private $password;
  private $remember;
  private $sessionid;

  function emrSession ()
  {
    global $mongo;
    $this->mongo = $mongo;
    $this->randomString = new emrRandom();
  }

  /**
   * Confirms login information
   * @return bool Returns true if user information is true
   */
  function ConfirmLogin ()
  {
    // Check if there is any input
    if ( !isset( $_POST[ "username" ] ) || !isset( $_POST [ "password" ] ) ) {
      return false;
    }

    // Get user input
    $this->username = filter_var( $_POST[ "username" ], FILTER_SANITIZE_MAGIC_QUOTES );
    $this->password = filter_var( $_POST [ "password" ], FILTER_SANITIZE_MAGIC_QUOTES );
    $this->remember = isset( $_POST [ "remember" ] ) ? 1 : 0;

    // Get user password
    $this->mongo->setCollection( COLLECTION_ADMINS );
    $currentpassword = $this->mongo->dataFindOne( array( "username" => $this->username, "active" => 1 ) );

    if ( !isset( $currentpassword[ "password" ] ) ) {
      return false;
    } else {
      $currentpassword = $currentpassword[ "password" ];
    }

    // Check password
    if ( $currentpassword && $currentpassword == sha1( $this->password ) ) {
      // Login successful
      // Create new session and write it to db
      $this->sessionid = $this->randomString->AlphaNumeric( 25 );
      $this->mongo->setCollection( COLLECTION_ADMINS );
      $this->mongo->dataUpdate( array( "username" => $this->username ), array( '$set' => array( "sessionid" => $this->sessionid ) ) );

      // Set session for user
      $_SESSION [ "username" ] = $this->username;
      $_SESSION [ "sessionid" ] = $this->sessionid;
      $_SESSION [ "remember" ] = $this->remember;

      if ( $this->remember == 1 && !headers_sent() ) {
        // Set cookies (expires in 30 days)
        setcookie( "username", $this->username, time() + ( 60 * 60 * 24 ) * 30, "/", DOMAIN, false, true );
        setcookie( "sessionid", $this->sessionid, time() + ( 60 * 60 * 24 ) * 30, "/", DOMAIN, false, true );
        setcookie( "remember", $this->remember, time() + ( 60 * 60 * 24 ) * 30, "/", DOMAIN, false, true );
      }

      // Update user time
      $this->mongo->setCollection( COLLECTION_ADMINS );
      $this->mongo->dataUpdate( array( "username" => $this->username ), array( '$set' => array( "lastaccess" => date( 'Y-m-d H:i:s' ) ) ) );

      return true;
    } else {
      return false;
    }
  }

  /**
   * Confirms session of the user
   * @return bool Returns true if the session information is safe
   */
  function ConfirmSession ()
  {
    // Get session info
    $this->username = isset( $_SESSION [ "username" ] ) ? $_SESSION [ "username" ] : null;
    $this->sessionid = isset( $_SESSION [ "sessionid" ] ) ? $_SESSION [ "sessionid" ] : null;
    $this->remember = isset( $_SESSION [ "remember" ] ) ? $_SESSION [ "remember" ] : 0;

    // Check cookie if no session is available
    if ( !$this->username || !$this->sessionid ) {
      $this->username = isset( $_COOKIE [ "username" ] ) ? $_COOKIE [ "username" ] : null;
      $this->sessionid = isset( $_COOKIE [ "sessionid" ] ) ? $_COOKIE [ "sessionid" ] : null;
      $this->remember = isset( $_COOKIE [ "remember" ] ) ? $_COOKIE [ "remember" ] : 0;
    }

    // Get user info
    $this->mongo->setCollection( COLLECTION_ADMINS );
    $currentsessionid = $this->mongo->dataFindOne( array( "username" => $this->username, "active" => 1 ), array( "sessionid" => 1 ) );
    if ( !isset( $currentsessionid[ "sessionid" ] ) || $currentsessionid[ "sessionid" ] == "..." ) {
      return false;
    } else {
      $currentsessionid = $currentsessionid[ "sessionid" ];
    }

    // If user's session is the same
    if ( $this->sessionid && $currentsessionid && $this->sessionid == $currentsessionid ) {
      $_SESSION [ "username" ] = $this->username;
      $_SESSION [ "sessionid" ] = $this->sessionid;
      $_SESSION [ "remember" ] = $this->remember;

      // Update user time
      $this->mongo->setCollection( COLLECTION_ADMINS );
      $this->mongo->dataUpdate( array( "username" => $this->username ), array( '$set' => array( "lastaccess" => date( 'Y-m-d H:i:s' ) ) ) );

      return true;
    } else {
      return false;
    }
  }

  /**
   * Destroys the session.
   */
  function DestroySession ()
  {
    // Destroy user session in database
    $set = array(
        '$set' => array(
            "sessionid" => $this->randomString->AlphaNumeric( 25 ),
            "lastaccess" => date( 'Y-m-d h:m:s' )
        )
    );

    $this->mongo->setCollection( COLLECTION_ADMINS );
    $this->mongo->dataUpdate( array( "username" => $this->username ), $set );

    // Destroy cookies
    setcookie( "username", false, time() + 60 * 60 * 24 * 30 * 60, "/", DOMAIN, false, true );
    setcookie( "sessionid", false, time() + 60 * 60 * 24 * 30 * 60, "/", DOMAIN, false, true );
    setcookie( "remember", false, time() + 60 * 60 * 24 * 30 * 60, "/", DOMAIN, false, true );

    return session_destroy();
  }

  /**
   * Returns the username of the logged in user
   * @return string
   */
  function GetUsername ()
  {
    $this->username = isset( $_SESSION [ "username" ] ) ? sanitize_string( $_SESSION [ "username" ] ) : null;
    if ( !$this->username ) {
      $this->username = isset( $_COOKIE [ "username" ] ) ? sanitize_string( $_COOKIE [ "username" ] ) : null;
    }
    return $this->username;
  }

  /**
   * Returns ID of the logged in user
   * @return int
   */
  function GetId ()
  {
    $this->username = isset( $_SESSION [ "username" ] ) ? sanitize_string( $_SESSION [ "username" ] ) : null;
    if ( !$this->username ) {
      $this->username = isset( $_COOKIE [ "username" ] ) ? sanitize_string( $_COOKIE [ "username" ] ) : null;
    }
    $this->mongo->setCollection( COLLECTION_ADMINS );
    $data = $this->mongo->dataFindOne( array( "username" => $this->username ) );
    return isset( $data[ "_id" ] ) ? $data[ "_id" ] : 0;
  }

  /**
   * Returns the name of the logged in user
   * @return string
   */
  function GetName ()
  {
    $this->username = isset( $_SESSION [ "username" ] ) ? sanitize_string( $_SESSION [ "username" ] ) : null;
    if ( !$this->username ) {
      $this->username = isset( $_COOKIE [ "username" ] ) ? sanitize_string( $_COOKIE [ "username" ] ) : null;
    }
    $this->mongo->setCollection( COLLECTION_ADMINS );
    $data = $this->mongo->dataFindOne( array( "username" => $this->username ) );
    return isset( $data[ "name" ] ) ? $data[ "name" ] : "?";
  }

  /**
   * Returns the sha1 encoded password of the logged in user
   * @return string
   */
  function GetPassword ()
  {
    $this->username = isset( $_SESSION [ "username" ] ) ? sanitize_string( $_SESSION [ "username" ] ) : null;
    if ( !$this->username ) {
      $this->username = isset( $_COOKIE [ "username" ] ) ? sanitize_string( $_COOKIE [ "username" ] ) : null;
    }
    $this->mongo->setCollection( COLLECTION_ADMINS );
    $data = $this->mongo->dataFindOne( array( "username" => $this->username ) );
    return isset( $data[ "password" ] ) ? $data[ "password" ] : 0;
  }

  /**
   * Save the new password
   * @param string $p
   */
  function SetPassword ( $p )
  {
    $this->username = isset( $_SESSION [ "username" ] ) ? sanitize_string( $_SESSION [ "username" ] ) : null;
    if ( !$this->username ) {
      $this->username = isset( $_COOKIE [ "username" ] ) ? sanitize_string( $_COOKIE [ "username" ] ) : null;
    }
    $this->mongo->setCollection( COLLECTION_ADMINS );
    $this->mongo->dataUpdate( array( "username" => $this->username ), array( '$set' => array( "password" => sha1( $p ) ) ) );
  }

}