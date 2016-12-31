<?php

class Team
{
  /**
   * @var emrMongo
   */
  private $mongo;

  /**
   * @var string
   */
  public $_id;

  /**
   * @var string
   */
  public $image;

  /**
   * @var string
   */
  public $imageUrl;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $title;

  /**
   * @var bool
   */
  public $isActive;

  /**
   * @var int
   */
  public $order;


  //<editor-fold desc="Constructors">
  public function Team()
  {
    global $mongo;
    $this->mongo = $mongo;
  }

  private function SetCollection()
  {
    $this->mongo->setCollection( COLLECTION_TEAM );
  }


  public function LoadAll( $all = true)
  {
    $this->SetCollection();

    $find = array();
    if (!$all) {
      $find = array('isActive' => true);
    }

    $items = $this->mongo->dataFind( $find, false, array( 'sort' => array( 'order' => -1 ) ) );
    if ( isset( $items[ "_id" ] ) ) {
      $items = array( $items );
    }

    if ( !is_array( $items ) ) {
      $items = array();
    }
    return $items;
  }

  public function LoadByData( $item )
  {
    $this->_id = $item[ '_id' ];
    $this->image = $item[ 'image' ];
    $this->imageUrl = PERSON_IMAGES_URL . "/" . $this->image;
    $this->name = $item[ 'name' ];
    $this->title = $item[ 'title' ];
    $this->isActive = $item[ 'isActive' ];
    $this->order = $item[ 'order' ];
  }

  public function Load( $id )
  {
    try {
      $this->SetCollection();

      $item = $this->mongo->dataFindOne( array( '_id' => new MongoId( $id ) ) );
      if ( !$item || !count( $item ) ) {
        return false;
      }

      $this->LoadByData( $item );

      return true;
    } catch ( Exception $e ) {
      return false;
    }
  }

  public function Create()
  {
    $this->SetCollection();

    $count = $this->mongo->dataCount();

    $item = array(
        'image' => '',
        'name' => '',
        'title' => '',
        'isActive' => false,
        'order' => $count
    );

    $return = $this->mongo->dataInsert( $item );
    $this->LoadByData( $return );
  }
  //</editor-fold>

  //<editor-fold desc="Setters">
  public function SetImage( $picture )
  {

    // Delete old image file
    $oldFile = PERSON_IMAGES . "/" . $this->image;


    if ( is_file( $oldFile ) ) {
      @unlink( $oldFile );
    }

    $picdir = PERSON_IMAGES;

    if ( !is_dir( $picdir ) ) {
      mkdir( $picdir, 0766, true );
    }


    // Extension of the image
    $filedims = getimagesize( $picture );
    $ext = '';
    switch ( $filedims[ 'mime' ] ) {
      case 'image/jpg':
      case 'image/jpeg':
        $ext = 'jpg';
        break;
      case 'image/png':
        $ext = 'png';
        break;
      case 'image/gif':
      case 'image/agif':
        $ext = 'gif';
        break;
    }

    // Generate a name for image
    $random = new emrRandom();
    $name = $random->AlphaNumeric( 12 ) . "_" . time() . ".{$ext}";
    $filename = $picdir . "/{$name}";

    // Create original image
    $imgResize = new emrImage();
    if ( $ext == "jpg" ) {
      $finalImage = $imgResize->CroppedThumbnailJPG( $picture, 500, 500 );
      imagejpeg( $finalImage, $filename, 90 );
    } else {
      $finalImage = $imgResize->CroppedThumbnailPNG( $picture, 500, 500 );
      imagepng( $finalImage, $filename );
    }

    $this->SetCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'image' => $name ) ) );
    $this->image = $name;
    $this->imageUrl = PERSON_IMAGES_URL . "/" . $name;
  }

  public function SetTitle( $title )
  {
    $this->setCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'title' => $title ) ) );
    $this->title = $title;
  }

  public function SetName( $name )
  {
    $this->setCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'name' => $name ) ) );
    $this->name = $name;
  }

  public function SetIsActive( $set )
  {
    $this->setCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'isActive' => $set ) ) );
    $this->isActive = $set;
  }

  public function SetOrder( $int )
  {
    $this->setCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'order' => sanitize_int($int) ) ) );
    $this->order = $int;
  }


  //</editor-fold>

  public function Delete()
  {
    $filename = PERSON_IMAGES . "/" . $this->image;

    if ( is_file( $filename ) ) {
      @unlink( $filename );
    }

    // Delete from DB
    $this->setCollection();
    $this->mongo->dataRemove( array( '_id' => new MongoId( $this->_id ) ) );
  }


}