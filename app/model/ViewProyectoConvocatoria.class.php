<?php
/**
* ViewProyectosUnsa Active Record
* @author  Renán Darío Gonzales Apaza
*/
class ViewConvocatoria extends TRecord
{
	const TABLENAME = 'reportes_invest.view_proyectos_convocatorias';
	const PRIMARYKEY = 'id_convocatoria';
	const IDPOLICY = 'max'; // {max, serial}

	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ViewProyectosUnsa
		parent::addAttribute('id_esquema_finan');
		parent::addAttribute('codigo_conv');
		parent::addAttribute('nomb_conv');
		parent::addAttribute('post_fech_inicio');
		parent::addAttribute('post_fech_cierre');
		parent::addAttribute('esta_conv');
		parent::addAttribute('id_anio');
		parent::addAttribute('post_hora_cierre');
		
	}

}