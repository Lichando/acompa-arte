<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4A90E2;
            --primary-dark: #357ABD;
            --secondary: #6c757d;
            --light: #f8f9fa;
            --dark: #343a40;
            --border: #dee2e6;
        }
        
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .welcome-header {
            background-color: var(--primary);
            color: white;
            text-align: center;
            padding: 30px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-title {
            font-size: 28px;
            margin: 0;
            font-weight: 600;
        }

        .welcome-subtitle {
            font-size: 16px;
            margin: 10px 0 0;
            opacity: 0.9;
        }

        .registration-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            max-width: 1000px;
            margin: 0 auto;
            flex: 1;
        }

        .registration-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            width: 100%;
            margin-top: 30px;
        }

        .registration-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .registration-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .card-icon {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 22px;
            color: var(--dark);
            margin: 0 0 15px;
            font-weight: 600;
        }

        .card-description {
            color: var(--secondary);
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .btn-register {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: auto;
        }

        .btn-register:hover {
            background-color: var(--primary-dark);
        }

        .welcome-footer {
            text-align: center;
            padding: 20px;
            color: var(--secondary);
            font-size: 14px;
            border-top: 1px solid var(--border);
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .registration-options {
                grid-template-columns: 1fr;
            }
            
            .welcome-title {
                font-size: 24px;
            }
            
            .registration-container {
                padding: 30px 15px;
            }
        }
    </style>
</head>

<body>
    <?= $header ?>

    <div class="welcome-header">
        <h1 class="welcome-title">¡Bienvenido a nuestro sistema!</h1>
        <p class="welcome-subtitle">Selecciona el tipo de registro que deseas completar</p>
    </div>

    <div class="registration-container">
        <div class="registration-options">
            <!-- Opción 1: Institución -->
            <div class="registration-card">
                <div class="card-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h3 class="card-title">Institución</h3>
                <p class="card-description">
                    Regístrate como institución médica o terapéutica para gestionar profesionales, 
                    pacientes y acompañantes en nuestro sistema.
                </p>
                <a href="../registro/institucion" class="btn-register">Registrar Institución</a>
            </div>

            <!-- Opción 2: Acompañante Terapéutico -->
            <div class="registration-card">
                <div class="card-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3 class="card-title">Acompañante Terapéutico</h3>
                <p class="card-description">
                    Regístrate como profesional para ofrecer tus servicios de acompañamiento 
                    terapéutico a pacientes e instituciones.
                </p>
                <a href="../registro/acompanante" class="btn-register">Registrar Acompañante</a>
            </div>

            <!-- Opción 3: Familiar/Tutor -->
            <div class="registration-card">
                <div class="card-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h3 class="card-title">Familiar o Tutor</h3>
                <p class="card-description">
                    Regístrate como familiar o tutor de un paciente para gestionar sus acompañantes 
                    terapéuticos y tratamiento.
                </p>
                <a href="../registro/paciente" class="btn-register">Registrar Familiar</a>
            </div>
        </div>
    </div>



    <?= $footer ?>
</body>

</html>