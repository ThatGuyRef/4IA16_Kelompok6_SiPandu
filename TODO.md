# TODO - Konversi Styling dari Tailwind CSS ke CSS Murni Laravel

## ✅ Selesai

### 1. CSS Files
- [x] `resources/css/app.css` - Diubah dari Tailwind directives ke CSS murni lengkap
  - Menghapus @tailwind base, components, utilities
  - Menambahkan CSS variables untuk colors, spacing, shadows, dll
  - Menambahkan reset & base styles
  - Menambahkan layout styles (app-container, nav, header, dll)
  - Menambahkan component styles (buttons, cards, tables, alerts)
  - Menambahkan utility classes
  - Menambahkan responsive breakpoints

### 2. Layout Files
- [x] `resources/views/layouts/app.blade.php` - Diubah class Tailwind ke CSS custom
  - `min-h-screen bg-gray-100` → `app-container`
  - `bg-white shadow` → `app-header`
  - `max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8` → `app-header-inner`
  - Menambahkan `app-main` class

- [x] `resources/views/layouts/navigation.blade.php` - Diubah class Tailwind ke CSS custom
  - `bg-white/60 backdrop-blur border-b border-gray-100` → `nav`
  - `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` → `nav-container`
  - `flex justify-between h-16` → `nav-wrapper`
  - Semua navigation classes diubah ke custom classes
  - Tetap menggunakan Alpine.js untuk interaktivitas

### 3. Component Files
- [x] `resources/views/components/nav-link.blade.php` - Disederhanakan
  - Menghapus semua Tailwind classes
  - Menggunakan `nav-link` dan `nav-link active`

- [x] `resources/views/components/responsive-nav-link.blade.php` - Disederhanakan
  - Menghapus semua Tailwind classes
  - Menggunakan `nav-link-responsive` dan `nav-link-responsive active`

- [x] `resources/views/components/dropdown-link.blade.php` - Disederhanakan
  - Menghapus semua Tailwind classes
  - Menggunakan `dropdown-link`

- [x] `resources/views/components/dropdown.blade.php` - Diubah ke CSS custom
  - Menghapus Tailwind classes
  - Menggunakan `dropdown`, `dropdown-menu`, `dropdown-menu-inner`
  - Tetap menggunakan Alpine.js untuk toggle functionality

### 4. View Files
- [x] `resources/views/dashboard.blade.php` - Diubah ke CSS custom
  - `py-4` → `dashboard-container`
  - `grid grid-cols-1 gap-6` → `dashboard-grid`
  - `p-6 bg-white border rounded` → `dashboard-welcome`
  - `flex items-center justify-between` → `dashboard-welcome-header`
  - Semua typography classes diubah ke custom classes

- [x] `resources/views/permohonan/warga/index.blade.php` - Diubah ke CSS custom
  - `py-12` → `dashboard-container`
  - `max-w-7xl mx-auto sm:px-6 lg:px-8` → `container`
  - `bg-white shadow-sm sm:rounded-lg p-6` → `card`

## 📋 Belum Dikerjakan (Opsional)

### File Views Lainnya
- [ ] `resources/views/permohonan/warga/create.blade.php`
- [ ] `resources/views/permohonan/admin/index.blade.php`
- [ ] `resources/views/permohonan/admin/show.blade.php`
- [ ] `resources/views/auth/register.blade.php`
- [ ] `resources/views/auth/verify-email.blade.php`
- [ ] `resources/views/auth/warga-login.blade.php`
- [ ] `resources/views/profile/edit.blade.php`
- [ ] `resources/views/layouts/guest.blade.php`

### Component Files Lainnya
- [ ] `resources/views/components/text-input.blade.php`
- [ ] `resources/views/components/input-label.blade.php`
- [ ] `resources/views/components/input-error.blade.php`
- [ ] `resources/views/components/primary-button.blade.php`
- [ ] `resources/views/components/secondary-button.blade.php`
- [ ] `resources/views/components/danger-button.blade.php`
- [ ] `resources/views/components/modal.blade.php`

### Admin Layout
- [ ] `resources/views/layouts/admin.blade.php`
- [ ] `resources/css/admin.css`

### Konfigurasi
- [ ] Hapus dependency Tailwind dari `package.json` (opsional)
- [ ] Update `vite.config.js` jika diperlukan (opsional)

## 📝 Catatan Penting

1. **Alpine.js Tetap Digunakan**: Sesuai permintaan, Alpine.js tidak diganti dengan vanilla JavaScript
2. **CSS Variables**: Menggunakan CSS custom properties untuk kemudahan maintenance
3. **Responsive Design**: Breakpoints tetap ada di CSS (@media queries)
4. **Compatibility**: Semua styling tetap kompatibel dengan struktur Laravel yang ada

## 🎯 Hasil yang Dicapai

- ✅ Dashboard sudah menggunakan CSS murni
- ✅ Navigation sudah menggunakan CSS murni
- ✅ Components utama sudah menggunakan CSS murni
- ✅ Layout utama sudah menggunakan CSS murni
- ✅ Tidak ada dependency Tailwind di file-file yang sudah diubah
- ✅ Alpine.js tetap digunakan untuk interaktivitas

## 🚀 Testing

Untuk menguji perubahan:
1. Jalankan `npm run dev` untuk compile CSS
2. Akses halaman dashboard
3. Test responsive design (mobile menu)
4. Test dropdown menu
5. Test navigation links
6. Pastikan semua styling terlihat konsisten

## 💡 Tips Maintenance

- Semua warna didefinisikan di CSS variables (`:root`)
- Spacing menggunakan CSS variables untuk konsistensi
- Shadows dan border-radius juga menggunakan variables
- Mudah untuk mengubah theme dengan mengubah CSS variables
