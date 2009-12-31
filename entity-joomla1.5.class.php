<?php

/**
 * @package Joomla DAO
 * @author Marek Dajnowski (first release 20080614)
 * @documentation http://dajnowski.net/wiki/index.php5/Entity
 * @latest http://github.com/fornve/Joomla--DAO/blob/master/entity.class.php
 * @version 1.3-1.5 - Joomla! 1.5 adapter
 * @License GPL v3
 */

class Entity
{
	private static $dblink;
	protected $db;
	protected $prefix = null;
	protected $multi_query = false;
	public $db_query_counter = 0;
	protected static $__CLASS__ = __CLASS__;
	protected $schema = array();

	function __construct()
	{
		$this->db = Entity::Instance();
	}

	public static function &Instance()
	{
		if( !is_object( self::$dblink ) )
		{
			self::$dblink = self::Connect();
		}

		return self::$dblink;
	}

	function Connect()
	{
		$db =& JFactory::getDBO();
		
		if( !$db )
			die( 'Database connection failed.' );

		return $db;
	}

	function __destruct()
	{
	}

	/**
	 * Execute query on database - works exactly like Collection but won't return results
	 * @param string $query
	 * @param mixed $arguments
	 */
	function Query( $query, $arguments = null )
	{
		if( DB_TABLE_PREFIX )
			$query = $this->Prefix( $query );
			
		$query = $this->Arguments( $query, $arguments );

		$this->db_query_counter++;
		$this->db->setQuery( $query );
		$this->db->Execute( $query ); 

		$this->error = $this->db->error;
		$this->query = $query;
		$_SESSION[ 'entity_query' ][] = $query;

		if( $this->db->errno && !PRODUCTION )
		{
			echo 'Database entity Collection error: ';
			var_dump( $this );
			var_dump( $arguments );
			exit;
		}
		elseif( $this->db->errno )
		{
			$this->Error( $this->db->errno, $arguments );
		}
	}

	/**
	 * Enity objects collection from table - rows => array( row => object of entity )
	 * @param string $query
	 * @param mixed $arguments
	 * @param string $class
	 * @return array
	 * Returns array of objects
	 */
	function Collection( $query, $arguments = null, $class = __CLASS__, $limit = null, $offset = null )
	{
		if( $limit )
		{
			if( $limit )
			{
				$query .= " LIMIT ?";
			}

			if( $offset > 0 )
			{
				$query .= ", ?";
				$arguments[] = $offset;
			}

			$arguments[] = $limit;
		}
		
		$query = $this->Arguments( $query, $arguments );

		unset( $this->result ); // for object reuse
		$this->db->setQuery( $query );
		//$this->db->Execute( $query ); 
		$this->result = $this->db->loadObjectList( '', $class );
		$this->db_query_counter++;

		/*
		if( $result )
		{
			$this->BuildResult( $result, $class );

			$_SESSION[ 'entity_query' ][] = $query;
		}
		*/

		$this->error = $this->db->error;
		$this->query = $query;
		
		if( $this->db->errno && !PRODUCTION )
		{
			echo 'Database entity Collection error: ';
			var_dump( $this );
			var_dump( $arguments );
			exit;
		}
		elseif( $this->db->errno )
		{
			$this->Error( $this->db->error, $arguments );
		}

		if( $class && isset( $this->result ) )
		{
			$class = new $class;

			if( $class->schema )
				$this->result = Entity::Stripslashes( $this->result, $class->schema );
		}

		if( isset( $this->result ) )
			return $this->result;
	}

	/**
	 * Retrieve column group results
	 * @param int $column
	 * @return object
	 * Returns array of objects type of entity
	 */	
	function TypeCollection( $type )
	{

		if( !in_array( $type, $this->schema ) )
			return false;

		$table_name = strtolower( get_class( $this ) );
		$query = "SELECT {$type} FROM {$table_name} GROUP BY {$type}";
		return $this->Collection( $query, null, 'stdClass' );
	}

	/**
	 * Retrieve row from database where id = $id ( or id => $id_name  )
	 * @param int $id
	 * @param string $id_name
	 * @param string $class
	 * @return object
	 * Returns object type of entity
	 */
	static function Retrieve( $id, $id_name = 'id', $class = __CLASS__ )
	{
		if( is_int( $id ) )
		{
			$object = new $class;
			$table = strtolower( $class );
			$entity = new Entity();
			$query = "SELECT * FROM `{$table}` WHERE `{$id}` = ? LIMIT 1";
			$result = $entity->GetFirstResult( $query, $id, $class );

			if( $result ) foreach( $result as $key => $value )
			{
				$object->$key = $value;
			}

			return $object;
		}
		
	}

	/**
	 *
	 * @param string $query
	 * @param mixed $arguments
	 * @param string $class
	 * @return object
	 */
	function RetrieveFromQuery( $query, $arguments, $class = __CLASS__ )
	{
		//$object_name = get_class( $this );
		$object = new $class;
		$table = strtolower( $class );
		$entity = new Entity();
		$result = $object->GetFirstResult( $query, $arguments );

		if( $result ) foreach( $result as $key => $value )
		{
			$object->$key = $value;
			return $object;
		}
		else
			return $false;
	}

	function Save()
	{
		$table = $this->table_name;

		$id = $this->schema[ 0 ];

		if( !$this->$id )
			$this->$id = $this->Create( $table );

		$query = "UPDATE `{$table}` SET ";

		foreach( $this->schema as $property )
		{
			if( $property != $this->schema[ 0 ] )
			{
				if( $notfirst )
					$query .= ', ';

				$query .= " `{$property}` = ?";
					
				if( is_object( $this->$property ) )
					$arguments[] = $this->$property->id;
				else
					$arguments[] = $this->$property;

				$notfirst = true;
			}
		}

		$query .= " WHERE {$this->schema[0]} = ?";
		$arguments[] = $this->{$id};

		$this->Query( $query, $arguments );
	}

