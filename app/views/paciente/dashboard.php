<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Secciones de contenido */
        section {
            margin-bottom: 25px;
        }

        section h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        section p {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        section p strong {
            color: var(--dark-color);
        }

        /* Listas */
        .historial-lista,
        .seguimiento-lista {
            list-style: none;
            padding: 0;
        }

        .historial-lista li,
        .seguimiento-lista li {
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s;
        }

        .historial-lista li:hover,
        .seguimiento-lista li:hover {
            background-color: #f9f9f9;
        }

        /* Acompañantes disponibles */
        .lista-acompanantes {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .fila-acompanante {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-radius: var(--border-radius);
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .fila-acompanante:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-acompanante {
            flex: 1;
        }

        .info-acompanante p {
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .info-acompanante p:first-child {
            font-weight: bold;
            font-size: 1.1rem;
            color: var(--dark-color);
        }

        .btn-solicitar {
            padding: 8px 16px;
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-solicitar:hover {
            background-color: #218838;
        }

        .btn-solicitar:disabled {
            background-color: var(--secondary-color);
            cursor: not-allowed;
        }

        /* Modal */
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
            background: white;
            padding: 25px;
            border-radius: var(--border-radius);
            max-width: 600px;
            width: 90%;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--secondary-color);
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
        PANEL DEL PACIENTE
    </div>

    <div class="main">
        <div class="sidebar">
            <div class="profile-section">
                <div class="profile-info">
                    <div class="profile-name"><?= htmlspecialchars($paciente->nombre . ' ' . $paciente->apellido) ?></div>
                    <div class="profile-role">Paciente</div>
                </div>
            </div>

            <div class="nav-menu">
                <button class="nav-btn" onclick="cambiarVista('inicio')">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
                <button class="nav-btn" onclick="cambiarVista('mis-datos')">
                    <i class="fas fa-user"></i> Mis Datos
                </button>
                <button class="nav-btn" onclick="cambiarVista('nueva-busqueda')">
                    <i class="fas fa-search"></i> Buscar Acompañante
                </button>
                <button class="nav-btn" onclick="cambiarVista('historial')">
                    <i class="fas fa-history"></i> Historial
                </button>
                <button class="nav-btn" onclick="cambiarVista('seguimiento')">
                    <i class="fas fa-clipboard-check"></i> Seguimiento
                </button>
            </div>

            <a href="./logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>

        <div class="content" id="contenido">
            <div class="content-header">
                <h2>Bienvenido/a, <?= htmlspecialchars($paciente->nombre) ?></h2>
                <p>Selecciona una opción del menú para comenzar</p>
            </div>
            <div class="card">
                <p>Desde este panel podrás gestionar toda la información relacionada con tu acompañamiento terapéutico.
                </p>
            </div>
        </div>
    </div>

    <!-- Modal para evaluaciones -->
    <div id="modal-seguimiento" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="cerrarModal()">×</button>
            <h3 id="modal-titulo">Evaluación</h3>
            <p id="texto-evaluacion"></p>
        </div>
    </div>

    <?= $footer ?>

    <script>
        // Datos del paciente y su historial
        const paciente = <?= json_encode($paciente) ?>;
        const historial = <?= json_encode($historial) ?>;
        const seguimiento = <?= json_encode($seguimiento) ?>;

        // Simulación de historial de acompañantes
        const historialAcompanantes = [
            {
                nombre: "María González",
                fecha_inicio: "2024-05-01",
                fecha_fin: "2024-06-15",
                evaluacion: "Excelente progreso en habilidades sociales durante este período."
            },
            {
                nombre: "Carlos Pérez",
                fecha_inicio: "2024-06-20",
                fecha_fin: null,
                evaluacion: "Actualmente trabajando en estrategias de regulación emocional."
            }
        ];

        function cambiarVista(vista) {
            const contenido = document.getElementById('contenido');

            switch (vista) {
                case 'inicio':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Bienvenido/a</h2>
                            <p>Selecciona una opción del menú para comenzar</p>
                        </div>
                    `;
                    break;
                case 'mis-datos':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Mis Datos Personales</h2>
                            <p>Información básica del paciente</p>
                        </div>
                        <div class="card">
                            <section class="datos-general">
                                <p><strong>Nombre completo:</strong> ${paciente.nombre} ${paciente.apellido}</p>
                                <p><strong>DNI:</strong> ${paciente.dni}</p>
                                <p><strong>Fecha de nacimiento:</strong> ${paciente.fecha_de_nacimiento}</p>
                                <p><strong>Edad:</strong> ${paciente.edad} años</p>
                                <p><strong>Dirección:</strong> ${paciente.direccion}</p>
                                <p><strong>Condición:</strong> ${paciente.tipo_condicion}</p>
                                <p><strong>Descripción:</strong> ${paciente.descripcion}</p>
                            </section>
                        </div>
                    `;
                    break;

                case 'nueva-busqueda':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Buscar Acompañante Terapéutico</h2>
                            <p>Acompañantes disponibles para: <em>${paciente.tipo_condicion}</em></p>
                        </div>
                        <div class="card">
                            <section id="resultadosBusqueda" class="lista-acompanantes">
                                <p>Cargando acompañantes disponibles...</p>
                            </section>
                        </div>
                    `;

                    // Simulación de búsqueda de acompañantes
                    setTimeout(() => {
                        const acompanantesDisponibles = [
                            {
                                id: 1,
                                nombre: 'Laura Pérez',
                                especialidad: paciente.tipo_condicion,
                                experiencia: '5 años',
                                disponibilidad: 'Mañanas y tardes',
                                zona: 'Rosario Centro'
                            },
                            {
                                id: 2,
                                nombre: 'Carlos Gómez',
                                especialidad: paciente.tipo_condicion,
                                experiencia: '3 años',
                                disponibilidad: 'Tardes y fines de semana',
                                zona: 'Zona Norte'
                            },
                            {
                                id: 3,
                                nombre: 'Ana Rodríguez',
                                especialidad: paciente.tipo_condicion,
                                experiencia: '7 años',
                                disponibilidad: 'Mañanas',
                                zona: 'Zona Oeste'
                            }
                        ];

                        const contenedor = document.getElementById('resultadosBusqueda');

                        if (acompanantesDisponibles.length === 0) {
                            contenedor.innerHTML = `
                                <div class="card">
                                    <p>No se encontraron acompañantes disponibles para tu condición en este momento.</p>
                                    <p>Por favor intenta nuevamente más tarde o consulta con tu institución.</p>
                                </div>
                            `;
                        } else {
                            contenedor.innerHTML = acompanantesDisponibles.map(a => `
                                <div class="fila-acompanante">
                                    <div class="info-acompanante">
                                        <p>${a.nombre}</p>
                                        <p><strong>Especialidad:</strong> ${a.especialidad}</p>
                                        <p><strong>Experiencia:</strong> ${a.experiencia}</p>
                                        <p><strong>Disponibilidad:</strong> ${a.disponibilidad}</p>
                                        <p><strong>Zona:</strong> ${a.zona}</p>
                                    </div>
                                    <button class="btn-solicitar" onclick="solicitarAcompanante(${a.id})">
                                        <i class="fas fa-user-plus"></i> Solicitar
                                    </button>
                                </div>
                            `).join('');
                        }
                    }, 1000);
                    break;

            /*    case 'historial':
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Historial de Acompañantes</h2>
                            <p>Registro de profesionales que te han acompañado</p>
                        </div>
                        <div class="card">
                            <ul class="historial-lista">
                                ${historialAcompanantes.length > 0 ?
                            historialAcompanantes.map(item => `
                                        <li>
                                            <p><strong>${item.nombre}</strong></p>
                                            <p>Desde: ${item.fecha_inicio} | Hasta: ${item.fecha_fin || 'Actualidad'}</p>
                                            ${item.evaluacion ? `<button onclick="mostrarEvaluacion('${item.evaluacion.replace(/'/g, "\\'")}')">Ver evaluación</button>` : ''}
                                        </li>
                                    `).join('') :
                            '<p>No hay registros de acompañantes anteriores.</p>'
                        }
                            </ul>
                        </div>
                    `;
                    break;

                case 'seguimiento':
                    const seguimientos = [
                        {
                            fecha: "Junio 2025",
                            acompanante: "María Rodríguez",
                            evaluacion: "El paciente mostró avances significativos en su comunicación verbal, con mayor participación en actividades grupales y mejor interacción social."
                        },
                        {
                            fecha: "Mayo 2025",
                            acompanante: "María Rodríguez",
                            evaluacion: "Se evidencian dificultades en el manejo de la frustración. Se reforzaron estrategias de autorregulación emocional con ejercicios prácticos diarios."
                        },
                        {
                            fecha: "Abril 2025",
                            acompanante: "María Rodríguez",
                            evaluacion: "Primera toma de contacto. El paciente se mostró reservado pero receptivo. Se establecieron objetivos terapéuticos iniciales enfocados en habilidades sociales básicas."
                        }
                    ];

                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Seguimiento Terapéutico</h2>
                            <p>Evaluaciones y progreso documentado</p>
                        </div>
                        <div class="card">
                            <ul class="seguimiento-lista">
                                ${seguimientos.map((item, index) => `
                                    <li>
                                        <p><strong>${item.fecha}</strong> - ${item.acompanante}</p>
                                        <button onclick="mostrarEvaluacion('${item.evaluacion.replace(/'/g, "\\'")}')">
                                            Ver evaluación completa
                                        </button>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `;
                    break;
*/
                default:
                    contenido.innerHTML = `
                        <div class="content-header">
                            <h2>Bienvenido/a</h2>
                            <p>Selecciona una opción del menú para comenzar</p>
                        </div>
                        <div class="card">
                            <p>Actualmente tienes ${historialAcompanantes.filter(a => !a.fecha_fin).length} acompañante(s) activo(s).</p>
                            <p>Última evaluación: ${seguimiento.length ? seguimiento[0].fecha : 'No registrada'}</p>
                        </div>
                    `;
            }
        }

        function solicitarAcompanante(id) {
            alert(`Función de solicitud para acompañante ID ${id} (simulada)`);
            // Aquí iría la lógica real para enviar la solicitud
        }

        function mostrarEvaluacion(texto) {
            document.getElementById('texto-evaluacion').innerText = texto;
            document.getElementById('modal-seguimiento').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal-seguimiento').style.display = 'none';
        }

        // Carga inicial
        cambiarVista('mis-datos');
    </script>
</body>

</html>