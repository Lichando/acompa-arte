<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= $title ?></title>

    <style>
        .login-body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-title {
            text-align: center;
            margin-top: 30px;
            color: #333;
            font-size: 2rem;
        }

        .login-form {
            max-width: 500px;
            margin: 30px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .login-form-group {
            margin-bottom: 20px;
        }

        .login-label {
            display: block;
            margin-bottom: 5px;
            color: #444;
            font-weight: 500;
        }

        .login-input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

        .login-input-error {
            border-color: #dc3545;
        }

        .login-error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .login-submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            width: 100%;
            transition: background-color 0.3s;
        }

        .login-submit-btn:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .login-general-error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8d7da;
            border-radius: 5px;
        }

        @media (max-width: 600px) {
            .login-form {
                padding: 20px;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body class="login-body">
    <?= $header ?>
    
    <div class="login-container">
        <h2 class="login-title">Iniciar Sesión</h2>

        <?php if (!empty($msgError)): ?>
            <div class="login-general-error"><?= $msgError ?></div>
        <?php endif; ?>

        <?php if (!empty($errors['general'])): ?>
            <div class="login-general-error"><?= $errors['general'] ?></div>
        <?php endif; ?>

        <form class="login-form" method="POST" action="">
            <!-- Email -->
            <div class="login-form-group">
                <label class="login-label" for="email">Email</label>
                <input class="login-input <?= !empty($errors['email']) ? 'login-input-error' : '' ?>" 
                       type="email" name="email" id="email" 
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" >
                <?php if (!empty($errors['email'])): ?>
                    <div class="login-error-message"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Contraseña -->
            <div class="login-form-group">
                <label class="login-label" for="contrasena">Contraseña</label>
                <input class="login-input <?= !empty($errors['contrasena']) ? 'login-input-error' : '' ?>" 
                       type="password" name="contrasena" id="contrasena" >
                <?php if (!empty($errors['contrasena'])): ?>
                    <div class="login-error-message"><?= $errors['contrasena'] ?></div>
                <?php endif; ?>
            </div>

            <div class="login-form-group">
                <button class="login-submit-btn" type="submit">Ingresar</button>
            </div>

            <div class="login-link">
                ¿No tienes cuenta? <a href="register">Regístrate aquí</a>
            </div>
        </form>
    </div>

    <?= $footer ?>
</body>

</html>