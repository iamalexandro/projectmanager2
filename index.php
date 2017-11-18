<?php

	include ('controlador/controladorInicio.php');

	session_start();	

	//Variable que me permite llamar funciones de la clase controladorInicio
	$controladorInicio = new controladorInicio();

	//Si alguien se acaba de registrar, seguidamente muestre la vista para iniciar sesion
	if(isset($_SESSION['registro'])){
		unset($_SESSION['registro']);
		$controladorInicio->inicio();
		exit();
	}



	/*************************************************************************************************
	 ***********************    METODOS GET   ********************************************************
	 *************************************************************************************************
	*/

	//Pregunta si existe el parametro boton con algun valor en la url de la pagina
	if(isset($_GET['boton'])){

		//Guardo el valor de la variable boton 
		$boton = $_GET['boton'];

		
		/********** METODOS GET ADMINISTRADOR ********/

		if(isset($_SESSION['admin'])){

			switch ( $boton ) {

				//Si el administrador desea cerrar sesion
				case 'logouta':
					unset ( $_SESSION['admin'] );
					header('Location: index.php');
					break;

				case 'registrar_docente':
					$controladorInicio->mostrarFormRegistrarDocente();
					break;

				case 'modificar_docente':
					$controladorInicio->mostrarFormModificarDocente();
					break;
			
					case 'modificar_curso':
					$controladorInicio->mostrarFormModificarCurso();
					break;

				case 'listado_docentes':
					$controladorInicio->mostrarFormListadoDocentes();
					break;

				case 'invitar_docente':
					$controladorInicio->mostrarFormInvitarDocente();
					break;

				case 'agregar_admin':
					$controladorInicio->mostrarFormAgregarAdmin();
					break;

				case 'registrar_curso':
					$controladorInicio->mostrarFormRegistrarCurso();
					break;
				
					case 'listado_cursos':
					$controladorInicio->mostrarFormListadoCursos();
					break;

				case 'generar_reportes':
					$controladorInicio->mostrarFormGenerarReportes();
					break;

				case 'inscribir_curso':
					$controladorInicio->mostrarFormInscribirCurso('a');
					break;

				case 'registrar_proyectos':
					$controladorInicio->mostrarFormRegistrarProyectos('a');
					break;

				case 'agregar_alumnos':
					$controladorInicio->mostrarFormAgregarAlumnos('a');
					break;

				
				default:
					header('Location: index.php');
					break;
			}
		}else{
			
			/********** METODOS GET DOCENTE ********/

			if(isset($_SESSION['docente'])){

				switch ($boton) {

					//Si el usuario desea cerrar sesion lo redirigimos a la pagina de inicio					
					case 'logoutd':
						unset ( $_SESSION['docente'] );
						header('Location: index.php');
						break;

					case 'inscribir_curso':
					$controladorInicio->mostrarFormInscribirCurso('d');
					break;

					case 'registrar_proyectos':
						$controladorInicio->mostrarFormRegistrarProyectos('d');
						break;

					default:
					header('Location: index.php');
					break;
				}	
			}else{

				if(isset($_SESSION['estudiante'])){

					switch ($boton) {

						//Si el usuario desea cerrar sesion lo redirigimos a la pagina de inicio					
						case 'logoute':
							unset ( $_SESSION['estudiante'] );
							header('Location: index.php');
							break;

						case 'inscribir_curso':
						$controladorInicio->mostrarFormInscribirCurso('e');
						break;

						case 'mis_proyectos':
							$controladorInicio->mostrarFormMisProyectos();
							break;

						default:
						header('Location: index.php');
						break;
					}
				}else{

					switch ( $boton ) {
					
						//Si se solicita la vista de inicio de sesion 
						case 'login':
							$controladorInicio->inicio();
							break;

						case 'recuperar_contrasena':
							$controladorInicio->mostrarFormRecuperarPass();
							break;

						case 'registro_estudiante':
							$controladorInicio->mostrarFormRegistrarEstudiante();
							break;
						default:
						header('Location: index.php');
						break;
					}
				}					
			}		
		}
		exit();
	}






	/*************************************************************************************************
	 ***********************    METODOS POST   *******************************************************
	 *************************************************************************************************
	*/



	if(isset($_POST['solicitudes'])){

		//Guardo el valor de la variable solicitudes
		$tipo = $_POST['solicitudes'];
		
		//Si la solicitud es para iniciar sesion, guardamos los datos de sesion 
		if($tipo == "login"){
			
			$controladorInicio->guardarLogin($_POST['correo'], $_POST['contrasena']);
		}

		if($tipo == "registrar_docente"){
			$controladorInicio->guardarDocente($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['admin']);
		}
	
		if($tipo == "modificar_docente"){
			$controladorInicio->modificarDocente($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['id']);
		}
		
		if($tipo == "modificar_curso"){
			$controladorInicio->modificarCurso($_POST['nombre'], $_POST['descripcion'], $_POST['id']);
		}

		if($tipo == "agregar_admin"){
			$controladorInicio->agregarAdmin($_POST['docente']);
		}

		if($tipo == "registrar_curso"){
			$controladorInicio->registrarCurso($_POST['codigo'], $_POST['nombre
			']);
		}

		if($tipo == "inscribir_curso_a"){
			$controladorInicio->inscribirCurso($_POST['curso'], 'a');	
		}

		if($tipo == "registrar_proyecto_a"){
			$controladorInicio->registrarProyecto('a', $_POST['curso'], $_POST['nombre'], $_POST['url_app'], $_POST['url_codigo'], $_POST['descripcion'] );	
		}

		if($tipo == "generar_reportes"){
			$controladorInicio->generarReportes($_POST['reporte'] );	
		}

		if($tipo == "invitar_docente"){
			$controladorInicio->invitarDocente($_POST['email'] );	
		}

		if($tipo == "registro_estudiante"){
			$controladorInicio->registrarEstudiante($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['confirm']);
		}
		
		exit();
	}
	
	
	//Si existe una sesion de administrador, o de docente o no existe ninguna sesion 
	if(isset($_SESSION['admin'])){
		
		//irse a la vista de admin
		$controladorInicio->inicioAdmin();
	}else{
		if (isset($_SESSION['docente'])) {
			
			//irse a la vista de docente
			$controladorInicio->inicioDocente();
		}else{

			if(isset($_SESSION['estudiante'])){
				
				//irse a la vista de estudiante
				$controladorInicio->inicioEstudiante();
			}else{
				
				//irse a la vista principal
				$controladorInicio->inicio();
			}
			

		}
	}




		/*************************************************************************************************
	 ***********************    METODOS DELETE   *******************************************************
	 *************************************************************************************************
	*/

	//eliminar usuarios desde las vistas de listados (docentes, estudiantes, etc)

	if(isset($_DELETE['docente'])) {
		$id_docente = $_DELETE['id'];
		echo "si borra";
		//$controladorInicio->eliminarDocente($id_docente);
	}
