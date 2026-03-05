# Dokumentasi Use Case - Sistem E-Commerce Jersey

Dokumen ini menjelaskan fungsionalitas sistem berdasarkan peran pengguna (Aktor). Sistem ini dirancang untuk menangani penjualan jersey, kustomisasi produk, hingga manajemen produksi dan laporan bagi owner.

## 1. Diagram Use Case (Mermaid)

```mermaid
flowchart LR

%% ACTORS
Customer([Customer])
Admin([Admin])
Produksi([Tim Produksi])
Owner([Owner])

%% SYSTEM
subgraph "Sistem E-Commerce Jersey"

%% CUSTOMER
UC1((Registrasi))
UC2((Login))
UC3((Kelola Profil))
UC4((Kelola Alamat))
UC5((Lihat Produk))
UC6((Custom Jersey))
UC7((Tambah ke Keranjang))
UC8((Checkout))
UC9((Upload Bukti Pembayaran))
UC10((Lihat Status Pesanan))
UC11((Lihat Invoice))
UC12((Ajukan Retur))
UC13((Lihat Notifikasi))

%% ADMIN
UA1((Kelola Produk))
UA2((Kelola Ukuran & Warna))
UA3((Kelola Order))
UA4((Verifikasi Pembayaran))
UA5((Generate Invoice))
UA6((Kelola Retur))
UA7((Kelola Status Pesanan))
UA8((Kelola Bahan Mentah))
UA9((Kelola Stok))
UA10((Kirim Notifikasi))

%% PRODUKSI
UP1((Lihat Order Produksi))
UP2((Update Status Produksi))
UP3((Input Penggunaan Bahan))
UP4((Update Log Produksi))

%% OWNER
UO1((Lihat Laporan Penjualan))
UO2((Lihat Laporan Produksi))
UO3((Lihat Laporan Stok))

end

%% RELATIONSHIPS
Customer --> UC1
Customer --> UC2
Customer --> UC3
Customer --> UC4
Customer --> UC5
Customer --> UC6
Customer --> UC7
Customer --> UC8
Customer --> UC9
Customer --> UC10
Customer --> UC11
Customer --> UC12
Customer --> UC13

Admin --> UA1
Admin --> UA2
Admin --> UA3
Admin --> UA4
Admin --> UA5
Admin --> UA6
Admin --> UA7
Admin --> UA8
Admin --> UA9
Admin --> UA10

Produksi --> UP1
Produksi --> UP2
Produksi --> UP3
Produksi --> UP4

Owner --> UO1
Owner --> UO2
Owner --> UO3