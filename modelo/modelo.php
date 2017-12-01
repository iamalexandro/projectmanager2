<?php


class modelo {

	/**
	 * @var String
	 */
	private $host = "localhost";

	/**
	 * @var String
	 */
	private $user = "root";

	/**
	 * @var String
	 */
	private $pw = "";

	/**
	 * @var String
	 */
	private $db = "projectmanager";

	/**
	 * @var String
	 */
	private $conexion;


	/**
	 * Contructor
	 * @return void
	 */
	public function __construct(){

	}

	/**
	 * Funcion para conectarme a la base de datos
	 * @return void
	 */
	public function conectar(){

		$this->conexion = mysqli_connect($this->host, $this->user , $this->pw, $this->db) or die("Problemas al conectar al servidor.");

	}

	/**
	 * Funcion para desconectarme a la base de datos
	 * @return void
	 */
	public function desconectar(){

		mysqli_close($this->conexion);

	}

	/**
	 * Funcion para mandar consultar a la base de datos
	 * @param String $query 
	 * @return String
	 */
	public function consultar($query){

		return mysqli_query( $this->conexion, $query );

	}


}

?>