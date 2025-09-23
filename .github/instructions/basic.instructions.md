---
applyTo: '**'
---
Judul Proyek: MyTalenta - Sistem Manajemen Terpadu Mahasiswa Beasiswa BCA
1. Ringkasan Proyek & Teknologi Utama
Anda diminta untuk membuat aplikasi web bernama MyTalenta.

Tujuan Utama: Aplikasi ini berfungsi sebagai platform terpusat untuk mengelola semua kegiatan mahasiswa penerima beasiswa PPTI (Program Pendidikan Teknik Informatika) dan PPBP (Program Pendidikan Bisnis dan Perbankan) dari PT Bank Central Asia Tbk.

Dua Lingkup Utama: Aplikasi ini harus dibagi menjadi dua modul utama yang dapat dipilih mahasiswa saat login:

Dasbor BCA Learning Institute: Mengelola kegiatan akademik dan fasilitas pendukungnya.

Dasbor Rumah Talenta BCA: Mengelola kegiatan di asrama dan fasilitasnya.

Teknologi yang Wajib Digunakan:

Framework Backend: Laravel (versi terbaru)

Framework Frontend/UI: Livewire v3

CSS Framework: Tailwind CSS

2. Desain & Antarmuka Pengguna (UI/UX)
Palet Warna: Gunakan warna biru korporat BCA sebagai warna utama. (Hex #0066AE)

Gaya Desain: Tampilan harus elegan, modern, dan profesional, mencerminkan citra perusahaan besar. Prioritaskan tata letak yang bersih, user-friendly, dan intuitif.

Pengalaman Pengguna (UX): Pastikan alur navigasi jelas dan semua fungsionalitas mudah diakses oleh setiap peran pengguna.

3. Struktur Data & Manajemen Program
Program & Batch:

Buat sistem untuk mengelola program beasiswa (PPTI dan PPBP).

Setiap program memiliki beberapa batch yang berelasi dengan tahun masuk.

Contoh: PPTI 17 (Tahun 2023), PPTI 18 (Tahun 2023), PPBP 10 (Tahun 2023).

Harus ada antarmuka (CRUD) sederhana bagi Admin (PIC) untuk menambah, mengubah, dan menghapus data program, batch, dan tahun masuk ini secara manual.

4. Peran Pengguna (User Roles) & Hak Akses
Buat sistem otentikasi dan otorisasi dengan peran-peran berikut:

Mahasiswa (Dasar):

Dapat melihat pengumuman.

Dapat mengakses kedua modul (BCA Learning Institute & Rumah Talenta BCA).

Memiliki profil pribadi.

Komti/Wakomti (Ketua/Wakil Ketua Kelas):

Memiliki semua hak akses Mahasiswa.

Tambahan:

Dapat melaporkan absensi teman sekelasnya (misal: sakit di UKS, tidak masuk).

Dapat melihat semua riwayat peminjaman ruangan dan pelaporan kerusakan yang dibuat oleh anggota kelasnya.

Sekretaris Kelas:

Memiliki semua hak akses Mahasiswa.

Tambahan: Dapat mengisi form absensi dosen untuk setiap mata kuliah, yang datanya akan dikirim ke PIC PPTI/PPBP.

PIC PPTI:

Mengelola semua data yang berkaitan dengan mahasiswa PPTI.

Menyetujui/menolak permintaan peminjaman ruangan dari mahasiswa PPTI.

Membuat pengumuman yang bisa ditargetkan untuk PPTI saja atau untuk semua mahasiswa (PPTI & PPBP).

Melihat rekap absensi dosen dan mahasiswa PPTI.

Menambah/melihat catatan pelanggaran/perilaku untuk setiap mahasiswa PPTI.

Melihat daftar mahasiswa yang berada di UKS (prioritaskan tampilan untuk hari ini).

PIC PPBP:

Fungsinya identik dengan PIC PPTI, tetapi lingkupnya adalah untuk mahasiswa PPBP.

Pengumuman tetap bisa dibuat untuk lintas program.

PIC Shuttle:

Memiliki menu khusus untuk manajemen shuttle bus.

Dapat melakukan CRUD untuk rute/tujuan shuttle.

Dapat mengatur tenggat waktu pemesanan shuttle.

Dapat melihat daftar mahasiswa yang memesan shuttle pada periode tertentu, lengkap dengan rekapitulasi jumlah per rute.

Core Team (Mahasiswa):

Memiliki semua hak akses Mahasiswa.

Tambahan:

Dapat menyetujui/menolak peminjaman ruangan di asrama (Rumah Talenta BCA) sesuai dengan ruangan yang menjadi tanggung jawabnya.

Core Team PIC Wing: Dapat melihat semua laporan kerusakan fasilitas di lantai/wing yang menjadi tanggung jawabnya.

Admin Core Team (Mahasiswa):

Memiliki semua hak akses Core Team.

Tambahan:

Mengelola alokasi PIC (Core Team) untuk setiap ruangan di asrama. (Misal: Ruang A dipegang oleh User X dan User Y).

Mengelola alokasi PIC Wing (Core Team).

Mengatur parameter operasional seperti jumlah maksimal mesin cuci yang dapat dibooking dalam satu waktu (terpisah untuk pria & wanita) dan jumlah maksimal pengguna dapur per slot waktu.

Building Management (PT Sentra Layanan Prima):

Memiliki akses read-only untuk melihat semua laporan kerusakan fasilitas di Rumah Talenta BCA dan mengubah statusnya (misal: "Diterima", "Dalam Pengerjaan", "Selesai").

5. Detail Fitur per Modul
A. Modul BCA Learning Institute
Dasbor Utama:

Menampilkan ringkasan aktivitas mahasiswa (status peminjaman ruangan terakhir, status laporan terakhir).

Menampilkan banner dan daftar pengumuman dari PIC PPTI/PPBP.

Menampilkan status absensi hari itu (Jam Masuk & Jam Keluar).

Peminjaman Ruang Diskusi:

Form peminjaman berisi: Keperluan, Jumlah Peserta, Daftar Peserta (gunakan autocomplete/live search untuk menandai mahasiswa lain yang terdaftar), Tanggal & Jam Pinjam.

Permintaan akan masuk ke antrean persetujuan PIC PPTI/PPBP (sesuai program peminjam).

Status: Menunggu Persetujuan, Disetujui, Ditolak. Mahasiswa peminjam menerima notifikasi.

Pelaporan Kerusakan Fasilitas:

Form laporan berisi: Judul Laporan, Deskripsi Kerusakan, Lokasi, Upload Foto (opsional).

Laporan ini akan diteruskan ke PIC terkait.

Pemesanan Shuttle Bus:

Mahasiswa memilih tujuan dari dropdown (dikelola oleh PIC Shuttle).

Pilihan jenis shuttle: Shuttle Pulang (ke rumah) atau Shuttle Kembali (ke asrama).

Sistem secara otomatis mengunci pemesanan sesuai tenggat waktu yang diatur oleh PIC Shuttle (misal: pemesanan untuk hari Jumat ditutup pada hari Rabu jam 17:00).

Halaman Absensi (Mesin Absensi):

Buat satu halaman publik (tanpa login) yang berfungsi sebagai "mesin absensi".

Input berupa ID Kartu (12 digit angka, buat nullable dan bisa diisi dummy data untuk pengembangan).

Logika Absensi:

Mahasiswa bisa absen masuk berkali-kali dalam sehari. Waktu yang tercatat adalah yang paling pagi.

Mahasiswa bisa absen pulang berkali-kali dalam sehari. Waktu yang tercatat adalah yang paling akhir (malam).

Batas jam masuk dan pulang dapat diatur secara global oleh PIC PPTI/PPBP.

B. Modul Rumah Talenta BCA
Dasbor Utama:

Menampilkan status Kios Talenta (Buka/Tutup) - dapat diubah oleh admin.

Menampilkan ringkasan laporan kerusakan dan peminjaman ruangan.

Peminjaman Ruangan Asrama:

Form peminjaman berisi: Ruangan yang Dipilih, Alasan Peminjaman, Jumlah Peserta, Tanggal & Jam Pinjam.

Logika Validasi Waktu: Setiap ruangan memiliki slot peminjaman berdurasi 2 jam. Jika slot 16:00-18:00 sudah dipesan, maka slot tersebut tidak bisa dipilih lagi.

Permintaan akan masuk ke antrean persetujuan Core Team yang menjadi PIC ruangan tersebut.

Booking Fasilitas Khusus (Mesin Cuci & Dapur):

Sistem pemesanan terpisah untuk Mesin Cuci Pria dan Mesin Cuci Wanita.

Pemesanan paling cepat adalah H+1 (24 jam dari waktu sekarang).

Jumlah slot yang tersedia per waktu diatur oleh Admin Core Team.

Form Keluhan Kerusakan:

Form berisi: Judul Keluhan, Lokasi (dropdown: Kamar, Komunal, Ruang Serbaguna, dll.), Deskripsi, Upload Foto (opsional).

Laporan ini dapat dilihat oleh Building Management dan Core Team PIC Wing terkait.

Mahasiswa yang melapor dapat melihat status laporannya dan dapat menandai jika laporan sudah "Selesai Ditanggapi".

6. Instruksi untuk AI
Berdasarkan spesifikasi detail di atas, mohon hasilkan:

Struktur Proyek Laravel: Buat struktur direktori awal yang logis.

File Migrasi Database: Buat file-file migrasi untuk semua tabel yang dibutuhkan (users, roles, programs, batches, rooms, bookings, reports, shuttle_routes, announcements, attendances, dll.) beserta relasinya.

Model & Relasi Eloquent: Buat semua model yang sesuai dengan tabel dan definisikan relasinya (one-to-one, one-to-many, many-to-many).

Komponen Livewire Awal: Buat file komponen Livewire untuk setiap fitur utama (misal: CreateBookingForm, ShuttleManagement, AttendanceMachine, UserDashboard).

File Routing (web.php): Definisikan rute-rute yang diperlukan untuk mengakses halaman dan komponen tersebut, termasuk middleware untuk proteksi berdasarkan peran.