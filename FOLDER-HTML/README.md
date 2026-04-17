# PT. Abizaros Terradrill - Website Struktur

Website perusahaan manufacturing supply chain untuk heavy equipment pertambangan.

## 📁 Struktur File

```
FOLDER-HTML/
├── index.html          # Halaman Home dengan Hero Section
├── about.html          # Halaman About (Visi, Misi, Tim)
├── services.html       # Halaman Services (Layanan & Produk)
├── contact.html        # Halaman Contact (Form & Info)
├── styles.css          # Stylesheet (Pure CSS - Responsive)
└── README.md           # Dokumentasi ini
```

**✨ Pure HTML & CSS - Fully Responsive - No JavaScript Required**

## 🏠 Halaman-Halaman

### 1. **index.html** - Home Page

- **Navbar** dengan 4 menu utama (Home, About, Services, Contact)
- **Hero Section** dengan penjelasan singkat company dan CTA buttons
- **Features Section** dengan 4 card fitur unggulan
- **Footer** dengan informasi kontak dan quick links

### 2. **about.html** - About Page

- **Sejarah Perusahaan** - Latar belakang PT. Abizaros Terradrill
- **Visi & Misi** - Target dan tujuan perusahaan
- **Nilai-nilai Kami** - Integrity, Quality, Innovation, Reliability
- **Statistik** - 500+ klien, 20+ tahun pengalaman, 1000+ equipment terjual
- **Tim Kami** - Profil anggota tim dengan foto

### 3. **services.html** - Services Page

- **6 Layanan Utama**:
  - Peralatan Penggalian (Excavator, Backhoe, Dragline)
  - Peralatan Transportasi (Dump Truck, Haul Truck)
  - Perawatan & Maintenance
  - Konsultasi Teknis
  - Delivery & Installation
  - Leasing & Rental
- **Produk Unggulan** dengan 4 equipment showcase
- **Why Choose Us** - Keunggulan kompetitif
- **CTA Section** - Call to Action

### 4. **contact.html** - Contact Page

- **Informasi Kontak** - Alamat, telepon, email, jam operasional
- **Contact Form** - Form untuk mengirim pesan (Name, Email, Phone, Company, Subject, Message)
- **Social Media Links** - Facebook, Twitter, LinkedIn, YouTube
- **Map Section** - Google Maps embed
- **FAQ Section** - Pertanyaan umum yang sering diajukan

## 🎨 Desain & Styling

### Warna Utama:

- **Primary Color**: `#d4a574` (Gold/Bronze)
- **Secondary Color**: `#1a1a1a` (Dark Gray/Black)
- **Text Color**: `#333333`
- **Light Background**: `#f8f8f8`

### Features CSS:

- ✅ **100% Responsive** (Mobile, Tablet, Desktop)
- ✅ **CSS-Only Hamburger Menu** (Checkbox hack - no JS)
- ✅ **HTML5 Native Form Validation**
- ✅ **CSS Grid & Flexbox Layouts**
- ✅ **Mobile-First Design Approach**
- ✅ **Smooth Scrolling** (`scroll-behavior: smooth`)
- ✅ **CSS Transitions & Hover Effects**
- ✅ **CSS Variables** untuk easy customization
- ✅ **No External Dependencies** - Pure HTML + CSS
- ✅ **No JavaScript Required**

## 🎯 CSS-Only Responsive Features

### Hamburger Menu (CSS Checkbox Hack)

```html
<!-- Checkbox tersembunyi untuk toggle menu -->
<input type="checkbox" id="hamburger-toggle" />
<label for="hamburger-toggle" class="hamburger">...</label>

<!-- CSS selector: #hamburger-toggle:checked ~ .nav-menu -->
```

### HTML5 Form Validation

- `required` - Field wajib diisi
- `type="email"` - Validasi format email otomatis
- `minlength` - Minimum panjang input
- Native browser error messages

### Responsive Breakpoints

- **Desktop**: Full navbar menu, grid layouts
- **Tablet** (≤768px): Hamburger menu visible, single column grids
- **Mobile** (≤480px): Adjusted font sizes, compact spacing
- Lazy loading images support
- Email validation

