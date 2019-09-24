<?php
/**
* ProyectosContador Active Record
* @author  Renán Darío Gonzales Apaza
*/
class ProyectosContador extends TRecord
{
	const TABLENAME = 'reportes_invest.proyectos_contador';
	const PRIMARYKEY = 'id_proyecto';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ProyectosContador
		parent::addAttribute('visitas');
	}
}