<?php
// search.php - memproses method GET: mencari dan memfilter daftar artikel/proyek.
require __DIR__ . '/data.php';

const PER_HALAMAN = 3;

// Ambil input GET. Pastikan berupa string (bukan array) lalu rapikan dengan trim().
$kata     = (isset($_GET['q']) && is_string($_GET['q'])) ? trim($_GET['q']) : '';
$kategori = (isset($_GET['kategori']) && is_string($_GET['kategori'])) ? trim($_GET['kategori']) : '';

// Kategori hanya boleh salah satu dari daftar yang ada.
if (!empty($kategori) && !in_array($kategori, daftar_kategori($daftar_proyek), true)) {
    $kategori = '';
}

// Nomor halaman harus bilangan bulat >= 1.
$halaman = filter_var(
    $_GET['halaman'] ?? 1,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1, 'default' => 1]]
);

$sedang_mencari = !empty($kata) || !empty($kategori);
$hasil          = cari_proyek($daftar_proyek, $kata, $kategori);
$total          = count($hasil);
$total_halaman  = max(1, (int) ceil($total / PER_HALAMAN));
$halaman        = min($halaman, $total_halaman);
$tampil         = array_slice($hasil, ($halaman - 1) * PER_HALAMAN, PER_HALAMAN);

$judul_halaman = 'Cari Artikel dan Proyek';
require __DIR__ . '/header.php';
?>

    <main class="page container">
        <h1>Cari artikel dan proyek</h1>
        <p class="page-intro">Ketik kata kunci atau pilih kategori untuk menyaring daftar.</p>

        <form class="search-form" method="get" action="search.php">
            <input type="search" name="q" value="<?= e($kata) ?>"
                   placeholder="Contoh: PKL, flexbox, K3" aria-label="Kata kunci">

            <select name="kategori" aria-label="Kategori">
                <option value="">Semua kategori</option>
                <?php foreach (daftar_kategori($daftar_proyek) as $k): ?>
                    <option value="<?= e($k) ?>" <?= $k === $kategori ? 'selected' : '' ?>><?= e($k) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn">Cari</button>
        </form>

        <?php if ($sedang_mencari): ?>
            <p class="page-intro">
                <?= $total ?> hasil
                <?php if (!empty($kata)): ?>untuk kata kunci &ldquo;<?= e($kata) ?>&rdquo;<?php endif; ?>
                <?php if (!empty($kategori)): ?>dalam kategori <?= e($kategori) ?><?php endif; ?>.
            </p>
        <?php endif; ?>

        <?php if ($total === 0): ?>
            <div class="alert alert-info" role="status">
                Tidak ada artikel atau proyek yang cocok dengan pencarianmu.
                Coba kata kunci lain atau pilih &ldquo;Semua kategori&rdquo;.
            </div>
        <?php else: ?>
            <ul class="result-list">
                <?php foreach ($tampil as $item): ?>
                    <li class="result-item">
                        <h2><?= e($item['judul']) ?></h2>
                        <p class="meta"><?= e($item['kategori']) ?> &middot; <?= (int) $item['tahun'] ?></p>
                        <p><?= e($item['ringkasan']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if ($total_halaman > 1): ?>
                <nav class="pagination" aria-label="Halaman hasil">
                    <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                        <?php
                        $url = 'search.php?' . http_build_query([
                            'q' => $kata, 'kategori' => $kategori, 'halaman' => $i,
                        ]);
                        ?>
                        <?php if ($i === $halaman): ?>
                            <span class="aktif" aria-current="page"><?= $i ?></span>
                        <?php else: ?>
                            <a href="<?= e($url) ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </main>

<?php require __DIR__ . '/footer.php'; ?>
