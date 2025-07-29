<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <?= $head ?>
  
    <style>
        :root {
            --primary-color: #34495e;
            --primary-dark: #2c3e50;
            --secondary-color: #7f8c8d;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
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
            font-size: 1.2rem;
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
            width: 280px;
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
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
            margin-bottom: 15px;
            box-shadow: var(--box-shadow);
        }

        .profile-info {
            text-align: center;
        }

        .profile-name {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .profile-role {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .nav-menu {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
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
            background-color: #c0392b;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .stat-card h3 {
            margin: 10px 0;
            color: var(--primary-dark);
        }

        .stat-card p {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #219653;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .btn-warning:hover {
            background-color: #e67e22;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Modal de carga */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 500px;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar {
                width: 250px;
            }
        }

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
                min-width: 160px;
                padding: 10px;
                font-size: 0.85rem;
            }

            .logout-btn {
                margin-top: 0;
                flex: 1;
                min-width: 160px;
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
                min-width: 140px;
                font-size: 0.8rem;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?= $header ?>

    <div class="nav-bar">
        PANEL ADMINISTRATIVO - GESTIÓN INTEGRAL
    </div>

    <div class="main">
        <div class="sidebar">
            <div class="profile-section">
           <div class="profile-info">
                    <div class="profile-name">Administrador del Sistema</div>
                    <div class="profile-role">Rol: Super Administrador</div>
                </div>
            </div>

            <div class="nav-menu">
                <button class="nav-btn" onclick="cambiarVistaAdmin('ir-dashboard')">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </button>
                <button class="nav-btn" onclick="cambiarVistaAdmin('gestion-familias')">
                    <i class="fas fa-users"></i> Familias
                </button>
                <button class="nav-btn" onclick="cambiarVistaAdmin('gestion-instituciones')">
                    <i class="fas fa-school"></i> Instituciones
                </button>
                <button class="nav-btn" onclick="cambiarVistaAdmin('gestion-asistentes')">
                    <i class="fas fa-user-nurse"></i> Asistentes
                </button>
                <!--  <button class="nav-btn" onclick="cambiarVistaAdmin('gestion-solicitudes')">
                    <i class="fas fa-file-alt"></i> Solicitudes
                </button>
                <button class="nav-btn" onclick="cambiarVistaAdmin('reportes')">
                    <i class="fas fa-chart-bar"></i> Reportes
                </button>
                <button class="nav-btn" onclick="cambiarVistaAdmin('configuracion')">
                    <i class="fas fa-cog"></i> Configuración
                </button>-->
            </div>

            <a href="../cuentas/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>

        <div class="content" id="contenido">
            <div class="content-header">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <p>Resumen general del sistema</p>
            </div>

            <div class="card-grid">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?= number_format($total_pacientes_activos) ?></h3>
                    <p>Pacientes activos</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-nurse"></i>
                    <h3><?= number_format($total_acompanantes_activos) ?></h3>
                    <p>Asistentes activos</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-school"></i>
                    <h3><?= number_format($total_instituciones) ?></h3>
                    <p>Instituciones</p>
                </div>
            </div>

            <div class="card">
                <h3>Instituciones Recientes</h3>
                <?php if (!empty($institucionesRecientes)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($institucionesRecientes as $institucion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($institucion['nombre'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($institucion['direccion'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($institucion['telefono'] ?? '') ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">No hay instituciones registradas</div>
                <?php endif; ?>
            </div>


            <div class="card">
                <h3>Pacientes Recientes</h3>
                <?php if (!empty($pacientesRecientes)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre y apellido</th>
                                <th>Edad</th>
                                <th>Institución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientesRecientes as $paciente): ?>
                                <tr>
                                    <td><?= htmlspecialchars($paciente['nombre']) ?>
                                        <?= htmlspecialchars($paciente['apellido']) ?>
                                    </td>
                                    </td>

                                    <td><?= htmlspecialchars($paciente['edad']) ?></td>
                                    <td><?= htmlspecialchars($paciente['institucion_nombre']) ?></td>
                                    <td>
                                        <button class="btn btn-primary" style="padding: 5px 10px;">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay pacientes registrados</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de carga -->
    <div class="modal" id="modal-carga">
        <div class="modal-content">
            <div class="loader"></div>
            <p>Generando reporte, por favor espere...</p>
        </div>
    </div>

    <script>
        // Datos del backend
        const adminData = {
            total_instituciones: <?= $total_instituciones ?>,
            total_pacientes_activos: <?= $total_pacientes_activos ?>,
            total_acompanantes_activos: <?= $total_acompanantes_activos ?>,
            instituciones: <?= json_encode($instituciones) ?>,
            pacientes: <?= json_encode($pacientes) ?>,
            institucionesRecientes: <?= json_encode($institucionesRecientes) ?>,
            pacientesRecientes: <?= json_encode($pacientesRecientes) ?>,
            acompanantes: <?= json_encode($acompanantes) ?>
        };

        function cambiarVistaAdmin(vista) {
            const contenido = document.getElementById('contenido');
            const modal = document.getElementById('modal-carga');

            // Mostrar modal de carga
            modal.style.display = 'flex';

            // Simular carga de datos
            setTimeout(() => {
                modal.style.display = 'none';

                switch (vista) {
                    case 'ir-dashboard':
                        contenido.innerHTML = `
                        <div class="content-header">
                            <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                            <p>Resumen general del sistema</p>
                        </div>

                        <div class="card-grid">
                            <!-- Tarjetas de estadísticas -->
                            <div class="stat-card">
                                <i class="fas fa-users"></i>
                                <h3>${adminData.total_pacientes_activos || 0}</h3>
                                <p>Pacientes activos</p>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-user-nurse"></i>
                                <h3>${adminData.total_acompanantes_activos || 0}</h3>
                                <p>Asistentes activos</p>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-school"></i>
                                <h3>${adminData.total_instituciones || 0}</h3>
                                <p>Instituciones</p>
                            </div>
                        </div>

                        <div class="card">
                            <h3><i class="fas fa-school"></i> Instituciones Recientes</h3>
                            ${adminData.institucionesRecientes && adminData.institucionesRecientes.length > 0 ? `
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.institucionesRecientes.map(institucionesReci => `
                                                <tr>
                                                    <td>${institucionesReci.nombre || 'Sin nombre'}</td>
                                                    <td>${institucionesReci.direccion || 'No especificada'}</td>
                                                    <td>${institucionesReci.telefono || 'No disponible'}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" 
                                                                onclick="verInstitucion(${institucionesReci.id})">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            ` : '<div class="alert alert-info">No hay instituciones registradas</div>'}
                        </div>

                        <div class="card mt-4">
                            <h3><i class="fas fa-user-injured"></i> Pacientes Recientes</h3>
                            ${adminData.pacientesRecientes && adminData.pacientesRecientes.length > 0 ? `
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Edad</th>
                                                <th>Institución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.pacientesRecientes.map(pacientesReci => {
                            // Buscar el nombre de la institución
                            const institucion = adminData.instituciones.find(i => i.id === pacientesReci.institucion_id);
                            const nombreInstitucion = institucion ? institucion.nombre : 'Sin institución';

                            return `
                                                <tr>
                                                    <td>${pacientesReci.nombre || 'Sin nombre'} ${pacientesReci.apellido || 'Sin apellido'}</td>
                                                    <td>${pacientesReci.edad || '--'}</td>
                                                    <td>${nombreInstitucion}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" 
                                                                onclick="verPaciente(${pacientesReci.id})">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </button>
                                                    </td>
                                                </tr>
                                                `;
                        }).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            ` : '<div class="alert alert-info">No hay pacientes registrados</div>'}
                        </div>
                    `;
                        break;


                    case 'gestion-instituciones':
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2><i class="fas fa-school"></i> Gestión de Instituciones</h2>
                                <p>Administración de instituciones educativas y sanitarias</p>
                            </div>

                            <div class="card">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h3>Listado de Instituciones</h3>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Nueva Institución
                                    </button>
                                </div>

                                ${adminData.instituciones.length > 0 ? `
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.instituciones.map(institucion => `
                                                <tr>
                                                    <td>${institucion.nombre}</td>
                                                    <td>${institucion.direccion}</td>
                                                    <td>${institucion.telefono}</td>
                                                    <td>
                                                        <button class="btn btn-primary" style="padding: 5px 10px;">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning" style="padding: 5px 10px;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                ` : '<p>No hay instituciones registradas</p>'}
                            </div>
                        `;
                        break;

                    case 'gestion-familias':
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2><i class="fas fa-user-nurse"></i> Gestión de Pacientes</h2>
                                <p>Administración de Pacientes</p>
                            </div>

                            <div class="card">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h3>Listado de pacientes</h3>
                                    <div>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Nuevo paciente
                                        </button>
                                        <button class="btn btn-success">
                                            <i class="fas fa-file-export"></i> Exportar
                                        </button>
                                    </div>
                                </div>

                                ${adminData.pacientes.length > 0 ? `
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>DNI</th>
                                                <th>Condicion</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.pacientes.map(paciente => `
                                                <tr>
                                                    <td>${paciente.nombre} ${paciente.apellido}</td></td>
                                                    <td>${paciente.dni}</td>
                                                    <td>${paciente.tipo_condicion}</td>
                                                    
                                                    <td>
                                                        <button class="btn btn-primary" style="padding: 5px 10px;">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning" style="padding: 5px 10px;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger" style="padding: 5px 10px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                ` : '<p>No hay pacientes registrados</p>'}
                            </div>
                        `;
                        break;



                    case 'gestion-instituciones':
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2><i class="fas fa-school"></i> Gestión de Instituciones</h2>
                                <p>Administración de instituciones educativas y sanitarias</p>
                            </div>

                            <div class="card">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h3>Listado de Instituciones</h3>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Nueva Institución
                                    </button>
                                </div>

                                ${adminData.instituciones.length > 0 ? `
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.instituciones.map(institucion => `
                                                <tr>
                                                    <td>${institucion.nombre}</td>
                                                    <td>${institucion.direccion}</td>
                                                    <td>${institucion.telefono}</td>
                                                    <td>
                                                        <button class="btn btn-primary" style="padding: 5px 10px;">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning" style="padding: 5px 10px;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                ` : '<p>No hay instituciones registradas</p>'}
                            </div>
                        `;
                        break;

                    case 'gestion-asistentes':
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2><i class="fas fa-user-nurse"></i> Gestión de Asistentes</h2>
                                <p>Administración de acompañantes terapéuticos</p>
                            </div>

                            <div class="card">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <h3>Listado de Asistentes</h3>
                                    <div>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Nuevo Asistente
                                        </button>
                                        <button class="btn btn-success">
                                            <i class="fas fa-file-export"></i> Exportar
                                        </button>
                                    </div>
                                </div>

                                ${adminData.acompanantes.length > 0 ? `
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>DNI</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.acompanantes.map(asistente => `
                                                <tr>
                                                    <td>${asistente.usuario_nombre} ${asistente.usuario_apellido}</td>
                                                    <td>${asistente.dni}</td>
                                                    <td>
                                                        <button class="btn btn-primary" style="padding: 5px 10px;">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning" style="padding: 5px 10px;">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger" style="padding: 5px 10px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                ` : '<p>No hay asistentes registrados</p>'}
                            </div>
                        `;
                        break;

                    default:
                        contenido.innerHTML = `
                            <div class="content-header">
                                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                                <p>Resumen general del sistema</p>
                            </div>

                            <div class="card-grid">
                                <div class="stat-card">
                                    <i class="fas fa-users"></i>
                                    <h3>${adminData.total_pacientes_activos}</h3>
                                    <p>Pacientes activos</p>
                                </div>
                                <div class="stat-card">
                                    <i class="fas fa-user-nurse"></i>
                                    <h3>${adminData.total_acompanantes_activos}</h3>
                                    <p>Asistentes activos</p>
                                </div>
                                <div class="stat-card">
                                    <i class="fas fa-school"></i>
                                    <h3>${adminData.total_instituciones}</h3>
                                    <p>Instituciones</p>
                                </div>
                            </div>

                            <div class="card">
                                <h3>Instituciones Recientes</h3>
                                ${adminData.instituciones.length > 0 ? `
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${adminData.instituciones.map(instituciones => `
                                                <tr>
                                                    <td>${instituciones.nombre}</td>
                                                    <td>${instituciones.direccion}</td>
                                                    <td>${instituciones.telefono}</td>
                                                    <td>
                                                        <button class="btn btn-primary" style="padding: 5px 10px;">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                ` : '<p>No hay instituciones registradas</p>'}
                            </div>
                        `;
                }
            }, 500);
        }

        function generarReporte(tipo) {
            const modal = document.getElementById('modal-carga');
            modal.style.display = 'flex';

            setTimeout(() => {
                modal.style.display = 'none';
                alert(`Reporte de ${tipo} generado con éxito. Se ha descargado el archivo.`);
            }, 2000);
        }

        // Cerrar modal al hacer clic fuera del contenido
        window.addEventListener('click', function (event) {
            const modal = document.getElementById('modal-carga');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

    <?= $footer ?>
</body>

</html>