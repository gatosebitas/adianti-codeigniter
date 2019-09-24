<?php
/**
* ViewProyectosUnsa Active Record
* @author  Renato
*/
class ViewUsers extends TRecord
{
	const TABLENAME = 'users';
	const PRIMARYKEY = 'cui';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ViewProyectosUnsa
		parent::addAttribute('id');
        parent::addAttribute('cui');
        parent::addAttribute('password');
	
	}

}