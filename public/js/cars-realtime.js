/**
 * PrimeLux Cars Real-Time Synchronization Engine
 * Hỗ trợ Dual-Channel Real-time:
 * 1. BroadcastChannel('primelux_cars_channel') + localStorage fallback (0ms latency, tức thì giữa các tab)
 * 2. Smart Background Feed Polling (kiểm tra version siêu nhẹ mỗi 8s giữa các trình duyệt/thiết bị khác nhau)
 * Cập nhật DOM mượt mà, Toast thông báo sang trọng, KHÔNG CẦN F5.
 */
(function() {
    'use strict';

    const CHANNEL_NAME = 'primelux_cars_channel';
    const STORAGE_KEY = 'primelux_cars_event';
    const FEED_URL = '/api/cars/feed';
    const POLLING_INTERVAL_MS = 8000;

    let broadcastChannel = null;
    try {
        if (typeof BroadcastChannel !== 'undefined') {
            broadcastChannel = new BroadcastChannel(CHANNEL_NAME);
        }
    } catch (e) {
        console.warn('[PrimeLux Sync] BroadcastChannel not supported, using localStorage fallback.');
    }

    // Lớp Toast Thông Báo Cao Cấp PrimeLux
    class PrimeLuxToast {
        static container = null;

        static ensureContainer() {
            if (!this.container) {
                let el = document.getElementById('primelux-toast-container');
                if (!el) {
                    el = document.createElement('div');
                    el.id = 'primelux-toast-container';
                    el.style.cssText = `
                        position: fixed;
                        bottom: 24px;
                        right: 24px;
                        z-index: 99999;
                        display: flex;
                        flex-direction: column;
                        gap: 12px;
                        max-width: 420px;
                        width: calc(100% - 48px);
                        pointer-events: none;
                    `;
                    document.body.appendChild(el);
                }
                this.container = el;
            }
            return this.container;
        }

        static show({ title = 'Thông Báo Showroom', message = '', icon = 'fa-car', type = 'info', actionUrl = null, actionText = 'Xem ngay', duration = 5000 }) {
            const container = this.ensureContainer();
            const toast = document.createElement('div');
            toast.className = 'primelux-realtime-toast';
            toast.style.cssText = `
                background: linear-gradient(135deg, #131b2e 0%, #0d121f 100%);
                border: 1px solid rgba(217, 119, 6, 0.4);
                border-left: 4px solid ${type === 'success' ? '#10b981' : type === 'warning' ? '#f59e0b' : type === 'danger' ? '#ef4444' : '#3b82f6'};
                border-radius: 12px;
                padding: 14px 18px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 15px rgba(217, 119, 6, 0.15);
                color: #ffffff;
                pointer-events: auto;
                opacity: 0;
                transform: translateY(20px) scale(0.97);
                transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
                display: flex;
                align-items: flex-start;
                gap: 14px;
            `;

            const iconColors = {
                success: 'text-success',
                warning: 'text-warning',
                danger: 'text-danger',
                info: 'text-primary'
            };

            toast.innerHTML = `
                <div style="font-size: 1.35rem; margin-top: 2px;" class="${iconColors[type] || 'text-warning'}">
                    <i class="fa-solid ${icon}"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">${title}</span>
                        <button type="button" class="btn-close-toast" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 0; font-size: 0.9rem;" title="Đóng">&times;</button>
                    </div>
                    <div style="font-size: 0.9rem; line-height: 1.4; color: #e2e8f0; margin-bottom: ${actionUrl ? '8px' : '0'};">
                        ${message}
                    </div>
                    ${actionUrl ? `
                        <div>
                            <a href="${actionUrl}" class="btn btn-sm btn-outline-warning py-0 px-2 fw-bold" style="font-size: 0.75rem;">
                                ${actionText} <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    ` : ''}
                </div>
            `;

            container.appendChild(toast);

            // Trigger animation in
            requestAnimationFrame(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0) scale(1)';
            });

            const closeBtn = toast.querySelector('.btn-close-toast');
            const dismiss = () => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(15px) scale(0.95)';
                setTimeout(() => toast.remove(), 350);
            };

            if (closeBtn) closeBtn.addEventListener('click', dismiss);
            if (duration > 0) setTimeout(dismiss, duration);
        }
    }

    // Public API Object
    window.PrimeLuxSync = {
        currentVersion: '1',

        // Phát sự kiện cập nhật xe từ Admin sang các tab Showroom (0ms latency)
        broadcast(action, data = {}) {
            const eventPayload = {
                action: action, // 'CAR_ADDED', 'CAR_UPDATED', 'CAR_DELETED', 'CAR_STATUS_CHANGED'
                data: data,
                timestamp: Date.now()
            };

            // 1. Gửi qua BroadcastChannel
            if (broadcastChannel) {
                try {
                    broadcastChannel.postMessage(eventPayload);
                } catch (e) {
                    console.warn('[PrimeLux Sync] postMessage error:', e);
                }
            }

            // 2. Gửi qua localStorage (kích hoạt event `storage` ở các tab khác)
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(eventPayload));
            } catch (e) {}
        },

        // Lắng nghe sự kiện từ các tab khác
        listen(callback) {
            if (broadcastChannel) {
                broadcastChannel.addEventListener('message', (event) => {
                    if (event.data && event.data.action) {
                        callback(event.data);
                    }
                });
            }

            window.addEventListener('storage', (event) => {
                if (event.key === STORAGE_KEY && event.newValue) {
                    try {
                        const parsed = JSON.parse(event.newValue);
                        if (parsed && parsed.action) {
                            callback(parsed);
                        }
                    } catch (e) {}
                }
            });
        },

        // Đăng ký nhận sự kiện theo action cụ thể
        on(action, callback) {
            this.listen((event) => {
                if (event && event.action === action) {
                    callback(event.data, event);
                }
            });
        },

        // Khởi động Smart Polling Feed cho các thiết bị khác nhau
        startFeedPolling(onUpdateCallback) {
            const checkFeed = async () => {
                // Chỉ thăm dò khi tab đang hiển thị để tiết kiệm tài nguyên CPU & pin
                if (document.hidden) return;

                try {
                    const res = await fetch(`${FEED_URL}?last_sync=${encodeURIComponent(window.PrimeLuxSync.currentVersion || '')}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!res.ok) return;
                    const json = await res.json();

                    if (json.success) {
                        if (json.updated && json.cars) {
                            window.PrimeLuxSync.currentVersion = json.version;
                            onUpdateCallback(json.cars, json.version);
                        } else if (json.version) {
                            window.PrimeLuxSync.currentVersion = json.version;
                        }
                    }
                } catch (err) {
                    // Im lặng nếu mạng offline tạm thời
                }
            };

            setInterval(checkFeed, POLLING_INTERVAL_MS);
        },

        showToast(options) {
            PrimeLuxToast.show(options);
        }
    };

    // Thêm CSS hiệu ứng highlight xe mới / cập nhật vào DOM
    const styleEl = document.createElement('style');
    styleEl.textContent = `
        @keyframes primeluxNewGlow {
            0% {
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.8), 0 0 25px rgba(16, 185, 129, 0.4);
                transform: translateY(-4px) scale(1.02);
            }
            70% {
                box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.4), 0 0 15px rgba(16, 185, 129, 0.2);
                transform: translateY(-2px);
            }
            100% {
                box-shadow: none;
                transform: translateY(0);
            }
        }
        @keyframes primeluxUpdateGlow {
            0% {
                box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.8), 0 0 25px rgba(245, 158, 11, 0.4);
            }
            100% {
                box-shadow: none;
            }
        }
        @keyframes tableRowFadeIn {
            0% {
                background-color: rgba(16, 185, 129, 0.35) !important;
                opacity: 0.2;
                transform: translateY(-10px);
            }
            60% {
                background-color: rgba(16, 185, 129, 0.2) !important;
            }
            100% {
                background-color: transparent !important;
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes tableRowFlashUpdate {
            0% {
                background-color: rgba(245, 158, 11, 0.35) !important;
            }
            100% {
                background-color: transparent !important;
            }
        }
        .table-row-highlight-new {
            animation: tableRowFadeIn 2.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .table-row-highlight-update {
            animation: tableRowFlashUpdate 1.8s ease-out forwards;
        }
        .car-card-highlight-new {
            animation: primeluxNewGlow 2.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .car-card-highlight-update {
            animation: primeluxUpdateGlow 1.8s ease-out forwards;
        }
    `;
    document.head.appendChild(styleEl);
})();
