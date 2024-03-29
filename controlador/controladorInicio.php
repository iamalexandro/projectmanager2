<?php

include ('controlador.php');
include (__DIR__ .'/../modelo/modelo.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require (__DIR__ .'/../recursos/phpmailer/src/PHPMailer.php');
require (__DIR__ .'/../recursos/phpmailer/src/SMTP.php');
require (__DIR__ .'/../recursos/phpmailer/src/Exception.php');



/**
	 * Clase que se encarga de llevar a cabo las peticiones recibidas de los usuarios.
	 */
class controladorInicio extends controlador{

	/**
	 * @var Modelo
	 */
	private $modelo;

	
	/**
	 * Instancia de la clase modelo donde tengo las funciones de conexion a la base de datos
	 * @return void
	 */
	public function __construct(){

		$this->modelo = new modelo();
	}






	/*************************************************************************************************	
	 *************************************************************************************************
	 ***********************    METODOS PARA MOSTRAR VISTAS   ****************************************
	 *************************************************************************************************
	 *************************************************************************************************	
	 */


	/**
	 * Muestro la vista de inicio
	 * @return void
	 */
	public function inicio(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/login.html');
		$this->mostrarVista($plantilla);
	}


	public function mostrarFormRecuperarPass(){
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/recuperar_contrasena.html');
		$this->mostrarVista($plantilla);
	}



	/*************************************************************************************************
	 ********************** METODOS PARA MOSTRAR VISTAS DE ADMINISTRADOR    **************************
	 *************************************************************************************************
	*/
	
	/**
	 * Muestro la vista de admin
	*/ 
	public function inicioAdmin(){

		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/principal_admin.html');

		$nuevaPlantilla = $this->calcularTarjetas($plantilla); 
		
		$plantillaConDatos = $this->montarDatos($nuevaPlantilla, 'admin', $_SESSION['admin']); 

		$this->mostrarVista($plantillaConDatos);
	}
	
	/**
	 * Muestro la vista de gestionar docentes
	*/ 
	public function mostrarFormListadoDocentes(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/listado_docentes.html');
		$docentes = "SELECT nombre, correo, telefono, id_docente FROM docente";

		$this->modelo->conectar();
		$docentes = $this->modelo->consultar($docentes);
		$this->modelo->desconectar();

		$nombre_docentes = '';
		$correo_docentes = '';
		$telefono_docentes = '';
		$listado = '';
		while ($row = mysqli_fetch_array($docentes)) {
			$nombre_docente = $row['nombre'];
			$correo_docente = $row['correo'];
			$telefono_docente = $row['telefono'];
			$id_docente = $row['id_docente'];
			$nombre_docente_string = '"'.$nombre_docente.'"';
			$listado .= "
				<tr>
					<td>
						$nombre_docente
					</td>
					<td>
						$correo_docente
					</td>
					<td>
						$telefono_docente
					</td>
					<td class='text-center'>
						<a href='index.php?boton=modificar_docente&id=$id_docente' class='btn btn-sm bg-blue waves-effect'>Editar</a>
						<button type='button' class='btn btn-sm bg-red waves-effect' onclick='borrarDocente($id_docente, $nombre_docente_string);'>Eliminar</button>
					</td>
				</tr>
			";

		}
		
		$plantilla = $this->reemplazar( $plantilla, '{{listado_docentes}}', $listado);
		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']); 
		$this->mostrarVista($plantillaConDatos);
		
	}

	/**
	 * Muestra la vista de registrar docente
	*/
	public function mostrarFormRegistrarDocente(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/registrar_docente.html');
		
		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);

		$this->mostrarVista($plantillaConDatos);		
	}
	
	/**
	 * Muestra la vista de rmodificar docente
	*/
	public function mostrarFormModificarDocente(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/modificar_docente.html');
		$id = $_GET['id'];
				
		$consulta2 = "SELECT * FROM docente WHERE id_docente = $id";
		
		$this->modelo->conectar();
		$respuesta2 = $this->modelo->consultar($consulta2);
		$this->modelo->desconectar();
		
		$nombre = '';
		$correo = '';
		$telefono = '';
		$contraseña = '';
		$id = '';
		
		while ($row = mysqli_fetch_array($respuesta2)) {
			$nombre = $row['nombre'];
			$correo = $row['correo'];
			$telefono = $row['telefono'];
			$contraseña = $row['contrasena'];
			$id = $row['id_docente'];
		}

		$plantilla = $this->reemplazar( $plantilla, '{{nombre2}}', $nombre);
		$plantilla = $this->reemplazar( $plantilla, '{{correo2}}', $correo);
		$plantilla = $this->reemplazar( $plantilla, '{{telefono}}', $telefono);
		$plantilla = $this->reemplazar( $plantilla, '{{contraseña}}', $contraseña);
		$plantilla = $this->reemplazar( $plantilla, '{{id}}', $id);

		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);

		$this->mostrarVista($plantillaConDatos);
	}

	/**
	 * Muestra la vista de invitar docente
	*/
	public function mostrarFormInvitarDocente(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/invitar_docente.html');
		
		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);

		$this->mostrarVista($plantillaConDatos);
	}

	/**
	 * Muestra la vista de agregar un docente como nuevo admin
	*/
	public function mostrarFormAgregarAdmin(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/agregar_admin.html');
		
		$consulta1 = "SELECT * FROM docente d WHERE d.id_docente NOT IN (SELECT a.id_docente FROM administrador a)";
		
		$this->modelo->conectar();
		$respuesta1 = $this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		$lista = '';
		while ($row = mysqli_fetch_array($respuesta1)) {
			$lista .= '<option value="'.$row['id_docente'].'" >'.$row['nombre'].'</option>';
		}

		$plantilla = $this->reemplazar( $plantilla, '{{lista_docentes}}', $lista);

		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);

		$this->mostrarVista($plantillaConDatos);
	}

	/**
	 * Muestra la vista de registrar un nuevo curso
	*/
	public function mostrarFormRegistrarCurso(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/registrar_curso.html');
		
		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);
		
		$this->mostrarVista($plantillaConDatos);
	}

	public function mostrarFormModificarCurso(){
		
		$id = $_GET['id'];
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/modificar_curso.html');
		$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";
		$consulta2 = "SELECT nombre, descripcion FROM curso WHERE id_curso = $id";

		$this->modelo->conectar();
		$respuesta1 = $this->modelo->consultar($consulta1);
		$respuesta2 = $this->modelo->consultar($consulta2);
		$this->modelo->desconectar();

		$nombre = '';
		$correo = '';
		while ($row = mysqli_fetch_array($respuesta1)) {
			$nombre = $row['nombre'];
			$correo = $row['correo'];
		}
		$nombre_curso = '';
		$descripcion_curso = '';
		while ($row = mysqli_fetch_array($respuesta2)) {
			$nombre_curso = $row['nombre'];
			$descripcion_curso = $row['descripcion'];
		}

		$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
		$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
		$plantilla = $this->reemplazar( $plantilla, '{{nombre_curso}}', $nombre_curso);
		$plantilla = $this->reemplazar( $plantilla, '{{descripcion_curso}}', $descripcion_curso);
		$plantilla = $this->reemplazar( $plantilla, '{{id}}', $id);
		$this->mostrarVista($plantilla);
		
	}


	public function mostrarFormListadoCursos(){
		
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/listado_cursos.html');
				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";
				$cursos = "SELECT nombre, descripcion, id_curso FROM curso";
				$id = $_SESSION['admin'];
				$is_admin = "SELECT COUNT(*) as exist FROM administrador WHERE id_docente = $id";
				
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$cursos = $this->modelo->consultar($cursos);
				$is_admin = $this->modelo->consultar($is_admin);
				$this->modelo->desconectar();
				
				$is_admin_aux = '';
				while ($row = mysqli_fetch_array($is_admin)) {
					$is_admin_aux = $row['exist'];
				}
				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}
		
		
				$nombre_curso = '';
				$descripcion_curso = '';
				$listado = '';
				$class = !$is_admin_aux ? 'hidden' : '';
				$disabled = $is_admin_aux ? '' : 'disabled';
				while ($row = mysqli_fetch_array($cursos)) {
					$nombre_curso = $row['nombre'];
					$descripcion_curso = $row['descripcion'];
					$id_curso = $row['id_curso'];
					//$nombre_docente_string = '"'.$nombre_docente.'"';
					$listado .= "
						<tr>
							<td>
								$nombre_curso
							</td>
							<td>
								$descripcion_curso
							</td>
							<td class='text-center'>
								<a href='index.php?boton=modificar_curso&id=$id_curso' class='btn btn-sm bg-blue waves-effect'>Editar</a>
								<button type='button' class='btn btn-sm bg-red waves-effect $class' $disabled>Eliminar</button>
							</td>
						</tr>
					";
		
				}
		
				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$plantilla = $this->reemplazar( $plantilla, '{{listado_cursos}}', $listado);
				$plantilla = $this->reemplazar( $plantilla, '{{id}}', $id);
				$this->mostrarVista($plantilla);
				
			}


	public function mostrarFormGenerarReportes(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
		
		$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);
		
		$this->mostrarVista($plantillaConDatos);
	}


	/*************************************************************************************************
	 **********************    METODOS PARA MOSTRAR VISTAS DE DOCENTE    *****************************
	 *************************************************************************************************
	*/
	
	/**
	 * Muestro la vista de docente
	 */
	public function inicioDocente(){

		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/principal_docente.html');

		$nuevaPlantilla = $this->calcularTarjetas($plantillaConDatos);

		$plantillaConDatos = $this->montarDatos($nuevaPlantilla, 'docente', $_SESSION['docente']); 
		
		$this->mostrarVista($plantillaConDatos);
	}

	/**
	 * Muestra la vista de inscribirse a un curso
	*/
	public function mostrarFormInscribirCurso($letra){
		
		if($letra == 'a'){

			$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/inscribirse_a_curso_admin.html');
			$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);

		}else{
			if($letra == 'd'){
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/inscribirse_a_curso_docente.html');
				$plantillaConDatos = $this->montarDatos($plantilla, 'docente', $_SESSION['docente']);
			}else{
				if($letra = 'e'){
					$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/inscribirse_a_curso_estudiante.html');
					$plantillaConDatos = $this->montarDatos($plantilla, 'estudiante', $_SESSION['estudiante']);
				}
			}
		}

		$consulta1 = "SELECT * FROM curso";

		$this->modelo->conectar();
		$respuesta1 = $this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		$lista = '';
		while ($row = mysqli_fetch_array($respuesta1)) {
			$lista .= '<option value="'.$row['id_curso'].'" >'.$row['codigo'].' - '.$row['nombre'].'</option>';
		}

		$plantillaConDatos = $this->reemplazar( $plantillaConDatos, '{{lista_cursos}}', $lista);
		$this->mostrarVista($plantillaConDatos);	
	}

	/**
	 * Muestra la vista de registrar un proyecto
	*/
	public function mostrarFormRegistrarProyectos($letra){
		
		if($letra == 'a'){
			$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/registrar_proyecto_admin.html');
			$plantillaConDatos = $this->montarDatos($plantilla, 'admin', $_SESSION['admin']);			
			$consulta2 = "SELECT c.id_curso, c.codigo, c.nombre FROM curso_docente cd, curso c WHERE cd.id_curso = c.id_curso AND cd.id_docente = ".$_SESSION['admin']." AND cd.id_docente IN (SELECT d.id_docente FROM docente d)";

		}else{
			if($letra == 'd'){
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/registrar_proyecto_docente.html');
				$plantillaConDatos = $this->montarDatos($plantilla, 'docente', $_SESSION['docente']);				
				$consulta2 = "SELECT c.id_curso, c.codigo, c.nombre FROM curso_docente cd, curso c WHERE cd.id_curso = c.id_curso AND cd.id_docente = ".$_SESSION['docente']." AND cd.id_docente IN (SELECT d.id_docente FROM docente d)";
			}
		}
		
		$this->modelo->conectar();
		$respuesta2 = $this->modelo->consultar($consulta2);
		$this->modelo->desconectar();

		$lista = '';
		while ($row = mysqli_fetch_array($respuesta2)) {
			$lista .= '<option value="'.$row['id_curso'].'" >'.$row['codigo'].' - '.$row['nombre'].'</option>';
		}

		$plantillaConDatos = $this->reemplazar( $plantillaConDatos, '{{lista_cursos}}', $lista);
		$this->mostrarVista($plantillaConDatos);
		
	}


	/*************************************************************************************************
	 **********************    METODOS PARA MOSTRAR VISTAS DE ESTUDIANTE    **************************
	 *************************************************************************************************
	*/


	/**
	 * Muestro la vista de estudiante
	 * @return 
	 */
	public function inicioEstudiante(){

		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/principal_estudiante.html');

		$plantillaConDatos = $this->montarDatos($plantilla, 'estudiante', $_SESSION['estudiante']); 

		$this->mostrarVista($plantillaConDatos);
	}
	
	/**
	 * Muestra la vista de registrar un estudiante
	*/
	public function mostrarFormRegistrarEstudiante(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/registro_estudiante.html');
		$this->mostrarVista($plantilla);
	}
		

	/**
	 * Muestra la vista de los proyectos de los estudiantes
	*/
	public function mostrarFormMisProyectos(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/mis_proyectos.html');
		
		$plantillaConDatos = $this->montarDatos($plantilla, 'estudiante', $_SESSION['estudiante']); 
		
		$this->mostrarVista($plantillaConDatos);
		
	}
	/*************************************************************************************************
	 ***********************    METODOS DEL PROYECTO   ********************************************************
	 *************************************************************************************************
	*/


	/**
	 * Funcion retorna true si un admin o un user iniciaron sesion
	 * @return boolean
	 */
	 public function hayLogin(){
		
		return isset( $_SESSION['admin']) || isset( $_SESSION['docente']);
	}



	/**
	 * Guarda la sesion de un usuario al loguearse
	 * @param String $correo 
	 * @param String $password 
	 * @return void
	 */
	public function guardarLogin($correo, $password){

		
		
		//Comprueba si la persona que intenta ingresar existe en la bd
		$consulta1 = "SELECT * FROM administrador a, docente d WHERE d.correo = '".$correo."' AND a.id_docente = d.id_docente";
		$consulta2 = "SELECT * FROM docente d WHERE d.correo = '".$correo."'";
		$consulta3 = "SELECT * FROM estudiante e WHERE e.correo = '".$correo."'";
		
		//realizo la consulta
		$this->modelo->conectar();
		$resultado1 = $this->modelo->consultar($consulta1);
		$resultado2 = $this->modelo->consultar($consulta2);
		$resultado3 = $this->modelo->consultar($consulta3);
		$this->modelo->desconectar();

		$i = mysqli_num_rows($resultado1);//administrador
		$j = mysqli_num_rows($resultado2);//docente
		$k = mysqli_num_rows($resultado3);//estudiante

		//Comprueba si existe una sola persona con los parametros dados
		if($i == 1 || $j == 1 || $k == 1){
			
			//saco los datos de la consulta
			$pass = '';
			$id = '';

			if($k == 1){
				while($row = mysqli_fetch_array($resultado3)){
						$pass = $row['contrasena'];
						$id = $row['id_estudiante'];
				}

				if(password_verify($password, $pass)){
					//inicio sesion como estudiante
					$_SESSION["estudiante"] = $id;
				}
			}else{
				
				if($i == 1){
					while($row = mysqli_fetch_array($resultado1)){
						$pass = $row['contrasena'];
						$id = $row['id_docente'];
					}
					if(password_verify($password, $pass)){
						//inicio sesion como admin
						$_SESSION["admin"] = $id;
					}
				}else{
					while($row = mysqli_fetch_array($resultado2)){
					$pass = $row['contrasena'];
					$id = $row['id_docente'];
					}

					if(password_verify($password, $pass)){
						//inicio sesion como docente
						$_SESSION["docente"] = $id;
					}	
				}
			}
		}else{
			
			$_SESSION['mensaje'] = "El usuario o la contrase&nacute;a son incorrectos.";
		}

		header('Location: index.php');
	}




