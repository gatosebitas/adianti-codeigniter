<?php
/**
* ViewProyectosIntegrante Active Record
* @author  Renán Darío Gonzales Apaza
*/
class ViewProyectosIntegrante extends TRecord
{
	const TABLENAME = 'reportes_invest.view_proyectos_integrante';
	const PRIMARYKEY = 'id_proyecto';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ViewProyectosIntegrante
		parent::addAttribute('full_name_per');
		parent::addAttribute('cargo_equipo');
		parent::addAttribute('prof_equipo');
		parent::addAttribute('estado_equipo');
		parent::addAttribute('motivo_baja_equipo');
		parent::addAttribute('id_corr_equipo');
	}
}