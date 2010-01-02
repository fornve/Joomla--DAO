<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.dao' );

/*
 * This plugin registeres Entity class and all entities
 */
class plgSystemDao extends JPlugin
{
	function onAfterInitialise()
	{
		$dir = scandir( JPATH_BASE .'/plugins/system/entities/' );

		if( $dir ) foreach( $dir as $file )
		{
			$filename = basename( $file );
			$fileparts = explode( '.', $file );
			
			if( $fileparts[ 1 ] == 'class' && $fileparts[ 2 ] == 'php' )
			{
				JLoader::register( ucfirst( $fileparts[ 0 ] ), JPATH_BASE .'/plugins/system/entities/'. $file );
			}
		}
	}
}
