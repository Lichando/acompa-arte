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

     

        // Obtener datos para el dashboard
        $familias = InstitucionModel::getFamiliasConAsistentes($institucionId);
        $asistentes = PacienteModel::getPacientesConAcompanantes($institucionId);
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

    public function actionActualizarDatos()
    {
        if (!SessionController::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['redirect' => '../cuentas/login']);
                return;
            }
            return Response::redirect("../cuentas/login");
        }
        
        $institucionId = SessionController::getInstitucionID();
        $institucion = InstitucionModel::findById($institucionId);

        if (!$institucion) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['redirect' => '../error/no-institucion']);
                return;
            }
            return Response::redirect("../error/no-institucion");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            // Validación básica
            if (empty($nombre) || empty($direccion) || empty($telefono)) {
                echo json_encode(['error' => 'Todos los campos son obligatorios']);
                return;
            }

            $resultado = InstitucionModel::update($institucionId, [
                'nombre' => $nombre,
                'direccion' => $direccion,
                'telefono' => $telefono,
            ]);

            if ($resultado === true) {
                echo json_encode(['redirect' => '../institucion/dashboard']);
            } else {
                echo json_encode(['error' => $resultado]);
            }
            return;
        }

        // Si no es POST, redirigimos
        return Response::redirect("../inicio");
    }



    public function actionDarBaja()
    {
        if (!SessionController::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['redirect' => '../cuentas/login']);
                return;
            }
            return Response::redirect("../cuentas/login");
        }

        $usuario_id = $_SESSION['usuario_id'];
        $institucionId = SessionController::getInstitucionID();
        $institucion = InstitucionModel::findById($institucionId);

       
        if (!$institucion) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['redirect' => '../error/no-institucion']);
                return;
            }
            return Response::redirect("../error/no-institucion");
        }

        $resultado = InstitucionModel::darBaja($usuario_id,$institucionId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($resultado === true) {
                echo json_encode(['redirect' => '../cuentas/logout']);
            } else {
                echo json_encode(['error' => $resultado]);
            }
            return;
        }

        if ($resultado === true) {
            return Response::redirect("../cuentas/logout");
        } else {
            return Response::render(
                $this->viewDir(__NAMESPACE__),
                "dashboard",
                [
                    "title" => "Error al dar de baja",
                    "errors" => [$resultado],
                    "head" => SiteController::head(),
                    "header" => SiteController::header(),
                    "footer" => SiteController::footer()
                ]
            );
        }
    }



    public function actionLogout()
    {
        SessionController::logout();
        return Response::redirect("../cuentas/login");
    }


}