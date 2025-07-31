<?php
namespace app\controllers;

use Controller;
use Response;
use app\controllers\SessionController;
use app\controllers\SiteController;

class UsuarioController extends Controller
{
    public function actionDashboard()
    {
        // Validación de sesión
        if (!SessionController::isLoggedIn()) {
            return Response::redirect("../cuentas/login");  // Ruta absoluta
        }

        // Solo permitir acceso si el rol es USER
        if (SessionController::getRoleId() !== SessionController::ROLE_USER) {
            (new CuentasController())->redirectByRole(); // redirige según el rol automáticamente
        }

        // Si está logueado, carga la vista
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "dashboard",
            [
                "title" => 'Panel Usuario',
                "head" => $head,
                "header" => $header,
                "footer" => $footer
            ]
        );
    }
    public function actionLogout()
    {
        SessionController::logout();  // Limpia toda la sesión
        
        // Redirección absoluta al login
        return Response::redirect("../cuentas/login");
    }
}