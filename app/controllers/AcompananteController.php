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

    public function actionActualizarDatos()
    {
        if (!SessionController::isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['redirect' => '../cuentas/login']);
                return;
            }
            return Response::redirect("../cuentas/login");
        }

        $usuario_id = $_SESSION['usuario_id'];
        $acompanante = AcompananteModel::findByUsuarioId($usuario_id);

        if (!$acompanante) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['redirect' => '../error/no-acompanante']);
                return;
            }
            return Response::redirect("../error/no-acompanante");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $dni = trim($_POST['dni'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            // Validación básica
            if (empty($nombre) || empty($apellido) || empty($dni) || empty($telefono)) {
                echo json_encode(['error' => 'Todos los campos son obligatorios']);
                return;
            }

            $resultado = AcompananteModel::update($usuario_id, [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'dni' => $dni,
                'telefono' => $telefono,
            ]);

            if ($resultado === true) {
                echo json_encode(['redirect' => '../acompanante/dashboard']);
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
        $acompanante = AcompananteModel::findByUsuarioId($usuario_id);
        if (!$acompanante) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo json_encode(['error' => 'No sos un acompañante válido.']);
                return;
            }
            return Response::redirect("../error/no-acompanante");
        }

        $resultado = AcompananteModel::darBaja($usuario_id);

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
        SessionController::logout();  // Limpia toda la sesión

        // Redirección absoluta al login
        return Response::redirect("../cuentas/login");
    }
}