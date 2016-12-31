<?php

/**
 * emrMongo
 * Written by Emrah Gunduz
 * Started : 23 October 2012
 * Version : 0.1
 */
class emrMongo
{

  /**
   * Internal holder for PHP Mongo object
   * @var Mongo
   */
  private $mongo;

  /**
   * Host the class will be connecting to
   * @var string
   */
  private $dbHost;

  /**
   * Post to use while connecting to host
   * @var int
   */
  private $dbPort;

  /**
   * User for connecting to Mongo
   * @var string
   */
  private $dbUser;

  /**
   * Password for connecting to Mongo
   * @var string
   */
  private $dbPass;

  /**
   * Database to be used
   * @var string
   */
  private $dbDatabase;

  /**
   * Collection name
   * @var string
   */
  private $dbCollection;

  /**
   * Connected database
   * @var MongoDB
   */
  private $database;

  /**
   * Connected collection
   * @var MongoCollection
   */
  private $collection;

  /**
   * Current cursor
   * @var MongoCursor
   */
  private $cursor;

  /**
   * Auto connect to Mongo
   * @var boolean
   */
  private $autoConnect;

  /**
   * For internal checking if Mongo connection is open
   * @var boolean
   */
  private $connected;

  /**
   * For internal checking of errors
   * @var boolean
   */
  private $error;

  /**
   * Error no
   * @var int
   */
  private $errorNo;

  /**
   * Error message
   * @var string
   */
  private $errorMessage;

  /**
   * Last object used for querying/inserting/updating/etc
   * @var array
   */
  private $lastObject;

  /**
   * Count of the last result
   * @var int
   */
  private $documentCount;

  /**
   * Constructor for the class
   */
  public function emrMongo ()
  {
    // Reset internal variables
    $this->dbHost = "localhost";
    $this->dbPort = 27017;
    $this->dbUser = false;
    $this->dbPass = false;
    $this->dbDatabase = false;
    $this->dbCollection = false;

    $this->database = false;
    $this->collection = false;
    $this->cursor = false;

    $this->error = false;
    $this->errorNo = 0;
    $this->errorMessage = '';

    // Set auto connect to true
    $this->autoConnect = true;

    // If constants are defined
    if ( defined( 'MONGO_HOST' ) )
      $this->dbHost = MONGO_HOST;
    if ( defined( 'MONGO_PORT' ) )
      $this->dbPort = MONGO_PORT;
    if ( defined( 'MONGO_USER' ) )
      $this->dbUser = MONGO_USER;
    if ( defined( 'MONGO_PASS' ) )
      $this->dbPass = MONGO_PASS;
    if ( defined( 'MONGO_DATABASE' ) )
      $this->dbDatabase = MONGO_DATABASE;
    if ( defined( 'MONGO_COLLECTION' ) )
      $this->dbCollection = MONGO_COLLECTION;
  }

  /**
   * Sets the auto connection to Mongo true or false.
   * If set to true, class will handle the connections.
   * @param boolean $set
   */
  public function setAutoConnect ( $set = true )
  {
    $this->autoConnect = $set;
  }

  /**
   * Changes the host the class will work on.
   * @param string $set
   */
  public function setHost ( $set )
  {
    if ( !$this->connected )
      $this->dbHost = $set;
    else
      $this->setError( 2, 'Cannot change host when a connection is active.' );
  }

  /**
   * Changes the port the class will work on
   * @param int $set
   */
  public function setPort ( $set )
  {
    if ( !$this->connected )
      $this->dbPort = $set;
    else
      $this->setError( 3, 'Cannot change port when a connection is active.' );
  }

  /**
   * Changes the user the class will work on
   * @param int $set
   */
  public function setUser ( $set )
  {
    if ( !$this->connected )
      $this->dbUser = $set;
    else
      $this->setError( 4, 'Cannot change user when a connection is active.' );
  }

  /**
   * Changes the password the class will work on
   * @param int $set
   */
  public function setPassword ( $set )
  {
    if ( !$this->connected )
      $this->dbPass = $set;
    else
      $this->setError( 5, 'Cannot change password when a connection is active.' );
  }

  /**
   * Changes the database the class will work on
   * @param string $set
   */
  public function setDatabase ( $set )
  {
    $this->dbDatabase = $set;
    if ( $this->connected )
      $this->database = $this->mongo->selectDB( $set );
  }

  /**
   * Changes the collection the class will work on
   * @param string $set
   */
  public function setCollection ( $set )
  {
    $this->dbCollection = $set;
    if ( $this->connected )
      $this->collection = $this->database->selectCollection( $set );
  }

