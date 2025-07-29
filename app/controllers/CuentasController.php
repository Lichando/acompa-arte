<?php
namespace app\controllers;
use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;
use app\models\InstitucionModel;
use app\controllers\SessionController;

class CuentasController extends Controller
{
	// Constructor
	public function __construct()
	{
		// Inicializar sesión
		new SessionController();
	}

	public function actionLogin()
	{
		// Si ya está logueado, redirigir según su rol
		if (SessionController::isLoggedIn()) {
			$this->redirectByRole();
			exit;
		}

		// Cargar componentes de la vista
		$head = SiteController::head();
		$header = SiteController::header();
		$footer = SiteController::footer();

		$errors = [];
		$old = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = trim(strtolower($_POST['email'] ?? ''));
			$password = $_POST['contrasena'] ?? '';
			$old = $_POST; // Guardar datos para repoblar el formulario

			// Validaciones
			if (empty($email)) {
				$errors['email'] = "El email es obligatorio";
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Ingrese un email válido";
			}

			if (empty($password)) {
				$errors['contrasena'] = "La contraseña es obligatoria";
			}

			if (empty($errors)) {
				$usuario = UserController::GetUser($email);

				if ($usuario) {
					$activo = UserController::checkActivo($email);

					if ($activo === true) {
						if (password_verify($password, $usuario->contrasena)) {

							$institucionId = InstitucionModel::getInstitucionPorUsuarioId($usuario->id);
							

							// Iniciar sesión con el rol correspondiente
							SessionController::login(
								$usuario->id,
								$usuario->nombre,
								$usuario->rol_id,
								$institucionId
							);

							// Redirigir según el rol
							$this->redirectByRole();
							exit;
						} else {
							$errors['contrasena'] = "La contraseña es incorrecta";
						}
					} else {
						$errors['general'] = $activo; // Mensaje de error de checkActivo
					}
				} else {
					$errors['email'] = "El usuario no existe";
				}
			}
		}

