<?php
/**
* ViewProyectosUnsa Active Record
* @author  Renato
*/
class ViewPublication extends TRecord
{
	const TABLENAME = 'publication';
	const PRIMARYKEY = 'id';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);		
		parent::addAttribute('id');
		parent::addAttribute('title');
		parent::addAttribute('description');
		parent::addAttribute('date_publicated');
		
	}

}