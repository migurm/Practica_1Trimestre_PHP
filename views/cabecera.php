<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (basename($_SERVER['PHP_SELF']) !== 'principal.php'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="principal.php">Principal</a>
                </li>
            <?php endif; ?>

            <?php if (basename($_SERVER['PHP_SELF']) !== 'registro.php'): ?>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'usuarios.php') ? 'active' : ''; ?> ">
                    <a class="nav-link" href="registro.php">Regístrate</a>
                </li>
            <?php endif; ?>

            <?php if (basename($_SERVER['PHP_SELF']) !== 'login.php'): ?>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'login.php') ? 'active' : ''; ?> ">
                    <a class="nav-link" href="login.php">Inicia sesión</a>
                </li>
            <?php endif; ?>

            <!-- Puedes agregar más enlaces aquí según sea necesario -->
        </ul>
    </div>
</nav>