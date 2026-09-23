// DỮ LIỆU CÁC DÒNG XE NỔI BẬT (MOCK DATABASE)
const CAR_DATABASE = [
    {
        id: "car-01",
        brand: "Mercedes-Benz",
        name: "Mercedes-Maybach S 680 4MATIC",
        price: 15990000000,
        priceText: "15,990,000,000 VNĐ",
        type: "Sedan",
        fuel: "Xăng (V12 6.0L)",
        power: "612 Mã lực",
        seats: "4 Chỗ",
        tag: "HOT",
        tagClass: "tag-hot",
        image: "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop",
        desc: "Đỉnh cao sự sang trọng và thượng lưu. Mercedes-Maybach S 680 được trang bị động cơ V12 bi-turbo mạnh mẽ, hệ dẫn động 4 bánh toàn thời gian cùng khoang hạng nhất cao cấp."
    },
    {
        id: "car-02",
        brand: "Porsche",
        name: "Porsche Taycan Turbo S",
        price: 9550000000,
        priceText: "9,550,000,000 VNĐ",
        type: "Electric",
        fuel: "Thuần Điện (EV)",
        power: "761 Mã lực",
        seats: "4 Chỗ",
        tag: "Mới Về",
        tagClass: "tag-new",
        image: "https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop",
        desc: "Siêu xe thuần điện với khả năng tăng tốc 0-100km/h trong 2.8 giây. Công nghệ sạc siêu nhanh 800V đẳng cấp thể thao Đức."
    },
    {
        id: "car-03",
        brand: "BMW",
        name: "BMW 740i Pure Excellence",
        price: 6299000000,
        priceText: "6,299,000,000 VNĐ",
        type: "Sedan",
        fuel: "Xăng (I6 Mild-Hybrid)",
        power: "381 Mã lực",
        seats: "5 Chỗ",
        tag: "Ưu Đãi",
        tagClass: "tag-sale",
        image: "https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop",
        desc: "Thiết kế tương lai ấn tượng với lưới tản nhiệt phát sáng Iconic Glow, màn hình rạp chiếu phim Theatre Screen 31 inch phía sau."
    },
    {
        id: "car-04",
        brand: "Audi",
        name: "Audi e-tron GT Quattro",
        price: 5200000000,
        priceText: "5,200,000,000 VNĐ",
        type: "Electric",
        fuel: "Thuần Điện (EV)",
        power: "530 Mã lực",
        seats: "5 Chỗ",
        tag: "HOT",
        tagClass: "tag-hot",
        image: "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop",
        desc: "Tuyệt tác thiết kế Gran Turismo điện năng. Sự kết hợp hoàn hảo giữa cảm giác lái thể thao và tính năng tiện nghi hàng ngày."
    },
    {
        id: "car-05",
        brand: "Land Rover",
        name: "Range Rover Autobiography LWB",
        price: 11699000000,
        priceText: "11,699,000,000 VNĐ",
        type: "SUV",
        fuel: "Xăng (V8 4.4L)",
        power: "530 Mã lực",
        seats: "5 Chỗ",
        tag: "Mới Về",
        tagClass: "tag-new",
        image: "https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop",
        desc: "Biểu tượng SUV hạng sang Hoàng gia Anh. Khả năng địa hình vượt trội cùng nội thất tinh tế bậc nhất."
    },
    {
        id: "car-06",
        brand: "Lexus",
        name: "Lexus LX 600 VIP 4 Chỗ",
        price: 9610000000,
        priceText: "9,610,000,000 VNĐ",
        type: "SUV",
        fuel: "Xăng (V6 3.5L Twin-Turbo)",
        power: "409 Mã lực",
        seats: "4 Chỗ VIP",
        tag: "HOT",
        tagClass: "tag-hot",
        image: "https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop",
        desc: "Chuyên cơ mặt đất Nhật Bản dành cho các doanh nhân. Cấu hình 4 ghế thương gia cao cấp tích hợp massage, sưởi và làm mát."
    }
];

// LƯU TRỮ VÀ KHỞI TẠO LOCALSTORAGE
function initLocalStorage() {
    if (!localStorage.getItem("prime_cars")) {
        localStorage.setItem("prime_cars", JSON.stringify(CAR_DATABASE));
    }
    if (!localStorage.getItem("prime_test_drives")) {
        localStorage.setItem("prime_test_drives", JSON.stringify([
            {
                id: "TD-101",
                name: "Nguyễn Văn Hùng",
                phone: "0908123456",
                email: "hung.nguyen@gmail.com",
                carName: "Mercedes-Maybach S 680 4MATIC",
                location: "Showroom TP. Hồ Chí Minh",
                date: "2026-09-20T10:00",
                status: "Đang chờ duyệt"
            },
            {
                id: "TD-102",
                name: "Trần Thị Mai",
                phone: "0912987654",
                email: "mai.tran@gmail.com",
                carName: "Porsche Taycan Turbo S",
                location: "Showroom Hà Nội",
                date: "2026-09-21T14:30",
                status: "Đã xác nhận"
            }
        ]));
    }
}

