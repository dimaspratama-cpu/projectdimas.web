<?php
// Template bagian atas halaman PHP. Set $judul_halaman sebelum memanggil file ini.
$judul_halaman = $judul_halaman ?? 'Portofolio';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($judul_halaman, ENT_QUOTES, 'UTF-8') ?> | Dimas Pratama</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="header">
        <?php require __DIR__ . '/nav.php'; ?>
    </header>
