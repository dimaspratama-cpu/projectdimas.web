# Portofolio Web – Proyek UTS Pemrograman Web 1

- **Nama:** Dimas Pratama
- **NIM:** 202501151018
- **Dosen:** Rahmat Gunawan, M.Kom.
- **Tautan Vercel:** https://ISI-TAUTAN-VERCEL-KAMU.vercel.app

## Isi proyek

| Berkas | Fungsi |
|---|---|
| `index.html` | Halaman utama (header, nav, main, article, aside, footer) |
| `style.css` | Seluruh styling (flexbox + media query) |
| `search.php` | Pencarian dengan method **GET** + filter kategori + pagination |
| `kontak.php` | Formulir kontak dengan method **POST** + validasi + simpan ke `pesan.json` |
| `data.php` | Array artikel/proyek dan fungsi buatan sendiri |
| `header.php`, `nav.php`, `footer.php` | Template yang dipakai ulang lewat `require` |

## Menjalankan PHP secara lokal

Vercel hanya melayani berkas statis, jadi `search.php` dan `kontak.php` dijalankan lokal:

```
php -S localhost:8000
```

Lalu buka `http://localhost:8000/search.php` dan `http://localhost:8000/kontak.php`.

## Bukti demo PHP

- Tangkapan layar pencarian (GET): ISI-DI-SINI
- Tangkapan layar formulir kontak (POST): ISI-DI-SINI
- Tautan video demo (opsional): ISI-DI-SINI
