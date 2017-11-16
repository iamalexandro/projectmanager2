<?php

class Controlador{

	/**
	 *  Muestra una vista
	 * @param vista $vista 
	 * @return void
	 */
	public function mostrarVista($vista){

		echo $vista;

	}

	/**
	 * Funcion para leer plantilla
	 * @param String $ruta 
	 * @return String
	 */
	public function leerPlantilla($ruta){

		return file_get_contents($ruta);

	}
	/**
	 * Esta funcion lee una cadena y la reemplaza en otra cadena
	 * @param String $ubicacion 
	 * @param String $cadenaReemplazar 
	 * @param String $reemplazo 
	 * @return string
	 */
	 
	public function reemplazar($ubicacion, $cadenaReemplazar, $reemplazo)
	{
		return str_replace($cadenaReemplazar, $reemplazo, $ubicacion);
	}
}