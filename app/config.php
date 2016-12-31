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

/** Admin url */
define( "ROOTURL", "{$http}://" . DOMAIN_SITE . "/administration" );
/** Public url */
define( "PUBLIC_HTML_URL", "{$http}://" . DOMAIN_SITE );

define( "ROOT_IMAGES", PUBLIC_HTML . "/content" );
/** Upload folder url */
define( "ROOT_IMAGES_URL", PUBLIC_HTML_URL . "/content" );

/** Photo upload folder */
define( "PERSON_IMAGES", PUBLIC_HTML . "/content/person" );
/** Photo folder url */
define( "PERSON_IMAGES_URL", PUBLIC_HTML_URL . "/content/person" );

define( "REFERENCE_IMAGES", PUBLIC_HTML . "/content/reference" );
/** Photo folder url */
define( "REFERENCE_IMAGES_URL", PUBLIC_HTML_URL . "/content/reference" );

define( "BUSINESSPARTNER_IMAGES", PUBLIC_HTML . "/content/businesspartner" );
/** Photo folder url */
define( "BUSINESSPARTNER_IMAGES_URL", PUBLIC_HTML_URL . "/content/businesspartner" );

define( "SLIDER_IMAGES", PUBLIC_HTML . "/content/slider" );
/** Photo folder url */
define( "SLIDER_IMAGES_URL", PUBLIC_HTML_URL . "/content/slider" );

define( "SHOWCASE_IMAGES", PUBLIC_HTML . "/content/showcase" );
/** Photo folder url */
define( "SHOWCASE_IMAGES_URL", PUBLIC_HTML_URL . "/content/showcase" );

define( "FORM_EMAIL", "info@markakod.emrg.me" );
define( "FORM_SMTP", "localhost" );
define( "FORM_USERNAME", "info@markakod.emrg.me" );
define( "FORM_PASSWORD", "d7IiNxxV" );
define( "FORM_PORT", 25 );
define( "FORM_SUBJECT", "Markakod Web Form" );

/** Message subject */
define( "SMTP_MESSAGE_SUBJECT", "MARKAKOD İLETİŞİM FORMU" );
/** Message in text format */
define( "SMTP_MESSAGE_TEXT", ROOT . "/items/email.txt" );
/** Message in html format */
define( "SMTP_MESSAGE_HTML", ROOT . "/items/email.html" );

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

/** Mongo server */
define( 'MONGO_HOST', 'localhost' );
/** Mongo port */
define( 'MONGO_PORT', 27017 );
/** Mongo db */
define( 'MONGO_DATABASE', 'markakod' );
/** Mongo user */
define( 'MONGO_USER', 'markakodUser' );
/** Mongo pass */
define( 'MONGO_PASS', 'HstAbFek7719' );

define( "COLLECTION_ADMINS", "admins" );
define( "COLLECTION_STATS", "stats" );
define( "COLLECTION_LANGUAGES", "languages" );
define( "COLLECTION_TEAM", "team" );
define( "COLLECTION_REFERENCE", "reference" );
define( "COLLECTION_ABOUT", "abouts" );
define( "COLLECTION_BUSINESSPARTNER", "businesspartner" );
define( "COLLECTION_SHOWCASE", "showcase" );
define( "COLLECTION_SLIDER", "slider" );


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
