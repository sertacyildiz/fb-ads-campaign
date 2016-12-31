<?php

/**
 * A collection for image resizing functions for JPG and PNG.
 * Transparent PNG is supported.
 * @author emrahgunduz
 */
class emrImage
{

  /**
   * Returns dimensions of the given image in pixels as an array (width, height)
   * @param $imgSrc string
   * @return array Width and height
   */
  static function ImageDimensions ( $imgSrc )
  {
    list ( $width_orig, $height_orig ) = getimagesize( $imgSrc );
    return array( "width" => $width_orig, "height" => $height_orig );
  }

  /**
   * Crops, resizes given image and returns the final as binary image data
   * @param string $imgSrc Original Image file location
   * @param int $thumbnail_height Thumbnail height
   * @param int $thumbnail_width Thumbnail width
   * @return resource in binary format
   */
  public static function CroppedThumbnailJPG ( $imgSrc, $thumbnail_width = 0, $thumbnail_height = 0 )
  {
    // Getting the image dimensions 
    list ( $width_orig, $height_orig ) = getimagesize( $imgSrc );
    $myImage = imagecreatefromjpeg( $imgSrc );
    $ratio_orig = $width_orig / $height_orig;

    // Thumbnail height and weight is not specified
    if ( ( !$thumbnail_width || $thumbnail_width == 0 ) && ( !$thumbnail_height || $thumbnail_height == 0 ) ) {
      $thumbnail_width = $width_orig;
      $thumbnail_height = $height_orig;
    }

    // No thumbnail width is specified
    if ( !$thumbnail_width || $thumbnail_width == 0 ) {
      $thumbnail_width = floor( $thumbnail_height * $ratio_orig );
    }

    // No thumbnail height is specified
    if ( !$thumbnail_height || $thumbnail_height == 0 ) {
      $thumbnail_height = floor( $thumbnail_width / $ratio_orig );
    }

    // Set new ratio if the ratios are off
    if ( $thumbnail_width / $thumbnail_height > $ratio_orig ) {
      $new_height = floor( $thumbnail_width / $ratio_orig );
      $new_width = $thumbnail_width;
    } else {
      $new_width = floor( $thumbnail_height * $ratio_orig );
      $new_height = $thumbnail_height;
    }

    // Find middle
    $x_mid = ( $new_width / 2 ); // Horizontal middle
    $y_mid = ( $new_height / 2 ); // Vertical middle

    // Create a new empty image
    $process = imagecreatetruecolor( round( $new_width ), round( $new_height ) );

    // Copy the old image by resampling
    imagecopyresampled( $process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig );

    // Create a new empty image with new height and width values
    $thumb = imagecreatetruecolor( $thumbnail_width, $thumbnail_height );

    // Copy the old image by resizing
    imagecopyresampled( $thumb, $process, 0, 0, ( $x_mid - ( $thumbnail_width / 2 ) ), ( $y_mid - ( $thumbnail_height / 2 ) ), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height );

    // Destroy not needed images
    imagedestroy( $process );
    imagedestroy( $myImage );

    // Return final image
    return $thumb;
  }

  /**
   * @desc For PNG files: Crops, resizes given image and returns the final as binary image data
   * @param string $imgSrc Original Image file location
   * @param int $thumbnail_height Thumbnail height
   * @param int $thumbnail_width Thumbnail width
   * @return resource in binary format
   */
  public static function CroppedThumbnailPNG ( $imgSrc, $thumbnail_width = 0, $thumbnail_height = 0 )
  {
    list ( $width_orig, $height_orig ) = getimagesize( $imgSrc );

    $myImage = imagecreatetruecolor( $width_orig, $height_orig );
    imagealphablending( $myImage, false );
    imagesavealpha( $myImage, true );

    $srcImage = imagecreatefrompng( $imgSrc );
    imagealphablending( $srcImage, false );
    imagesavealpha( $srcImage, true );

    imagecopyresampled( $myImage, $srcImage, 0, 0, 0, 0, $width_orig, $height_orig, $width_orig, $height_orig );

    $ratio_orig = $width_orig / $height_orig;

    // Thumbnail height and weight is not specified
    if ( ( !$thumbnail_width || $thumbnail_width == 0 ) && ( !$thumbnail_height || $thumbnail_height == 0 ) ) {
      $thumbnail_width = $width_orig;
      $thumbnail_height = $height_orig;
    }

    // No thumbnail width is specified
    if ( !$thumbnail_width || $thumbnail_width == 0 ) {
      $thumbnail_width = floor( $thumbnail_height * $ratio_orig );
    }

    // No thumbnail height is specified
    if ( !$thumbnail_height || $thumbnail_height == 0 ) {
      $thumbnail_height = floor( $thumbnail_width / $ratio_orig );
    }

    if ( $thumbnail_width / $thumbnail_height > $ratio_orig ) {
      $new_height = floor( $thumbnail_width / $ratio_orig );
      $new_width = $thumbnail_width;
    } else {
      $new_width = floor( $thumbnail_height * $ratio_orig );
      $new_height = $thumbnail_height;
    }

    $x_mid = ( $new_width / 2 ); // Horizontal middle
    $y_mid = ( $new_height / 2 ); // Vertical middle

    $process = imagecreatetruecolor( $new_width, $new_height );
    imagealphablending( $process, false );
    imagesavealpha( $process, true );
    imagecopyresampled( $process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig );

    $thumb = imagecreatetruecolor( $thumbnail_width, $thumbnail_height );
    imagealphablending( $thumb, false );
    imagesavealpha( $thumb, true );
    imagecopyresampled( $thumb, $process, 0, 0, ( $x_mid - ( $thumbnail_width / 2 ) ), ( $y_mid - ( $thumbnail_height / 2 ) ), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height );

    imagedestroy( $process );
    imagedestroy( $myImage );
    return $thumb;
  }

}