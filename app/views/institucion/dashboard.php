<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-popup {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            font-size: 1rem;
            padding: 5px;
            text-align: left;
        }

        .btn-popup:hover {
            text-decoration: underline;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: var(--border-radius);
            max-width: 500px;
            width: 90%;
        }

        .modal-close {
            margin-top: 20px;
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
        }

        .modal-close:hover {
            background-color: var(--primary-dark);
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
        PANEL DE GESTIÓN INSTITUCIONAL - <?= htmlspecialchars($institucion->nombre) ?>
    </div>

    <div class="main">
        <div class="sidebar">
            <div class="profile-section">
                <div class="profile-info">
                    <div class="profile-name"><?= htmlspecialchars($institucion->nombre) ?></div>
                    <div class="profile-role">Institución <?= htmlspecialchars(ucfirst($institucion->tipo)) ?></div>
                </div>
            </div>

            <div class="nav-menu">
                <button class="nav-btn" onclick="cambiarVista('inicio')">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
                <button class="nav-btn" onclick="cambiarVista('familias')">
                    <i class="fas fa-users"></i> Familias
                </button>
                <button class="nav-btn" onclick="cambiarVista('asistentes')">
                    <i class="fas fa-user-nurse"></i> Asistentes
                </button>
                <button class="nav-btn" onclick="cambiarVista('pacientes')">
                    <i class="fas fa-user-injured"></i> Pacientes
                </button>
                <button class="nav-btn" onclick="cambiarVista('solicitudes')">
                    <i class="fas fa-plus-circle"></i> Solicitudes
                </button>
            </div>

            <a href="../institucion/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>

        <div class="content" id="contenido">
            <div class="content-header">
                <h2>Bienvenido al Panel Institucional</h2>
                <p>Seleccione una opción del menú para comenzar</p>
            </div>

            <div class="card">
                <h3>Resumen Institucional</h3>
                <p>Desde aquí podrás gestionar todas las actividades relacionadas con tu institución.</p>
            </div>
        </div>
    </div>

    <script>
        // Datos de la aplicación
        const appData = {
            familias: <?= json_encode($familias ?: []) ?>,
            asistentes: <?= json_encode($asistentes ?: []) ?>,
            pacientes: <?= json_encode($pacientes ?: []) ?>,
            institucion: <?= json_encode($institucion) ?>
        };

        // Agrupar familias por tutor
        const familiasAgrupadas = appData.familias.reduce((acc, item) => {
            const tutorKey = `${item.nombre_tutor} ${item.apellido_tutor}`.trim();
            if (!acc[tutorKey]) {
                acc[tutorKey] = {
                    nombre_tutor: item.nombre_tutor,
                    apellido_tutor: item.apellido_tutor,
                    pacientes: []
                };
            }
            acc[tutorKey].pacientes.push({
                nombre_paciente: item.nombre_paciente,
                condicion: item.condicion
            });
            return acc;
        }, {});

        function cambiarVista(vista) {
            const contenido = document.getElementById("contenido");

            switch (vista) {

                case 'inicio':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Bienvenido al Panel Institucional</h2>
                            <p>Seleccione una opción del menú para comenzar</p>
                        </div>
                        <div class="card">
                            <h3>Resumen Institucional</h3>
                            <p>Desde aquí podrás gestionar todas las actividades relacionadas con tu institución.</p>
                        </div>
                    `;
                    break;

                case 'familias':
                    if (!appData.familias.length) {
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2>Familias Registradas</h2>
                                <p>No hay familias registradas en esta institución</p>
                            </div>
                            <div class="card">
                                <p>Actualmente no hay familias asociadas a esta institución.</p>
                            </div>`;
                        return;
                    }

                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Familias Registradas</h2>
                            <p>Listado de familias asociadas a la institución</p>
                        </div>
                        <div class="card">
                            <table>
                                <thead>
                                    <tr><th>Familias por tutor</th></tr>
                                </thead>
                                <tbody>
                                    ${Object.values(familiasAgrupadas).map(familia => {
                        const pacientesTexto = familia.pacientes.map(p =>
                            `• ${p.nombre_paciente} (${p.condicion})`
                        ).join('\n');
                        const pacientesInfo = pacientesTexto.replace(/"/g, '&quot;');
                        const nombreCompleto = `${familia.nombre_tutor} ${familia.apellido_tutor}`.trim();

                        return `
                                            <tr>
                                                <td>
                                                    <button class="btn-popup" 
                                                        data-info="${pacientesInfo}" 
                                                        data-nombre="${nombreCompleto}">
                                                        ${nombreCompleto || 'N/A'}
                                                    </button>
                                                </td>
                                            </tr>`;
                    }).join('')}
                                </tbody>
                            </table>
                        </div>

                        <div id="modal" class="modal">
                            <div class="modal-content">
                                <h3 id="modal-titulo"></h3>
                                <pre id="modal-contenido" style="white-space: pre-wrap;"></pre>
                                <button id="modal-cerrar" class="modal-close">Cerrar</button>
                            </div>
                        </div>
                    `;
                    break;

                case 'asistentes':
                    if (!appData.asistentes.length) {
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2>Asistentes Terapéuticos</h2>
                                <p>No hay asistentes disponibles</p>
                            </div>
                            <div class="card">
                                <p>Actualmente no hay asistentes terapéuticos asociados a esta institución.</p>
                            </div>`;
                        return;
                    }

                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Asistentes Terapéuticos</h2>
                            <p>Listado de asistentes disponibles</p>
                        </div>
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>DNI</th>
                                        <th>Paciente a cargo</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    ${appData.asistentes.map(asistente => `
                                        <tr>
                                            <td>${asistente.acompanante_nombre || 'N/A'} ${asistente.acompanante_apellido || 'N/A'}</td></td>
                                            
                                            <td>${asistente.acompanante_dni || 'Sin documento'}</td>

                                            <td>${asistente.paciente_nombre || 'Sin nombre'} ${asistente.paciente_apellido || 'Sin nombre'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                    break;

                case 'pacientes':
                    if (!appData.pacientes.length) {
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2>Pacientes</h2>
                                <p>No hay pacientes registrados</p>
                            </div>
                            <div class="card">
                                <p>Actualmente no hay pacientes asociados a esta institución.</p>
                            </div>`;
                        return;
                    }

                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Pacientes</h2>
                            <p>Listado completo de pacientes</p>
                        </div>
                        <div class="card">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nombre y apellido</th>
                                        <th>Edad</th>
                                        <th>Condición</th>
                                        <th>Tutor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${appData.pacientes.map(paciente => `
                                        <tr>
                                            <td>${paciente.nombre} ${paciente.apellido}</td>
                                            <td>${paciente.edad}</td>
                                            <td>${paciente.tipo_condicion}</td>
                                            <td>${paciente.nombre_tutor || 'No especificado'} ${paciente.apellido_tutor || 'No especificado'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                    break;

                case 'solicitudes':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Crear Solicitudes</h2>
                            <p>Formulario para solicitar acompañantes terapéuticos</p>
                        </div>
                        <div class="card">
                            <form id="form-solicitud" onsubmit="crearSolicitud(event)">
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px;">Paciente</label>
                                    <select name="paciente_id" required style="width: 100%; padding: 8px; border-radius: var(--border-radius); border: 1px solid #ddd;">
                                        <option value="">Seleccione un paciente</option>
                                        ${appData.pacientes.map(p => `
                                            <option value="${p.id}">${p.nombre} ${p.apellido}</option>
                                        `).join('')}
                                    </select>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px;">Motivo</label>
                                    <textarea name="motivo" required style="width: 100%; padding: 8px; border-radius: var(--border-radius); border: 1px solid #ddd; min-height: 100px;"></textarea>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; margin-bottom: 5px;">Fecha Requerida</label>
                                    <input type="date" name="fecha_requerida" required style="width: 100%; padding: 8px; border-radius: var(--border-radius); border: 1px solid #ddd;">
                                </div>
                                
                                <button type="submit" style="background-color: var(--primary-color); color: white; padding: 10px 15px; border: none; border-radius: var(--border-radius); cursor: pointer;">
                                    Enviar Solicitud
                                </button>
                            </form>
                        </div>
                    `;
                    break;

                default:
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Bienvenido al Panel Institucional</h2>
                            <p>Seleccione una opción del menú para comenzar</p>
                        </div>
                        <div class="card">
                            <h3>Resumen Institucional</h3>
                            <p>Desde aquí podrás gestionar todas las actividades relacionadas con tu institución.</p>
                        </div>
                    `;
                    break;
            }

            // Configurar modal si es necesario
            if (vista === 'familias') {
                document.querySelectorAll('.btn-popup').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const info = btn.getAttribute('data-info');
                        const nombre = btn.getAttribute('data-nombre');
                        document.getElementById('modal-titulo').innerText = `Chicos a cargo de${nombre}`;
                        document.getElementById('modal-contenido').innerText = info;
                        document.getElementById('modal').style.display = 'flex';
                    });
                });

                document.getElementById('modal-cerrar').addEventListener('click', () => {
                    document.getElementById('modal').style.display = 'none';
                });
            }
        }

        function crearSolicitud(event) {
            event.preventDefault();
            alert('Solicitud creada con éxito (simulación)');
            // Aquí iría la lógica real para enviar la solicitud
        }
    </script>

    <?= $footer ?>
</body>

</html>