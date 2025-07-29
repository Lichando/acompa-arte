<?php 
namespace app\controllers;
use \Controller;
use \Response;
use \DataBase;

class HomeController extends Controller
{

    // Constructor
    public function __construct(){

    }

	public function actionIndex($var = null){
		$head = SiteController::head();
		$header = SiteController::header();
		$footer = SiteController::footer();
		$path = static::path();
		Response::render($this->viewDir(__NAMESPACE__),"inicio", [
																"title" => 'Bienvenidos a AcompañArte',
																 "head" => $head,
																 "header" => $header,
																 "footer"=>$footer
																]);
	}

		public function actionBusqueda(){
		$head = SiteController::head();
		$path = static::path();
		Response::render($this->viewDir(__NAMESPACE__),"busqueda", [
																"title" => 'Busqueda',
																 "head" => $head,
																]);
	}

	
	public function actionNosotros(){
		$head = SiteController::head();
		$header = SiteController::header();
		$footer = SiteController::footer();
		$path = static::path();
		Response::render($this->viewDir(__NAMESPACE__),"nosotros", [
																"title" => 'Nosotros',
																 "head" => $head,
																 "header" => $header,
																 "footer"=>$footer
																]);
	}

	
	public function action404(){
		$head = SiteController::head();
		Response::render($this->viewDir(__NAMESPACE__),"404", [
																"title" => $this->title.' 404',
																"head" => $head,
															   ]);
	}

	private function actionHola(){
		echo 'hola';
	}
}