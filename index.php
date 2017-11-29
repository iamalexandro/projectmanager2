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


	if( isset($_GET['tokenRetrivePass']) && isset($_GET['userEmail']) ) {
		$controladorInicio->recuperarPassValidate($_GET['tokenRetrivePass'], $_GET['userEmail']);
	}

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
					$controladorInicio->mostrarFormRegistrarDocenteAdmin();
					break;

				case 'modificar_docente':
					$controladorInicio->mostrarFormModificarDocente();
					break;
			
				case 'modificar_curso':
					$controladorInicio->mostrarFormModificarCurso();
					break;
			
				case 'modificar_proyecto':
					$controladorInicio->mostrarFormModificarProyecto();
					break;

				case 'listado_docentes':
					$controladorInicio->mostrarFormListadoDocentes();
					break;
				
				case 'listado_proyectos':
				$controladorInicio->mostrarFormListadoProyectos();
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

				case 'mis_cursos':
					$controladorInicio->mostrarFormMisCursos();
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

					case 'listado_proyectos':
						$controladorInicio->mostrarFormListadoProyectos();
						break;

					case 'registrar_proyectos':
						$controladorInicio->mostrarFormRegistrarProyectos('d');
						break;

					case 'modificar_proyecto':
						$controladorInicio->mostrarFormModificarProyecto();
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
						
						case 'mis_cursos':
							$controladorInicio->mostrarFormMisCursos();
							break;
						
						case 'inscribir_curso':
							$controladorInicio->mostrarFormInscribirCurso('e');
							break;
						
							case 'inscribir_proyecto':
							$controladorInicio->mostrarFormInscribirProyecto();
							break;

						case 'mis_proyectos':
							$controladorInicio->mostrarFormMisProyectosEstudiante();
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

						case 'registro_docente':
							$controladorInicio->mostrarFormRegistroDocente();
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

	//si no hay ni mierda y se desea recuperar la contraseña
	if(isset($_POST['recuperarPass'])) {
		$controladorInicio->recuperarPassSendMail($_POST['correo']);
	}

	if( isset($_POST['recuperarPassValidated']) && $_POST['pass']==$_POST['confirm'] ) {
		$controladorInicio->updatePass($_POST['pass'], $_POST['email']);
	}


	//si hay una solicitud por el metodo post
	if(isset($_POST['solicitudes'])){

		//Guardo el valor de la variable solicitudes
		$tipo = $_POST['solicitudes'];
		
		//si hay una solicitud en la sesion admin
		if(isset($_SESSION['admin'])){

			if($tipo == "modificar_docente"){
				$controladorInicio->modificarDocente($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['id']);
			}

			if($tipo == "invitar_docente"){
				$controladorInicio->invitarDocente($_POST['email'] );	
			}
			
			if($tipo == "modificar_curso"){
				$controladorInicio->modificarCurso($_POST['codigo'], $_POST['nombre'], $_POST['id']);
			}
	
			if($tipo == "agregar_admin"){
				$controladorInicio->agregarAdmin($_POST['docente']);
			}
	
			if($tipo == "registrar_curso"){
				$controladorInicio->registrarCurso($_POST['codigo'], $_POST['nombre']);
			}

			if($tipo == "generar_reportes"){
				$controladorInicio->generarReportes($_POST['reporte']);	
			}

			if($tipo == "inscribir_curso"){
				$controladorInicio->inscribirCurso($_POST['curso'], 'a');	
			}

			if($tipo == "registrar_proyecto"){
				$controladorInicio->registrarProyecto('a', $_POST['curso'], $_POST['nombre'], $_POST['url_app'] || null, $_POST['url_codigo'] || null, $_POST['descripcion'] || null);	
			}

			if($tipo == "modificar_proyecto"){
				$controladorInicio->modificarProyecto($_POST['curso'], $_POST['nombre'], $_POST['url_app'] || null, $_POST['url_codigo'] || null, $_POST['descripcion'] || null, $_POST['id_proyecto'], $_POST['estado'] );	
			}

		}else{//si hay una solicitud en la sesion docente

			if(isset($_SESSION['docente'])){

				if($tipo == "inscribir_curso"){
					$controladorInicio->inscribirCurso($_POST['curso'], 'd');	
				}

				if($tipo == "registrar_proyecto"){
					$controladorInicio->registrarProyecto('d', $_POST['curso'], $_POST['nombre'], $_POST['url_app'] || null, $_POST['url_codigo'] || null, $_POST['descripcion'] || null);	
				}

				if($tipo == "modificar_proyecto"){
					$controladorInicio->modificarProyecto($_POST['curso'], $_POST['nombre'], $_POST['url_app'] || null, $_POST['url_codigo'] || null, $_POST['descripcion'] || null, $_POST['id_proyecto'], $_POST['estado'] );	
				}

			}else{//si hay una solicitud en la sesion estudiante

				if(isset($_SESSION['estudiante'])){

					if($tipo == "inscribir_curso"){
						$controladorInicio->inscribirCurso($_POST['curso'], 'e');	
					}

				}else{//si hay una solicitud sin iniciar una sesion

					//Si la solicitud es para iniciar sesion, guardamos los datos de sesion 
					if($tipo == "login"){
						
						$controladorInicio->guardarLogin($_POST['correo'], $_POST['contrasena']);
					}
					
					if($tipo == "registrar_docente"){
						$controladorInicio->guardarDocente($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password']);
					}

					if($tipo == "registro_estudiante"){
						$controladorInicio->registrarEstudiante($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['codigo'], $_POST['confirm']);
					}

					if($tipo == "registro_docente"){
						$controladorInicio->registrarDocente($_POST['nombre'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['confirm']);
					}
				}
			}
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

	//eliminar docente
	if(isset($_POST['docente'])) {
		$id_docente = $_POST['id'];
		echo json_encode(array('response' => $controladorInicio->eliminarDocente($id_docente)));
		exit();
	}


	//eliminar curso
	if(isset($_POST['curso'])) {
		$id_curso = $_POST['id'];
		echo json_encode(array('response' => $controladorInicio->eliminarCurso($id_curso)));
		exit();
	}


	//eliminar proyecto
	if(isset($_POST['proyecto'])) {
		$id_proyecto = $_POST['id'];
		echo json_encode(array('response' => $controladorInicio->eliminarProyecto($id_proyecto)));
		exit();
	}

	//salir curso
	if(isset($_POST['curso'])) {
		$id_curso = $_POST['id'];
		echo json_encode(array('response' => $controladorInicio->salirCurso($id_curso)));
		exit();
	}