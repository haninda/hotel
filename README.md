**SETIAP UPLOAD FILE ISI BAGIAN ISSUESS KASI KETERANGANNYA**

Berikut adalah alur pembuatan website untuk manajemen hotel yang mencakup halaman-halaman utama serta interaksi antara halaman-halaman tersebut:
### index.php
1. **Tampil Rooms** **DONE**
   - Halaman utama yang menampilkan daftar kamar yang tersedia beserta informasi singkat seperti jenis kamar, harga, ketersediaan, dan deskripsi.
   - Setiap kamar memiliki tombol atau tautan untuk melakukan pemesanan.

2. **Booking**
   - Pengguna memilih kamar yang ingin dipesan.
   - Pengguna diarahkan ke halaman `booking.php` dengan mengirimkan `room_id` sebagai parameter.

### rooms.php
1. **Tampil Rooms** **DONE**
   - Halaman untuk menampilkan semua kamar yang tersedia dengan informasi yang sama seperti `index.php`.
   - Pengguna bisa memilih kamar untuk melakukan pemesanan.

2. **Pilih Room**
   - Pengguna memilih kamar yang ingin dipesan.
   - Pengguna diarahkan ke halaman `booking.php` dengan mengirimkan `room_id` sebagai parameter.

### booking.php
1. **Isi Data Booking**
   - Form untuk mengisi data pemesanan, seperti tanggal check-in, tanggal check-out, jumlah orang dewasa dan anak-anak, serta permintaan khusus.
   - Setelah pengguna mengisi dan mengirimkan form, data booking dimasukkan ke dalam tabel `bookings`.
   - Pengguna diarahkan ke halaman `payment.php` dengan mengirimkan `booking_id` sebagai parameter.

### payment.php
1. **Tampilin Detail Booking**
   - Halaman untuk menampilkan rincian pemesanan yang sudah dilakukan, seperti informasi kamar, tanggal check-in dan check-out, jumlah tamu, dan permintaan khusus.
   - Juga menampilkan form untuk mengisi data pembayaran, seperti jumlah pembayaran dan metode pembayaran.
   - Setelah pengguna mengisi dan mengirimkan form pembayaran, data transaksi dimasukkan ke dalam tabel `transactions` dan data pembayaran dimasukkan ke dalam tabel `payments`.
   - Pengguna diarahkan ke halaman `detail_booking.php` dengan mengirimkan `booking_id` sebagai parameter.

### detail_booking.php
1. **Detail Booking**
   - Halaman untuk menampilkan detail lengkap dari pemesanan yang sudah dilakukan, termasuk informasi kamar, tanggal check-in dan check-out, jumlah tamu, permintaan khusus, rincian pembayaran, dan status pembayaran.
   - Memberikan konfirmasi kepada pengguna tentang keberhasilan pemesanan dan pembayaran.

Untuk menambahkan halaman `profile.php` dalam alur pembuatan website hotel, berikut adalah rinciannya:

### profile.php
1. **Detail Data Pengguna**
   - Halaman ini akan menampilkan informasi detail tentang pengguna, seperti nama, email, nomor telepon, dan mungkin informasi tambahan tergantung pada kebutuhan bisnis Anda.
   - Informasi ini dapat diambil dari tabel `guests` berdasarkan `guest_id` yang tersimpan dalam `$_SESSION`.

2. **Edit Data Pengguna**
   - Menyediakan form untuk mengubah informasi pengguna seperti nama, email, dan nomor telepon.
   - Form ini akan mengirimkan data yang diperbarui ke halaman `process_profile.php` untuk diproses.

3. **Link Detail Booking**
   - Menampilkan daftar pemesanan yang dilakukan oleh pengguna berdasarkan `guest_id`.
   - Setiap pemesanan akan memiliki tautan ke halaman `detail_booking.php` dengan menyertakan `booking_id` sebagai parameter untuk melihat rincian pemesanan tersebut.
  
Kalau belum sign in g bisa booking
### sign_up.php dan process_sign_up.php **DONE**
