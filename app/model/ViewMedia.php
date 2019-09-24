<?php
/**
* ViewProyectosUnsa Active Record
* @author  Renato
*/
class ViewMedia extends TRecord
{
	const TABLENAME = 'media';
	const PRIMARYKEY = 'id';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ViewProyectosUnsa
		parent::addAttribute('id');
		parent::addAttribute('path');
		parent::addAttribute('name');
		parent::addAttribute('description');
		parent::addAttribute('type');
		parent::addAttribute('state');
		parent::addAttribute('id_publication');
		
	}

}