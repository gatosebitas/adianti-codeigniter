<?php
/**
* ViewProyectosUnsa Active Record
* @author  Renán Darío Gonzales Apaza
*/
class ViewProyectosUnsa extends TRecord
{
	const TABLENAME = 'reportes_invest.view_proyectos_unsa';
	const PRIMARYKEY = 'id_proyecto';
	const IDPOLICY = 'max'; // {max, serial}


	/**
	* Constructor method
	*/
	public function __construct($id = NULL, $callObjectLoad = TRUE)
	{
		parent::__construct($id, $callObjectLoad);
		//Atributos de ViewProyectosUnsa
		parent::addAttribute('codigo_conv');
		parent::addAttribute('id_convocatoria');
		parent::addAttribute('nomb_conv');
		parent::addAttribute('id_esquema_finan');
		parent::addAttribute('nomb_esq_finan');
		parent::addAttribute('numero_cont');
		parent::addAttribute('codigo_proy');
		parent::addAttribute('nomb_proy');
		parent::addAttribute('busqueda_nomb_proy');
		parent::addAttribute('principal');
		parent::addAttribute('busqueda_principal');
		parent::addAttribute('estado_proyecto');
		parent::addAttribute('estado_contrato');
		parent::addAttribute('monto_ppto_item');
		parent::addAttribute('monto_cont');
		parent::addAttribute('claves_proy');
		parent::addAttribute('busqueda_claves_proy');
		parent::addAttribute('resumen_ejecutivo');
		parent::addAttribute('obj_general_proy');
		parent::addAttribute('est_proy');
		parent::addAttribute('obs_proy');
		parent::addAttribute('impacto_proy');
		parent::addAttribute('resul_espe_proy');
		parent::addAttribute('hipo_proy');
		parent::addAttribute('just_proy');
		parent::addAttribute('fech_ini_proy');
		parent::addAttribute('durac_proy');
		parent::addAttribute('id_persona');
		parent::addAttribute('integrantes');
		parent::addAttribute('busqueda_integrantes');
		parent::addAttribute('monitor');
		parent::addAttribute('id_area_prioritaria');
		parent::addAttribute('nomb_areapri');
		parent::addAttribute('est_cont');
		parent::addAttribute('area_investigacion');
		parent::addAttribute('linea_investigacion');
		parent::addAttribute('id_anio');
		parent::addAttribute('id_investigador');
		parent::addAttribute('contrato_id_persona');
		parent::addAttribute('id_tiposubvencionado');
		parent::addAttribute('tiposubven');
		parent::addAttribute('id_coordinador');
		parent::addAttribute('coordinador_nombres');

	}

}