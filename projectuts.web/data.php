<?php
// Data artikel dan proyek yang dipakai oleh search.php.
// Setiap item adalah array asosiatif.
$daftar_proyek = [
    [
        'judul'     => 'Pengalaman PKL sebagai Operator Produksi',
        'kategori'  => 'Artikel',
        'tahun'     => 2025,
        'ringkasan' => 'Cerita saya menjalani PKL di bagian produksi PT Kabel Indocitra Widhitama: bekerja sesuai SOP, menjaga kualitas, dan menerapkan K3.',
    ],
    [
        'judul'     => 'Mengenal Alur Produksi Kabel',
        'kategori'  => 'Artikel',
        'tahun'     => 2025,
        'ringkasan' => 'Gambaran umum alur produksi kabel dari bahan baku hingga pemeriksaan kualitas, berdasarkan pengamatan selama PKL.',
    ],
    [
        'judul'     => 'Pentingnya K3 di Area Produksi',
        'kategori'  => 'Artikel',
        'tahun'     => 2025,
        'ringkasan' => 'Catatan tentang keselamatan dan kesehatan kerja: memakai APD, mematuhi rambu, dan bekerja dengan hati-hati di dekat mesin.',
    ],
    [
        'judul'     => 'Website Portofolio UTS',
        'kategori'  => 'Proyek',
        'tahun'     => 2026,
        'ringkasan' => 'Website portofolio pribadi dengan HTML semantic, CSS flexbox, dan PHP dasar untuk pencarian serta formulir kontak.',
    ],
    [
        'judul'     => 'Belajar Layout Responsif dengan Flexbox',
        'kategori'  => 'Artikel',
        'tahun'     => 2026,
        'ringkasan' => 'Catatan belajar menyusun layout satu dan dua kolom yang menyesuaikan ukuran layar memakai flexbox dan media query.',
    ],
    [
        'judul'     => 'Formulir Kontak dengan PHP',
        'kategori'  => 'Proyek',
        'tahun'     => 2026,
        'ringkasan' => 'Formulir yang memproses data POST, memvalidasi email, mengamankan output, dan menyimpan pesan ke berkas JSON.',
    ],
    [
        'judul'     => 'Dari Operator Produksi ke Sistem Informasi',
        'kategori'  => 'Artikel',
        'tahun'     => 2026,
        'ringkasan' => 'Refleksi tentang bagaimana pengalaman di lantai produksi memengaruhi cara saya melihat sistem informasi.',
    ],
];

/**
 * Menyaring data berdasarkan kata kunci (judul atau ringkasan) dan kategori.
 * Kata kunci / kategori kosong berarti tidak disaring.
 */
function cari_proyek(array $data, string $kata, string $kategori): array
{
    $hasil = [];

    foreach ($data as $item) {
        $cocok_kata = ($kata === '')
            || stripos($item['judul'], $kata) !== false
            || stripos($item['ringkasan'], $kata) !== false;

        $cocok_kategori = ($kategori === '') || strcasecmp($item['kategori'], $kategori) === 0;

        if ($cocok_kata && $cocok_kategori) {
            $hasil[] = $item;
        }
    }

    return $hasil;
}

/** Daftar kategori unik untuk pilihan filter. */
function daftar_kategori(array $data): array
{
    $kategori = array_unique(array_column($data, 'kategori'));
    sort($kategori);
    return $kategori;
}

/** Mengamankan teks sebelum ditampilkan di HTML. */
function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}
