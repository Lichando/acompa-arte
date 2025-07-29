<?php
namespace app\controllers;
use \Controller;
use app\models\CategoriaModel;

class SiteController extends Controller
{
	// Constructor
	public function __construct()
	{
		// self::$sessionStatus = SessionController::sessionVerificacion();
	}

	public static function head()
	{
		static::path();
		$head = file_get_contents(APP_PATH . '/views/inc/head.php');
		$head = str_replace('#PATH#', self::$ruta, $head);
		return $head;
	}
	public static function header()
	{
		static::path();
		$header = file_get_contents(APP_PATH . '/views/inc/header.php');

		// Determinar el enlace de autenticación
		$authLink = SessionController::isLoggedIn()
			? '<li><a href="' . self::$ruta . 'cuentas/logout" class="btn-inicio1">Cerrar sesión</a></li>'
			: '<li><a href="' . self::$ruta . 'cuentas/login" class="btn-inicio1">Iniciar sesión</a></li>';

		// Reemplazar los placeholders
		$header = str_replace(
			['#PATH#', '#AUTH_LINK#'],
			[self::$ruta, $authLink],
			$header
		);

		return $header;
	}
	public static function footer()
	{
		static::path();
		$footer = file_get_contents(APP_PATH . '/views/inc/footer.php');
		$footer = str_replace('#PATH#', self::$ruta, $footer);
		return $footer;
	}
	public static function menu()
	{
	}
}