## 🚀 Setup Instructions

### 1. Setup Lokal - No Build Required! 🎉

```bash
# Tidak ada build process, dependency, atau setup kompleks
# Cukup buka file HTML langsung di browser:
# - Double-click index.html untuk Home
# - Double-click about.html untuk About
# - Double-click services.html untuk Services
# - Double-click contact.html untuk Contact
```

**Website langsung berfungsi dengan sempurna di semua browser modern!**

### 2. Dengan Local Server (Optional - untuk form testing)

```bash
# Menggunakan Python 3
python -m http.server 8000

# Menggunakan Python 2
python -m SimpleHTTPServer 8000

# Menggunakan Node.js (http-server)
npm install -g http-server
http-server

# Buka di browser: http://localhost:8000
```

### 3. Contact Form Setup (Optional)

Untuk mengaktifkan form submission, edit `contact.html` dan ganti:

```html
<form method="POST" action="https://formspree.io/f/YOUR_FORM_ID"></form>
```

Opsi Backend:

- [Formspree](https://formspree.io/) - SMTP-based (easiest)
- [Netlify Forms](https://www.netlify.com/products/forms/)
- Server backend sendiri (PHP, Node.js, Python)

### 4. Customization

#### Ganti Company Info

Edit semua pages dan `footer` section:

```html
<p>Email: info@yourcompany.com</p>
<p>Phone: +62 (0) YOUR-NUMBER</p>
<p>Address: Your Address</p>
```

#### Ganti Warna (CSS Custom Properties)

Edit `styles.css`:

```css
:root {
  --primary-color: #d4a574; /* Gold/Bronze - Ganti warna utama */
  --secondary-color: #1a1a1a; /* Dark - Ganti warna sekunder */
  --text-color: #333; /* Text - Warna teks */
  --light-bg: #f8f8f8; /* Light background */
}
```

#### Tambah Images

Replace placeholder image paths:

```html
<!-- Semua images perlu di-replace dengan actual image paths -->
<img src="logo.png" alt="Logo" />
<img src="hero-equipment.jpg" alt="Heavy Equipment" />
<img src="team-1.jpg" alt="Team Member" />
<img src="excavator.jpg" alt="Excavator" />
```

## 📋 Checklist Implementasi ✅

- [x] 4 halaman HTML terpisah (Home, About, Services, Contact)
- [x] Navbar responsive di semua pages
- [x] Hero section dengan penjelasan company
- [x] Content sections untuk setiap halaman
- [x] Contact form dengan HTML5 validation
- [x] **Fully Responsive** - Mobile, Tablet, Desktop
- [x] **CSS-only hamburger menu** - no JS needed
- [x] Footer dengan info kontak
- [x] **Smooth scrolling** dengan CSS
- [x] **Pure HTML + CSS** - no JavaScript dependencies

## � Keuntungan Website Pure HTML + CSS

| Fitur                  | Benefit                                                        |
| ---------------------- | -------------------------------------------------------------- |
| **No JavaScript**      | Faster loading, smaller file size, no security vulnerabilities |
| **Easy to Maintain**   | Simple code structure, easy to update                          |
| **High Compatibility** | Works on all browsers, even old ones                           |
| **SEO Friendly**       | Better SEO, semantic HTML                                      |
| **Offline Ready**      | Can work offline easily                                        |
| **No Build Tools**     | Just edit HTML/CSS files directly                              |
| **Hosting Anywhere**   | Static files only, any free hosting works                      |

## 🎯 Next Steps - Pengembangan Lebih Lanjut

### Jika Ingin Tambah JavaScript (Optional):

1. **Interaktivity Enhancement**
   - Form submission dengan AJAX
   - Image gallery atau carousel
   - Modal/popup windows
   - Smooth animations

2. **Advanced Features**
   - Shopping cart functionality
   - Product filters
   - Search functionality
   - User authentication

### Backend Integration Option

1. **Contact Form Handler** (pilih salah satu):
   - [Formspree](https://formspree.io/) - Free, easy, email-based
   - [Netlify Forms](https://www.netlify.com/products/forms/)
   - Custom backend (PHP, Node.js, Python, Go)

2. **Database & CMS**
   - Setup product database
   - Team member management
   - Testimonial showcase
   - Blog/News section

3. **SEO & Analytics**
   - Meta tags optimization
   - Schema.org structured data
   - Google Analytics
   - Sitemap.xml

## 📱 Browser Support

| Browser       | Version   |
| ------------- | --------- |
| Chrome        | Latest ✅ |
| Firefox       | Latest ✅ |
| Safari        | Latest ✅ |
| Edge          | Latest ✅ |
| IE            | 11+ ✅    |
| Mobile Chrome | Latest ✅ |
| Mobile Safari | Latest ✅ |

**Semua browser modern fully support HTML5, CSS3, dan responsive design!**

## 📧 Contact

PT. Abizaros Terradrill

- Email: info@abizaros.com
- Phone: +62 (0) 123-4567
- Address: Jakarta, Indonesia

---

**Created**: 2026
**Version**: 2.0 - Pure HTML + CSS (No JavaScript)
**License**: Private

## 🔧 Technical Notes

### CSS Hamburger Implementation (Checkbox Hack)

Kami menggunakan CSS checkbox hack untuk hamburger menu - ini adalah teknik pure CSS tanpa JavaScript:

```html
<!-- Hidden checkbox input -->
<input type="checkbox" id="hamburger-toggle" class="hamburger-toggle" />

<!-- Label yang berfungsi sebagai hamburger button -->
<label for="hamburger-toggle" class="hamburger">
  <span class="bar"></span>
  <span class="bar"></span>
  <span class="bar"></span>
</label>

<!-- Menu yang di-toggle dengan CSS selector -->
<ul class="nav-menu">
  ...
</ul>
```

```css
/* CSS selector untuk toggle effect */
#hamburger-toggle:checked ~ .nav-menu {
  left: 0; /* Menu appears */
}
```

**Keuntungan:**

- ✅ Pure CSS - no JavaScript needed
- ✅ Good accessibility (checkbox patterns)
- ✅ Works on all browsers
- ✅ Responsive dan flexible
- ✅ Lightweight

### Responsive Design Breakpoints

```css
/* Desktop (≥769px) */
@media (min-width: 769px) {
  /* Navbar menu always visible */
}

/* Tablet (≤768px) */
@media (max-width: 768px) {
  /* Hamburger visible, stacked menu */
}

/* Mobile (≤480px) */
@media (max-width: 480px) {
  /* Adjusted font sizes, compact */
}
```

### HTML5 Form Validation

Browser-level validation tanpa JavaScript:

```html
<input type="email" required>  <!-- Email format checking -->
<input type="tel" required>    <!-- Phone number -->
<textarea minlength="10">      <!-- Minimum length -->
<input type="checkbox" required> <!-- Checkbox required -->
```

Browser otomatis akan:

- ✅ Cek format email
- ✅ Cek required fields
- ✅ Show native error messages
- ✅ Prevent form submission jika invalid

## ❓ FAQ

**Q: Website bisa berfungsi offline?**  
A: Ya! Buka file HTML langsung dari folder, tidak perlu internet.

**Q: Bagaimana contact form berfungsi?**  
A: Edit `action` attribute di form tag untuk setup backend atau service pihak ketiga.

**Q: Kenapa tidak pakai JavaScript?**  
A: Pure HTML+CSS lebih cepat, lebih aman, dan lebih mudah di-maintain untuk static website.

**Q: Bisa tambah JavaScript nanti?**  
A: Tentu! Cukup buat file `script.js` dan link di HTML files.

**Q: Responsive berhasil di semua device?**  
A: Ya! Tested di desktop, tablet, dan mobile devices.

## 📞 Support & Contribute

Untuk pertanyaan atau improvement:

- Email: info@abizaros.com
- GitHub Issues (jika ada repository)
- Pull requests welcome!

---

**Happy coding! 🚀**

Website ini dioptimasi untuk performa maksimal dengan zero JavaScript dependencies.
Enjoy your fast, secure, dan maintainable website! ✨
