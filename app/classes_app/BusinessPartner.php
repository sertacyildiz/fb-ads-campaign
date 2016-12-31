<?php

class BusinessPartner
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
    public $detail;

    /**
     * @var bool
     */
    public $isActive;

    /**
     * @var int
     */
    public $order;

    public function BusinessPartner()
    {
        global $mongo;
        $this->mongo = $mongo;
    }

    private function SetCollection()
    {
        $this->mongo->setCollection(COLLECTION_BUSINESSPARTNER);
    }

    public function LoadAll( $all = true )
    {
        $this->SetCollection();

        $find = array();
        if( !$all )
        {
            $find =  array('isActive' => true);
        }

        $items = $this->mongo->dataFind( $find, false, array( 'sort' => array( 'order' => -1 ) ) );
        if( isset( $items['_id'] ) )
        {
            $items = array($items);
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
        $this->imageUrl = BUSINESSPARTNER_IMAGES_URL . '/' . $this->image;
        $this->detail = $item['detail'];
        $this->isActive = $item['isActive'];
        $this->order = $item['order'];
    }

    public function Load( $id )
    {
        $this->SetCollection();

        $item = $this->mongo->dataFindOne( array('_id' => new MongoId( $id )) );
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
            'image' => '',
            'detail' => array(),
            'isActive' => false,
            'order' => $count
        );

        $return = $this->mongo->dataInsert( $item );
        $this->LoadByData( $return );
    }

    public function SetImage( $picture )
    {
        $oldFile = BUSINESSPARTNER_IMAGES . '/' . $this->image;

        if( is_file( $oldFile ) )
        {
            @unlink( $oldFile );
        }

        $picdir = BUSINESSPARTNER_IMAGES;
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
        $name = $random->alphaNumeric(12) .'_'.time()."{$ext}";
        $filename = $picdir."/{$name}";

        $imgResize = new emrImage();
        if( $ext == 'jpg' )
        {
            $finalImage = $imgResize->CroppedThumbnailJPG( $picture,500,500);
            imagejpeg( $finalImage, $filename, 90 );
        }
        else
        {
            $finalImage = $imgResize->CroppedThumbnailPNG( $picture,500,500);
            imagepng( $finalImage, $filename );
        }

        $this->SetCollection();
        $this->mongo->dataUpdate( array('_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'image' => $name ) ) );
        $this->image = $name;
        $this->imageUrl = BUSINESSPARTNER_IMAGES_URL . '/' . $name;
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

    public function Delete()
    {
        $filename = BUSINESSPARTNER_IMAGES . '/' . $this->image;

        if( is_file( $filename ) )
        {
            @unlink( $filename );
        }

        $this->SetCollection();
        $this->mongo->dataRemove( array( '_id' => new MongoId( $this->_id ) ) );
    }


}