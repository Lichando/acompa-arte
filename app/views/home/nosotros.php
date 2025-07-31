<!DOCTYPE html>
<html lang="es">

<head>
    <?= $head ?>
    <title><?= $title ?></title>

    <style>

    </style>
</head>

<body>
    <?= $header ?>
    <section class="somos-section">
        <div class="somos-container">
            <h1 class="somos-title">¿Quienes somos?</h1>
            <p class="somos-text">Somos una entiedad que se encarga de facilitar la busqueda de acompañantes terapéutico
                para chicos en las instituciones de gestion privada y publica. Creemos que una sociedad
                mas justa se construye desde la unidad entre seres humanos y que todos debemos tener
                acceso a una niñez digna independiente de una patologia o condicion.
            </p>
        </div>
        <div class="somos-container">
            <h2 class="somos-subtitle">¿A que a puntamos?</h2>
            <p class="somos-text">Apuntamos a facilitar a las familias que tengan hijos con alguna patologia que le
                dificulte el aprendizaje o el vinculo en sociedad con otras personas para que puedan
                tener un acompañante terapéutico de manera rapida.
            </p>
            <p class="somos-text">
                Esto lo definimos con el fin de que muchas instituciones a la hora de buscar un acompañante
                terapéutico este proceso suele demorar semanas debido a la burocracia estatal y la cantidad
                de tramites que conlleva para las instituciones buscar uno.
            </p>
            <p class="somos-text">En este proyecto tomamos como pilar a las familias y a los acompañantes terapéuticos
                que van a poder
                realizar en caracter de pasantes o ejercer su profesion de manera directa, bajo los estatutos de la ley,
                de manera completamente agil sin tener que someterse a una lista de espera.
            </p>
        </div>
    </section>

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