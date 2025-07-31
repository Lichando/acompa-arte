<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= $title ?></title>
    <style>
        .institucion-registro {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .institucion-registro .welcome-title {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .institucion-registro .formulario-registro {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .institucion-registro label {
            display: block;
            margin-bottom: 0.5rem;
            color: #495057;
            font-weight: 500;
            grid-column: span 1;
        }

        .institucion-registro input[type="text"],
        .institucion-registro input[type="email"],
        .institucion-registro input[type="tel"],
        .institucion-registro select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .institucion-registro input:focus,
        .institucion-registro select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .institucion-registro .btn-register {
            grid-column: span 2;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 1rem;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .institucion-registro .btn-register:hover {
            background-color: #2980b9;
        }

        .institucion-registro .alert-danger {
            grid-column: span 2;
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            border: 1px solid #f5c6cb;
        }

        /* Campos de ancho completo */
        .institucion-registro .full-width {
            grid-column: span 2;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .institucion-registro .formulario-registro {
                grid-template-columns: 1fr;
            }

            .institucion-registro label,
            .institucion-registro .btn-register,
            .institucion-registro .alert-danger {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <?= $header ?>

    <div class="institucion-registro">
        <h2 class="welcome-title">Registro de Institución</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="formulario-registro">

            <!-- Primera columna -->
            <div class="form-group full-width">
                <label>Nombre de la Institución *</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($oldInput['nombre'] ?? '') ?>"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s0-9\-]{2,100}"
                    title="Solo letras, números, espacios y guiones (2-100 caracteres)">
            </div>

            <div class="form-group full-width">
                <label>Dirección *</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($oldInput['direccion'] ?? '') ?>"
                    minlength="5" maxlength="200">
            </div>

            <div class="form-group">
                <label>Ciudad *</label>
                <input type="text" name="ciudad" value="<?= htmlspecialchars($oldInput['ciudad'] ?? '') ?>"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}" title="Solo letras y espacios (2-50 caracteres)">
            </div>

            <div class="form-group">
                <label>Provincia *</label>
                <input type="text" name="provincia" value="<?= htmlspecialchars($oldInput['provincia'] ?? '') ?>"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}" title="Solo letras y espacios (2-50 caracteres)">
            </div>

            <!-- Segunda columna -->
            <div class="form-group">
                <label>Teléfono *</label>
                <input type="tel" name="telefono" value="<?= htmlspecialchars($oldInput['telefono'] ?? '') ?>"
                    pattern="[\d\s\-\(\)]{6,20}" title="6-20 dígitos, puede incluir espacios, guiones y paréntesis">
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?= htmlspecialchars($oldInput['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Tipo de Institución *</label>
                <select name="tipo">
                    <option value="">Seleccione un tipo...</option>
                    <option value="educativa" <?= ($oldInput['tipo'] ?? '') == 'educativa' ? 'selected' : '' ?>>Educativa
                    </option>
                    <option value="sanitaria" <?= ($oldInput['tipo'] ?? '') == 'sanitaria' ? 'selected' : '' ?>>Sanitaria
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Sector *</label>
                <select name="sector">
                    <option value="">Seleccione un sector...</option>
                    <option value="publica" <?= ($oldInput['sector'] ?? '') == 'publica' ? 'selected' : '' ?>>Pública
                    </option>
                    <option value="privada" <?= ($oldInput['sector'] ?? '') == 'privada' ? 'selected' : '' ?>>Privada
                    </option>
                </select>
            </div>

            <div class="form-group full-width">
                <button type="submit" class="btn-register">Registrar Institución</button>
            </div>
        </form>
    </div>

    <?= $footer ?>

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