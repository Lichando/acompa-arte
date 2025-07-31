<?php
namespace app\controllers;

use Controller;
use Response;
use app\controllers\SessionController;
use app\controllers\SiteController;
use app\models\PacienteModel;
use app\models\HistorialModel;
use app\models\SeguimientoModel;

class PacienteController extends Controller
{
    public function actionDashboard()
    {
        if (!SessionController::isLoggedIn()) {
            return Response::redirect("../cuentas/login");
        }
        // Solo permitir acceso si el rol es PACIENTE
        if (SessionController::getRoleId() !== SessionController::ROLE_PACIENTE) {
            (new CuentasController())->redirectByRole(); // redirige según el rol automáticamente
        }

        $usuario_id = $_SESSION['usuario_id'];

        // método para obtener datos del paciente
        $paciente = PacienteModel::findByUserId($usuario_id);


        $asistenteporcon = PacienteModel::getAcompanantesPorCondicion($paciente->tipo_condicion);

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "dashboard",
            [
                "title" => 'Panel Paciente',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "paciente" => $paciente,
                "asistenteporcon" => $asistenteporcon,
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