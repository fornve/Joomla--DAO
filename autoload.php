<?php

/*
 * This script loads created entities into JLoader::autoload
*/

defined('_JEXEC') or die('Restricted access');

// DAO base class (what is DAO? http://en.wikipedia.org/wiki/Data_access_object)
JLoader::register( 'Entity', JPATH_BASE .'/libraries/entities/entity.class.php' );

JLoader::register( 'Category', JPATH_BASE .'/libraries/entities/category.class.php' );
JLoader::register( 'Item', JPATH_BASE .'/libraries/entities/item.class.php' );
