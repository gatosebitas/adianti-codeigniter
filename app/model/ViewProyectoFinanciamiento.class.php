<?php
/**
* ViewProyectosUnsa Active Record
* @author  Renán Darío Gonzales Apaza
*/
class ViewProyectoFinanciamiento extends TRecord
{
	const TABLENAME = 'reportes_invest.view_proyectos_financiamiento';
	const PRIMARYKEY = 'id_contrato';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ViewProyectosUnsa
		parent::addAttribute('nombres');
		parent::addAttribute('mont_finan_mone');
		parent::addAttribute('mont_finan_nomone');
		parent::addAttribute('total');
		parent::addAttribute('porc_finan_mone');
		parent::addAttribute('porc_finan_nomone');
	}
}