  /**
   * Sets an error for class, mostly returning Mongo error codes and messages
   * @param int $no
   * @param string $msg
   */
  private function setError ( $no, $msg )
  {
    $this->error = true;
    $this->errorNo = $no;
    $this->errorMessage = $msg;
  }

  /**
   * Returns true for errors
   * @return boolean
   */
  public function getError ()
  {
    return $this->error;
  }

  /**
   * Returns the last received error number
   * @return int
   */
  public function getErrorNo ()
  {
    return $this->errorNo;
  }

  /**
   * Returns the last received error message
   * @return string
   */
  public function getErrorMessage ()
  {
    return $this->errorMessage;
  }

  /**
   * Connects to Mongo with the given parameters.
   * If the connection fails, this command will return false.
   * @return boolean
   */
  public function mongoConnect ()
  {
    try {
      // Server string
      $server = "mongodb://{$this->dbHost}:{$this->dbPort}";
      // Options array
      $options = array();
      if ( $this->dbUser && strlen( $this->dbUser ) )
        $options[ 'username' ] = $this->dbUser;
      if ( $this->dbPass && strlen( $this->dbPass ) )
        $options[ 'password' ] = $this->dbPass;
      if ( $this->dbDatabase )
        $options[ 'db' ] = $this->dbDatabase;
      // Connect
      if ( count( $options ) ) {
        // With options
        $this->mongo = new MongoClient( $server, $options );
      } else {
        // No options
        $this->mongo = new MongoClient( $server );
      }
    } catch ( MongoConnectionException $e ) {
      // Could not connect to mongo
      $this->lastObject = "";
      $this->connected = false;
      $this->setError( 1, 'Cannot connect to Mongo, is server active?' );
      return false;
    }

    $this->connected = true;

    // Connect to specified database
    if ( $this->dbDatabase )
      $this->database = $this->mongo->selectDB( $this->dbDatabase );

    // Select the collection
    if ( $this->dbCollection )
      $this->collection = $this->database->selectCollection( $this->dbCollection );

    return true;
  }

  /**
   * Close any open connection
   */
  public function mongoConnectionClose ()
  {
    if ( $this->connected ) {
      if ( $this->cursor )
        $this->cursor->reset();

      $this->mongo->close();
    }
    $this->connected = false;
    $this->database = false;
    $this->collection = false;
    $this->error = false;
    $this->errorMessage = '';
    $this->errorNo = 0;
    $this->lastObject = false;
  }

  /**
   * Inserts a new document to the db.collection. The object must be an array!
   * @param array $object
   * @return int|array
   */
  public function dataInsert ( $object )
  {
    $this->lastObject = $object;

    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $check = $this->collection->save( $object );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    if ( $check == false || ( is_array( $check ) && $check[ 'ok' ] != 1 ) ) {
      $this->setError( 7, 'Data not inserted' );
      return 0;
    } else {
      // Data entry ok
      $object[ "_id" ] = isset( $object[ "_id" ]->{'$id'} ) ? $object[ "_id" ]->{'$id'} : $object[ "_id" ];
      return $object;
    }
  }

  /**
   * Returns the count of the result of the query
   * @param array|bool $query
   * @return int
   */
  public function dataCount ( $query = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( !$query ) {
      $query = array();
    }

    $count = $this->collection->count( $query );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $count;
  }

  /**
   * Returns the found documents
   * @param array|bool $query The query array ex: array('name' => 'Myname', 'age' => 12);
   * @param array|bool $fields Returned fields array ex: array('name' => true, 'surname'=> false);
   * @param array|bool $options Options is a speacial array to keep limit, skip and sort functions ex: array('limit' => 3, 'skip' => 2, 'sort' => array('name' => 1, 'age' => -1) );
   * @return array
   */
  public function dataFind ( $query = false, $fields = false, $options = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( !$query ) {
      $query = array();
    }
    if ( !$fields ) {
      $fields = array();
    }

    $this->cursor = $this->collection->find( $query, $fields );

    if ( $options ) {
      foreach ( $options as $key => $value ) {
        switch ( $key ) {
          case 'sort':
            $this->cursor = $this->cursor->sort( $value );
            break;
          case 'limit':
            $this->cursor = $this->cursor->limit( $value );
            break;
          case 'skip':
            $this->cursor = $this->cursor->skip( $value );
            break;
        }
      }
    }

    // Count
    $this->documentCount = $this->cursor->count();

    // Convert to array
    $result = iterator_to_array( $this->cursor, true );

    // Close cursor connection
    $this->cursor->reset();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    // Convert the id
    if ( count( $result ) == 1 ) {
      $return = array_shift( $result );
      if ( array_key_exists( "_id", $return ) ) {
        $return[ "_id" ] = isset( $return[ "_id" ]->{'$id'} ) ? $return[ "_id" ]->{'$id'} : $return[ "_id" ];
      }
    } else {
      $return = array();
      foreach ( $result as $r ) {
        if ( array_key_exists( "_id", $r ) ) {
          $r[ "_id" ] = isset( $r[ "_id" ]->{'$id'} ) ? $r[ "_id" ]->{'$id'} : $r[ "_id" ];
        }
        $return[ ] = $r;
      }
    }

    if ( isset( $return[ '_id' ] ) ) {
      $return = array( $return );
    }

    return $return;
  }

