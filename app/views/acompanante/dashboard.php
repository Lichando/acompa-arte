<!DOCTYPE html>

<html lang="es">


<head>
    <title><?= htmlspecialchars($title) ?></title>
    <?= $head ?>

    <style>
        :root {
            --primary-color: #4A90E2;
            --primary-dark: #357ABD;
            --secondary-color: #6c757d;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        .nav-bar {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 15px;
            font-weight: bold;
            font-size: 1.1rem;
            letter-spacing: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .main {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            background-color: white;
            padding: 20px 15px;
            width: 250px;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
            width: 100%;
        }

        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-bottom: 15px;
            box-shadow: var(--box-shadow);
        }

        .profile-info {
            text-align: center;
        }

        .profile-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-role {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .nav-menu {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-btn {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: var(--border-radius);
            background-color: var(--primary-color);
            color: white;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: left;
        }

        .nav-btn:hover {
            background-color: var(--primary-dark);
            transform: translateX(5px);
        }

        .nav-btn i {
            width: 20px;
            text-align: center;
        }

        .logout-btn {
            margin-top: auto;
            width: 100%;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            background-color: var(--danger-color);
            color: white;
            text-decoration: none;
            text-align: center;
            font-size: 0.95rem;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .content {
            flex: 1;
            background-color: white;
            margin: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            overflow-y: auto;
        }

        .content-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .content-header h2 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
                padding: 15px 10px;
            }
        }

        @media (max-width: 768px) {
            .main {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }

            .profile-section {
                flex: 1 0 100%;
                margin-bottom: 15px;
            }

            .nav-btn {
                flex: 1;
                min-width: 150px;
                padding: 10px;
                font-size: 0.85rem;
            }

            .logout-btn {
                margin-top: 0;
                flex: 1;
                min-width: 150px;
                padding: 10px;
                font-size: 0.85rem;
            }

            .content {
                margin: 15px;
                padding: 20px;
            }
        }

        @media (max-width: 576px) {

            .nav-btn,
            .logout-btn {
                min-width: 120px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <?= $header ?>

    <div class="nav-bar">
        PANEL ASISTENCIAL TERAPÉUTICO
    </div>

    <div class="main">
        <div class="sidebar">
            <div class="profile-section">
                <div class="profile-info">
                    <div class="profile-name"><?php echo $acompanante->nombre . ' ' . $acompanante->apellido; ?></div>

                    <div class="profile-role">Acompañante Terapéutico</div>
                </div>
            </div>

            <div class="nav-menu">
                <button class="nav-btn" onclick="cambiarVista('inicio')">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
                <button class="nav-btn" onclick="cambiarVista('mis-datos')">
                    <i class="fas fa-id-card"></i> Mis Datos
                </button>
                <button class="nav-btn" onclick="cambiarVista('mis-pacientes')">
                    <i class="fas fa-search"></i> Mis pacientes
                </button>
                <button class="nav-btn" onclick="cambiarVista('historial')">
                    <i class="fas fa-notes-medical"></i> Historial
                </button>
                <button class="nav-btn" onclick="cambiarVista('seguimiento')">
                    <i class="fas fa-user-injured"></i> Pacientes
                </button>
            </div>

            <a href="logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>

        <div class="content" id="contenido">
            <div class="content-header">
                <h2>Bienvenido al Panel Asistencial</h2>
                <p>Seleccione una opción del menú para comenzar</p>

            </div>

            <div class="card">
                <h3>Resumen de Actividad</h3>
                <p>Aquí podrás ver un resumen de tus actividades recientes cuando selecciones una sección.</p>
            </div>
        </div>
    </div>

    <script>
        console.log($mispacientes)
    </script>


    <script>
        // Datos simulados (en un caso real vendrían de una API)

        const acompanante = <?= json_encode($acompanante) ?>;
        const misPacientes = <?= json_encode(is_array($mispacientes) ? $mispacientes : []) ?>;








        function cambiarVista(vista) {
            let contenido = document.getElementById("contenido");

            switch (vista) {
                case 'inicio':
                    contenido.innerHTML = `
                    <div class="content-header">
                        <h2>Bienvenido al Panel Asistencial</h2>
                        <p>Seleccione una opción del menú para comenzar</p>
                    </div>
                    
                `;
                    break;
                case 'mis-datos':
                    contenido.innerHTML = `
        <div class="content-header">
            <h2>Mis Datos Personales</h2>
            <p>Información de tu perfil profesional</p>
        </div>
        <div class="card" id="datosVista">
            <h3>Información Básica</h3>
            <p><strong>Acompañante:</strong> ${acompanante.nombre} ${acompanante.apellido}</p>
            <p><strong>DNI:</strong> ${acompanante.dni}</p>
            <p><strong>Teléfono:</strong> ${acompanante.telefono}</p>

            <div style="margin-top: 20px;">
                <button id="btnEditar" class="btn btn-primary">Editar Datos</button>
                <button id="btnBaja" class="btn btn-danger" style="margin-left: 10px;">Darse de Baja</button>
            </div>
        </div>`;

                    // Acción del botón "Editar Datos"
                    document.getElementById('btnEditar').addEventListener('click', () => {
                        const datosVista = document.getElementById('datosVista');
                        datosVista.innerHTML = `
            <h3>Editar Información</h3>
            <form id="formEditar" action="guardar-datos" method="POST">
                <label>Nombre:<br>
                    <input type="text" name="nombre" value="${acompanante.nombre}" required>
                </label><br><br>
                <label>Apellido:<br>
                    <input type="text" name="apellido" value="${acompanante.apellido}" required>
                </label><br><br>
                <label>DNI:<br>
                    <input type="text" name="dni" value="${acompanante.dni}" required>
                </label><br><br>
                <label>Teléfono:<br>
                    <input type="text" name="telefono" value="${acompanante.telefono}" required>
                </label><br><br>

                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" id="cancelarEdicion" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</button>
            </form>
        `;

                        // Envío del formulario y recarga de página
                        document.getElementById('formEditar').addEventListener('submit', function (e) {
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch('guardar-datos', {
                                method: 'POST',
                                body: formData
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.reload(); // Recarga si fue exitoso
                                    } else {
                                        alert("Error al guardar los datos.");
                                    }
                                })
                                .catch(() => alert("Ocurrió un error al intentar guardar."));
                        });

                        // Cancelar edición y recargar la vista original
                        document.getElementById('cancelarEdicion').addEventListener('click', () => {
                            window.dispatchEvent(new Event("hashchange"));
                        });
                    });

                    // Acción del botón "Darse de Baja"
                    document.getElementById('btnBaja').addEventListener('click', () => {
                        if (confirm("¿Estás seguro que querés darte de baja?")) {
                            window.location.href = "darse-baja";
                        }
                    });

                    break;

                case 'mis-pacientes':
                    let listaPacientesHTML = '';

                    if (misPacientes.length === 0) {
                        listaPacientesHTML = '<p>No tenés pacientes asignados.</p>';
                    } else {
                        listaPacientesHTML = '<ul style="list-style:none; padding:0;">';
                        misPacientes.forEach(paciente => {
                            listaPacientesHTML += `
                <li style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                    <strong>${paciente.nombre_paciente} ${paciente.apellido_paciente}</strong><br>
                    Tutor: ${paciente.nombre_tutor} ${paciente.apellido_tutor}<br>
                    Condición: ${paciente.condicion}
                </li>
            `;
                        });
                        listaPacientesHTML += '</ul>';
                    }

                    contenido.innerHTML = `
                    <div class="content-header">
                        <h2>Mis Pacientes</h2>
                        <p>Lista de tus pacientes asignados</p>
                    </div>
                    <div class="card">
                        <h3>Pacientes</h3>
                        ${listaPacientesHTML}
                    </div>

                `;
                    break;

               /* case 'historial':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Historial de Asistencialismo</h2>
                            <p>Registro de tus intervenciones anteriores</p>
                        </div>
                        <div class="card">
                            <h3>Últimas intervenciones</h3>
                            <p>Aquí se mostraría un listado de tus intervenciones pasadas con detalles como fecha, paciente, diagnóstico, etc.</p>
                        </div>`;
                    break;

                case 'seguimiento':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Seguimiento de Pacientes</h2>
                            <p>Gestiona tus pacientes actuales</p>
                        </div>
                        <div class="card">
                            <h3>Pacientes Activos</h3>
                            <p>Listado de pacientes con los que estás trabajando actualmente, incluyendo información de contacto, diagnóstico y próximas citas.</p>
                        </div>`;
                    break;*/

                default:
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Bienvenido al Panel Asistencial</h2>
                            <p>Seleccione una opción del menú para comenzar</p>
                        </div>
                        `;
            }
        }
    </script>
</body>

</html>