/************************************************************************
 ******************* FUNCIONES ADMINISTRADOR ****************************
 ************************************************************************/

	


	public function guardarDocente($nombre, $telefono, $correo, $password, $admin){


	 	//Busco todas las personas para hacer la comprobacion si ya existe o no en la base de datos 	
		$consulta1 = "SELECT COUNT(correo) FROM docente  WHERE correo = '".$correo."'";
		$resultado;
		$this->modelo->conectar();
		$resultado=$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();


		$row = mysqli_fetch_array($resultado);
		
	 	//Si la consulta no me arrojo resultados, quiere decir que la persona no existe, entonces la agrego a la bd
		if($row[0] == 0){

			$passh= password_hash($password, PASSWORD_DEFAULT);

			$consulta2 = "INSERT INTO docente VALUES( null, '".$nombre."', '".$correo."', '".$telefono."', '".$passh."')";
			$this->modelo->conectar();
			$this->modelo->consultar($consulta2);
			$this->modelo->desconectar();

			
	 	 	//Guardo un mensaje para ser mostrado al registrar el usuario
			echo'<script type="text/javascript">
            		alert("Registro exitoso.");
         		</script>';
			header('Location: index.php');

		}else{

	 	 	//Si el usuario ya esta registrado muestre la vista de registro
			echo'<script type="text/javascript">
            		alert("Registro fallido: Usuario ya existe.");
         		</script>';
			header('Location: index.php');
		}
	}

	public function modificarDocente($nombre, $telefono, $correo, $password, $id_docente){
		 
		$consulta2 = "UPDATE docente set nombre = '$nombre', 
			correo = '$correo', 
			telefono = '$telefono' ";

			if( !empty($password) ) {
				$passh= password_hash($password, PASSWORD_DEFAULT);
				$consulta2 .= "contrasena = '$passh' ";
			}

		$this->modelo->conectar();
		$this->modelo->consultar($consulta2);
		$this->modelo->desconectar();

		
			//Guardo un mensaje para ser mostrado al registrar el usuario
		echo'<script type="text/javascript">
							alert("Docente modificado correctamente.");
					</script>';
		header('Location: index.php');
	}

	public function modificarCurso($nombre, $descripcion, $id_curso){
		 
		$consulta2 = "UPDATE curso set nombre = '$nombre', 
			descripcion = '$descripcion' WHERE id_curso = $id_curso";

		$this->modelo->conectar();
		$this->modelo->consultar($consulta2);
		$this->modelo->desconectar();

			//Guardo un mensaje para ser mostrado al registrar el usuario
		echo'<script type="text/javascript">
							alert("Curso modificado correctamente.");
					</script>';
		header('Location: index.php');
	}




	public function agregarAdmin($docente){


	 	//Busco todas las personas para hacer la comprobacion si ya existe o no en la base de datos 	
		$consulta1 = "SELECT COUNT(correo) FROM docente  WHERE correo = '".$correo."'";
		$resultado;
		$this->modelo->conectar();
		$resultado=$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();


		$row = mysqli_fetch_array($resultado);
		
	 	//Si la consulta no me arrojo resultados, quiere decir que la persona no existe, entonces la agrego a la bd
		if($row[0] == 0){

			$consulta2 = "INSERT INTO administrador VALUES( '".$docente."', 'Activo', CURRENT_DATE, NULL)";
			$this->modelo->conectar();
			$this->modelo->consultar($consulta2);
			$this->modelo->desconectar();

			
	 	 	//Guardo un mensaje para ser mostrado al registrar el usuario
			echo'<script type="text/javascript">
            		alert("Registro exitoso.");
         		</script>';
			header('Location: index.php');

		}else{

	 	 	//Si el usuario ya esta registrado muestre la vista de registro
			echo'<script type="text/javascript">
            		alert("Registro fallido: Usuario ya existe.");
         		</script>';
			header('Location: index.php');
		}
	}

	public function registrarCurso($codigo, $nombre){

		$consulta1 = "INSERT INTO curso VALUES( null, '".$codigo."', '".$nombre."')";
		$this->modelo->conectar();
		$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		
 	 	//Guardo un mensaje para ser mostrado al registrar el curso
		echo'<script type="text/javascript">
    			alert("Registro exitoso.");
 			</script>';
		header('Location: index.php');
	}

	public function inscribirCurso($curso, $letra){

		if($letra == 'a'){

			$consulta1 = "INSERT INTO curso_docente VALUES( null, ".$curso.", ".$_SESSION['admin'].", 'A', 2017, 1)";
		}else{
			if($letra == 'd'){
				
				$consulta1 = "INSERT INTO curso_docente VALUES( null, ".$curso.", ".$_SESSION['docente'].", 'A', 2017, 1)";
			}
		}
		$this->modelo->conectar();
		$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		
 	 	//Guardo un mensaje para ser mostrado al registrar el docente en el curso
		echo'<script type="text/javascript">
    			alert("Registro exitoso.");
 			</script>';
		header('Location: index.php');
	}

	public function registrarProyecto($letra, $curso, $nombre, $url_app, $url_codigo, $descripcion){


		//datos del arhivo 
		$nombre_archivo = $_FILES['documento']['name']; 
		$tipo_archivo = $_FILES['documento']['type']; 
		$tamano_archivo = $_FILES['documento']['size'];
		$ruta_subida =  __DIR__. '/../archivos/'. $nombre_archivo;
		
		//compruebo si las características del archivo son las que deseo 
		if (!((strpos($tipo_archivo, "doc") || strpos($tipo_archivo, "pdf")) && ($tamano_archivo < 8000000))){
			$_SESSION["mensaje"] = "La extension o el tamano de los archivos no es correcta. Se permiten archivos .pfd o .doc se permiten archivos de 8 Mb maximo."; 
		}else{ 
			//si cumple con las caracterisiticas lo guardo en la carpeta destino
		   	if (move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_subida)){ 
		      	$_SESSION["mensaje"] = "El archivo ha sido cargado correctamente."; 
		   	}else{ 
		      	$_SESSION["mensaje"] = "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
		   	} 
		}

		if($letra == 'a'){
			$consulta1 = "INSERT INTO proyecto VALUES(null, ".$_SESSION['admin'].", ".$curso.", '".$nombre."', '".$descripcion."', '".$url_app."', '".$url_codigo."', CURRENT_DATE, null, 'En desarrollo', '".$ruta_subida."')";
		}else{
			if($letra == 'd'){
				$consulta1 = "INSERT INTO proyecto VALUES(null, ".$_SESSION['docente'].", ".$curso.", '".$nombre."', '".$descripcion."', '".$url_app."', '".$url_codigo."', CURRENT_DATE, null, 'En desarrollo', '".$ruta_subida."')";
			}
		}

		$this->modelo->conectar();
		$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		
 	 	//Guardo un mensaje para ser mostrado al registrar el docente en el curso
		//$_SESSION['registro_exitoso'] = 'docente registrado registrado exitosamente';
		header('Location: index.php');
	}

	public function generarReportes($tipo_reporte){

		switch($tipo_reporte){

			//Estudiantes por curso
			case 'estudiantes_curso':
				$consulta1 = "SELECT e.nombre, e.correo, e.telefono, c.codigo, c.nombre  FROM estudiante e, proyecto p, proyecto_estudiante pe, curso c WHERE e.id_estudiante = pe.id_estudiante AND p.id_proyecto = pe.id_proyecto AND p.id_curso = c.id_curso";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();	

				$lista = '<thead>
                                <tr>
                                    <th>Nombre estudiante</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Codigo materia</th>
                                    <th>Nombre materia</th>
                                    <th>Grupo</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nombre estudiante</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Codigo materia</th>
                                    <th>Nombre materia</th>
                                    <th>Grupo</th>
                                </tr>
                            </tfoot>
                            <tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '	<tr>
				                        <td>'.$row['nombre'].'</td>
				                        <td>'.$row['correo'].'</td>
				                        <td>'.$row['telefono'].'</td>
				                        <td>'.$row['codigo'].'</td>
				                        <td>'.$row['nombre'].'</td>
				                        <td> A </td>
			                        </tr>';
				}
				$lista.='</tbody>';

				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta2 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta2 = $this->modelo->consultar($consulta2);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta2)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$this->mostrarVista($plantilla);

				break;

			//proyectos por curso
			case 'proyecto_curso':
				$consulta1 = "SELECT p.nombre, p.descripcion, p.estado, c.codigo, c.nombre  FROM proyecto p, curso c WHERE p.id_curso = c.id_curso";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$lista = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                        	</thead>
                        	<tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                        	</tfoot>
                        	<tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '
                                
									<tr>
				                        <td>'.$row['nombre'].'</td>
				                        <td>'.$row['descripcion'].'</td>
				                        <td>'.$row['estado'].'</td>
				                        <td>'.$row['codigo'].'</td>
				                        <td>'.$row['nombre'].'</td>
				                        <td> A </td>
			                        </tr>';
				}
				$lista.='</tbody>';
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$this->mostrarVista($plantilla);
				break;

			//proyectos por semestre
			case 'proyecto_semestre':
				$consulta1 = "SELECT p.nombre, p.descripcion, p.estado, c.codigo, c.nombre  FROM proyecto p, curso c WHERE p.id_curso = c.id_curso";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$lista = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Semestre</th>
                            </tr>
                        	</thead>
                        	<tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Semestre</th>
                            </tr>
                        	</tfoot>
                        	<tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '
                                
									<tr>
				                        <td>'.$row['nombre'].'</td>
				                        <td>'.$row['descripcion'].'</td>
				                        <td>'.$row['estado'].'</td>
				                        <td>'.$row['codigo'].'</td>
				                        <td>'.$row['nombre'].'</td>
				                        <td> 2017 </td>
			                        </tr>';
				}
				$lista.='</tbody>';
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$this->mostrarVista($plantilla);
				break;

			//proyectos sin terminar
			case 'proyectos_sin_terminar':

				$consulta1 = "SELECT p.nombre, p.descripcion, p.estado, c.codigo, c.nombre  FROM proyecto p, curso c WHERE p.id_curso = c.id_curso";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$lista = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                        	</thead>
                        	<tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                        	</tfoot>
                        	<tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '
                                
									<tr>
				                        <td>'.$row['nombre'].'</td>
				                        <td>'.$row['descripcion'].'</td>
				                        <td>'.$row['estado'].'</td>
				                        <td>'.$row['codigo'].'</td>
				                        <td>'.$row['nombre'].'</td>
				                        <td> A </td>
			                        </tr>';
				}
				$lista.='</tbody>';
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$this->mostrarVista($plantilla);

				break;

			case 'proyectos_todos':

				$consulta1 = "SELECT p.nombre, p.descripcion, p.estado, c.codigo, c.nombre  FROM proyecto p, curso c WHERE p.id_curso = c.id_curso";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$lista = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                        	</thead>
                        	<tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                        	</tfoot>
                        	<tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '
                                
									<tr>
				                        <td>'.$row['nombre'].'</td>
				                        <td>'.$row['descripcion'].'</td>
				                        <td>'.$row['estado'].'</td>
				                        <td>'.$row['codigo'].'</td>
				                        <td>'.$row['nombre'].'</td>
				                        <td> A </td>
			                        </tr>';
				}
				$lista.='</tbody>';
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$this->mostrarVista($plantilla);
				break;

			case 'curso_semestre':
				$consulta1 = "SELECT c.codigo, c.nombre  FROM curso c";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$lista = '<thead>
                            <tr>
                                <th>Nombre curso</th>
                                <th>Descripcion</th>
                                <th>A&nacute;o</th>
                                <th>Periodo</th>
                                <th>Grupo</th>
                                <th>Semestre</th>
                            </tr>
                        	</thead>
                        	<tfoot>
                            <tr>
                                <th>Nombre curso</th>
                                <th>Descripcion</th>
                                <th>A&nacute;o</th>
                                <th>Periodo</th>
                                <th>Grupo</th>
                                <th>Semestre</th>
                            </tr>
                        	</tfoot>
                        	<tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '
                                
									<tr>
				                        <td>'.$row['codigo'].'</td>
				                        <td>'.$row['nombre'].'</td>
				                        <td> 2017 </td>
				                        <td> I </td>
				                        <td> A </td>
				                        <td> Actual </td>
			                        </tr>';
				}
				$lista.='</tbody>';
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
				$this->mostrarVista($plantilla);
				break;

			case 'docentes_semestre':
				$consulta1 = "SELECT d.nombre, d.correo, d.telefono FROM docente d";
				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$lista = '<thead>
                            <tr>
                                <th>Nombre docente</th>
                                <th>Correo docente</th>
                                <th>Telefono</th>
                                <th>A&nacute;o</th>
                                <th>Periodo</th>
                                <th>Semestre</th>
                            </tr>
                        	</thead>
                        	<tfoot>
                            <tr>
                                <th>Nombre docente</th>
                                <th>Correo docente</th>
                                <th>Telefono</th>
                                <th>A&nacute;o</th>
                                <th>Periodo</th>
                                <th>Semestre</th>
                            </tr>
                        	</tfoot>
                        	<tbody>';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$lista .= '
                                
									<tr>
				                        <td>'.$row['nombre'].'</td>
				                        <td>'.$row['correo'].'</td>
				                        <td>'.$row['telefono'].'</td>
				                        <td> 2017 </td>
				                        <td> I </td>
				                        <td> Actual </td>
			                        </tr>';
				}
				$lista.='</tbody>';
				$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/generar_reportes.html');
				$replace = '<thead>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nombre proyecto</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Codigo materia</th>
                                <th>Nombre materia</th>
                                <th>Grupo</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>';
				$plantilla = $this->reemplazar( $plantilla, $replace, $lista);

				$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$_SESSION['admin']."";

				$this->modelo->conectar();
				$respuesta1 = $this->modelo->consultar($consulta1);
				$this->modelo->desconectar();

				$nombre = '';
				$correo = '';
				while ($row = mysqli_fetch_array($respuesta1)) {
					$nombre = $row['nombre'];
					$correo = $row['correo'];
				}

				$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
				$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);

				
				$this->mostrarVista($plantilla);
				break;
		}
	}


	public function invitarDocente($email){

		
		/*
				//funcion mail simple 
				$mail = "Lo invitamos a formar parte de Project Manager";
				//Titulo
				$titulo = "Project Manager UFPS";
				//cabecera
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				//dirección del remitente 
				$headers .= "From: ProjectManagerTeam <".$email.">\r\n";
				//Enviamos el mensaje a tu_dirección_email 
				$bool = mail($email,$titulo,$mail,$headers);
				if($bool){
					echo'<script type="text/javascript">
					alert("Enviado Correctamente");
					</script>'; 
				}else{
					echo'<script type="text/javascript">
					alert("NO ENVIADO, intentar de nuevo");
					</script>';
				}
		*/		

		
		//funcion para enviar correo con la libreria PHPMailer
		$mail = new PHPMailer();

		//Luego tenemos que iniciar la validación por SMTP:
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPDebug = 4;
		$mail->Host = "smtp.gmailcom"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
		$mail->Username = "brayamalbertoma@ufps.edu.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
		$mail->Password = "Elvira22*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
		$mail->Port = 587; // Puerto de conexión al servidor de envio. 
		$mail->From = "brayamalbertoma@ufps.edu.co"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
		$mail->FromName = "Projec Manager UFPS"; //A RELLENAR Nombre a mostrar del remitente. 
		$mail->AddAddress( $email ); // Esta es la dirección a donde enviamos 
		$mail->IsHTML(true); // El correo se envía como HTML 
		$mail->Subject = "Invitacion Project Manager"; // Este es el titulo del email. 
		$body = "Buen dia docente."; 
		$body .= "Lo invitamos a formar parte de la plataforma de administracion de projectos: <br> <b>Project Manager</b>"; 
		$mail->Body = $body; // Mensaje a enviar. 
		$exito = $mail->Send(); // Envía el correo.
		if($exito){ 
			echo'<script type="text/javascript">
            alert("Enviado Correctamente");
         	</script>'; 
		}else{ 
			echo'<script type="text/javascript">
            alert("NO ENVIADO, intentar de nuevo");
         	</script>';
         	echo $mail->ErrorInfo; 
		} 
		
		
		header('Location: index.php');
	}

	public function registrarEstudiante($nombre, $telefono, $correo, $password, $confirm){


		//Busco todas las personas para hacer la comprobacion si ya existe o no en la base de datos 	
		$consulta1 = "SELECT COUNT(correo) FROM estudiante  WHERE correo = '".$correo."'";
		$resultado;
		$this->modelo->conectar();
		$resultado=$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();


		$row = mysqli_fetch_array($resultado);
		
	 	//Si la consulta no me arrojo resultados, quiere decir que la persona no existe, entonces la agrego a la bd
		if($row[0] == 0){

			$passh= password_hash($password, PASSWORD_DEFAULT);

			$consulta2 = "INSERT INTO estudiante VALUES( null, '".$nombre."', '".$correo."', '".$telefono."', '".$passh."')";
			$this->modelo->conectar();
			$this->modelo->consultar($consulta2);
			$this->modelo->desconectar();

			
	 	 	//Guardo un mensaje para ser mostrado al registrar el usuario
			echo'<script type="text/javascript">
            		alert("Registro exitoso.");
         		</script>';
			header('Location: index.php');

		}else{

	 	 	//Si el usuario ya esta registrado muestre la vista de registro
			echo'<script type="text/javascript">
            		alert("Registro fallido: Usuario ya existe.");
         		</script>';
			header('Location: index.php');
		}
	}







	//Eliminar Docente

	public function eliminarDocente( $id_docente ) {
		$consulta1 = "DELETE FROM docente WHERE id_docente = $id_docente";
		$this->modelo->conectar();
		$resultado=$this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		echo'<script type="text/javascript">
				alert("Docente eliminado correctamente.");
		</script>';
		header('Location: index.php');
	}
 



	/*************************************************************************************************
	 ***********************    METODOS PRIVADOS   **************************************************
	 *************************************************************************************************
	*/

	/**
	* Monto en la plantilla los datos de nombre y correo que siempre se muestran
	* @return la plantilla modificada
	*/
	
	private function montarDatos($plantilla, $tipoUser, $id){

		if(($tipoUser == 'admin') || ($tipoUser == 'docente')){
			$consulta1 = "SELECT nombre, correo FROM docente WHERE id_docente = ".$id."";
		}else{
			if($tipoUser == 'estudiante'){
				$consulta1 = "SELECT nombre, correo FROM estudiante WHERE id_estudiante = ".$id."";
			}
		}
		
		$this->modelo->conectar();
		$respuesta1 = $this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		$nombre = '';
		$correo = '';
		while ($row = mysqli_fetch_array($respuesta1)) {
			$nombre = $row['nombre'];
			$correo = $row['correo'];
		}

		$nuevaPlantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
		$nuevaPlantilla = $this->reemplazar( $nuevaPlantilla, '{{correo}}', $correo);

		return $nuevaPlantilla;
	}


	/**
	* Monto en la plantilla los datos calculados de las tarjetas
	* @return la plantilla modificada
	*/
	private function calcularTarjetas($plantilla){

		$consulta2 = "SELECT COUNT(correo) FROM docente";
		$consulta3 = "SELECT COUNT(*) FROM curso";
		$consulta4 = "SELECT COUNT(*) FROM proyecto";
		$consulta5 = "SELECT COUNT(*) FROM estudiante";

		$this->modelo->conectar();
		$respuesta2 = $this->modelo->consultar($consulta2);		
		$respuesta3 = $this->modelo->consultar($consulta3);
		$respuesta4 = $this->modelo->consultar($consulta4);
		$respuesta5 = $this->modelo->consultar($consulta5);
		$this->modelo->desconectar();

		
		$docentes='';
		if(!$respuesta2 || mysqli_num_rows($respuesta2) == 0){

			$docentes = '<div class="icon">
                            <i class="material-icons">group</i>
                        </div>
                        <div class="content">
                            <div class="text">DOCENTES</div>
                            <div class="number count-to" data-from="0" data-to="0" data-speed="15" data-fresh-interval="20"></div>
                        </div>';
		}else{
			
			while($row = mysqli_fetch_array($respuesta2)){
			$docentes = '<div class="icon">
                            <i class="material-icons">group</i>
                        </div>
                        <div class="content">
                            <div class="text">DOCENTES</div>
                            <div class="number count-to" data-from="0" data-to="'.$row['COUNT(correo)'].'" data-speed="15" data-fresh-interval="20"></div>
                        </div>';
			}
		}
		

		$cursos='';
		if(!$respuesta3 || mysqli_num_rows($respuesta3) == 0){

			$cursos = ' <div class="icon">
	                            <i class="material-icons">book</i>
	                        </div>
	                        <div class="content">
	                            <div class="text">CURSOS</div>
	                            <div class="number count-to" data-from="0" data-to="0" data-speed="1000" data-fresh-interval="20"></div>
	                        </div>';
		}else{
			while($row = mysqli_fetch_array($respuesta3)){
				$cursos = ' <div class="icon">
	                            <i class="material-icons">book</i>
	                        </div>
	                        <div class="content">
	                            <div class="text">CURSOS</div>
	                            <div class="number count-to" data-from="0" data-to="'.$row['COUNT(*)'].'" data-speed="1000" data-fresh-interval="20"></div>
	                        </div>';
	        }
		}

		$proyectos='';
		if(!$respuesta4 || mysqli_num_rows($respuesta4) == 0){

			$proyectos= ' <div class="icon">
	                            <i class="material-icons">folder</i>
	                        </div>
	                        <div class="content">
	                            <div class="text">PROYECTOS</div>
	                            <div class="number count-to" data-from="0" data-to="0" data-speed="1000" data-fresh-interval="20"></div>
	                        </div>';
		}else{
			while($row = mysqli_fetch_array($respuesta4)){
				$proyectos = ' <div class="icon">
	                            <i class="material-icons">folder</i>
	                        </div>
	                        <div class="content">
	                            <div class="text">PROYECTOS</div>
	                            <div class="number count-to" data-from="0" data-to="'.$row['COUNT(*)'].'" data-speed="1000" data-fresh-interval="20"></div>
	                        </div>';
			}
		}


		$alumnos='';
		if(!$respuesta5 || mysqli_num_rows($respuesta5) == 0){

			$alumnos =  '  <div class="icon">
	                            <i class="material-icons">person_add</i>
	                        </div>
	                        <div class="content">
	                            <div class="text">ALUMNOS</div>
	                            <div class="number count-to" data-from="0" data-to="0" data-speed="1000" data-fresh-interval="20"></div>
	                        </div>';
		}else{
			while($row = mysqli_fetch_array($respuesta5)){
				$alumnos = '  <div class="icon">
	                            <i class="material-icons">person_add</i>
	                        </div>
	                        <div class="content">
	                            <div class="text">ALUMNOS</div>
	                            <div class="number count-to" data-from="0" data-to="'.$row['COUNT(*)'].'" data-speed="1000" data-fresh-interval="20"></div>
	                        </div>';
			}
		}

		
		$nuevaPlantilla = $this->reemplazar( $plantilla, '{{docentes}}', $docentes);
		$nuevaPlantilla = $this->reemplazar( $nuevaPlantilla, '{{cursos}}', $cursos);
		$nuevaPlantilla = $this->reemplazar( $nuevaPlantilla, '{{proyectos}}', $proyectos);
		$nuevaPlantilla = $this->reemplazar( $nuevaPlantilla, '{{alumnos}}', $alumnos);

		return $nuevaPlantilla;
	}
}