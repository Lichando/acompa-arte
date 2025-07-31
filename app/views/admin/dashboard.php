<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <?= $head ?>


</head>

<body>
    <?= $header ?>

    <div class="admin-nav-bar">
        PANEL ADMINISTRATIVO - GESTIÓN INTEGRAL
    </div>

    <div class="admin-main">
        <div class="admin-sidebar">
            <div class="admin-profile-section">
                <div class="admin-profile-info">
                    <div class="admin-profile-name">Administrador del Sistema</div>
                    <div class="admin-profile-role">Rol: Super Administrador</div>
                </div>
            </div>

            <div class="admin-nav-menu">
                <button class="admin-nav-btn" onclick="cambiarVistaAdmin('ir-dashboard')">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </button>
                <button class="admin-nav-btn" onclick="cambiarVistaAdmin('gestion-familias')">
                    <i class="fas fa-users"></i> Familias
                </button>
                <button class="admin-nav-btn" onclick="cambiarVistaAdmin('gestion-instituciones')">
                    <i class="fas fa-school"></i> Instituciones
                </button>
                <button class="admin-nav-btn" onclick="cambiarVistaAdmin('gestion-asistentes')">
                    <i class="fas fa-user-nurse"></i> Asistentes
                </button>

            </div>

            <a href="../cuentas/logout" class="admin-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>

        <div class="admin-content" id="contenido">
            <div class="admin-content-header">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <p>Resumen general del sistema</p>
            </div>

            <div class="admin-card-grid">
                <div class="admin-stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?= number_format($total_pacientes_activos) ?></h3>
                    <p>Pacientes activos</p>
                </div>
                <div class="admin-stat-card">
                    <i class="fas fa-user-nurse"></i>
                    <h3><?= number_format($total_acompanantes_activos) ?></h3>
                    <p>Asistentes activos</p>
                </div>
                <div class="admin-stat-card">
                    <i class="fas fa-school"></i>
                    <h3><?= number_format($total_instituciones) ?></h3>
                    <p>Instituciones</p>
                </div>
            </div>

            <div class="admin-card">
                <h3><i class="fas fa-school"></i> Instituciones Recientes</h3>
                <?php if (!empty($institucionesRecientes)): ?>
                    <div class="admin-table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr class="admin-tr">
                                    <th class="admin-th">Nombre</th>
                                    <th class="admin-th">Dirección</th>
                                    <th class="admin-th">Teléfono</th>
                                    <th class="admin-th">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($institucionesRecientes as $institucion): ?>
                                    <tr class="admin-tr">
                                        <td class="admin-td"><?= htmlspecialchars($institucion['nombre'] ?? 'Sin nombre') ?>
                                        </td>
                                        <td class="admin-td">
                                            <?= htmlspecialchars($institucion['direccion'] ?? 'No especificada') ?>
                                        </td>
                                        <td class="admin-td">
                                            <?= htmlspecialchars($institucion['telefono'] ?? 'No disponible') ?>
                                        </td>
                                        <td class="admin-td">
                                            <button class="admin-btn admin-btn-primary"
                                                onclick="verInstitucion(<?= $institucion['id'] ?? 0 ?>)">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="admin-alert admin-alert-info">No hay instituciones registradas</div>
                <?php endif; ?>
            </div>

            <div class="admin-card admin-mt-4">
                <h3><i class="fas fa-user-injured"></i> Pacientes Recientes</h3>
                <?php if (!empty($pacientesRecientes)): ?>
                    <div class="admin-table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr class="admin-tr">
                                    <th class="admin-th">Nombre y apellido</th>
                                    <th class="admin-th">Edad</th>
                                    <th class="admin-th">Institución</th>
                                    <th class="admin-th">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pacientesRecientes as $paciente): ?>
                                    <tr class="admin-tr">
                                        <td class="admin-td">
                                            <?= htmlspecialchars($paciente['nombre'] ?? '') ?>
                                            <?= htmlspecialchars($paciente['apellido'] ?? '') ?>
                                        </td>
                                        <td class="admin-td"><?= htmlspecialchars($paciente['edad'] ?? '--') ?></td>
                                        <td class="admin-td">
                                            <?= htmlspecialchars($paciente['institucion_nombre'] ?? 'Sin institución') ?>
                                        </td>
                                        <td class="admin-td">
                                            <button class="admin-btn admin-btn-primary"
                                                onclick="verPaciente(<?= $paciente['id'] ?? 0 ?>)">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="admin-alert admin-alert-info">No hay pacientes registrados</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de carga -->
    <div class="admin-modal" id="modal-carga">
        <div class="admin-modal-content">
            <div class="loader"></div>
            <p>Cargando la vista</p>
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
    <div class="admin-content-header">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
        <p>Resumen general del sistema</p>
    </div>

    <div class="admin-card-grid">
        <!-- Tarjetas de estadísticas -->
        <div class="admin-stat-card">
            <i class="fas fa-users"></i>
            <h3>${adminData.total_pacientes_activos || 0}</h3>
            <p>Pacientes activos</p>
        </div>
        <div class="admin-stat-card">
            <i class="fas fa-user-nurse"></i>
            <h3>${adminData.total_acompanantes_activos || 0}</h3>
            <p>Asistentes activos</p>
        </div>
        <div class="admin-stat-card">
            <i class="fas fa-school"></i>
            <h3>${adminData.total_instituciones || 0}</h3>
            <p>Instituciones</p>
        </div>
    </div>

    <div class="admin-card">
        <h3><i class="fas fa-school"></i> Instituciones Recientes</h3>
        ${adminData.institucionesRecientes && adminData.institucionesRecientes.length > 0 ? `
            <div class="admin-table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr class="admin-tr">
                            <th class="admin-th">Nombre</th>
                            <th class="admin-th">Dirección</th>
                            <th class="admin-th">Teléfono</th>
                            <th class="admin-th">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${adminData.institucionesRecientes.map(institucionesReci => `
                            <tr class="admin-tr">
                                <td class="admin-td">${institucionesReci.nombre || 'Sin nombre'}</td>
                                <td class="admin-td">${institucionesReci.direccion || 'No especificada'}</td>
                                <td class="admin-td">${institucionesReci.telefono || 'No disponible'}</td>
                                <td class="admin-td">
                                    <button class="admin-btn admin-btn-primary" 
                                            onclick="verInstitucion(${institucionesReci.id})">
                                        <i class="fas fa-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        ` : '<div class="admin-alert admin-alert-info">No hay instituciones registradas</div>'}
    </div>

    <div class="admin-card admin-mt-4">
        <h3><i class="fas fa-user-injured"></i> Pacientes Recientes</h3>
        ${adminData.pacientesRecientes && adminData.pacientesRecientes.length > 0 ? `
            <div class="admin-table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr class="admin-tr">
                            <th class="admin-th">Nombre</th>
                            <th class="admin-th">Edad</th>
                            <th class="admin-th">Institución</th>
                            <th class="admin-th">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${adminData.pacientesRecientes.map(pacientesReci => {
                            const institucion = adminData.instituciones.find(i => i.id === pacientesReci.institucion_id);
                            const nombreInstitucion = institucion ? institucion.nombre : 'Sin institución';

                            return `
                            <tr class="admin-tr">
                                <td class="admin-td">${pacientesReci.nombre || 'Sin nombre'} ${pacientesReci.apellido || ''}</td>
                                <td class="admin-td">${pacientesReci.edad || '--'}</td>
                                <td class="admin-td">${nombreInstitucion}</td>
                                <td class="admin-td">
                                    <button class="admin-btn admin-btn-primary" 
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
        ` : '<div class="admin-alert admin-alert-info">No hay pacientes registrados</div>'}
    </div>
    `;
                        break;
                    case 'gestion-instituciones':
                        contenido.innerHTML = `
        <div class="admin-content-header">
            <h2><i class="fas fa-school"></i> Gestión de Instituciones</h2>
            <p>Administración de instituciones educativas y sanitarias</p>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Listado de Instituciones</h3>
            </div>

            ${adminData.instituciones.length > 0 ? `
                <div class="admin-table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr class="admin-tr">
                                <th class="admin-th">Nombre</th>
                                <th class="admin-th">Dirección</th>
                                <th class="admin-th">Teléfono</th>
                                <th class="admin-th">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${adminData.instituciones.map(institucion => `
                                <tr class="admin-tr">
                                    <td class="admin-td">${institucion.nombre || 'Sin nombre'}</td>
                                    <td class="admin-td">${institucion.direccion || 'No especificada'}</td>
                                    <td class="admin-td">${institucion.telefono || 'No disponible'}</td>
                                    <td class="admin-td admin-actions">
                                        <button class="admin-btn admin-btn-primary" 
                                                onclick="verInstitucion(${institucion.id})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="admin-btn admin-btn-warning" 
                                                onclick="editarInstitucion(${institucion.id})"
                                                style="margin-left: 5px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            ` : '<div class="admin-alert admin-alert-info">No hay instituciones registradas</div>'}
        </div>
    `;

                        break;
                    case 'gestion-familias':
                        contenido.innerHTML = `
        <div class="admin-content-header">
            <h2><i class="fas fa-user-nurse"></i> Gestión de Pacientes</h2>
            <p>Administración de Pacientes</p>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Listado de pacientes</h3>

            </div>

            ${adminData.pacientes.length > 0 ? `
                <div class="admin-table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr class="admin-tr">
                                <th class="admin-th">Nombre</th>
                                <th class="admin-th">DNI</th>
                                <th class="admin-th">Condición</th>
                                <th class="admin-th">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${adminData.pacientes.map(paciente => `
                                <tr class="admin-tr">
                                    <td class="admin-td">${paciente.nombre || ''} ${paciente.apellido || ''}</td>
                                    <td class="admin-td">${paciente.dni || 'No especificado'}</td>
                                    <td class="admin-td">${paciente.tipo_condicion || 'No especificada'}</td>
                                    <td class="admin-td admin-actions">
                                        <button class="admin-btn admin-btn-primary" 
                                                onclick="verPaciente(${paciente.id})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="admin-btn admin-btn-warning" 
                                                onclick="editarPaciente(${paciente.id})"
                                                style="margin-left: 5px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="admin-btn admin-btn-danger" 
                                                onclick="eliminarPaciente(${paciente.id})"
                                                style="margin-left: 5px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            ` : '<div class="admin-alert admin-alert-info">No hay pacientes registrados</div>'}
        </div>
    `;

                        break;




                    case 'gestion-asistentes':
                        contenido.innerHTML = `
        <div class="admin-content-header">
            <h2><i class="fas fa-user-nurse"></i> Gestión de Asistentes</h2>
            <p>Administración de acompañantes terapéuticos</p>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Listado de Asistentes</h3>
            </div>

            ${adminData.acompanantes.length > 0 ? `
                <div class="admin-table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr class="admin-tr">
                                <th class="admin-th">Nombre</th>
                                <th class="admin-th">DNI</th>
                                <th class="admin-th">Condición</th>
                                <th class="admin-th">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${adminData.acompanantes.map(asistente => `
                                <tr class="admin-tr">
                                    <td class="admin-td">${asistente.usuario_nombre || ''} ${asistente.usuario_apellido || ''}</td>
                                    <td class="admin-td">${asistente.dni || 'No especificado'}</td>
                                    <td class="admin-td">${asistente.tipo_condicion || 'No especificada'}</td>
                                    <td class="admin-td admin-actions">
                                        <button class="admin-btn admin-btn-primary" 
                                                onclick="verAsistente(${asistente.id})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="admin-btn admin-btn-warning" 
                                                onclick="editarAsistente(${asistente.id})"
                                                style="margin-left: 5px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="admin-btn admin-btn-danger" 
                                                onclick="eliminarAsistente(${asistente.id})"
                                                style="margin-left: 5px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            ` : '<div class="admin-alert admin-alert-info">No hay asistentes registrados</div>'}
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



        // Cerrar modal al hacer clic fuera del contenido
        window.addEventListener('click', function (event) {
            const modal = document.getElementById('modal-carga');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.querySelector('.menu-toggle');
            const navLinks = document.querySelector('.acomp-header-nav-links');

            menuToggle.addEventListener('click', function () {
                navLinks.classList.toggle('active');
                menuToggle.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
            });

            // Cerrar menú al hacer clic en un enlace (para móviles)
            document.querySelectorAll('.acomp-header-nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        navLinks.classList.remove('active');
                        menuToggle.textContent = '☰';
                    }
                });
            });
        });
          </script>

    <?= $footer ?>
</body>

</html>