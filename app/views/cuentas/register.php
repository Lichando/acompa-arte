<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= $title ?></title>

    <style>
        .register-body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .register-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .register-title {
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 2rem;
        }

        .register-form {
            max-width: 500px;
            margin: 30px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .register-form-group {
            margin-bottom: 20px;
        }

        .register-label {
            display: block;
            margin-bottom: 5px;
            color: #444;
            font-weight: 500;
        }

        .register-input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .register-input-error {
            border-color: #dc3545;
        }

        .register-error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 3px;
            display: none;
        }

        .register-radio-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }

        .register-radio-option {
            display: flex;
            align-items: center;
        }

        .register-radio-input {
            margin-right: 8px;
        }

        .register-gender-error {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }

        .register-submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .register-submit-btn:hover {
            background-color: #0056b3;
        }

        .register-password-strength {
            margin-top: 10px;
            height: 5px;
            background: #eee;
            border-radius: 3px;
            overflow: hidden;
        }

        .register-strength-bar {
            height: 100%;
            width: 0%;
            background: #dc3545;
            transition: all 0.3s;
        }

        .register-strength-text {
            font-size: 0.8rem;
            color: #666;
            display: block;
            margin-top: 5px;
        }

        .register-terms {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }

        .register-terms input {
            margin-right: 10px;
        }

        @media (max-width: 600px) {
            .register-form {
                padding: 20px;
            }

            .register-title {
                font-size: 1.5rem;
            }

            .register-radio-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>

<body class="register-body">
    <?= $header ?>

    <div class="register-container">
        <h2 class="register-title">Registrate en nuestra página</h2>

        <?php if (!empty($errors['general'])): ?>
            <div class="register-error-message" style="display: block; text-align: center; margin-bottom: 20px;">
                <?= $errors['general'] ?>
            </div>
        <?php endif; ?>

        <form class="register-form" method="POST" action="" id="registerForm">
            <!-- Nombre -->
            <div class="register-form-group">
                <label class="register-label" for="name">Nombre</label>
                <input class="register-input <?= !empty($errors['name']) ? 'register-input-error' : '' ?>" type="text"
                    name="name" id="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                <?php if (!empty($errors['name'])): ?>
                    <div class="register-error-message" style="display: block;"><?= $errors['name'] ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="nameError">El nombre solo puede contener letras y espacios</div>
                <?php endif; ?>
            </div>

            <!-- Apellido -->
            <div class="register-form-group">
                <label class="register-label" for="lastname">Apellido</label>
                <input class="register-input <?= !empty($errors['lastname']) ? 'register-input-error' : '' ?>"
                    type="text" name="lastname" id="lastname" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
                <?php if (!empty($errors['lastname'])): ?>
                    <div class="register-error-message" style="display: block;"><?= $errors['lastname'] ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="lastnameError">El apellido solo puede contener letras y espacios
                    </div>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="register-form-group">
                <label class="register-label" for="email">Correo electrónico</label>
                <input class="register-input <?= !empty($errors['email']) ? 'register-input-error' : '' ?>" type="email"
                    name="email" id="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                <?php if (!empty($errors['email'])): ?>
                    <div class="register-error-message" style="display: block;"><?= $errors['email'] ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="emailError">Ingrese un correo electrónico válido</div>
                    <div class="register-error-message" id="emailExistsError">Este correo ya está registrado</div>
                <?php endif; ?>
            </div>

            <!-- Contraseña -->
            <div class="register-form-group">
                <label class="register-label" for="contrasena">Contraseña</label>
                <input class="register-input <?= !empty($errors['contrasena']) ? 'register-input-error' : '' ?>"
                    type="password" name="contrasena" id="contrasena">
                <div class="register-password-strength">
                    <div class="register-strength-bar" id="passwordStrengthBar"></div>
                    <span class="register-strength-text" id="passwordStrengthText">Seguridad: Muy débil</span>
                </div>
                <?php if (!empty($errors['contrasena'])): ?>
                    <div class="register-error-message" style="display: block;"><?= $errors['contrasena'] ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="passwordError">Debe tener 8+ caracteres, 1 mayúscula, 1 número y
                        1 carácter especial</div>
                <?php endif; ?>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="register-form-group">
                <label class="register-label" for="confirmar_contrasena">Confirmar Contraseña</label>
                <input
                    class="register-input <?= !empty($errors['confirmar_contrasena']) ? 'register-input-error' : '' ?>"
                    type="password" name="confirmar_contrasena" id="confirmar_contrasena">
                <?php if (!empty($errors['confirmar_contrasena'])): ?>
                    <div class="register-error-message" style="display: block;"><?= $errors['confirmar_contrasena'] ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="confirmPasswordError">Las contraseñas no coinciden</div>
                <?php endif; ?>
            </div>

            <!-- Fecha Nacimiento -->
            <div class="register-form-group">
                <label class="register-label" for="nacimiento">Fecha de nacimiento</label>
                <input class="register-input <?= !empty($errors['nacimiento']) ? 'register-input-error' : '' ?>"
                    type="date" name="nacimiento" id="nacimiento"
                    value="<?= htmlspecialchars($old['nacimiento'] ?? '') ?>">
                <?php if (!empty($errors['nacimiento'])): ?>
                    <div class="register-error-message" style="display: block;"><?= $errors['nacimiento'] ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="birthdateError">Formato inválido (AAAA-MM-DD)</div>
                    <div class="register-error-message" id="ageError">Debes tener al menos 13 años para registrarte</div>
                <?php endif; ?>
            </div>

            <!-- Género -->
            <div class="register-form-group">
                <label class="register-label">Género</label>
                <div class="register-radio-group">
                    <div class="register-radio-option">
                        <input class="register-radio-input" type="radio" id="masculino" name="genero" value="masculino"
                            <?= (isset($old['genero']) && $old['genero'] === 'masculino') ? 'checked' : '' ?>>
                        <label for="masculino">Masculino</label>
                    </div>
                    <div class="register-radio-option">
                        <input class="register-radio-input" type="radio" id="femenino" name="genero" value="femenino"
                            <?= (isset($old['genero']) && $old['genero'] === 'femenino') ? 'checked' : '' ?>>
                        <label for="femenino">Femenino</label>
                    </div>
                    <div class="register-radio-option">
                        <input class="register-radio-input" type="radio" id="nobinario" name="genero" value="nobinario"
                            <?= (isset($old['genero']) && $old['genero'] === 'nobinario') ? 'checked' : '' ?>>
                        <label for="nobinario">No binario</label>
                    </div>
                </div>
                <?php if (!empty($errors['genero'])): ?>
                    <div class="register-gender-error" style="display: block;"><?= $errors['genero'] ?></div>
                <?php else: ?>
                    <div class="register-gender-error" id="genderError">Seleccione un género</div>
                <?php endif; ?>
            </div>

            <!-- Términos y Condiciones -->
            <div class="register-form-group">
                <div class="register-terms">
                    <input type="checkbox" id="terminos" name="terminos" <?php echo (isset($old['terminos']) && $old['terminos'] ? 'checked' : ''); ?>>
                    <label for="terminos">Acepto los términos y condiciones</label>
                </div>
                <?php if (!empty($errors['terminos'])): ?>
                    <div class="register-error-message" style="display: block;">
                        <?php echo htmlspecialchars($errors['terminos']); ?></div>
                <?php else: ?>
                    <div class="register-error-message" id="termsError">Debe aceptar los términos</div>
                <?php endif; ?>
            </div>

            <div class="register-form-group">
                <button class="register-submit-btn" type="submit">Registrarse</button>
            </div>
        </form>
    </div>

    <?= $footer ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registerForm');

            // Elementos del formulario
            const name = document.getElementById('name');
            const lastname = document.getElementById('lastname');
            const email = document.getElementById('email');
            const password = document.getElementById('contrasena');
            const confirmPassword = document.getElementById('confirmar_contrasena');
            const birthdate = document.getElementById('nacimiento');

            const terms = document.getElementById('terminos');

            // Elementos de error
            const nameError = document.getElementById('nameError');
            const lastnameError = document.getElementById('lastnameError');
            const emailError = document.getElementById('emailError');
            const emailExistsError = document.getElementById('emailExistsError');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const birthdateError = document.getElementById('birthdateError');
            const ageError = document.getElementById('ageError');
            const genderError = document.getElementById('genderError');

            const termsError = document.getElementById('termsError');

            // Elementos de fortaleza de contraseña
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            const passwordStrengthText = document.getElementById('passwordStrengthText');

            // Validación en tiempo real para nombre
            name.addEventListener('input', validateName);

            // Validación en tiempo real para apellido
            lastname.addEventListener('input', validateLastname);

            // Validación en tiempo real para email
            email.addEventListener('blur', validateEmail);

            // Validación en tiempo real para contraseña
            password.addEventListener('input', function () {
                validatePassword();
                updatePasswordStrength();
            });

            // Validación en tiempo real para confirmar contraseña
            confirmPassword.addEventListener('input', validateConfirmPassword);

            // Validación en tiempo real para fecha de nacimiento
            birthdate.addEventListener('change', validateBirthdate);

            // Validación al enviar el formulario
            form.addEventListener('submit', function (e) {
                let isValid = true;

                if (!validateName()) isValid = false;
                if (!validateLastname()) isValid = false;
                if (!validateEmail()) isValid = false;
                if (!validatePassword()) isValid = false;
                if (!validateConfirmPassword()) isValid = false;
                if (!validateBirthdate()) isValid = false;
                if (!validateGender()) isValid = false;

                if (!validateTerms()) isValid = false;

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Funciones de validación
            function validateName() {
                if (!name.value.trim()) {
                    showError(name, nameError, "El nombre es obligatorio");
                    return false;
                } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(name.value)) {
                    showError(name, nameError, "El nombre solo puede contener letras y espacios");
                    return false;
                } else {
                    hideError(name, nameError);
                    return true;
                }
            }

            function validateLastname() {
                if (!lastname.value.trim()) {
                    showError(lastname, lastnameError, "El apellido es obligatorio");
                    return false;
                } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(lastname.value)) {
                    showError(lastname, lastnameError, "El apellido solo puede contener letras y espacios");
                    return false;
                } else {
                    hideError(lastname, lastnameError);
                    return true;
                }
            }

            function validateEmail() {
                if (!email.value.trim()) {
                    showError(email, emailError, "El correo electrónico es obligatorio");
                    return false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                    showError(email, emailError, "Ingrese un correo electrónico válido");
                    return false;
                } else {
                    // Aquí iría la validación AJAX para verificar si el email existe
                    // Por ahora simulamos que está disponible
                    hideError(email, emailError);
                    hideError(email, emailExistsError);
                    return true;
                }
            }

            function validatePassword() {
                if (!password.value.trim()) {
                    showError(password, passwordError, "La contraseña es obligatoria");
                    return false;
                } else if (!/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(password.value)) {
                    showError(password, passwordError, "Debe tener 8+ caracteres, 1 mayúscula, 1 número y 1 carácter especial");
                    return false;
                } else {
                    hideError(password, passwordError);
                    return true;
                }
            }

            function validateConfirmPassword() {
                if (!confirmPassword.value.trim()) {
                    showError(confirmPassword, confirmPasswordError, "Confirme su contraseña");
                    return false;
                } else if (password.value !== confirmPassword.value) {
                    showError(confirmPassword, confirmPasswordError, "Las contraseñas no coinciden");
                    return false;
                } else {
                    hideError(confirmPassword, confirmPasswordError);
                    return true;
                }
            }

            function validateBirthdate() {
                if (!birthdate.value) {
                    showError(birthdate, birthdateError, "La fecha de nacimiento es obligatoria");
                    return false;
                } else if (!/^\d{4}-\d{2}-\d{2}$/.test(birthdate.value)) {
                    showError(birthdate, birthdateError, "Formato inválido (AAAA-MM-DD)");
                    return false;
                } else {
                    // Validar edad mínima (13 años)
                    const birthDate = new Date(birthdate.value);
                    const minAgeDate = new Date();
                    minAgeDate.setFullYear(minAgeDate.getFullYear() - 13);

                    if (birthDate > minAgeDate) {
                        showError(birthdate, ageError, "Debes tener al menos 13 años para registrarte");
                        return false;
                    } else {
                        hideError(birthdate, birthdateError);
                        hideError(birthdate, ageError);
                        return true;
                    }
                }
            }

            function validateGender() {
                const gender = document.querySelector('input[name="genero"]:checked');
                if (!gender) {
                    genderError.style.display = 'block';
                    return false;
                } else {
                    genderError.style.display = 'none';
                    return true;
                }
            }



            function validateTerms() {
                if (!terms.checked) {
                    termsError.style.display = 'block';
                    return false;
                } else {
                    termsError.style.display = 'none';
                    return true;
                }
            }

            function updatePasswordStrength() {
                const strength = calculatePasswordStrength(password.value);
                passwordStrengthBar.style.width = strength.percentage + '%';
                passwordStrengthBar.style.backgroundColor = strength.color;
                passwordStrengthText.textContent = "Seguridad: " + strength.text;
                passwordStrengthText.style.color = strength.color;
            }

            function calculatePasswordStrength(pass) {
                let score = 0;

                // Longitud
                if (pass.length >= 8) score += 1;
                if (pass.length >= 12) score += 1;

                // Complejidad
                if (/[A-Z]/.test(pass)) score += 1;
                if (/\d/.test(pass)) score += 1;
                if (/[\W_]/.test(pass)) score += 1;

                // Determinar fortaleza
                if (score <= 2) {
                    return { percentage: 25, color: '#dc3545', text: 'Débil' };
                } else if (score <= 4) {
                    return { percentage: 50, color: '#fd7e14', text: 'Moderada' };
                } else if (score <= 5) {
                    return { percentage: 75, color: '#ffc107', text: 'Fuerte' };
                } else {
                    return { percentage: 100, color: '#28a745', text: 'Muy fuerte' };
                }
            }

            function showError(input, errorElement, message) {
                input.classList.add('register-input-error');
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }

            function hideError(input, errorElement) {
                input.classList.remove('register-input-error');
                errorElement.style.display = 'none';
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
</body>

</html>