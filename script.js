// --- STATE MANAGEMENT ---
let isAdmin = false; 
let activeCategory = 'Semua';
let cart = [];
let menus = [];

// --- FUNGSI AMBIL DATA (DARI DATABASE) ---
function loadMenus() {
    fetch('ambil_menu.php')
        .then(response => response.json())
        .then(data => {
            // Pastikan data yang diterima adalah array agar tidak error
            menus = Array.isArray(data) ? data : []; 
            renderMenus();
        })
        .catch(err => console.error("Gagal memuat menu:", err));
}

// --- FUNGSI RENDER MENU KE LAYAR ---
function renderMenus() {
    const container = document.getElementById('menuContainer');
    if (!container) return;
    container.innerHTML = ''; 

    let filteredMenus = menus;
    if (activeCategory !== 'Semua') {
        filteredMenus = menus.filter(menu => menu.category === activeCategory);
    }

    filteredMenus.forEach((item) => {
        let actionButton = '';
        if (isAdmin) {
            actionButton = `<button class="btn-delete" onclick="deleteMenu('${item.id}')">🗑️ Hapus</button>`;
        } else {
            actionButton = `<button class="btn-order" onclick="addToCart('${item.id}')">🛒 Pesan</button>`;
        }

        container.innerHTML += `
            <div class="dish-card">
                <img src="${item.img}" alt="${item.name}">
                <div class="dish-info">
                    <div class="dish-category">${item.category}</div>
                    <h3>${item.name}</h3>
                    <div class="dish-price">Rp ${Number(item.price).toLocaleString('id-ID')}</div>
                    ${actionButton}
                </div>
            </div>
        `;
    });
}

// --- FUNGSI FILTER KATEGORI ---
function filterCategory(category) {
    activeCategory = category;
    renderMenus();
}

// --- FUNGSI ADMIN: TAMBAH & HAPUS MENU ---
function addMenu() {
    const name = document.getElementById('menuName').value;
    const price = document.getElementById('menuPrice').value;
    const category = document.getElementById('menuCategory').value;
    const fileInput = document.getElementById('menuImgFile');

    if (!name || !price || fileInput.files.length === 0) {
        alert("Harap isi semua data, termasuk gambar!");
        return;
    }

    const reader = new FileReader();
    reader.onloadend = function () {
        const menuData = { 
            name: name, 
            price: price, 
            category: category, 
            img: reader.result 
        };

        fetch('tambah_menu.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(menuData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                // Kosongkan form setelah berhasil
                document.getElementById('menuName').value = '';
                document.getElementById('menuPrice').value = '';
                document.getElementById('menuImgFile').value = '';
                document.getElementById('fileLabel').innerText = 'Pilih Gambar';
                
                loadMenus(); // Auto-refresh menu
            } else {
                alert("Gagal: " + data.message);
            }
        })
        .catch(err => alert("Gagal menambah menu: Periksa koneksi atau database!"));
    };
    reader.readAsDataURL(fileInput.files[0]);
}

function deleteMenu(id) {
    if (confirm("Hapus menu ini secara permanen dari database?")) {
        fetch(`hapus_menu.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    loadMenus();
                } else {
                    alert("Gagal: " + data.message);
                }
            })
            .catch(err => console.error("Error saat menghapus:", err));
    }
}

function updateFileLabel() {
    const fileInput = document.getElementById('menuImgFile');
    const label = document.getElementById('fileLabel');
    if (fileInput.files.length > 0) {
        label.innerText = fileInput.files[0].name;
    } else {
        label.innerText = 'Pilih Gambar';
    }
}

// --- FUNGSI KERANJANG ---
function addToCart(menuId) {
    const menu = menus.find(m => String(m.id) === String(menuId));
    if (menu) {
        cart.push(menu);
        renderCart();
    }
}

function renderCart() {
    const cartItems = document.getElementById('cartItems');
    const cartTotalText = document.getElementById('cartTotalText');
    const cartContainer = document.getElementById('cartContainer');

    if (cart.length === 0) {
        cartContainer.classList.add('hidden');
        return;
    }

    cartContainer.classList.remove('hidden');
    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        if (!item) return; 
        let harga = Number(item.price) || 0;
        total += harga;
        cartItems.innerHTML += `
            <div class="cart-item">
                <span>${item.name}</span>
                <span>Rp ${harga.toLocaleString('id-ID')} 
                <button onclick="removeFromCart(${index})">x</button></span>
            </div>
        `;
    });
    cartTotalText.innerText = total.toLocaleString('id-ID');
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
}

function checkout() {
    if (cart.length === 0) return;
    let total = 0;
    cart.forEach(item => total += (Number(item.price) || 0));
    
    if (confirm(`Total Bayar: Rp ${total.toLocaleString('id-ID')}\nApakah Anda ingin memproses pembayaran?`)) {
        alert("Pembayaran Berhasil!\nTerima kasih telah memesan.");
        cart = [];
        renderCart();
    }
}

// --- FUNGSI MODAL & LOGIN ---
function toggleAdmin() {
    if (isAdmin) {
        if (confirm("Yakin ingin keluar dari mode Admin?")) {
            isAdmin = false;
            updateUI();
        }
    } else {
        document.getElementById('adminUsername').value = '';
        document.getElementById('adminPassword').value = '';
        document.getElementById('loginModal').classList.remove('hidden');
    }
}

function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
}

function loginAdmin() {
    const user = document.getElementById('adminUsername').value;
    const pass = document.getElementById('adminPassword').value;

    if (user === "admin" && pass === "12345") {
        alert("Login berhasil!");
        isAdmin = true;
        closeLoginModal();
        updateUI();
    } else {
        alert("Username atau Password salah!");
    }
}

function updateUI() {
    const adminPanel = document.getElementById('adminPanel');
    const adminBtn = document.getElementById('adminToggleBtn');
    if (isAdmin) {
        adminPanel.classList.remove('hidden');
        adminBtn.innerText = "LOGOUT";
        document.getElementById('cartContainer').classList.add('hidden');
    } else {
        adminPanel.classList.add('hidden');
        adminBtn.innerText = "⚙️ ADMIN LOGIN";
    }
    renderMenus();
}

// --- FUNGSI CONTACT (INI YANG TADI HILANG & BIKIN ERROR) ---
function openContactModal() {
    const modal = document.getElementById('contactModal');
    if (modal) modal.classList.remove('hidden');
}

function closeContactModal() {
    const modal = document.getElementById('contactModal');
    if (modal) modal.classList.add('hidden');
}

// --- INISIALISASI SAAT HALAMAN DIBUKA ---
document.addEventListener('DOMContentLoaded', () => {
    loadMenus();
});