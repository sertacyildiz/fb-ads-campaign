<?php

class Language
{

  //<editor-fold desc="Internal Variables">
  /**
   * @var string
   */
  public $_id;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $code;

  /**
   * @var bool
   */
  public $isActive;

  /**
   * @var bool
   */
  public $order;

  /**
   * @var emrMongo
   */
  private $mongo;

  //</editor-fold>


  //<editor-fold desc="Constructors">
  function __construct()
  {
    global $mongo;
    $this->mongo = $mongo;
  }

  private function SetCollection()
  {
    $this->mongo->setCollection( COLLECTION_LANGUAGES );
  }

  public function Create()
  {
    $this->SetCollection();

    $count = $this->mongo->dataCount();

    $item = array(
        'name' => '',
        'code' => '',
        'isActive' => false,
        'order' => $count
    );

    $item = $this->mongo->dataInsert( $item );
    $this->LoadByData( $item );
  }

  public function LoadByData( $item )
  {
    $this->_id = $item[ '_id' ];
    $this->name = $item[ 'name' ];
    $this->code = $item[ 'code' ];
    $this->isActive = $item[ 'isActive' ];
    $this->order = $item[ 'order' ];
  }


  public function Load( $id )
  {
    $this->SetCollection();

    $item = $this->mongo->dataFindOne( array( '_id' => new MongoId( $id ) ) );
    if ( !$item || !count( $item ) ) {
      return false;
    }

    $this->LoadByData( $item );
    return $this;
  }

  public static function LoadAll( $all = true )
  {
    global $mongo;
    $mongo->setCollection( COLLECTION_LANGUAGES );

    $find = array();

    if ( !$all ) {
      $find = array( 'isActive' => true );
    }

    $items = $mongo->dataFind( $find, false, array( 'sort' => array( 'order' => -1 ) ) );
    if ( isset( $items[ '_id' ] ) ) {
      $items = array( $items );
    }

    if ( !is_array( $items ) ) {
      $items = array();
    }

    return $items;
  }

  //</editor-fold>


  //<editor-fold desc="Setters">
  public function SetName( $str )
  {
    $this->SetCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'name' => $str ) ) );
    $this->name = $str;
  }

  public function SetCode( $str )
  {
    $this->SetCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'code' => $str ) ) );
    $this->code = $str;
  }

  public function SetIsActive( $bool )
  {
    $this->SetCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'isActive' => $bool ) ) );
    $this->isActive = $bool;
  }

  public function SetOrder( $int )
  {
    $this->SetCollection();
    $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'order' => sanitize_int($int) ) ) );
    $this->order = $int;
  }
  //</editor-fold>


  //<editor-fold desc="Delete function">
  public function Delete()
  {
    $this->SetCollection();
    $this->mongo->dataRemove( array( '_id' => new MongoId( $this->_id )  ) );
  }
  //</editor-fold>


}