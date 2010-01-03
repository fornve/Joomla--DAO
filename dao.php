<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/*
 * This plugin registeres Entity class and all entities
 */
class plgSystemDao extends JPlugin
{
	function onAfterInitialise()
	{
		// load common entities
		
		$dir_path = JPATH_BASE . DS .'plugins'. DS .'system'. DS .'dao'. DS .'entities'. DS;
		self::AutoloadDirectory( $dir_path );
		
		// load admin entities
		$dir_path = JPATH_SITE . DS .'plugins'. DS .'system'. DS .'dao'. DS .'entities'. DS;
		self::AutoloadDirectory( $dir_path );
	}
	
	private static function AutoloadDirectory( $dir_path )
	{
		if( !file_exists( $dir_path ) )
			return false;
		
		$dir = scandir( $dir_path );
		
		foreach( $dir as $file )
		{
			$filename = basename( $file );
			$fileparts = explode( '.', $file );
	
			if( $fileparts[ 1 ] == 'class' && $fileparts[ 2 ] == 'php' )
			{
				JLoader::register( ucfirst( $fileparts[ 0 ] ), $dir_path . $file );
			}
		}
	}
}
