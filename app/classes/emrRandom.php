<?php

class emrRandom
{

  /**
   * Internal variable.
   * Character range that will be used to generate the random set
   * @var string
   */
  private static $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
  private static $alpha = 'abcdefghijklmnopqrstuvwxyz';
  private static $numeric = '0123456789';

  /**
   * Generates a random alphanumeric set (A-Z a-z 0-9)
   * @param int $length Length of the returned random set
   * @return string
   */
  public static function alphaNumeric ( $length = 14 )
  {
    $len = strlen( emrRandom::$characters ) - 1;
    $result = "";
    for ( $p = 0; $p < $length; $p++ ) {
      $randomChar = emrRandom::$characters [ mt_rand( 0, $len ) ];
      if ( !is_numeric( $randomChar ) ) {
        switch ( mt_rand( 1, 2 ) ) {
          case 1 :
            $randomChar = strtolower( $randomChar );
            break;
          case 2 :
            $randomChar = strtoupper( $randomChar );
            break;
        }
      }
      $result .= $randomChar;
    }
    return substr( $result, 0, $length );
  }

  /**
   * Generates a random alpha set (A-Z a-z)
   * @param int $length Length of the returned random set
   * @return string
   */
  public static function alpha ( $length = 14 )
  {
    $len = strlen( emrRandom::$alpha ) - 1;
    $result = "";
    for ( $p = 0; $p < $length; $p++ ) {
      $randomChar = emrRandom::$alpha [ mt_rand( 0, $len ) ];
      if ( !is_numeric( $randomChar ) ) {
        switch ( mt_rand( 1, 2 ) ) {
          case 1 :
            $randomChar = strtolower( $randomChar );
            break;
          case 2 :
            $randomChar = strtoupper( $randomChar );
            break;
        }
      }
      $result .= $randomChar;
    }
    return substr( $result, 0, $length );
  }

  /**
   * Generates a random numeric set (0-9)
   * @param int $length Length of the returned random set
   * @return string
   */
  function numeric ( $length = 14 )
  {
    $len = strlen( emrRandom::$numeric ) - 1;
    $result = "";
    for ( $p = 0; $p < $length; $p++ ) {
      $randomChar = emrRandom::$numeric [ mt_rand( 0, $len ) ];
      if ( !is_numeric( $randomChar ) ) {
        switch ( mt_rand( 1, 2 ) ) {
          case 1 :
            $randomChar = strtolower( $randomChar );
            break;
          case 2 :
            $randomChar = strtoupper( $randomChar );
            break;
        }
      }
      $result .= $randomChar;
    }
    return substr( $result, 0, $length );
  }

  /**
   * Tries to create meaningful words
   * @param int $length
   * @return string
   */
  public static function meaningful ( $length = 14 )
  {
    $vowels = 'aeiouypst';
    $consonents = 'bcdfghjklmnqrvwxz';

    $v = str_split( $vowels );
    $c = str_split( $consonents );

    $word = "";
    for ( $i = $length; $i > 0; $i-- ) {
      $lastvowel = rand( 0, 1 );
      if ( $lastvowel ) {
        $word = $word . emrRandom::returnVowel( $v );
      } else {
        $word = $word . emrRandom::returnConsonent( $c );
      }
    }

    return $word;
  }

  /**
   * Returns a random vovel
   * @param string $v
   * @return string mixed
   */
  private static function returnVowel ( $v )
  {
    return $v[ rand( 0, count( $v ) - 1 ) ];
  }

  /**
   * Returns a random consonant
   * @param string $c
   * @return string
   */
  private static function returnConsonent ( $c )
  {
    return $c[ rand( 0, count( $c ) - 1 ) ];
  }

}