// HÀM RENDER DANH SÁCH XE RA GIAO DIỆN
function renderCarCards(carsToRender, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (carsToRender.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-car-triangle text-secondary fa-3x mb-3"></i>
                <h4 class="text-secondary">Không tìm thấy mẫu xe phù hợp</h4>
                <p class="text-muted">Vui lòng thử chọn bộ lọc khác.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = carsToRender.map(car => `
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="car-card">
                <div class="car-thumb">
                    <img src="${car.image}" alt="${car.name}">
                    <span class="car-tag ${car.tagClass}">${car.tag}</span>
                </div>
                <div class="car-body">
                    <div class="car-brand">${car.brand}</div>
                    <h3 class="car-title">${car.name}</h3>
                    <div class="car-specs">
                        <span><i class="fa-solid fa-gas-pump"></i> ${car.fuel}</span>
                        <span><i class="fa-solid fa-bolt"></i> ${car.power}</span>
                        <span><i class="fa-solid fa-chair"></i> ${car.seats}</span>
                    </div>
                    <div class="car-price">${car.priceText}</div>
                    <div class="car-actions">
                        <a href="/cars/${car.id}" class="btn btn-accent flex-grow-1 text-center">
                            <i class="fa-solid fa-eye"></i> Xem Chi Tiết
                        </a>
                        <a href="/test-drive?car=${encodeURIComponent(car.name)}" class="btn btn-gold text-center">
                            <i class="fa-solid fa-steering-wheel"></i> Lái Thử
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// TÍNH GIÁ LĂN BÁNH UỚC TÍNH
function calculateOnRoadPrice(basePrice, provinceRate) {
    const tax = basePrice * (provinceRate / 100);
    const plateFee = provinceRate === 12 || provinceRate === 10 ? 20000000 : 1000000; // Phí biển số
    const roadFee = 1560000; // Phí bảo trì đường bộ 1 năm
    const civilInsurance = 480700; // Phí TNDS
    const totalPrice = basePrice + tax + plateFee + roadFee + civilInsurance;
    
    return {
        tax,
        plateFee,
        roadFee,
        civilInsurance,
        totalPrice
    };
}

// ĐỊNH DẠNG MÀU TIỀN VNĐ
function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}

// KHỞI TẠO KHI TRANG TẢI
document.addEventListener("DOMContentLoaded", () => {
    initLocalStorage();
    const cars = JSON.parse(localStorage.getItem("prime_cars")) || CAR_DATABASE;
    renderCarCards(cars, "car-list-container");

    // LẮNG NGHE BỘ LỌC TÌM KIẾM
    const filterBrand = document.getElementById("filterBrand");
    const filterType = document.getElementById("filterType");
    const filterPrice = document.getElementById("filterPrice");
    const searchInput = document.getElementById("searchInput");

    function applyFilter() {
        let filtered = cars;

        if (filterBrand && filterBrand.value !== "all") {
            filtered = filtered.filter(c => c.brand === filterBrand.value);
        }
        if (filterType && filterType.value !== "all") {
            filtered = filtered.filter(c => c.type === filterType.value);
        }
        if (filterPrice && filterPrice.value !== "all") {
            const val = filterPrice.value;
            if (val === "under5") filtered = filtered.filter(c => c.price < 5000000000);
            if (val === "5to10") filtered = filtered.filter(c => c.price >= 5000000000 && c.price <= 10000000000);
            if (val === "over10") filtered = filtered.filter(c => c.price > 10000000000);
        }
        if (searchInput && searchInput.value.trim() !== "") {
            const query = searchInput.value.toLowerCase();
            filtered = filtered.filter(c => c.name.toLowerCase().includes(query) || c.brand.toLowerCase().includes(query));
        }

        renderCarCards(filtered, "car-list-container");
    }

    if (filterBrand) filterBrand.addEventListener("change", applyFilter);
    if (filterType) filterType.addEventListener("change", applyFilter);
    if (filterPrice) filterPrice.addEventListener("change", applyFilter);
    if (searchInput) searchInput.addEventListener("input", applyFilter);
});
