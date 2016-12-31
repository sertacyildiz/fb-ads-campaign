<?php

class About
{
    private $mongo;

    /**
     * @var string
     */
    public $_id;

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

    public function About()
    {
        global $mongo;
        $this->mongo = $mongo;
    }

    private function SetCollection()
    {
        $this->mongo->setCollection(COLLECTION_ABOUT);
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
        $this->detail = $item['detail'];
        $this->isActive = $item['isActive'];
        $this->order = $item['order'];
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
            'detail' => array(),
            'isActive' => false,
            'order' => $count
        );

        $return = $this->mongo->dataInsert( $item );
        $this->LoadByData( $return );
    }

    public function SetDetail($language, $detail)
    {
        $this->SetCollection();
        $this->detail[ $language ] = $detail;
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'detail' => $this->detail ) ) );
    }

    public function SetIsActive( $isActive )
    {
        $this->SetCollection();
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'isActive' => $isActive ) ) );
        $this->isActive = $isActive;
    }

    public function SetOrder( $order )
    {
        $this->SetCollection();
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->_id ) ), array( '$set' => array( 'order' => $order ) ) );
        $this->order = $order;
    }

    public function Delete()
    {
        $this->SetCollection();
        $this->mongo->dataRemove( array( '_id' => new MongoId( $this->_id ) ) );
    }

}