<?php
namespace app\controllers;

use app\models\AdminModel;
use Controller;
use Response;
use app\controllers\SessionController;
use app\controllers\SiteController;

class AdminController extends Controller
{
    public function actionDashboard()
    {
        // Validación de sesión y rol
        if (!SessionController::isLoggedIn()) {
            return Response::redirect("../cuentas/login");
        }

        // Verificar que el usuario sea administrador
        if (SessionController::getRoleId() !== SessionController::ROLE_ADMIN) {
            return Response::redirect("../error/unauthorized");
        }

        $countInstituciones = AdminModel::TotalInstituciones();
        $countPA = AdminModel::PacientesActivos();
        $countAA = AdminModel::AcompanantesActivos();
        $ListIns = AdminModel::ListaInstituciones();
        $ListInsRec = AdminModel::ListaInstitucionesRecientes();
        $ListPaRec = AdminModel::ListaPacientesRecientes();
        $ListPa = AdminModel::ListaPacientes();
        $ListAcom = AdminModel::ListaAcompanantes();


        // Obtener componentes de la vista
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
    

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "dashboard",
            [
                "title" => 'Panel de Administración',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "total_instituciones" => $countInstituciones,
                "institucionesRecientes"=>$ListInsRec,
                "pacientesRecientes"=>$ListPaRec,
                "total_pacientes_activos" => $countPA,
                "total_acompanantes_activos" => $countAA,
                "instituciones" => $ListIns,
                "pacientes" => $ListPa,
                "acompanantes" => $ListAcom,

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