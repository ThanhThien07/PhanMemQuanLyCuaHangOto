// DỮ LIỆU CÁC DÒNG XE NỔI BẬT (MOCK DATABASE)
const CAR_DATABASE = [
    {
        id: "car-01",
        brand: "Mercedes-Benz",
        name: "Mercedes-Maybach S 680 4MATIC",
        price: 15990000000,
        priceText: "15.990.000.000 VNĐ",
        type: "Sedan",
        fuel: "Xăng (V12 6.0L)",
        power: "612 Mã lực",
        seats: "4 Chỗ",
        year: 2026,
        transmission: "Tự động 9 cấp 9G-TRONIC",
        tag: "HOT",
        tagClass: "tag-hot",
        is_new: false,
        is_best_seller: true,
        image: "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop",
        desc: "Đỉnh cao sự sang trọng và thượng lưu. Mercedes-Maybach S 680 được trang bị động cơ V12 bi-turbo mạnh mẽ, hệ dẫn động 4 bánh toàn thời gian cùng khoang hạng nhất cao cấp."
    },
    {
        id: "car-02",
        brand: "Porsche",
        name: "Porsche Taycan Turbo S",
        price: 9550000000,
        priceText: "9.550.000.000 VNĐ",
        type: "Electric",
        fuel: "Thuần Điện (EV)",
        power: "761 Mã lực",
        seats: "4 Chỗ",
        year: 2026,
        transmission: "Tự động 2 cấp thể thao",
        tag: "Mới Về",
        tagClass: "tag-new",
        is_new: true,
        is_best_seller: false,
        image: "https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?q=80&w=1000&auto=format&fit=crop",
        desc: "Siêu xe thuần điện với khả năng tăng tốc 0-100km/h trong 2.8 giây. Công nghệ sạc siêu nhanh 800V đẳng cấp thể thao Đức."
    },
    {
        id: "car-03",
        brand: "BMW",
        name: "BMW 740i Pure Excellence",
        price: 6299000000,
        priceText: "6.299.000.000 VNĐ",
        type: "Sedan",
        fuel: "Xăng (I6 Mild-Hybrid)",
        power: "381 Mã lực",
        seats: "5 Chỗ",
        year: 2025,
        transmission: "Tự động 8 cấp Steptronic",
        tag: "Ưu Đãi",
        tagClass: "tag-sale",
        is_new: false,
        is_best_seller: true,
        image: "https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1000&auto=format&fit=crop",
        desc: "Thiết kế tương lai ấn tượng với lưới tản nhiệt phát sáng Iconic Glow, màn hình rạp chiếu phim Theatre Screen 31 inch phía sau."
    },
    {
        id: "car-04",
        brand: "Audi",
        name: "Audi e-tron GT Quattro",
        price: 5200000000,
        priceText: "5.200.000.000 VNĐ",
        type: "Electric",
        fuel: "Thuần Điện (EV)",
        power: "530 Mã lực",
        seats: "5 Chỗ",
        year: 2025,
        transmission: "Tự động 2 cấp điện tử",
        tag: "HOT",
        tagClass: "tag-hot",
        is_new: false,
        is_best_seller: true,
        image: "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?q=80&w=1000&auto=format&fit=crop",
        desc: "Tuyệt tác thiết kế Gran Turismo điện năng. Sự kết hợp hoàn hảo giữa cảm giác lái thể thao và tính năng tiện nghi hàng ngày."
    },
    {
        id: "car-05",
        brand: "Land Rover",
        name: "Range Rover Autobiography LWB",
        price: 11699000000,
        priceText: "11.699.000.000 VNĐ",
        type: "SUV",
        fuel: "Xăng (V8 4.4L)",
        power: "530 Mã lực",
        seats: "5 Chỗ",
        year: 2026,
        transmission: "Tự động 8 cấp ZF",
        tag: "Mới Về",
        tagClass: "tag-new",
        is_new: true,
        is_best_seller: false,
        image: "https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1000&auto=format&fit=crop",
        desc: "Biểu tượng SUV hạng sang Hoàng gia Anh. Khả năng địa hình vượt trội cùng nội thất tinh tế bậc nhất."
    },
    {
        id: "car-06",
        brand: "Lexus",
        name: "Lexus LX 600 VIP 4 Chỗ",
        price: 9610000000,
        priceText: "9.610.000.000 VNĐ",
        type: "SUV",
        fuel: "Xăng (V6 3.5L Twin-Turbo)",
        power: "409 Mã lực",
        seats: "4 Chỗ VIP",
        year: 2024,
        transmission: "Tự động 10 cấp Direct-Shift",
        tag: "HOT",
        tagClass: "tag-hot",
        is_new: false,
        is_best_seller: true,
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
                date: "2026-09-20 10:00",
                status: "Chờ duyệt"
            },
            {
                id: "TD-102",
                name: "Trần Thị Mai",
                phone: "0912987654",
                email: "mai.tran@gmail.com",
                carName: "Porsche Taycan Turbo S",
                location: "Showroom Hà Nội",
                date: "2026-09-21 14:30",
                status: "Đã hoàn thành"
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
                <i class="fa-solid fa-car-tunnel text-secondary fa-3x mb-3"></i>
                <h4 class="text-secondary fw-bold">Không tìm thấy mẫu xe phù hợp</h4>
                <p class="text-muted">Vui lòng thử chọn bộ lọc khác.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = carsToRender.map(car => `
        <div class="col-lg-4 col-md-6 mb-4 car-item-col"
             data-brand="${car.brand}"
             data-type="${car.type}"
             data-price="${car.price}"
             data-name="${car.name.toLowerCase()}"
             data-tag="${car.tag || ''}"
             data-new="${car.is_new ? '1' : (car.tag === 'Mới Về' ? '1' : '0')}"
             data-bestseller="${car.is_best_seller ? '1' : (car.tag === 'HOT' ? '1' : '0')}">
            <div class="car-card h-100 d-flex flex-column">
                <div class="car-thumb position-relative overflow-hidden">
                    <a href="/cars/${car.id}" class="d-block w-100 h-100" title="Xem chi tiết ${car.name}">
                        <img src="${car.image}" alt="${car.name}" class="w-100 object-fit-cover" style="height: 230px;">
                    </a>
                </div>
                <div class="car-body d-flex flex-column flex-grow-1 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="car-brand text-primary fw-bold small text-uppercase">${car.brand}</span>
                        <div class="d-flex align-items-center gap-1">
                            ${car.year ? `<span class="badge bg-dark border border-secondary text-secondary" style="font-size: 11px;">Đời ${car.year}</span>` : ''}
                            <span class="badge bg-secondary bg-opacity-25 text-secondary small">${car.type}</span>
                        </div>
                    </div>
                    <h3 class="car-title fs-5 fw-bold text-white mb-2 d-flex align-items-center">
                        <a href="/cars/${car.id}" class="text-white text-decoration-none" title="Xem chi tiết ${car.name}">${car.name}</a>
                        ${car.tag ? `<span class="status-indicator-dot ${car.tagClass || 'tag-hot'} ms-2" title="${car.tag}"></span>` : ''}
                    </h3>
                    <div class="car-specs text-secondary small mb-3 d-flex flex-wrap gap-2">
                        <span><i class="fa-solid fa-gas-pump text-primary me-1"></i> ${car.fuel}</span>
                        <span><i class="fa-solid fa-bolt text-warning me-1"></i> ${car.power}</span>
                        <span><i class="fa-solid fa-chair text-info me-1"></i> ${car.seats}</span>
                    </div>
                    <div class="car-price text-warning fw-bold fs-5 mt-auto mb-3">${car.priceText || formatCurrency(car.price)}</div>
                    <div class="car-actions d-flex gap-2">
                        <a href="/cars/${car.id}" class="btn btn-accent flex-fill text-center py-2 px-1 small fw-bold" title="Xem chi tiết ${car.name}">
                            <i class="fa-solid fa-eye me-1"></i> Chi Tiết
                        </a>
                        <a href="/cars/${car.id}/compare" class="btn btn-outline-info flex-fill text-center py-2 px-1 small fw-bold" title="So Sánh Giá Đa Sàn">
                            <i class="fa-solid fa-scale-balanced me-1"></i> So Sánh
                        </a>
                        <a href="/test-drive?car=${encodeURIComponent(car.name)}" class="btn btn-gold flex-fill text-center py-2 px-1 small fw-bold" title="Đặt Lái Thử Xe">
                            <i class="fa-solid fa-car me-1"></i> Lái Thử
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// ĐỊNH DẠNG MÀU TIỀN VNĐ
function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}

// KHỞI TẠO KHI TRANG TẢI
document.addEventListener("DOMContentLoaded", () => {
    initLocalStorage();
});
