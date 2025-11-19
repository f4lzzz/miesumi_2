<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warung Mie Ayam - Menu Online</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #FEA116;
      --primary-dark: #e55a00;
      --secondary: #ffcc00;
      --accent: #28a745;
      --light: #F1F8FF;
      --dark: #0F172B;
      --gray: #6c757d;
      --shadow: 0 4px 12px rgba(0,0,0,0.1);
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f9f9f9 0%, #fff5e6 100%);
      color: var(--dark);
      line-height: 1.6;
      padding: 0;
      min-height: 100vh;
    }

    .header {
      background: linear-gradient(to right, var(--primary), var(--primary-dark));
      color: white;
      padding: 25px 0;
      text-align: center;
      box-shadow: var(--shadow);
      position: relative;
      overflow: hidden;
    }

    .header::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
      background-size: cover;
    }

    .judul {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
      position: relative;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
      font-weight: 300;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .slider-container {
      position: relative;
      margin: 30px auto;
      max-width: 95%;
    }

    .slider {
      display: flex;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      -webkit-overflow-scrolling: touch;
      gap: 20px;
      padding: 20px 10px;
      scroll-behavior: smooth;
      scrollbar-width: none;
    }

    .slider::-webkit-scrollbar {
      display: none;
    }

    .menu-item {
      flex: 0 0 auto;
      scroll-snap-align: start;
      width: 280px;
      background: white;
      border-radius: 12px;
      box-shadow: var(--shadow);
      padding: 20px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .menu-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .menu-item::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: var(--primary);
    }

    .menu-item img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
      transition: var(--transition);
    }

    .menu-item:hover img {
      transform: scale(1.05);
    }

    .menu-item label {
      display: block;
      margin: 10px 0 15px;
      font-weight: 600;
      font-size: 1.2rem;
      cursor: pointer;
      color: var(--dark);
    }

    .harga {
      color: var(--primary);
      font-size: 1.3rem;
      font-weight: 700;
      margin: 10px 0;
    }

    .nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: white;
      color: var(--primary);
      border: none;
      font-size: 24px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer;
      z-index: 10;
      box-shadow: var(--shadow);
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .nav:hover {
      background: var(--primary);
      color: white;
    }

    .left {
      left: -25px;
    }

    .right {
      right: -25px;
    }

    @media (max-width: 768px) {
      .nav {
        display: none;
      }
      
      .menu-item {
        width: 240px;
      }
      
      .cart-panel {
        width: 90% !important;
        right: 5% !important;
      }
    }

    .jumlah-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
      margin-top: 15px;
    }

    .jumlah-wrapper button {
      padding: 8px 14px;
      font-size: 18px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      transition: var(--transition);
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .jumlah-wrapper button:hover {
      background: var(--primary-dark);
      transform: scale(1.1);
    }

    .jumlah-wrapper button:disabled {
      background: var(--gray);
      cursor: not-allowed;
      transform: none;
    }

    .jumlah-wrapper .jumlah {
      font-size: 18px;
      font-weight: 600;
      min-width: 30px;
      text-align: center;
    }

    .output {
      margin: 30px auto;
      padding: 25px;
      background: white;
      border-radius: 12px;
      box-shadow: var(--shadow);
      max-width: 600px;
      text-align: left;
      display: none;
    }

    .output.show {
      display: block;
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .output h3 {
      color: var(--accent);
      margin-bottom: 15px;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .output h3 i {
      font-size: 1.3rem;
    }

    .output ul {
      list-style: none;
      margin-bottom: 20px;
    }

    .output li {
      padding: 10px 0;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
    }

    .output .total {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--primary);
      text-align: right;
      padding-top: 15px;
      border-top: 2px solid #eee;
    }

    .tombol-aksi {
      margin: 30px auto;
      display: flex;
      justify-content: center;
      gap: 15px;
      max-width: 600px;
    }

    .tombol-aksi button {
      padding: 12px 25px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      background: var(--gray);
      color: white;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .tombol-aksi button:hover {
      background: #5a6268;
      transform: translateY(-2px);
    }

    .footer {
      background: var(--dark);
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }

    .badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: var(--secondary);
      color: var(--dark);
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .loading {
      display: none;
      text-align: center;
      margin: 20px 0;
    }

    .loading-spinner {
      border: 4px solid rgba(255, 107, 0, 0.3);
      border-radius: 50%;
      border-top: 4px solid var(--primary);
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      background: var(--accent);
      color: white;
      padding: 15px 25px;
      border-radius: 8px;
      box-shadow: var(--shadow);
      z-index: 1000;
      display: none;
      animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    .cart-summary {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: var(--primary);
      color: white;
      padding: 15px 20px;
      border-radius: 50px;
      box-shadow: var(--shadow);
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      z-index: 100;
      transition: var(--transition);
    }

    .cart-summary:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(255, 107, 0, 0.4);
    }

    .cart-count {
      background: var(--secondary);
      color: var(--dark);
      border-radius: 50%;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      font-weight: 600;
    }

    /* Panel Keranjang */
    .cart-panel {
      position: fixed;
      top: 0;
      right: -400px;
      width: 380px;
      height: 100vh;
      background: white;
      box-shadow: -5px 0 15px rgba(0,0,0,0.1);
      z-index: 1000;
      transition: var(--transition);
      display: flex;
      flex-direction: column;
    }

    .cart-panel.open {
      right: 0;
    }

    .cart-header {
      background: var(--primary);
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .cart-header h3 {
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .close-cart {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .cart-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 0;
      border-bottom: 1px solid #eee;
    }

    .cart-item-info {
      flex: 1;
    }

    .cart-item-name {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .cart-item-price {
      color: var(--primary);
      font-weight: 600;
    }

    .cart-item-controls {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cart-item-controls button {
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .cart-item-quantity {
      font-weight: 600;
      min-width: 30px;
      text-align: center;
    }

    .cart-footer {
      padding: 20px;
      border-top: 2px solid #eee;
    }

    .cart-total {
      display: flex;
      justify-content: space-between;
      font-size: 1.2rem;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .cart-total-price {
      color: var(--primary);
    }

    .checkout-btn {
      width: 100%;
      padding: 15px;
      background: var(--accent);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
    }

    .checkout-btn:hover {
      background: #218838;
    }

    .empty-cart {
      text-align: center;
      padding: 40px 20px;
      color: var(--gray);
    }

    .empty-cart i {
      font-size: 3rem;
      margin-bottom: 15px;
      opacity: 0.5;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
      display: none;
    }

    .overlay.show {
      display: block;
    }

    /* Instruksi untuk pengguna */
    .instruksi {
      text-align: center;
      margin: 20px 0;
      color: var(--gray);
      font-style: italic;
    }

    /* Form Nama Pemesan */
    .nama-pemesan-form {
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
      background: #f8f9fa;
    }

    .form-group {
      margin-bottom: 0;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--dark);
      font-size: 0.9rem;
    }

    .form-input {
      width: 100%;
      padding: 12px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 1rem;
      transition: var(--transition);
    }

    .form-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
    }

    .form-input::placeholder {
      color: #adb5bd;
    }

    .customer-info {
      background: #f8f9fa;
      padding: 15px;
      margin: 10px 0;
      border-radius: 8px;
      border-left: 4px solid var(--primary);
    }

    .customer-name {
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1 class="judul">Daftar Menu</h1>
    <p class="subtitle">Mie Ayam Bu Suyatmi</p>
  </div>

  <div class="container">
    <div class="slider-container">
      <button class="nav left" onclick="geser(-1)">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="slider" id="slider">
        <div class="menu-item">
          <img src="https://via.placeholder.com/280x180?text=Mie+Ayam" alt="Mie Ayam">
          <label>Mie Ayam</label>
          <div class="harga">Rp12.000</div>
          <div class="jumlah-wrapper">
            <button class="btn-kurang" onclick="ubahJumlah(this, -1)" disabled>−</button>
            <span class="jumlah">0</span>
            <button class="btn-tambah" onclick="ubahJumlah(this, 1)">+</button>
          </div>
        </div>

        <div class="menu-item">
          <img src="https://via.placeholder.com/280x180?text=Mie+Ayam+Bakso" alt="Mie Ayam Bakso">
          <label>Mie Ayam Bakso</label>
          <div class="harga">Rp15.000</div>
          <div class="jumlah-wrapper">
            <button class="btn-kurang" onclick="ubahJumlah(this, -1)" disabled>−</button>
            <span class="jumlah">0</span>
            <button class="btn-tambah" onclick="ubahJumlah(this, 1)">+</button>
          </div>
        </div>

        <div class="menu-item">
          <div class="badge">Terlaris</div>
          <img src="https://via.placeholder.com/280x180?text=Mie+Ayam+Ceker" alt="Mie Ayam Ceker">
          <label>Mie Ayam Ceker</label>
          <div class="harga">Rp14.000</div>
          <div class="jumlah-wrapper">
            <button class="btn-kurang" onclick="ubahJumlah(this, -1)" disabled>−</button>
            <span class="jumlah">0</span>
            <button class="btn-tambah" onclick="ubahJumlah(this, 1)">+</button>
          </div>
        </div>

        <div class="menu-item">
          <div class="badge">Spesial</div>
          <img src="https://via.placeholder.com/280x180?text=Mie+Ayam+Spesial" alt="Mie Ayam Spesial">
          <label>Mie Ayam Spesial</label>
          <div class="harga">Rp17.000</div>
          <div class="jumlah-wrapper">
            <button class="btn-kurang" onclick="ubahJumlah(this, -1)" disabled>−</button>
            <span class="jumlah">0</span>
            <button class="btn-tambah" onclick="ubahJumlah(this, 1)">+</button>
          </div>
        </div>

        <div class="menu-item">
          <img src="https://via.placeholder.com/280x180?text=Es+Teh" alt="Es Teh">
          <label>Es Teh</label>
          <div class="harga">Rp5.000</div>
          <div class="jumlah-wrapper">
            <button class="btn-kurang" onclick="ubahJumlah(this, -1)" disabled>−</button>
            <span class="jumlah">0</span>
            <button class="btn-tambah" onclick="ubahJumlah(this, 1)">+</button>
          </div>
        </div>

        <div class="menu-item">
          <img src="https://via.placeholder.com/280x180?text=Es+Jeruk" alt="Es Jeruk">
          <label>Es Jeruk</label>
          <div class="harga">Rp6.000</div>
          <div class="jumlah-wrapper">
            <button class="btn-kurang" onclick="ubahJumlah(this, -1)" disabled>−</button>
            <span class="jumlah">0</span>
            <button class="btn-tambah" onclick="ubahJumlah(this, 1)">+</button>
          </div>
        </div>
      </div>
      <button class="nav right" onclick="geser(1)">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <p class="instruksi">Klik tombol + untuk menambahkan menu ke keranjang</p>

    <div class="loading">
      <div class="loading-spinner"></div>
      <p>Memproses pesanan...</p>
    </div>

    <div id="hasil" class="output">
      <h3><i class="fas fa-check-circle"></i> Pesanan Terkirim!</h3>
      <div class="customer-info" id="customer-info">
        <div class="customer-name" id="customer-name-display"></div>
        <div>Terima kasih atas pesanan Anda!</div>
      </div>
      <ul id="daftar-pesanan"></ul>
      <div class="total" id="total-harga"></div>
    </div>

    <div class="tombol-aksi">
      <button onclick="location.reload()">
        <i class="fas fa-redo"></i> Reload
      </button>
      <button onclick="history.back()">
        <i class="fas fa-arrow-left"></i> Kembali
      </button>
    </div>
  </div>

  <!-- Panel Keranjang -->
  <div class="cart-panel" id="cartPanel">
    <div class="cart-header">
      <h3><i class="fas fa-shopping-cart"></i> Keranjang Anda</h3>
      <button class="close-cart" onclick="closeCart()">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Form Nama Pemesan -->
    <div class="nama-pemesan-form">
      <div class="form-group">
        <label class="form-label" for="nama-pemesan">
          <i class="fas fa-user"></i> Nama Pemesan
        </label>
        <input type="text" class="form-input" id="nama-pemesan" placeholder="Masukkan nama Anda..." maxlength="50">
      </div>
    </div>
    
    <div class="cart-content" id="cartContent">
      <!-- Item keranjang akan dimasukkan di sini secara dinamis -->
    </div>
    <div class="cart-footer">
      <div class="cart-total">
        <span>Total:</span>
        <span class="cart-total-price" id="cartTotalPrice">Rp0</span>
      </div>
      <button class="checkout-btn" onclick="checkoutFromCart()">
        <i class="fas fa-check"></i> Pesan Sekarang
      </button>
    </div>
  </div>

  <!-- Overlay -->
  <div class="overlay" id="overlay" onclick="closeCart()"></div>

  <!-- Tombol Keranjang -->
  <div class="cart-summary" onclick="openCart()">
    <i class="fas fa-shopping-cart"></i>
    <span>Keranjang</span>
    <div class="cart-count" id="cartCount">0</div>
  </div>

  <div class="notification" id="notification">
    Pesanan berhasil ditambahkan!
  </div>

  <div class="footer">
    <p>Mie Ayam Bu Suyatmi &copy; 2025 - Semua Hak Dilindungi</p>
  </div>

  <script>
    const slider = document.getElementById("slider");
    const cartCount = document.getElementById("cartCount");
    const notification = document.getElementById("notification");
    const cartPanel = document.getElementById("cartPanel");
    const cartContent = document.getElementById("cartContent");
    const cartTotalPrice = document.getElementById("cartTotalPrice");
    const overlay = document.getElementById("overlay");
    const namaPemesanInput = document.getElementById("nama-pemesan");
    
    let cartItems = [];
    let customerName = "";

    // Fungsi geser slider
    function geser(arah) {
      slider.scrollBy({ left: arah * 300, behavior: 'smooth' });
    }

    // Fungsi untuk mendapatkan nama menu dari item
    function getNamaMenu(menuItem) {
      return menuItem.querySelector('label').textContent.trim();
    }

    // Fungsi untuk mendapatkan harga dari item
    function getHargaMenu(menuItem) {
      const hargaText = menuItem.querySelector('.harga').textContent;
      return parseInt(hargaText.replace('Rp', '').replace('.', ''));
    }

    // Fungsi tambah/kurang jumlah - LOGIKA BARU
    function ubahJumlah(button, delta) {
      const wrapper = button.parentElement;
      const jumlahSpan = wrapper.querySelector(".jumlah");
      const btnKurang = wrapper.querySelector(".btn-kurang");
      let jumlah = parseInt(jumlahSpan.innerText);
      
      // Cek apakah ini penambahan pertama (dari 0 ke 1)
      const isFirstAdd = jumlah === 0 && delta === 1;
      // Cek apakah ini penghapusan terakhir (dari 1 ke 0)
      const isLastRemove = jumlah === 1 && delta === -1;
      
      jumlah = Math.max(0, jumlah + delta);  // Minimal 0, bukan 1
      jumlahSpan.innerText = jumlah;
      
      // Update state tombol
      btnKurang.disabled = jumlah <= 0;
      
      const menuItem = wrapper.closest('.menu-item');
      const namaMenu = getNamaMenu(menuItem);
      
      // Jika item baru ditambahkan (dari 0 ke 1)
      if (isFirstAdd) {
        menuItem.style.boxShadow = '0 8px 20px rgba(255, 107, 0, 0.3)';
        showNotification(`${namaMenu} ditambahkan ke keranjang`);
      }
      
      // Jika item dihapus (dari 1 ke 0)
      if (isLastRemove) {
        menuItem.style.boxShadow = 'var(--shadow)';
        showNotification(`${namaMenu} dihapus dari keranjang`);
      }
      
      updateCart();
    }

    // Fungsi untuk membuka panel keranjang
    function openCart() {
      cartPanel.classList.add('open');
      overlay.classList.add('show');
      document.body.style.overflow = 'hidden';
      
      // Fokus ke input nama pemesan saat panel terbuka
      setTimeout(() => {
        namaPemesanInput.focus();
      }, 300);
    }

    // Fungsi untuk menutup panel keranjang
    function closeCart() {
      cartPanel.classList.remove('open');
      overlay.classList.remove('show');
      document.body.style.overflow = 'auto';
    }

    // Fungsi untuk memperbarui keranjang - LOGIKA BARU
    function updateCart() {
      const items = document.querySelectorAll(".menu-item");
      cartItems = [];
      let totalItems = 0;
      let totalPrice = 0;
      
      items.forEach(item => {
        const jumlah = parseInt(item.querySelector(".jumlah").innerText);
        
        // Hanya tambahkan ke keranjang jika jumlah > 0
        if (jumlah > 0) {
          const namaMenu = getNamaMenu(item);
          const harga = getHargaMenu(item);
          const subtotal = harga * jumlah;
          
          cartItems.push({
            nama: namaMenu,
            harga: harga,
            jumlah: jumlah,
            subtotal: subtotal
          });
          
          totalItems += jumlah;
          totalPrice += subtotal;
        }
      });
      
      // Update counter keranjang
      cartCount.textContent = totalItems;
      
      // Update konten keranjang
      renderCartItems();
      
      // Update total harga
      cartTotalPrice.textContent = `Rp${totalPrice.toLocaleString("id-ID")}`;
    }

    // Fungsi untuk merender item di keranjang
    function renderCartItems() {
      if (cartItems.length === 0) {
        cartContent.innerHTML = `
          <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Keranjang Anda masih kosong</p>
            <p>Klik tombol + pada menu untuk menambahkan</p>
          </div>
        `;
        return;
      }
      
      let cartHTML = '';
      cartItems.forEach((item, index) => {
        cartHTML += `
          <div class="cart-item">
            <div class="cart-item-info">
              <div class="cart-item-name">${item.nama}</div>
              <div class="cart-item-price">Rp${item.harga.toLocaleString("id-ID")}</div>
            </div>
            <div class="cart-item-controls">
              <button onclick="ubahItemJumlah(${index}, -1)">-</button>
              <span class="cart-item-quantity">${item.jumlah}</span>
              <button onclick="ubahItemJumlah(${index}, 1)">+</button>
            </div>
          </div>
        `;
      });
      
      cartContent.innerHTML = cartHTML;
    }

    // Fungsi untuk mengubah jumlah item di keranjang
    function ubahItemJumlah(index, delta) {
      const item = cartItems[index];
      item.jumlah = Math.max(0, item.jumlah + delta);
      item.subtotal = item.harga * item.jumlah;
      
      // Update juga di menu utama
      const menuItems = document.querySelectorAll('.menu-item');
      menuItems.forEach(menuItem => {
        if (getNamaMenu(menuItem) === item.nama) {
          const jumlahSpan = menuItem.querySelector('.jumlah');
          const btnKurang = menuItem.querySelector('.btn-kurang');
          jumlahSpan.textContent = item.jumlah;
          btnKurang.disabled = item.jumlah <= 0;
          
          // Update shadow berdasarkan jumlah
          if (item.jumlah > 0) {
            menuItem.style.boxShadow = '0 8px 20px rgba(255, 107, 0, 0.3)';
          } else {
            menuItem.style.boxShadow = 'var(--shadow)';
          }
        }
      });
      
      updateCart();
    }

    // Fungsi untuk checkout dari keranjang
    function checkoutFromCart() {
      if (cartItems.length === 0) {
        showNotification("Keranjang masih kosong. Silakan tambahkan menu terlebih dahulu.");
        return;
      }
      
      // Validasi nama pemesan
      customerName = namaPemesanInput.value.trim();
      if (customerName === "") {
        showNotification("Mohon masukkan nama pemesan terlebih dahulu.");
        namaPemesanInput.focus();
        return;
      }
      
      if (customerName.length < 2) {
        showNotification("Nama pemesan minimal 2 karakter.");
        namaPemesanInput.focus();
        return;
      }
      
      closeCart();
      kirimPesanan();
    }

    // Fungsi untuk menampilkan notifikasi
    function showNotification(message) {
      notification.textContent = message;
      notification.style.display = 'block';
      setTimeout(() => {
        notification.style.display = 'none';
      }, 3000);
    }

    // Fungsi kirim pesanan dengan animasi loading
    function kirimPesanan() {
      if (cartItems.length === 0) {
        showNotification("Belum ada menu yang dipilih.");
        return;
      }

      const hasil = document.getElementById("hasil");
      const daftarPesanan = document.getElementById("daftar-pesanan");
      const totalHarga = document.getElementById("total-harga");
      const customerNameDisplay = document.getElementById("customer-name-display");
      const loading = document.querySelector('.loading');

      // Tampilkan loading
      loading.style.display = 'block';
      
      // Simulasi proses pengiriman
      setTimeout(() => {
        loading.style.display = 'none';
        
        // Tampilkan nama pemesan
        customerNameDisplay.textContent = `Atas nama: ${customerName}`;
        
        // Tampilkan hasil pesanan
        daftarPesanan.innerHTML = '';
        let total = 0;
        
        cartItems.forEach(item => {
          const li = document.createElement('li');
          li.innerHTML = `
            <span>${item.nama} (${item.jumlah})</span>
            <span>Rp${item.subtotal.toLocaleString("id-ID")}</span>
          `;
          daftarPesanan.appendChild(li);
          total += item.subtotal;
        });
        
        totalHarga.textContent = `Total: Rp${total.toLocaleString("id-ID")}`;
        hasil.classList.add('show');
        
        // Scroll ke hasil pesanan
        window.scrollTo({
          top: hasil.offsetTop - 100,
          behavior: 'smooth'
        });
        
        showNotification(`Pesanan ${customerName} berhasil dikirim!`);
        
        // Reset keranjang setelah pesanan dikirim
        resetCart();
      }, 1500);
    }

    // Fungsi untuk mereset keranjang
    function resetCart() {
      cartItems = [];
      cartCount.textContent = '0';
      cartTotalPrice.textContent = 'Rp0';
      namaPemesanInput.value = '';
      customerName = '';
      renderCartItems();
      
      // Reset semua jumlah ke 0
      document.querySelectorAll('.menu-item').forEach(menuItem => {
        const jumlahSpan = menuItem.querySelector('.jumlah');
        const btnKurang = menuItem.querySelector('.btn-kurang');
        jumlahSpan.textContent = '0';
        btnKurang.disabled = true;
        menuItem.style.boxShadow = 'var(--shadow)';
      });
    }

    // Event listener untuk input nama pemesan (Enter key)
    namaPemesanInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        checkoutFromCart();
      }
    });

    // Inisialisasi
    document.addEventListener('DOMContentLoaded', function() {
      updateCart();
    });
  </script>
</body>
</html>