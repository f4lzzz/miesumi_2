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
        showNotification(${namaMenu} ditambahkan ke keranjang);
      }
      
      // Jika item dihapus (dari 1 ke 0)
      if (isLastRemove) {
        menuItem.style.boxShadow = 'var(--shadow)';
        showNotification(${namaMenu} dihapus dari keranjang);
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
      cartTotalPrice.textContent = Rp${totalPrice.toLocaleString("id-ID")};
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
        customerNameDisplay.textContent = Atas nama: ${customerName};
        
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
        
        totalHarga.textContent = Total: Rp${total.toLocaleString("id-ID")};
        hasil.classList.add('show');
        
        // Scroll ke hasil pesanan
        window.scrollTo({
          top: hasil.offsetTop - 100,
          behavior: 'smooth'
        });
        
        showNotification(Pesanan ${customerName} berhasil dikirim!);
        
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