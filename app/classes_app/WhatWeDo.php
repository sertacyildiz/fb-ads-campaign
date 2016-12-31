<?php

class WhatWeDo
{
    private $mongo;

    public $id;
    public $messages = array();
    public $published;

    public function WhatWeDo()
    {
        global $mongo;
        $this->mongo = $mongo;
    }

    private function SetCollection()
    {
        $this->mongo->setCollection( COLLECTION_WHATWEDO );
    }

    /**
     * @param int $page
     * @param int $per
     * @param int $distance
     * @param mixed $search
     * @return array
     */
    public function LoadPaginated ( $page = 1, $per = 30, $distance = 5, $search = false )
    {
        $this->SetCollection();

        if ( !$search ) {
            $search = array();
        }

        $itemsCount = $this->mongo->dataCount( $search );
        $totalPages = ceil( $itemsCount / $per );

        $pagesList = array( $page );
        for ( $i = 1; $i <= $distance; $i++ ) {
            if ( $i > 0 && $i <= $totalPages ) {
                array_push( $pagesList, $i );
            }
        }
        for ( $i = $totalPages; $i > $totalPages - $distance; $i-- ) {
            if ( $i > 0 && $i <= $totalPages ) {
                array_push( $pagesList, $i );
            }
        }
        for ( $i = $page - $distance; $i <= $page + $distance; $i++ ) {
            if ( $i > 0 && $i <= $totalPages ) {
                array_push( $pagesList, $i );
            }
        }
        sort( $pagesList );
        $pages = array_unique( $pagesList );

        $sort = array( 'sort' => array( 'datetime' => 1 ), 'skip' => ( $page - 1 ) * $per, 'limit' => $per );

        $items = $this->mongo->dataFind( $search, false, $sort );
        if ( isset( $items[ "_id" ] ) ) {
            $items = array( $items );
        }

        if ( !is_array( $items ) ) {
            $items = array();
        }

        return array( 'pages' => $pages, 'items' => $items );
    }

    public function LoadAll()
    {
        $this->SetCollection();

        $items = $this->mongo->dataFind( array(), false );

        if( isset( $items[ "_id" ] ) )
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
        $this->id = $item[ "_id" ];
        $this->messages = $item[ "messages" ];
        $this->published = $item[ "published" ];
    }

    public function Load( $id )
    {
        try
        {
            $this->SetCollection();

            $item = $this->mongo->dataFindOne( array( "_id" => new MongoId( $id ) ) );
            if( !$item || !count( $item ) )
            {
                return false;
            }

            $this->LoadByData( $item );

            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function Create()
    {
        $this->SetCollection();

        $item = array(
            "messages" => array(),
            "published" => false
        );

        $return = $this->mongo->dataInsert( $item );
        $this->LoadByData( $return );
    }
    public function SetMessage ( $language, $messages )
    {
        $this->SetCollection();
        $this->messages[ $language ] = $messages;
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->id ) ), array( '$set' => array( 'messages' => $this->messages ) ) );
    }

    public function SetPublished ( $set = true )
    {
        $this->setCollection();
        $this->mongo->dataUpdate( array( '_id' => new MongoId( $this->id ) ), array( '$set' => array( 'published' => $set ) ) );
        $this->published = $set;
    }

    public function Delete ()
    {
        // Delete from DB
        $this->SetCollection();
        $this->mongo->dataRemove( array( '_id' => new MongoId( $this->id ) ) );
    }

}