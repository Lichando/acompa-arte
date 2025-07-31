<!DOCTYPE html>
<html lang="es">

<head>

    <title><?= htmlspecialchars($title) ?></title>
    <?= $head ?>

</head>

<body>
    <?= $header ?>

    <div class="dashboard-nav-bar">
        PANEL DE GESTIÓN INSTITUCIONAL - <?= htmlspecialchars($institucion->nombre) ?>
    </div>

    <div class="dashboard-main">
        <div class="dashboard-sidebar">
            <div class="dashboard-profile-section">
                <div class="dashboard-profile-info">
                    <div class="dashboard-profile-name"><?= htmlspecialchars($institucion->nombre) ?></div>
                    <div class="dashboard-profile-role">Institución <?= htmlspecialchars(ucfirst($institucion->tipo)) ?>
                    </div>
                </div>
            </div>

            <div class="dashboard-nav-menu">
                <button class="dashboard-nav-btn" onclick="cambiarVista('inicio')">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('mis-datos')">
                    <i class="fas fa-id-card"></i> Mis Datos
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('familias')">
                    <i class="fas fa-users"></i> Familias
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('asistentes')">
                    <i class="fas fa-user-nurse"></i> Asistentes
                </button>
            </div>

            <a href="../institucion/logout" class="dashboard-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>

        <div class="dashboard-content" id="contenido">
            <div class="dashboard-content-header">
                <h2>Bienvenido al Panel Institucional</h2>
                <p>Seleccione una opción del menú para comenzar</p>
            </div>

            <div class="dashboard-card">
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
                        <div class="dashboard-content-header">
                            <h2>Bienvenido al Panel Institucional</h2>
                            <p>Seleccione una opción del menú para comenzar</p>
                        </div>
                        <div class="dashboard-card">
                            <h3>Resumen Institucional</h3>
                            <p>Desde aquí podrás gestionar todas las actividades relacionadas con tu institución.</p>
                        </div>
                    `;
                    break;

                case 'mis-datos':
                    contenido.innerHTML = `
 
                    <div class="dashboard-content-header">
                        <h2>Mis Datos Personales</h2>
                        <p>Información de tu perfil profesional</p>
                    </div>
                    <div class="dashboard-card" id="datosVista">
                        <h3>Información Básica</h3>
                        <p><strong>Acompañante:</strong> ${appData.institucion.nombre}</p>
                        <p><strong>DNI:</strong> ${appData.institucion.direccion}</p>
                        <p><strong>Teléfono:</strong> ${appData.institucion.telefono}</p>

                        <div style="margin-top: 20px;">
                            <button id="btnEditar" class="dashboard-btn btn-editar">Editar Datos</button>
                            <button id="btnBaja" class="dashboard-btn btn-baja" style="margin-left: 10px;">Darse de Baja</button>
                        </div>
                    </div>
                    <div id="mensajeResultado" class="mt-3"></div>`;

                    // Botón Editar Datos
                    document.getElementById('btnEditar').addEventListener('click', () => {
                        const datosVista = document.getElementById('datosVista');
                        datosVista.innerHTML = `
                        <h3>Editar Información</h3>
                        <form id="formEditar">
                            <div class="dashbord-form-group">
                                <label>Nombre:</label>
                                <input type="text" class="dashbord-form-control" name="nombre" value="${appData.institucion.nombre}" >
                            </div>
                            <div class="form-group">
                                <label>Direccion:</label>
                                <input type="text" class="dashbord-form-control" name="direccion" value="${appData.institucion.direccion}" >
                            </div>
                            <div class="form-group">
                                <label>Teléfono:</label>
                                <input type="tel" class="dashbord-form-control" name="telefono" value="${appData.institucion.telefono}" >
                            </div>

                            <button type="submit" class="dashboard-btn btn-guardar">Guardar</button>
                            <button type="button" id="cancelarEdicion" class="dashboard-btn btn-cancelar ml-2">Cancelar</button>
                        </form>
                        <div id="mensajeError" class="alert alert-danger mt-3 d-none"></div>`;

                        // Envío del formulario
                        document.getElementById('formEditar').addEventListener('submit', async function (e) {
                            e.preventDefault();
                            const mensajeError = document.getElementById('mensajeError');
                            mensajeError.classList.add('d-none');

                            try {
                                const response = await fetch('../institucion/actualizarDatos', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: new URLSearchParams(new FormData(this))
                                });

                                const text = await response.text();

                                try {
                                    const data = JSON.parse(text);

                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    } else if (data.error) {
                                        mensajeError.textContent = data.error;
                                        mensajeError.classList.remove('d-none');
                                    }
                                } catch {
                                    // Si no es JSON, manejar como HTML (renderiza de nuevo la vista)
                                    document.open();
                                    document.write(text);
                                    document.close();
                                }
                            } catch (error) {
                                mensajeError.textContent = 'Error de conexión: ' + error.message;
                                mensajeError.classList.remove('d-none');
                            }
                        });


                        // Cancelar edición
                        document.getElementById('cancelarEdicion').addEventListener('click', () => {
                            window.dispatchEvent(new Event("hashchange"));
                        });
                    });

                    // Botón Darse de Baja
                    document.getElementById('btnBaja').addEventListener('click', async () => {
                        if (confirm("¿Estás seguro que deseas darte de baja? Esta acción no se puede deshacer.")) {
                            try {
                                const response = await fetch('../institucion/darBaja', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: 'confirmar=true'
                                });

                                const text = await response.text();

                                try {
                                    const data = JSON.parse(text);
                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    } else if (data.error) {
                                        document.getElementById('mensajeResultado').innerHTML = `
                            <div class="alert alert-danger">${data.error}</div>`;
                                    }
                                } catch {
                                    // Si no es JSON, manejar como HTML
                                    document.open();
                                    document.write(text);
                                    document.close();
                                }
                            } catch (error) {
                                document.getElementById('mensajeResultado').innerHTML = `
                    <div class="alert alert-danger">Error de conexión: ${error.message}</div>`;
                            }
                        }
                    });
                    break;


                case 'familias':
                    if (!appData.familias.length) {
                        contenido.innerHTML = `
                            <div class="dashboard-content-header">
                                <h2>Familias Registradas</h2>
                                <p>No hay familias registradas en esta institución</p>
                            </div>
                            <div class="card">
                                <p>Actualmente no hay familias asociadas a esta institución.</p>
                            </div>`;
                        return;
                    }

                    contenido.innerHTML = `
                        <div class="dashboard-content-header">
                            <h2>Familias Registradas</h2>
                            <p>Listado de familias asociadas a la institución</p>
                        </div>
                        <div class="dashboard-card">
                            <table class="dashboard-table">
                                <thead class="dashboard-thead">
                                    <tr class="dashboard-tr"><th class="dashboard-th">Familias por tutor</th></tr>
                                </thead>
                                <tbody>
                                    ${Object.values(familiasAgrupadas).map(familia => {
                        const pacientesTexto = familia.pacientes.map(p =>
                            `• ${p.nombre_paciente} (${p.condicion})`
                        ).join('\n');
                        const pacientesInfo = pacientesTexto.replace(/"/g, '&quot;');
                        const nombreCompleto = `${familia.nombre_tutor} ${familia.apellido_tutor}`.trim();

                        return `
                                            <tr class="dashboard-tr">
                                                <td class="dashboard-td">
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

                        <div id="modal" class="dashboard-modal">
                            <div class="dashboard-modal-content">
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
            <div class="dashboard-content-header">
                <h2>Asistentes Terapéuticos</h2>
                <p>No hay asistentes disponibles</p>
            </div>
            <div class="dashboard-card">
                <p>Actualmente no hay asistentes terapéuticos asociados a esta institución.</p>
            </div>`;
                        return;
                    }

                    // Agrupar pacientes por asistente
                    const asistentesMap = new Map();
                    appData.asistentes.forEach(a => {
                        const clave = `${a.acompanante_id}`; // clave única por asistente
                        const nombreCompleto = `${a.acompanante_nombre || 'N/A'} ${a.acompanante_apellido || ''}`.trim();
                        const paciente = `• ${a.paciente_nombre || 'Sin nombre'} ${a.paciente_apellido || ''} `;

                        if (!asistentesMap.has(clave)) {
                            asistentesMap.set(clave, {
                                nombre: nombreCompleto,
                                pacientes: [paciente]
                            });
                        } else {
                            asistentesMap.get(clave).pacientes.push(paciente);
                        }
                    });

                    contenido.innerHTML = `
                        <div class="dashboard-content-header">
                            <h2>Asistentes Terapéuticos</h2>
                            <p>Listado de asistentes en mi institución</p>
                        </div>
                        <div class="dashboard-card">
                            <table class="dashboard-table">
                                <thead class="dashboard-thead">
                                    <tr class="dashboard-tr"><th class="dashboard-th">Asistente</th></tr>
                                </thead>
                                <tbody>
                                    ${Array.from(asistentesMap.values()).map(({ nombre, pacientes }) => `
                                        <tr class="dashboard-tr">
                                            <td class="dashboard-td">
                                                <button class="btn-popup" 
                                                    data-info="${pacientes.join('\n').replace(/"/g, '&quot;')}" 
                                                    data-nombre="${nombre}">
                                                    ${nombre}
                                                </button>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>

                        <div id="modal" class="dashboard-modal">
                            <div class="dashboard-modal-content">
                                <h3 id="modal-titulo"></h3>
                                <pre id="modal-contenido" style="white-space: pre-wrap;"></pre>
                                <button id="modal-cerrar" class="modal-close">Cerrar</button>
                            </div>
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
                        document.getElementById('modal-titulo').innerText = `Chicos a cargo de ${nombre}`;
                        document.getElementById('modal-contenido').innerText = info;
                        document.getElementById('modal').style.display = 'flex';
                    });
                });

                document.getElementById('modal-cerrar').addEventListener('click', () => {
                    document.getElementById('modal').style.display = 'none';
                });
            }
            if (vista === 'asistentes') {
                document.querySelectorAll('.btn-popup').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const info = btn.getAttribute('data-info');
                        const nombre = btn.getAttribute('data-nombre');
                        document.getElementById('modal-titulo').innerText = `Pacientes a cargo de ${nombre}`;
                        document.getElementById('modal-contenido').innerText = info;
                        document.getElementById('modal').style.display = 'flex';
                    });
                });

                document.getElementById('modal-cerrar').addEventListener('click', () => {
                    document.getElementById('modal').style.display = 'none';
                });

                document.getElementById('modal').addEventListener('click', (e) => {
                    if (e.target.id === 'modal') {
                        document.getElementById('modal').style.display = 'none';
                    }
                });
            }


        }
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