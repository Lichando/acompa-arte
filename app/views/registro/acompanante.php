<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title>Registro de Acompañante Terapéutico</title>
    <style>
        .registration-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .welcome-title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.8px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="password"]:focus {
            border-color: #4A90E2;
            outline: none;
        }

        .btn-register {
            width: 100%;
            background-color: #4A90E2;
            border: none;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-register:hover {
            background-color: #357ABD;
        }

        @media (max-width: 480px) {
            .registration-container {
                padding: 20px 25px;
            }
        }
    </style>
</head>

<body>
    <?= $header ?>

    <div class="registration-container">
        <h2 class="welcome-title">Registro de Acompañante Terapéutico</h2>
        <!-- Mensajes -->
        <?php if (!empty($error)): ?>
            <div style="background-color:#f8d7da; color:#842029; padding:10px; margin-bottom:15px; border-radius:5px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div style="background-color:#d1e7dd; color:#0f5132; padding:10px; margin-bottom:15px; border-radius:5px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="formulario-registro">


            <label>DNI</label>
            <input type="text" name="dni">

            <label>Teléfono</label>
            <input type="text" name="telefono">

            <div class="form-group full-width">
                <label>Tipo de Condición *</label>
                <select name="tipo_condicion" class="form-control">
                    <option value="">Seleccione el tipo de condición...</option>
                    <option value="TEA" <?= ($oldInput['tipo_condicion'] ?? '') == 'TEA' ? 'selected' : '' ?>>
                        TEA (Trastorno del Espectro Autista)
                    </option>
                    <option value="TGD" <?= ($oldInput['tipo_condicion'] ?? '') == 'TGD' ? 'selected' : '' ?>>
                        TGD (Trastorno Generalizado del Desarrollo)
                    </option>
                    <option value="Discapacidad_Intelectual" <?= ($oldInput['tipo_condicion'] ?? '') == 'Discapacidad_Intelectual' ? 'selected' : '' ?>>
                        Discapacidad Intelectual
                    </option>
                    <option value="TDAH" <?= ($oldInput['tipo_condicion'] ?? '') == 'TDAH' ? 'selected' : '' ?>>
                        TDAH (Trastorno por Déficit de Atención e Hiperactividad)
                    </option>
                    <option value="Psicosis_Infantil" <?= ($oldInput['tipo_condicion'] ?? '') == 'Psicosis_Infantil' ? 'selected' : '' ?>>
                        Psicosis Infantil
                    </option>
                    <option value="Parálisis_Cerebral" <?= ($oldInput['tipo_condicion'] ?? '') == 'Parálisis_Cerebral' ? 'selected' : '' ?>>
                        Parálisis Cerebral
                    </option>
                    <option value="Sindrome_Down" <?= ($oldInput['tipo_condicion'] ?? '') == 'Sindrome_Down' ? 'selected' : '' ?>>
                        Síndrome de Down
                    </option>
                    <option value="Otra" <?= ($oldInput['tipo_condicion'] ?? '') == 'Otra' ? 'selected' : '' ?>>
                        Otra condición no especificada
                    </option>
                </select>
            </div>

            <button type="submit" class="btn-register">Registrar</button>

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