  /**
   * Use aggregate framework on the collection
   * @param array $aggregate
   * @return array
   */
  public function dataAggregate ( $aggregate )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $agg = $this->collection->aggregate( $aggregate );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return array_key_exists( "result", $agg ) ? $agg[ "result" ] : array();
  }

  /**
   * Returns only a single document
   * @param array|bool $query The query array ex: array('name' => 'Myname', 'age' => 12);
   * @param array|bool $fields Returned fields array ex: array('name' => true, 'surname'=> false);
   * @return array
   */
  public function dataFindOne ( $query = false, $fields = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( !$query ) {
      $query = array();
    }
    if ( !$fields ) {
      $fields = array();
    }

    $cursor = $this->collection->findOne( $query, $fields );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    if ( count( $cursor ) ) {
      if ( array_key_exists( "_id", $cursor ) ) {
        $cursor[ "_id" ] = isset( $cursor[ "_id" ]->{'$id'} ) ? $cursor[ "_id" ]->{'$id'} : $cursor[ "_id" ];
      }
      return $cursor;
    } else {
      return $cursor;
    }
  }

  /**
   * Updates the query results with the given documents
   * @param array $find
   * @param array $replace
   * @param array|bool $action array("upsert" => true) / array("multiple" => true)... etc
   * @return array Database response
   */
  public function dataUpdate ( $find, $replace, $action = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( !$action ) {
      $action = array();
    }

    $check = $this->collection->update( $find, $replace, $action );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $check;
  }

  /**
   * Removes the matching documents from collection
   * @param array|bool $find
   * @param array|bool $options array("safe" => false) / array("timeout" => 1000)... etc
   * @return array Database response
   */
  public function dataRemove ( $find = false, $options = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( !$options ) {
      $options = array();
    }

    $check = $this->collection->remove( $find, $options );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $check;
  }

  /**
   * Drops the current collection
   * @return array Database response
   */
  public function collectionDrop ()
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $response = $this->collection->drop();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $response;
  }

  /**
   * Creates an index on collection
   * @param array $keys Example: array('z' => 1, 'zz' => -1)
   * @param array $options Example: array("unique" => 1, "dropDups" => 1, "background" => 1, "name" => "indexName", "w" => 1) *w writeConcern
   * @return boolean Return true for success
   */
  public function collectionSetIndex ( $keys, $options )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $return = $this->collection->ensureIndex( $keys, $options );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

  /**
   * Drops a single or all indexes
   * @param array|bool $keys Example array("j" => 1, "k" => 1) *If no keys are specified, all indexes will be dropped
   * @return array Database response
   */
  public function collectionRemoveIndex ( $keys = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( $keys )
      $return = $this->collection->deleteIndex( $keys );
    else
      $return = $this->collection->deleteIndexes();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

  /**
   * Drops the current selected database
   * @return array Database response
   */
  public function dbDrop ()
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $return = $this->database->drop();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

  /**
   * Executes the given code on database level
   * @param mixed $code String or array as code. Example: "function(greeting, name) { return greeting+', '+name+'!'; }"
   * @param array|bool $arguments Example: array("Good bye", "Joe")
   * @return array Returns database response
   */
  public function dbExecute ( $code, $arguments = false )
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    if ( !$arguments ) {
      $arguments = array();
    }

    $return = $this->database->execute( $code, $arguments );

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

  /**
   * Returns a list of available dbs
   * @return array|bool
   */
  public function dbs ()
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $return = $this->mongo->listDBs();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

  /**
   * Returns the collection names of the database
   * @return array
   */
  public function dbCollections ()
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $return = $this->database->getCollectionNames();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

  /**
   * Return last error message. No error returns false.
   * @return array|bool
   */
  public function dbLastError ()
  {
    if ( !$this->connected && $this->autoConnect ) {
      // Auto connect
      $this->mongoConnect();
      if ( !$this->connected ) {
        // Not connected to database
        $this->setError( 6, 'Not connected to Mongo. Cannot perform save command.' );
        return false;
      }
    }

    $return = $this->database->lastError();

    if ( $this->autoConnect ) {
      $this->mongoConnectionClose();
    }

    return $return;
  }

}
