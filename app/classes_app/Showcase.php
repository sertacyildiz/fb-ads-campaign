<?php

class Showcase
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
    public $title;

    /**
     * @var string
     */
    public $detail;

    /**
     * @var bool
     */
    public $isActive;

    /**
     * @var int
     */
    public $order;

    public function Showcase()
    {
        global $mongo;
        $this->mongo = $mongo;
    }

    public function SetCollection()
    {
        $this->mongo->setCollection( COLLECTION_SHOWCASE );
    }

    public function LoadAll( $all = true )
    {
        $this->SetCollection();

        $find = array();
        if( !$all )
        {
            $find = array( 'isActive' => true );
        }

        $items = $this->mongo->dataFind( $find, false, array( 'sort' => array( 'order' => -1 ) ) );
        if( isset( $items['_id'] ) )
        {
            $items = array( $items );
        }

        if( !is_array( $items ) )
        {
            $items = array();
        }

        return $items;
    }

    public function LoadByData( $item )
    {
        $this->_id = $item['_id'];
        $this->image = $item['image'];
        $this->title = $item['title'];
        $this->detail = $item['detail'];
        $this->isActive = $item['isActive'];
        $this->order = $item['order'];

    }

    public function Load( $id )
    {
        $this->SetCollection();

        $item = $this->mongo->dataFindOne( array( '_id' => new MongoId( $id ) ) );
        if( !$item || !count( $item ) )
        {
            return false;
        }

        $this->LoadByData( $item );
        return true;
    }

    public function Create()
    {
        $this->SetCollection();

        $count = $this->mongo->dataCount();

        $item = array(
            'image' => array(),
            'title' => array(),
            'detail' => array(),
            'isActive' => false,
            'order' => $count
        );

        $return = $this->mongo->dataInsert( $item );
        $this->LoadByData($return);
    }

    public function SetImage( $picture )
    {

        $picdir = SHOWCASE_IMAGES;
        if( !is_dir( $picdir ) )
        {
            mkdir( $picdir, 0766 , true );
        }

        $filedims = getimagesize( $picture );

        $ext = '';
        switch( $filedims['mime'] )
        {
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

        $random = new emrRandom();
        $name = $random->alphaNumeric(12) .'_'.time().".{$ext}";
        $filename = $picdir."/{$name}";

        $imgResize = new emrImage();
        if( $ext == 'jpg' )
        {
            $finalImage = $imgResize->CroppedThumbnailJPG( $picture, 500, 500 );
            imagejpeg( $finalImage, $filename, 90 );
        }
        else
        {
            $finalImage = $imgResize->CroppedThumbnailPNG( $picture, 500, 500 );
            imagepng( $finalImage, $filename );
        }

        $this->SetCollection();

        $find = array( '_id' => new MongoId( $this->_id ) );
        $count = count( $this->image );
        $_id = new MongoId();
        $replace = array('$set' => array( 'image.'. $count => array( '_id'=> $_id, 'name' => $name, 'order' => $count ) ) );
        $this->mongo->dataUpdate( $find , $replace);
        array_push($this->image,array('_id'=>  $_id,'name' => $name, 'order' => $count));

        $returnArray = array('ERR' => 0,'ID' =>  $_id, 'ORD' => $count, 'IMG' => SHOWCASE_IMAGES_URL . '/' . $name);

        return $returnArray;

    }


    public function SetTitle( $language, $title )
    {
        $this->SetCollection();
        $this->title[ $language ] = $title;
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'title' => $this->title ) ) );
    }

    public function SetDetail( $language, $detail )
    {
        $this->SetCollection();
        $this->detail[ $language ] = $detail;
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'detail' => $this->detail ) ) );
    }


    public function SetIsActive( $set )
    {
        $this->SetCollection();
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'isActive' => $set ) ) );
        $this->isActive = $set;
    }

    public function SetOrder( $int )
    {
        $this->SetCollection();
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'order' => sanitize_int( $int ) ) ) );
        $this->order = $int;
    }

    public function SetImageOrder( $_id, $int )
    {
        $this->SetCollection();
        $find = array(
            '_id' => new MongoId($this->_id),
            'image._id' => new MongoId($_id)
        );
        $replace = array( '$set' => array( 'image.$.order' => $int ) );
        $this->mongo->dataUpdate( $find, $replace );

    }

    public function DeleteSingleImage( $_id,$image_id )
    {
        foreach($this->image as $photo)
        {
            if( $photo['_id'] == $image_id )
            {
                $filename = SHOWCASE_IMAGES . '/' . $photo["name"];

                if (is_file($filename)) {
                    @unlink($filename);
                }
            }

        }

        $this->SetCollection();
        $this->mongo->dataUpdate( array( '_id' => new MongoId($_id) ), array( '$pull' => array( 'image' => array( '_id' => new MongoId( $image_id ) ) ) ) );
        $this->Load($_id);

    }

    public function Delete()
    {
        foreach($this->image as $photo)
        {

            $filename = SHOWCASE_IMAGES . '/' . $photo["name"];

            if( is_file( $filename ) )
            {
                @unlink( $filename );
            }

        }

        $this->SetCollection();
        $this->mongo->dataRemove( array( '_id' => new MongoId( $this->_id ) ) );
    }

}