<?php
namespace app\controllers;

use Controller;
use Response;
use app\controllers\SessionController;
use app\controllers\SiteController;
use app\models\InstitucionModel;
use app\models\AcompananteModel;
use app\models\PacienteModel;
//use app\models\SolicitudModel;
//use app\models\AsignaturaModel;

class InstitucionController extends Controller
{
    public function actionDashboard()
    {
        // Verificar autenticación
        if (!SessionController::isLoggedIn()) {
            return Response::redirect("../cuentas/login");
        }

        // Redirigir según el rol si no es institución
        if (SessionController::getRoleId() !== SessionController::ROLE_INSTITUCION) {
            (new CuentasController())->redirectByRole();
            return;
        }

        // Obtener ID de la institución desde la sesión
        $institucionId = SessionController::getInstitucionID();

        if (!$institucionId) {
            return Response::redirect("../error/no-institucion");
        }

        // Obtener datos de la institución
        $institucion = InstitucionModel::findById($institucionId);
        if (!$institucion) {
            return Response::redirect("../error/no-institucion");
        }

        // Procesar solicitudes POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['crear_solicitud'])) {
                $data = [
                    'paciente_id' => $_POST['paciente_id'],
                    'institucion_id' => $institucionId,
                    'motivo' => $_POST['motivo'],
                    'fecha_requerida' => $_POST['fecha_requerida'],
                    'estado' => 'pendiente'
                ];

                if (SolicitudModel::create($data)) {
                    return Response::redirect('../institucion/dashboard');
                }
            }

            if (isset($_POST['desvincular'])) {
                AsignaturaModel::desvincularAsistente($_POST['asignacion_id']);
                return Response::redirect('/institucion/dashboard');
            }
        }

        // Obtener datos para el dashboard
        $familias = InstitucionModel::getFamiliasConAsistentes($institucionId);
        $asistentes = PacienteModel::getPacientesPorInstitucion($institucionId);
        $pacientes = PacienteModel::getPacientesPorInstitucion(institucionId: $institucionId);

        // Renderizar vista
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "dashboard",
            [
                "title" => 'Panel Institucional',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "institucion" => $institucion,
                "familias" => $familias,
                "asistentes" => $asistentes,
                "pacientes" => $pacientes
            ]
        );
    }

    public function actionLogout()
    {
        SessionController::logout();
        return Response::redirect("../cuentas/login");
    }


}