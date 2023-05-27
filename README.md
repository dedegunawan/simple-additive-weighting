## Tutorial Lengkap Metode SAW

- [Contoh Metode SAW](https://veza.co.id/contoh-metode-saw/)

## Cara Install 

- Clone repository ini
- Pastikan php yang digunakan adalah php 8.0 atau php 7.3
- Jalankan perintah `composer install`
- Copy file `.env.example` ke `.env`
- Sesuaikan konfigurasi database pada file `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=nama_user_database_biasanya_root
DB_PASSWORD=password_db_nya_biasanya_kosong
```

- Jalankan perintah `php artisan migrate` untuk mengimport database
- Jalankan perintah `php artisan db:seed --class=DatabaseSeeder` untuk membuat user seed di database
- Jalankan perintah `php artisan key:generate` untuk membuat `APP:KEY`

## Default User
- Email : gunawan@dede.web.id
- Password : dedegunawan