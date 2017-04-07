<?php
/** DEBUG */
define( "DEBUG", true );
define( "DEBUG_LOG", true );

/*
 * SYSTEM CONFIGURATION
 */
error_reporting( E_ALL );
date_default_timezone_set( "Europe/Istanbul" );
ini_set( 'display_errors', DEBUG ? 1 : 0 );
ini_set( "log_errors", DEBUG_LOG ? 1 : 0  );
ini_set( "log_errors_max_len", 0 );
ini_set( "error_log", __DIR__ . "/../error.log" );
ini_set( 'session.gc_maxlifetime', '86400 * 3' );
ini_set( 'session.use_trans_sid', false );
ini_set( 'session.cookie_lifetime', '86400 * 3' );
ini_set( 'session.cookie_domain', '.fbadtest.mrkd.info' );
ini_set( 'session.save_path', __DIR__ . "/../session" );
ini_set( 'url_rewriter.tags', '' );
session_name( 'markakod' );
session_start();

// Check for secure connection
$http = "http";
if ( isset( $_SERVER[ 'SERVER_PORT' ] ) ) {
    if ( !empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' || $_SERVER[ 'SERVER_PORT' ] == 443 ) {
        $http = "https";
    }
}

/** Cookie domain */
define( "DOMAIN", "*" );

/** Site domain */
define( "DOMAIN_SITE", "fbadtest.mrkd.info" );
//define( "DOMAIN_SITE", "markakod.emrg.me" );

/** Application title */
define( "APP_TITLE", "FB ADS" );

//CAMPAIGN ID
define("CAMPAIGN_ID", "6039675316489");

//ACCESS TOKEN
define("ACCESS_TOKEN", "EAAUygNNkpFYBAEHDAfwKwdZBSfqH549c2o4t1BJ9eoiRSXFZB6lyCFG3vNe8DzfhZBoldkdtVjavjHJVXjaH6khFspExBAij0348Lj7TcORyWTR7Gz1ym3AyKZCjO42wuiZBxxBZCTu9s64JUrkHnw3ZCpNvbik5wAZD");

/** Root folder of the system */
define( "ROOT", __DIR__ );
/** Root folder for public html */
define( "PUBLIC_HTML", ROOT . "/../public_html" );

/** Photo upload folder */
define( "TEMP_FOLDER", ROOT . "/tempfolder" );

/** Public url */
define( "PUBLIC_HTML_URL", "{$http}://" . DOMAIN_SITE );

/** Facebook App ID */
define( "FACEBOOK_APP_ID", "1462903767344214" );
/** Facebook App Secret */
define( "FACEBOOK_APP_SECRET", "345b7b64c07baeed0d34c8059765823c" );
/** Facebook App Title */
define( "FACEBOOK_APP_TITLE", "Marketing API App" );
/** Facebook Redirect Url */
define( "FACEBOOK_REDIRECT_URL", PUBLIC_HTML_URL . "/adtest/index/" );


/** Actions files */
define( "ACTIONS", ROOT . "/actions" );


require __DIR__ . '/composer/vendor/autoload.php';

// Load required php classses
$classes = glob( ROOT . "/classes/*.php" );
if ( $classes && is_array( $classes ) ) {
    foreach ( $classes as $file ) {
        /** @noinspection PhpIncludeInspection */
        include_once $file;
    }
}
unset( $classes );

// Load app php classes
$classes = glob( ROOT . "/classes_app/*.php" );
if ( $classes && is_array( $classes ) ) {
    foreach ( $classes as $file ) {
        /** @noinspection PhpIncludeInspection */
        include_once $file;
    }
}
unset( $classes );

// Load required php functions
$functions = glob( ROOT . "/functions/*.php" );
if ( $functions && is_array( $functions ) ) {
    foreach ( $functions as $file ) {
        /** @noinspection PhpIncludeInspection */
        include_once $file;
    }
}
unset( $functions );
