<?php defined('_JEXEC') or die('Restricted access');

class User extends Entity
{
	protected $table_name = '#__users';
	protected $schema = array( 'id', 'name', 'username', 'email', 'password', 'usertype', 'block', 'sendEmail', 'gid', 'registerDate', 'lastvisitDate', 'activation', 'params' );
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