	//function Update() { $this->Save(); }

	/**
	 * Creates new entry in $table and returns id
	 * @param string $table
	 * @return  int
	 */
	function Create( $table, $id_value = null )
	{
		$id = $this->schema[ 0 ];
		$column = $this->schema[ 1 ];

		if( $id_value )
			$query = "INSERT INTO `{$table}` ( `{$id}`, `{$column}` ) VALUES ( {$id_value}, 0 )";
		else
			$query = "INSERT INTO `{$table}` ( `{$column}` ) VALUES ( 0 )";


		$this->Query( $query );
		$result = $this->GetFirstResult( "SELECT {$id} FROM `{$table}` WHERE `{$column}` = 0 ORDER BY `{$id}` DESC LIMIT 1" );
		return $result->$id;
	}

	/**
	 *
	 * @param string $query
	 * @param mixed $arguments
	 * @param string $class
	 * @return object
	 */
	function GetFirstResult( $query, $arguments = null, $class = __CLASS__ )
	{
		if( $query )
			$this->Collection( $query, $arguments, $class );

		return $this->result[ 0 ];
	}

	function PreDelete() {}
	function FlushCache() {}

	function Delete()
	{
		$this->PreDelete();
		$table = strtolower( get_class( $this ) );
		$query = "DELETE FROM `{$table}` WHERE id = ?";
		$this->query( $query, $this->id );
	}

	/**
	 * Gets all entries from database
	 * @param $class string class name
	 */
	static function GetAll( $class = null )
	{
		if( !$class )
			die( "Entity::GetAll - class name cannot be null." );

		$table = strtolower( $class );
		$query = "SELECT * from `{$table}`";
		$entity = new Entity();
		return $entity->Collection( $query, null, $class );
	}

	/**
	 * Gets input and sets into object cproperties
	 * @param const $method
	 */
	public function SetProperties( $method = INPUT_POST )
	{
		$input = Common::Inputs( $this->schema, $method );

		foreach( $this->schema as $property )
		{
			$this->$property = $input->$property;
		}
	}

	/**
	 * Returns schema
	 * @return array
	 */
	public function GetSchema()
	{
		return $this->schema;
	}

	public function InSchema( $key )
	{
		if( $this->schema ) foreach( $this->schema as $schema_key )
		{
			if( $key == $schema_key )
				return true;
		}
	}

	/**
	 * Converts array into object
	 * @return object
	 */ 
	public static function Array2Entity( $array, $class )
	{
		if( $array ) 
		{
			$object = new $class();	

			foreach ( $array as $key => $value )
			{
				if( !is_numeric( $key ) )	
					$object->$key = $value;
			}
		}

		return $object;
	}

	/* BIG FAT WARNING! VERY DANGEROUS!!! */
	/*function multiQuery( $query, $arguments = null )
	{
		$this->multi_query = true;
		$this->Query( $query, $arguments );
	}*/

	private static function getClass()
	{
		$implementing_class = Entity::$__CLASS__;
		$original_class = __CLASS__;

		return $original_class;
	}

	/*
	private function BuildResult( $result, $class )
	{
		if( DB_TYPE == 'mysql' )
		{
			while( $row = mysqli_fetch_object( $result, $class ) )
			{
				$this->result[] = $row;
			}
		}
		else
		{
			while( $row = $result->fetchArray() )
			{
				$this->result[] = Entity::Array2Entity( $row, $class );
			}
		}

	}*/

	/**
	 * Parse prefix - useful if shared database
	 * @param string $query
	 * @return string
	 */
	private function Prefix( $query )
	{
		//global $mosConfig_dbprefix; // joomla 1.0
		if( defined( 'DB_TABLE_PREFIX' ) )
		{
			$exp = explode( '#__', $query );
			$query = implode( DB_TABLE_PREFIX, $exp );
		}

		return $query;
	}

	/**
	 *
	 * @param string $query
	 * @param mixed $arguments
	 * @return string
	 */
	private function Arguments( $query, $arguments = null )
	{
		$query = explode( '?', $query );
		$i = 0;

		if( !is_array( $arguments ) and $arguments !== null )
		{
			$arguments = array( $arguments );
		}

		$new_query = '';

		if( count( $arguments ) ) foreach( $arguments as $argument )
		{
			if( is_object( $argument ) )
			{
				$argument = "'". $this->Escape( $argument->id ) ."'";
			}
			elseif( !is_numeric( $argument ) and isset( $argument ) )
			{
				$argument = "'". $this->Escape( $argument ) ."'";
			}
			elseif( !isset( $argument ) )
			{
				$argument = 'NULL';
			}

			$new_query .= $query[ $i++ ] . $argument;
		}
		$new_query .= $query[ $i ];

		return $new_query;
	}

	private function Escape( $string )
	{
		return $this->db->getEscaped( $string );
	}

	function Stripslashes( $result, $schema )
	{
		foreach( $schema as $key )
		{
			 $result[ 0 ]->$key = stripslashes( $result[ 0 ]->$key );
		}

		return $result;
	}

	function getParam( $name = null )
	{
		if( !$this->params || !$name )
			return null;
		
		$params = explode( "\n", $this->params );
		
		if( $params ) foreach( $params as $param )
		{
			$item = explode( "=", $param );
			
			if( $item[ 0 ] == $name )
				return trim( $item[ 1 ] );
		}
	}
}
