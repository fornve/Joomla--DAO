<?php
 
/*
* This script loads created entities into JLoader::autoload
* Part of Joomla Dao library http://github.com/fornve/Joomla--DAO/
*/
 
defined('_JEXEC') or die('Restricted access');
 
// DAO base class (what is DAO? http://en.wikipedia.org/wiki/Data_access_object)
JLoader::register( 'Entity', JPATH_BASE .'/includes/entity.class.php' );
 
$dir = scandir( JPATH_BASE .'/includes/entities/' );

if( $dir ) foreach( $dir as $file )
{
	$filename = basename( $file );
	$fileparts = explode( '.', $file );
	if( $fileparts[ 1 ] == 'class' && $fileparts[ 2 ] == 'php' )
	{
		JLoader::register( ucfirst( $fileparts[ 0 ] ), JPATH_BASE .'/includes/'. $file );
	}
}