		Response::render(
			$this->viewDir(__NAMESPACE__),
			"login",
			[
				"title" => 'Iniciar Sesión',
				"head" => $head,
				"header" => $header,
				"footer" => $footer,
				"errors" => $errors,
				"old" => $old, // Pasar datos para repoblar formulario
				"msgError" => $errors['general'] ?? '' // Mantener compatibilidad con vista antigua
			]
		);
	}

	public function actionRegister()
	{
		// Redirigir si ya está logueado
		if (SessionController::isLoggedIn()) {
			$this->redirectByRole();
			exit;
		}

		// Cargar componentes de la vista
		$head = SiteController::head();
		$header = SiteController::header();
		$footer = SiteController::footer();

		$errors = [];

		// Procesar formulario POST
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Sanear y validar datos
			$nombre = trim($_POST['name'] ?? '');
			$apellido = trim($_POST['lastname'] ?? '');
			$email = trim($_POST['email'] ?? '');
			$password = $_POST['contrasena'] ?? '';
			$confirmPassword = $_POST['confirmar_contrasena'] ?? '';
			$nacimiento = $_POST['nacimiento'] ?? '';
			$genero = $_POST['genero'] ?? '';
			$terminos = isset($_POST['terminos']) ? true : false;

			// Validación de campos
			if (empty($nombre)) {
				$errors['name'] = "El nombre es obligatorio";
			} elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
				$errors['name'] = "El nombre solo puede contener letras y espacios";
			}

			if (empty($apellido)) {
				$errors['lastname'] = "El apellido es obligatorio";
			} elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellido)) {
				$errors['lastname'] = "El apellido solo puede contener letras y espacios";
			}

			if (empty($email)) {
				$errors['email'] = "El correo electrónico es obligatorio";
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Ingrese un correo electrónico válido";
			} elseif (UserModel::findEmail($email) !== false) {
				$errors['email'] = "Este correo electrónico ya está registrado";
			}

			if (empty($password)) {
				$errors['contrasena'] = "La contraseña es obligatoria";
			} elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
				$errors['contrasena'] = "Debe tener 8+ caracteres, 1 mayúscula, 1 número y 1 carácter especial";
			}

			if (empty($confirmPassword)) {
				$errors['confirmar_contrasena'] = "Confirme su contraseña";
			} elseif ($password !== $confirmPassword) {
				$errors['confirmar_contrasena'] = "Las contraseñas no coinciden";
			}

			if (empty($nacimiento)) {
				$errors['nacimiento'] = "La fecha de nacimiento es obligatoria";
			} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $nacimiento)) {
				$errors['nacimiento'] = "Formato inválido (AAAA-MM-DD)";
			} else {
				// Validar edad mínima (13 años)
				$birthDate = new \DateTime($nacimiento);
				$minAgeDate = new \DateTime();
				$minAgeDate->modify('-13 years');

				if ($birthDate > $minAgeDate) {
					$errors['nacimiento'] = "Debes tener al menos 13 años para registrarte";
				}
			}

			if (empty($genero)) {
				$errors['genero'] = "Seleccione un género";
			} elseif (!in_array($genero, ['masculino', 'femenino', 'nobinario'])) {
				$errors['genero'] = "Género inválido";
			}


			if (!$terminos) {
				$errors['terminos'] = "Debe aceptar los términos y condiciones";
			}

			// Si no hay errores, proceder con el registro
			if (empty($errors)) {
				$passwordHash = password_hash($password, PASSWORD_DEFAULT);

				// Datos para el modelo
				$userData = [
					'nombre' => $nombre,
					'apellido' => $apellido,
					'email' => $email,
					'contrasena' => $passwordHash,
					'fecha_nacimiento' => $nacimiento,
					'genero' => $genero,
					'rol_id' => 1,
					'activo' => 1
				];

				// Intentar registro
				$registroExitoso = UserModel::usuarioNew($userData);

				if ($registroExitoso) {
					// Iniciar sesión automáticamente
					$usuario = UserController::GetUser($email);
					if ($usuario) {
						SessionController::login(
							$usuario->id,
							$usuario->nombre,
							$usuario->rol_id
						);
						$this->redirectByRole();
						exit;
					}
					header("Location: ./login");
					exit;
				} else {
					error_log("Error al registrar usuario: " . print_r($userData, true));
					$errors['general'] = "Hubo un error al registrar el usuario. Por favor, intente nuevamente.";
				}
			}
		}

		// Renderizar vista
		Response::render($this->viewDir(__NAMESPACE__), "register", [
			"title" => 'Registrarse',
			"head" => $head,
			"header" => $header,
			"footer" => $footer,
			"errors" => $errors ?? [],
			"roles" => $this->getAvailableRolesForRegistration() ?? [],
			"old" => $_POST ?? [] // Para mantener los valores ingresados
		]);
	}
	/**
	 * Redirige al usuario según su rol
	 */
	public function redirectByRole()
	{
		switch (SessionController::getRoleId()) {
			case SessionController::ROLE_ADMIN:
				header("Location: ../admin/dashboard");
				break;

			case SessionController::ROLE_INSTITUCION:
				header("Location: ../institucion/dashboard");

				break;

			case SessionController::ROLE_ACOMPANANTE:
				header("Location: ../acompanante/dashboard");
				break;

			case SessionController::ROLE_PACIENTE:
				header("Location: ../paciente/dashboard");
				break;

			case SessionController::ROLE_USER:
			default:
				header("Location: ../usuario/dashboard"); // <- empezamos con este
				break;
		}

		exit;
	}


	/**
	 * Obtiene los roles disponibles para registro
	 */
	private function getAvailableRolesForRegistration()
	{
		// Por defecto solo permitir registro como usuario normal
		// Puedes modificar esto según tus necesidades
		return [
			SessionController::ROLE_USER => 'Usuario normal',
			// SessionController::ROLE_ACOMPANANTE => 'Asistente', // Descomentar si quieres permitir este registro
			// SessionController::ROLE_INSTITUCION => 'Institución', // Descomentar si quieres permitir este registro
		];
	}

	public function action404()
	{
		$head = SiteController::head();
		Response::render($this->viewDir(__NAMESPACE__), "../home/404", [
			"title" => $this->title . ' 404',
			"head" => $head,
		]);
	}
	public function actionLogout()
	{
		SessionController::logout();
		header("Location: ./login");
		exit;
	}



}