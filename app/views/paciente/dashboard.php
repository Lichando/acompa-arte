<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <?= $header ?>

    <div class="dashboard-nav-bar">
        PANEL DEL PACIENTE
    </div>

    <div class="dashboard-main">
        <div class="dashboard-sidebar">
            <div class="dashboard-profile-section">
                <div class="dashboard-profile-info">
                    <div class="dashboard-profile-name">
                        <?= htmlspecialchars($paciente->nombre . ' ' . $paciente->apellido) ?>
                    </div>
                    <div class="dashboard-profile-role">Paciente</div>
                </div>
            </div>

            <div class="dashboard-nav-menu">
                <button class="dashboard-nav-btn" onclick="cambiarVista('inicio')">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('mis-datos')">
                    <i class="fas fa-user"></i> Mis Datos
                </button>
                <button class="dashboard-nav-btn" onclick="cambiarVista('nueva-busqueda')">
                    <i class="fas fa-search"></i> Buscar Acompañante
                </button>

            </div>

            <a href="./logout" class="dashboard-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>

        <div class="dashboard-content" id="contenido">
            <div class="dashboard-content-header">
                <h2>Bienvenido/a, <?= htmlspecialchars($paciente->nombre) ?></h2>
                <p>Selecciona una opción del menú para comenzar</p>
            </div>
            <div class="dashboard-card">
                <p>Desde este panel podrás gestionar toda la información relacionada con tu acompañamiento terapéutico.
                </p>
            </div>
        </div>
    </div>

    <?= $footer ?>

    <script>
        // Datos del paciente y su historial
        const paciente = <?= json_encode($paciente) ?>;
        const $asistenteporcon = <?= json_encode($asistenteporcon) ?>;

        function formatFecha(fechaString) {
            if (!fechaString) return 'No especificada';

            const fecha = new Date(fechaString);
            if (isNaN(fecha.getTime())) return 'Fecha inválida';

            const dia = String(fecha.getDate()).padStart(2, '0');
            const mes = String(fecha.getMonth() + 1).padStart(2, '0');
            const año = fecha.getFullYear();

            return `${dia}/${mes}/${año}`;
        }



        function cambiarVista(vista) {
            const contenido = document.getElementById('contenido');

            switch (vista) {
                case 'inicio':
                    contenido.innerHTML = `
                        <div class="dashboard-content-header">
                            <h2>Bienvenido al Panel de paciente</h2>
                            <p>Seleccione una opción del menú para comenzar</p>
                        </div>
                    `;
                    break;
                case 'mis-datos':
                    contenido.innerHTML = `
                        <div class="dashboard-content-header">
                            <h2>Mis Datos Personales</h2>
                            <p>Información básica del paciente</p>
                        </div>
                        <div class="dashboard-card" id="datosVista">
                            <section class="dashboard-datos-general">
                                <h3>Información Básica</h3>
                                <p><strong>Nombre completo:</strong> ${paciente.nombre} ${paciente.apellido}</p>
                                <p><strong>DNI:</strong> ${paciente.dni}</p>
                                <p><strong>Fecha de nacimiento:</strong> ${formatFecha(paciente.fecha_de_nacimiento)}</p>
                                <p><strong>Edad:</strong> ${paciente.edad} años</p>
                                <p><strong>Dirección:</strong> ${paciente.direccion}</p>
                                <p><strong>Condición:</strong> ${paciente.tipo_condicion}</p>
                                <p><strong>Descripción:</strong> ${paciente.descripcion}</p>
                            </section>
                        </div>
                        <div id="mensajeResultado" class="mt-3"></div>`;


                    break;
                case 'nueva-busqueda':
                    contenido.innerHTML = `
                                
                        <div class="dashboard-content-header">
                            <h2>Buscar Acompañante Terapéutico</h2>
                            <p>Acompañantes disponibles para: <em>${paciente.tipo_condicion}</em></p>
                        </div>
                        <div class="dashboard-card">
                            <section id="resultadosBusqueda" class="dashboard-lista-acompanantes">
                                <p>Cargando acompañantes disponibles...</p>
                            </section>
                        </div>
                    `;

                    setTimeout(() => {
                        const acompanantesDisponibles = $asistenteporcon.filter(a => a.tipo_condicion === paciente.tipo_condicion);

                        const contenedor = document.getElementById('resultadosBusqueda');

                        if (acompanantesDisponibles.length === 0) {
                            contenedor.innerHTML = `
                <div class="dashboard-card">
                    <p>No se encontraron acompañantes disponibles para tu condición en este momento.</p>
                    <p>Por favor intenta nuevamente más tarde o consulta con tu institución.</p>
                </div>
            `;
                        } else {
                            contenedor.innerHTML = acompanantesDisponibles.map(a => `
                <div class="dashboard-fila-acompanante">
                    <div class="dashboard-info-acompanante">
                        <p>${a.nombre} ${a.apellido}</p>
                        <p><strong>Especialidad:</strong> ${a.tipo_condicion}</p>
                        <p><strong>Experiencia:</strong> ${a.experiencia ?? 'No especificada'}</p>
                        <p><strong>Disponibilidad:</strong> ${a.disponibilidad ?? 'No especificada'}</p>
                        <p><strong>Zona:</strong> ${a.zona ?? 'No especificada'}</p>
                    </div>
                    <button class="dashboard-btn btn-solicitar" onclick="solicitarAcompanante(${a.id})">
                        <i class="fas fa-user-plus"></i> Solicitar
                    </button>
                </div>
            `).join('');
                        }
                    }, 500);
                    break;



                default:
                    contenido.innerHTML = `
                         <div class="dashboard-content-header">
                            <h2>Bienvenido al Panel de paciente</h2>
                            <p>Seleccione una opción del menú para comenzar</p>
                        </div>
                    `;
            }
        }



        function cerrarModal() {
            document.getElementById('modal-seguimiento').style.display = 'none';
        }

        // Carga inicial
        cambiarVista('inicio');
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