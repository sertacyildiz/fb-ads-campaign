<?php
// Simple security check
if ( !isset( $ping ) || $ping != "pong" ) {
    endHere();
}

if ( !isset( $actionD ) ) {
    // Is is missing
    echo "http://placehold.it/100x100&text=Image";
    endHere();
    exit();
}

$id = sanitize_string( $actionD );
$showcase = new Showcase();
if ( !$showcase->Load( $id ) ) {
    echo "http://placehold.it/100x100&text=Image";
    endHere();
    exit();
}

// Temporary folder for images
$tempFolder = TEMP_FOLDER;

// Create missing folder
if ( !is_dir( $tempFolder ) ) {
    mkdir( $tempFolder, 0755, true );
}

// Get the file
$fileName = ( isset( $_SERVER[ 'HTTP_X_FILE_NAME' ] ) ? $_SERVER[ 'HTTP_X_FILE_NAME' ] : false );

// Load file data into variable
$in = fopen( 'php://input', 'r' );

// Save the file
$file = "{$tempFolder}/{$fileName}";

// Save data to file
file_put_contents( $file, $in );

// Check if the image can be read
$filedims = getimagesize( $file );

$acceptedMimes = array(
    "image/jpg",
    "image/jpeg",
    "image/png"
);

if ( isset( $filedims[ 'mime' ] ) && in_array( $filedims[ 'mime' ], $acceptedMimes ) ) {
    //Save image

    echo json_encode($showcase->SetImage( $file ));


} else {
    echo "http://placehold.it/100x100&text=Image";
}

// Delete the temp file
@unlink( $file );

// End
endHere();







