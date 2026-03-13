<!DOCTYPE html>


<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'La Rych Restaurant</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>

    <nav>
        <div class="logo">D'La Rych</div>
        <ul class="nav-links">
            <li><a href="#" class="active">HOME</a></li>                        
            <li><a href="#" onclick="openContactModal()">CONTACT</a></li>
            <li><a href="#" onclick="toggleAdmin()" id="adminToggleBtn" style="color: #27ae60;">⚙️ ADMIN</a></li>
        </ul>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-subtitle">Selamat datang</div>
            <h1>D'La Rych Restaurant</h1>
            <p>Rumah makan mengisi kekosongan perut mu.</p>
            <a href="#menu-section" class="btn">PESAN SEKARANG</a>
        </div>
    </section>

    <section class="admin-panel hidden" id="adminPanel">
        <h3>⚙️ Admin Panel: Kelola Menu</h3>
        <div class="form-group">
            <input type="text" id="menuName" placeholder="Nama Menu...">
            <input type="number" id="menuPrice" placeholder="Harga (Misal: 15000)">
            
            <select id="menuCategory">
                <option value="Makanan Berat">Makanan Berat</option>    
                <option value="Cold Drink">Cold Drink</option>
                <option value="Hot Drink">Hot Drink</option>
                <option value="Snack">Snack</option>
            </select>

            <div class="file-input-wrapper">
                <label for="menuImgFile" id="fileLabel">Pilih Gambar</label>
                <input type="file" id="menuImgFile" accept="image/*" onchange="updateFileLabel()">
            </div>
            <button class="btn-add" onclick="addMenu()">Tambah Menu</button>
        </div>
    </section>

    <section class="dishes-section" id="menu-section">
        <h2>Menu Pilihan Kami</h2>
        
        <div class="category-tabs" id="categoryTabs">
            <button class="active" onclick="filterCategory('Semua')">Semua</button>
            <button onclick="filterCategory('Makanan Berat')">Makanan Berat</button>
            <button onclick="filterCategory('Snack')">Snack</button>
            <button onclick="filterCategory('Cold Drink')">Cold Drink</button>
            <button onclick="filterCategory('Hot Drink')">Hot Drink</button>
        </div>
        
        <div class="dish-grid" id="menuContainer">
            </div>
                
    </section>

    <div class="cart-container hidden" id="cartContainer">
        <h3> Keranjang Pesanan</h3>
        <div id="cartItems"></div>
        <div class="cart-total">Total: Rp <span id="cartTotalText">0</span></div>
        <button class="btn-pay" onclick="checkout()">Bayar Sekarang</button>
    </div>

    <div id="contactModal" class="modal hidden">
        <div class="modal-content" style="max-width: 500px;"> 
            <span class="close-btn" onclick="closeContactModal()">&times;</span>
            <h2 style="color: #e74c3c; margin-bottom: 20px;">Hubungi Kami</h2>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px;">D'La Rych Restaurant</h3>
                <p style="margin-bottom: 8px;">Jl. Kuliner No. 123, Kota Rasa</p>
                <p style="margin-bottom: 8px;">+62 123-456-7890</p>
                <p style="margin-bottom: 8px;">✉️ farrelldiderych@gmail.com</p>
            </div>
            
            <div style="text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                <h3 style="margin-bottom: 15px;">Ikuti Kami</h3>
                <div class="social-icons">
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">TikTok</a>
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn" onclick="closeLoginModal()">&times;</span>
            <h3>Login Admin</h3>
           
            <input type="text" id="adminUsername" placeholder="Username" autocomplete="off">
            <input type="password" id="adminPassword" placeholder="Password" autocomplete="new-password">
            <button class="btn-login" onclick="loginAdmin()">MASUK</button>
        </div>
    </div>

    <script src="script.js?v=5"></script>
</body>
</html>