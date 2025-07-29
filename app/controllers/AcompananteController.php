<?php
namespace app\controllers;

use app\models\AcompananteModel;
use Controller;
use Response;
use app\controllers\SessionController;
use app\controllers\SiteController;

class AcompananteController extends Controller
{
    public function actionDashboard()
    {
        // Verificar autenticación
        if (!SessionController::isLoggedIn()) {
            return Response::redirect("../cuentas/login");
        }

        // Redirigir según el rol si no es acompañante
        if (SessionController::getRoleId() !== SessionController::ROLE_ACOMPANANTE) {
            (new CuentasController())->redirectByRole();
            return;
        }

        // Obtener información del acompañante
        $usuario_id = $_SESSION['usuario_id'];
        $acompanante = AcompananteModel::findByUsuarioId($usuario_id);

        if (!$acompanante) {
            return Response::redirect("../error/no-acompanante");
        }

        // Obtener pacientes asignados
        $mispacientes = AcompananteModel::getFamilias($acompanante->id);
        $mensaje = empty($mispacientes) ? "No hay pacientes asignados." : "";

        // Renderizar vista
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "dashboard",
            [
                "title" => 'Panel Acompañante',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "acompanante" => $acompanante,
                "mispacientes" => $mispacientes,
                "mensaje" => $mensaje
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