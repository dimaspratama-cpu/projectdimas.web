<?php
require __DIR__ . '/data.php'; // memakai fungsi e() untuk htmlspecialchars

$errors = [];
$sukses = false;
$tersimpan = false;
$nama = $email = $telepon = $pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = (isset($_POST['nama'])    && is_string($_POST['nama']))    ? trim($_POST['nama'])    : '';
    $email   = (isset($_POST['email'])   && is_string($_POST['email']))   ? trim($_POST['email'])   : '';
    $telepon = (isset($_POST['telepon']) && is_string($_POST['telepon'])) ? trim($_POST['telepon']) : '';
    $pesan   = (isset($_POST['pesan'])   && is_string($_POST['pesan']))   ? trim($_POST['pesan'])   : '';

    // Validasi
    if (empty($nama)) {
        $errors[] = 'Nama wajib diisi.';
    } elseif (strlen($nama) < 2 || strlen($nama) > 100) {
        $errors[] = 'Nama harus 2 sampai 100 karakter.';
    }

    if (empty($email)) {
        $errors[] = 'Email wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid. Contoh: nama@domain.com.';
    }

    if (empty($telepon)) {
        $errors[] = 'Nomor telepon wajib diisi.';
    } else {
        // Hapus spasi dan tanda hubung sebelum dicek, lalu cocokkan dengan format nomor HP Indonesia.
        $telepon_bersih = preg_replace('/[\s\-]/', '', $telepon);
        if (!preg_match('/^(\+62|62|0)8[0-9]{8,11}$/', $telepon_bersih)) {
            $errors[] = 'Nomor telepon tidak valid. Contoh: 081234567890 atau +6281234567890.';
        }
    }

    if (empty($pesan)) {
        $errors[] = 'Pesan wajib diisi.';
    } elseif (strlen($pesan) < 10) {
        $errors[] = 'Pesan terlalu pendek. Tulis minimal 10 karakter.';
    } elseif (strlen($pesan) > 1000) {
        $errors[] = 'Pesan terlalu panjang. Maksimal 1000 karakter.';
    }

    if (empty($errors)) {
        $sukses = true;

        $berkas = __DIR__ . '/pesan.json';
        $isi    = [];
        if (is_file($berkas)) {
            $dibaca = json_decode((string) file_get_contents($berkas), true);
            if (is_array($dibaca)) {
                $isi = $dibaca;
            }
        }
        $isi[] = [
            'waktu'   => date('Y-m-d H:i:s'),
            'nama'    => $nama,
            'email'   => $email,
            'telepon' => $telepon,
            'pesan'   => $pesan,
        ];
        $tersimpan = file_put_contents(
            $berkas,
            json_encode($isi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        ) !== false;
    }
}

$judul_halaman = 'Kontak';
require __DIR__ . '/header.php';
?>

    <main class="page container">
        <h1>Hubungi saya</h1>
        <p class="page-intro">Isi formulir di bawah. Semua kolom wajib diisi.</p>

        <?php if ($sukses): ?>
            <div class="alert alert-success" role="status">
                Terima kasih, <?= e($nama) ?>. Pesanmu sudah diterima.
                <?php if (!$tersimpan): ?>
                    (Pesan belum bisa disimpan ke berkas karena folder tidak dapat ditulis.)
                <?php endif; ?>
            </div>

            <div class="result-box">
                <h2>Pesan yang kamu kirim</h2>
                <dl>
                    <dt>Nama</dt>
                    <dd><?= e($nama) ?></dd>
                    <dt>Email</dt>
                    <dd><?= e($email) ?></dd>
                    <dt>Nomor telepon</dt>
                    <dd><?= e($telepon) ?></dd>
                    <dt>Pesan</dt>
                    <dd><?= e($pesan) ?></dd>
                </dl>
                <p class="btn-row"><a href="kontak.php" class="btn btn-outline">Kirim pesan lain</a></p>
            </div>

        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    Pesan belum terkirim. Perbaiki hal berikut:
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="form-box" method="post" action="kontak.php" novalidate>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" maxlength="100">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= e($email) ?>">
                </div>

                <div class="form-group">
                    <label for="telepon">Nomor telepon</label>
                    <input type="tel" id="telepon" name="telepon" value="<?= e($telepon) ?>"
                           placeholder="Contoh: 081234567890" maxlength="20">
                </div>

                <div class="form-group">
                    <label for="pesan">Pesan</label>
                    <textarea id="pesan" name="pesan" maxlength="1000"><?= e($pesan) ?></textarea>
                </div>

                <button type="submit" class="btn">Kirim pesan</button>
            </form>
        <?php endif; ?>
    </main>

<?php require __DIR__ . '/footer.php'; ?>