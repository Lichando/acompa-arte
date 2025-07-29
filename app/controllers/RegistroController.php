<?php
namespace app\controllers;

use Controller;
use Response;
use app\controllers\SiteController;
use app\models\InstitucionModel;
use app\models\AcompananteModel;
use app\models\PacienteModel;
use app\models\ObraSocialModel;

class RegistroController extends Controller
{
    public function actionInstitucion()
    {
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $errors = [];
        $oldInput = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Recoger y limpiar datos del formulario
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'ciudad' => trim($_POST['ciudad'] ?? ''),
                'provincia' => trim($_POST['provincia'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'tipo' => strtolower(trim($_POST['tipo'] ?? '')),
                'sector' => strtolower(trim($_POST['sector'] ?? '')),
                'activa' => 1,
                'usuario_id' => $_SESSION['usuario_id'],
                'rol' => 4
            ];

            $oldInput = $data;

            // Validaciones
            if (empty($data['nombre']) || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s0-9\-]{2,100}$/', $data['nombre'])) {
                $errors[] = "Nombre inválido (2-100 caracteres, solo letras, números, espacios y guiones)";
            }

            if (empty($data['direccion']) || strlen($data['direccion']) < 5 || strlen($data['direccion']) > 200) {
                $errors[] = "Dirección inválida (5-200 caracteres)";
            }

            if (empty($data['ciudad']) || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/', $data['ciudad'])) {
                $errors[] = "Ciudad inválida (solo letras, 2-50 caracteres)";
            }

            if (empty($data['provincia']) || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/', $data['provincia'])) {
                $errors[] = "Provincia inválida (solo letras, 2-50 caracteres)";
            }

            if (empty($data['telefono']) || !preg_match('/^[\d\s\-\(\)]{6,20}$/', $data['telefono'])) {
                $errors[] = "Teléfono inválido (6-20 dígitos, puede incluir espacios, guiones y paréntesis)";
            }

            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email inválido";
            }

            if (empty($data['tipo']) || !in_array($data['tipo'], ['educativa', 'sanitaria'])) {
                $errors[] = "Tipo inválido (debe ser 'educativa' o 'sanitaria')";
            }

            if (empty($data['sector']) || !in_array($data['sector'], ['publica', 'privada'])) {
                $errors[] = "Sector inválido (debe ser 'publica' o 'privada')";
            }

