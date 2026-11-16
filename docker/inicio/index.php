<?php
// Índice de proyectos: lista las carpetas de www/ que tienen public/
$base = '/var/www/html';
$proyectos = array_values(array_filter(
    scandir($base),
    fn ($d) => $d[0] !== '.' && is_dir("$base/$d/public")
));
$puerto = $_SERVER['SERVER_PORT'] === '80' ? '8083' : $_SERVER['SERVER_PORT'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Proyectos Laravel</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 640px; margin: 40px auto; padding: 0 16px; }
        li { margin: 8px 0; }
        code { background: #eee; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Proyectos en el servidor</h1>
    <?php if (!$proyectos): ?>
        <p>No hay proyectos todavía. Crea uno en <code>www/</code>.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($proyectos as $p): $p = htmlspecialchars($p); ?>
            <li><a href="http://<?= $p ?>.localhost:<?= $puerto ?>"><?= $p ?></a></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <p>PHP <?= PHP_VERSION ?> · pgAdmin: <a href="http://localhost:8087">localhost:8087</a></p>
</body>
</html>