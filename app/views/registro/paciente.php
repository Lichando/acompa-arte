<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= $title ?></title>
    <style>
        .paciente-registro {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .paciente-registro .welcome-title {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .paciente-registro .formulario-registro {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .paciente-registro label {
            display: block;
            margin-bottom: 0.5rem;
            color: #495057;
            font-weight: 500;
            grid-column: span 1;
        }

        .paciente-registro input[type="text"],
        .paciente-registro input[type="date"],
        .paciente-registro input[type="number"],
        .paciente-registro textarea,
        .paciente-registro select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .paciente-registro input[type="text"]:focus,
        .paciente-registro input[type="date"]:focus,
        .paciente-registro input[type="number"]:focus,
        .paciente-registro textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .paciente-registro textarea {
            min-height: 100px;
            resize: vertical;
        }

        .paciente-registro input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .paciente-registro .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .paciente-registro .btn-register {
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

        .paciente-registro .btn-register:hover {
            background-color: #2980b9;
        }

        .paciente-registro .alert-danger {
            grid-column: span 2;
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            border: 1px solid #f5c6cb;
        }

        /* Campos de ancho completo */
        .paciente-registro .full-width {
            grid-column: span 2;
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .paciente-registro .formulario-registro {
                grid-template-columns: 1fr;
            }

            .paciente-registro label,
            .paciente-registro .btn-register,
            .paciente-registro .alert-danger {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <?= $header ?>

    <div class="paciente-registro">
        <h2 class="welcome-title">Registro de Paciente</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="formulario-registro">

            <!-- Primera columna -->
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($oldInput['nombre'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Apellido *</label>
                <input type="text" name="apellido" value="<?= htmlspecialchars($oldInput['apellido'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>DNI *</label>
                <input type="text" name="dni" value="<?= htmlspecialchars($oldInput['dni'] ?? '') ?>" pattern="\d{7,8}"
                    title="Debe contener 7 u 8 dígitos">
            </div>

            <div class="form-group">
                <label>Fecha de Nacimiento *</label>
                <input type="date" name="fecha_de_nacimiento"
                    value="<?= htmlspecialchars($oldInput['fecha_de_nacimiento'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Edad *</label>
                <input type="number" name="edad" min="0" max="120"
                    value="<?= htmlspecialchars($oldInput['edad'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Dirección *</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($oldInput['direccion'] ?? '') ?>">
            </div>

            <!-- Select para Institución -->
            <div class="form-group">
                <label>Institución *</label>
                <select name="institucion_id">
                    <option value="">Seleccione una institución</option>
                    <?php foreach ($instituciones as $institucion): ?>
                        <option value="<?= $institucion->id ?>" <?= ($oldInput['institucion_id'] ?? '') == $institucion->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($institucion->nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Segunda columna -->
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="tiene_obra_social" id="tiene_obra_social"
                        <?= isset($oldInput['tiene_obra_social']) && $oldInput['tiene_obra_social'] ? 'checked' : '' ?>>
                    ¿Tiene Obra Social?
                </label>
            </div>

            <div class="form-group obra-social-group" id="obra_social_container"
                style="display: <?= isset($oldInput['tiene_obra_social']) && $oldInput['tiene_obra_social'] ? 'block' : 'none' ?>;">
                <label>Seleccione Obra Social</label>
                <select name="obra_social_id" class="select-obra-social form-control">
                    <option value="">-- Seleccione --</option>
                    <?php if (!empty($obrasSociales)): ?>
                        <?php foreach ($obrasSociales as $obra): ?>
                            <option value="<?= $obra->id ?>" <?= (isset($oldInput['obra_social_id']) && $oldInput['obra_social_id'] == $obra->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($obra->nombre ?? 'Sin nombre') ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay obras sociales disponibles</option>
                    <?php endif; ?>
                </select>
            </div>


            <!-- Campos de ancho completo -->
            <div class="form-group full-width">
                    <label>Tipo de Condición *</label>
                    <select name="tipo_condicion" class="form-control" >
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

                <div class="form-group full-width">
                    <label>Descripción *</label>
                    <textarea name="descripcion"
                        rows="4"><?= htmlspecialchars($oldInput['descripcion'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label>Número de CUD</label>
                    <input type="text" name="numero_cud" value="<?= htmlspecialchars($oldInput['numero_cud'] ?? '') ?>"
                        pattern="\d{6,10}" title="Debe contener entre 6 y 10 dígitos">
                </div>

                <div class="form-group full-width">
                    <button type="submit" class="btn-register">Registrar Paciente</button>
                </div>
        </form>
    </div>

    <?= $footer ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.formulario-registro');
            const checkbox = document.getElementById('tiene_obra_social');
            const obraSocialContainer = document.getElementById('obra_social_container');
            const selectObraSocial = document.querySelector('.select-obra-social');

            // Mostrar/ocultar al cambiar el checkbox
            checkbox.addEventListener('change', function () {
                obraSocialContainer.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) selectObraSocial.value = '';
            });

            // Validación antes de enviar el formulario
            form.addEventListener('submit', function (e) {
                if (checkbox.checked && selectObraSocial.value === '') {
                    e.preventDefault();
                    alert('Por favor seleccione una obra social');
                    selectObraSocial.focus();
                }
            });

            // Estado inicial
            obraSocialContainer.style.display = checkbox.checked ? 'block' : 'none';
        });
    </script>
</body>

</html>