<!DOCTYPE html>

<html lang="es">


<head>
    <title><?= htmlspecialchars($title) ?></title>
    <?= $head ?>

</head>

<body>
    <?= $header ?>

    <div class="dashboard-nav-bar">
        PANEL ASISTENCIAL TERAPÉUTICO
    </div>

    <div class="dashboard-main">
        <div class="dashboard-sidebar">
            <div class="dashboard-profile-section">
                <div class="dashboard-profile-info">
                    <div class="dashboard-profile-name">
                        <?php echo $acompanante->nombre . ' ' . $acompanante->apellido; ?>
                    </div>

                    <div class="profile-role">Acompañante Terapéutico</div>
                </div>
            </div>

            <div class="dashboard-nav-menu">
                <button class="dashboard-nav-btn" onclick="cambiarVista('inicio')">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('mis-datos')">
                    <i class="fas fa-id-card"></i> Mis Datos
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('mis-pacientes')">
                    <i class="fas fa-search"></i> Mis pacientes
                </button>

            </div>

            <a href="logout" class="dashboard-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>

        <div class="dashboard-content" id="contenido">
            <div class="dashboard-content-header">
                <h2>Bienvenido al Panel Asistencial</h2>
                <p>Seleccione una opción del menú para comenzar</p>

            </div>

            <div class="dashboard-card">
                <h3>Resumen de Actividad</h3>
                <p>Aquí podrás ver un resumen de tus actividades recientes cuando selecciones una sección.</p>
            </div>
        </div>
    </div>

    <?= $footer ?>
    <script>
        // Datos simulados (en un caso real vendrían de una API)

        const acompanante = <?= json_encode($acompanante) ?>;
        const misPacientes = <?= json_encode(is_array($mispacientes) ? $mispacientes : []) ?>;








        function cambiarVista(vista) {
            let contenido = document.getElementById("contenido");

            switch (vista) {
                case 'inicio':
                    contenido.innerHTML = `
                    <div class="dashboard-content-header">
                        <h2>Bienvenido al Panel Asistencial</h2>
                        <p>Seleccione una opción del menú para comenzar</p>
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
            <p><strong>Acompañante:</strong> ${acompanante.nombre} ${acompanante.apellido}</p>
            <p><strong>DNI:</strong> ${acompanante.dni}</p>
            <p><strong>Teléfono:</strong> ${acompanante.telefono}</p>

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
                <div class="dashboard-form-group">
                    <label>Nombre:</label>
                    <input type="text" class="dashboard-form-control" name="nombre" value="${acompanante.nombre}" >
                </div>
                <div class="form-group">
                    <label>Apellido:</label>
                    <input type="text" class="dashboard-form-control" name="apellido" value="${acompanante.apellido}" >
                </div>
                <div class="form-group">
                    <label>DNI:</label>
                    <input type="text" class="dashboard-form-control" name="dni" value="${acompanante.dni}" >
                </div>
                <div class="form-group">
                    <label>Teléfono:</label>
                    <input type="tel" class="dashboard-form-control" name="telefono" value="${acompanante.telefono}" >
                </div>

                <button type="submit" class="dashboard-btn btn-guardar">Guardar</button>
                <button type="button" id="cancelarEdicion" class="dashboard-btn btn-cancelar ml-2">Cancelar</button>
            </form>
            <div id="mensajeError" class="dashboard-alert alert-danger mt-3 d-none"></div>`;

                        // Envío del formulario
                        document.getElementById('formEditar').addEventListener('submit', async function (e) {
                            e.preventDefault();
                            const mensajeError = document.getElementById('mensajeError');
                            mensajeError.classList.add('d-none');

                            try {
                                const response = await fetch('../acompanante/actualizarDatos', {
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
                                const response = await fetch('../acompanante/darBaja', {
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


                case 'mis-pacientes':
                    let listaPacientesHTML = '';

                    if (misPacientes.length === 0) {
                        listaPacientesHTML = '<p>No tenés pacientes asignados.</p>';
                    } else {
                        listaPacientesHTML = `
            <div class="dashboard-pacientes-scrollable">
                <ul style="list-style:none; padding:0; margin:0;">
                    ${misPacientes.map(paciente => `
                        <li style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <strong>${paciente.nombre_paciente} ${paciente.apellido_paciente}</strong><br>
                            Tutor: ${paciente.nombre_tutor} ${paciente.apellido_tutor}<br>
                            Condición: ${paciente.condicion}
                        </li>
                    `).join('')}
                </ul>
            </div>`;
                    }

                    contenido.innerHTML = `
                    <div class="dashboard-content-header">
                        <h2>Mis Pacientes</h2>
                        <p>Lista de tus pacientes asignados</p>
                    </div>
                    <div class="dashboard-card">
                        <h3>Pacientes</h3>
                        ${listaPacientesHTML}
                    </div>`;
                    break;



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
</body>

</html>