            if (empty($errors)) {
                $resultado = InstitucionModel::create($data);

                if ($resultado === true) {
                    header("Location: ../institucion/dashboard");
                    exit;
                } else {
                    $errors[] = $resultado;
                }
            }
        }

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "institucion",
            [
                "title" => 'Registro de Institución',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "errors" => $errors,
                "oldInput" => $oldInput
            ]
        );
    }




    public function actionAcompanante()
    {
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $errors = [];
        $oldInput = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Recoger y limpiar datos del formulario
            $data = [
                'usuario_id' => $_SESSION['usuario_id'] ?? null,
                'dni' => trim($_POST['dni'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'tipo_condicion' => trim($_POST['tipo_condicion'] ?? ''),
                'rol' => 3 // Asumiendo que 4 es el rol para acompañantes
            ];

            $oldInput = $data;

            // Validaciones
            if (empty($data['usuario_id'])) {
                $errors[] = "Error de sesión, por favor inicie sesión nuevamente";
            }

            if (empty($data['dni']) || !preg_match('/^\d{7,8}$/', $data['dni'])) {
                $errors[] = "DNI inválido (7 u 8 dígitos)";
            }

            if (empty($data['telefono']) || !preg_match('/^[\d\s\-\(\)]{6,20}$/', $data['telefono'])) {
                $errors[] = "Teléfono inválido (6-20 dígitos, puede incluir espacios, guiones y paréntesis)";
            }
            if (empty($data['tipo_condicion'])) {
                $errors[] = "Tipo de condición inválido";
            }

            if (empty($errors)) {
                try {
                    $resultado = AcompananteModel::create($data);

                    if ($resultado === true) {
                        header("Location: ../acompanante/dashboard");
                        exit;
                    } else {
                        $errors[] = $resultado ?? "Error al registrar acompañante";
                    }
                } catch (\Exception $e) {
                    $errors[] = "Error en el sistema: " . $e->getMessage();
                }
            }
        }

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "acompanante",
            [
                "title" => 'Registro de Acompañante Terapéutico',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "errors" => $errors,
                "oldInput" => $oldInput
            ]
        );
    }

    public function actionPaciente()
    {
        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $errors = [];
        $oldInput = [];

        // Obtener datos para los selects
        $instituciones = InstitucionModel::obtenerInstituciones();
        $obrasSociales = ObraSocialModel::getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'dni' => trim($_POST['dni'] ?? ''),
                'fecha_de_nacimiento' => trim($_POST['fecha_de_nacimiento'] ?? ''),
                'edad' => trim($_POST['edad'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'institucion_id' => trim($_POST['institucion_id'] ?? ''),
                'tiene_obra_social' => isset($_POST['tiene_obra_social']) ? 1 : 0,
                'obra_social_id' => trim($_POST['obra_social_id'] ?? ''),
                'tipo_condicion' => trim($_POST['tipo_condicion'] ?? ''),
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'numero_cud' => trim($_POST['numero_cud'] ?? ''),
                'fecha_registro' => date('Y-m-d H:i:s'),
                'usuario_id' => $_SESSION['usuario_id'], // Obtenido de la sesión
                'rol' => 2
            ];

            $oldInput = $data;

            // Validaciones
            if (empty($data['nombre']) || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/', $data['nombre'])) {
                $errors[] = "Nombre inválido (solo letras, 2-50 caracteres)";
            }

            if (empty($data['apellido']) || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/', $data['apellido'])) {
                $errors[] = "Apellido inválido (solo letras, 2-50 caracteres)";
            }

            if (empty($data['dni']) || !preg_match('/^\d{7,8}$/', $data['dni'])) {
                $errors[] = "DNI inválido (7 u 8 dígitos)";
            }

            if (empty($data['fecha_de_nacimiento']) || !strtotime($data['fecha_de_nacimiento'])) {
                $errors[] = "Fecha de nacimiento inválida";
            }

            if (!is_numeric($data['edad']) || $data['edad'] < 0 || $data['edad'] > 120) {
                $errors[] = "Edad inválida (0-120 años)";
            }

            if (empty($data['direccion'])) {
                $errors[] = "Dirección requerida";
            }

            if (empty($data['institucion_id']) || !is_numeric($data['institucion_id'])) {
                $errors[] = "Institución requerida";
            }

            if ($data['tiene_obra_social'] && empty($data['obra_social_id'])) {
                $errors[] = "Debe seleccionar una obra social";
            }

            if (empty($data['tipo_condicion'])) {
                $errors[] = "Tipo de condición inválido";
            }

            if (empty($data['descripcion'])) {
                $errors[] = "Descripción requerida";
            }

            if (!empty($data['numero_cud']) && !preg_match('/^\d{6,10}$/', $data['numero_cud'])) {
                $errors[] = "Número CUD inválido (6-10 dígitos)";
            }

            if (empty($errors)) {
                $resultado = PacienteModel::create($data);

                if ($resultado === true) {
                    header("Location: ../paciente/dashboard");
                    exit;
                } else {
                    // $resultado tiene mensaje de error, lo guardamos para mostrar
                    $errors[] = $resultado;
                }
            }
        }

        return Response::render(
            $this->viewDir(__NAMESPACE__),
            "paciente",
            [
                "title" => 'Registro de Paciente',
                "head" => $head,
                "header" => $header,
                "footer" => $footer,
                "errors" => $errors,
                "oldInput" => $oldInput,
                "instituciones" => $instituciones,
                "obrasSociales" => $obrasSociales
            ]
        );
    }


}
