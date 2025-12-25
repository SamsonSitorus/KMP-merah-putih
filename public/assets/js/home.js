// Externalized JS for resources/views/user/home.blade.php
// Assumes a small inline `window.HomePageData = { muaraId: '...', sipingganId: '...'}` object is present in the Blade before this script is loaded.
document.addEventListener('DOMContentLoaded', function() {

    const asalSelect   = document.getElementById('asalSelect');
    const tujuanInput  = document.getElementById('tujuanInput');
    const tujuanId     = document.getElementById('tujuanId');
    const tanggalInput = document.getElementById('departureDateInput');
    const jamSelect    = document.getElementById('jamselect');

    // mapping pelabuhan DINAMIS dari Blade
    const portMap = {};
    if (window.HomePageData?.muaraId && window.HomePageData?.sipingganId) {
        portMap[window.HomePageData.muaraId] = {
            id: window.HomePageData.sipingganId,
            name: 'Sipinggan'
        };
        portMap[window.HomePageData.sipingganId] = {
            id: window.HomePageData.muaraId,
            name: 'Muara'
        };
    }

    function resetJam() {
        jamSelect.innerHTML = '<option value="">Pilih Jam</option>';
    }

    function fetchJam() {
        const asal    = asalSelect.value;
        const tujuan  = tujuanId.value;
        const tanggal = tanggalInput.value;

        if (!asal || !tujuan || !tanggal) {
            resetJam();
            return;
        }

        const url = `${window.AppConfig.getDepartureTimesUrl}?origin_port_id=${asal}&destination_port_id=${tujuan}&departure_date=${tanggal}`;

        fetch(url)
            .then(res => {
                if (!res.ok) {
                    throw new Error('HTTP error ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                resetJam();

                if (!Array.isArray(data) || data.length === 0) {
                    jamSelect.innerHTML = '<option value="">Jam tidak tersedia</option>';
                    return;
                }

                data.forEach(time => {
                    const opt = document.createElement('option');
                    opt.value = time;
                    opt.textContent = time.substring(0,5); // 08:00
                    jamSelect.appendChild(opt);
                });
            })
            .catch(err => {
                console.error(err);
                resetJam();
                alert('Gagal mengambil jam keberangkatan');
            });
    }

    asalSelect.addEventListener('change', function () {
        const asalId = this.value;

        if (portMap[asalId]) {
            tujuanInput.value = portMap[asalId].name;
            tujuanId.value    = portMap[asalId].id;
        } else {
            tujuanInput.value = '';
            tujuanId.value    = '';
        }

        resetJam();
        fetchJam();
    });

    tanggalInput.addEventListener('change', function () {
        resetJam();
        fetchJam();
    });

    // Reveal animations
    const revealElements = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries, obs) => { entries.forEach(entry => { if (entry.isIntersecting) { const items = entry.target.querySelectorAll('.stagger-item'); if (items.length) { items.forEach((it, i) => setTimeout(() => it.classList.add('visible'), i * 90)); } entry.target.classList.add('visible'); obs.unobserve(entry.target); } }); }, { threshold: 0.12 });
        revealElements.forEach(el => io.observe(el));
    } else { revealElements.forEach(el => { el.classList.add('visible'); const items = el.querySelectorAll('.stagger-item'); items.forEach((it, i) => setTimeout(() => it.classList.add('visible'), i * 90)); }); }

    // Navbar collapse anchor behavior
    const navLinks = document.querySelectorAll('.navbar-nav a[href^="#"]');
    navLinks.forEach(link => link.addEventListener('click', (ev) => {
        try { const navbarCollapse = document.getElementById('navbar-collapse'); if (navbarCollapse && navbarCollapse.classList.contains('show')) { if (window.bootstrap && bootstrap.Collapse) { const bs = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse); bs.hide(); } else { navbarCollapse.classList.remove('show'); } } } catch (err) {}
        link.classList.add('text-primary'); setTimeout(() => link.classList.remove('text-primary'), 900);
    }));

    // Parallax and tilt
    const heroShapes = document.querySelectorAll('.hero-shape');
    const hero = document.querySelector('.hero-section');
    if (hero) {
        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect(); const cx = rect.left + rect.width/2; const cy = rect.top + rect.height/2; const dx = (e.clientX - cx) / rect.width; const dy = (e.clientY - cy) / rect.height; heroShapes.forEach((s, i) => { const depth = (i+1) * 6; s.style.transform = `translate3d(${dx * depth}px, ${dy * depth}px, 0) rotate(${(dx+dy)*6}deg)`; });
        });
        window.addEventListener('scroll', () => { const top = window.scrollY; heroShapes.forEach((s, i) => s.style.transform += ` translateY(${top * (0.002 * (i+1))}px)`); }, { passive: true });
    }

    function bindTilt(el) { const inner = el.querySelector('.card-inner'); if (!inner) return; el.addEventListener('mousemove', (ev) => { const r = el.getBoundingClientRect(); const px = (ev.clientX - r.left) / r.width; const py = (ev.clientY - r.top) / r.height; const rx = (py - 0.5) * 10; const ry = (px - 0.5) * -12; inner.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg) translateZ(12px)`; }); el.addEventListener('mouseleave', () => { inner.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0)'; }); }
    document.querySelectorAll('.tilt').forEach(bindTilt);

    // Ripple
    function makeRipple(e) { const btn = e.currentTarget; const rect = btn.getBoundingClientRect(); const circle = document.createElement('span'); const size = Math.max(rect.width, rect.height) * 1.6; circle.style.position = 'absolute'; circle.style.width = circle.style.height = size + 'px'; circle.style.borderRadius = '50%'; circle.style.left = (e.clientX - rect.left - size/2) + 'px'; circle.style.top = (e.clientY - rect.top - size/2) + 'px'; circle.style.background = 'radial-gradient(circle, rgba(255,255,255,0.45), rgba(255,255,255,0.05))'; circle.style.opacity = '0.95'; circle.style.transform = 'scale(0.2)'; circle.style.transition = 'transform 600ms cubic-bezier(.2,.9,.3,1), opacity 600ms ease'; circle.style.pointerEvents = 'none'; circle.className = 'ripple-effect'; btn.style.position = 'relative'; btn.appendChild(circle); requestAnimationFrame(() => circle.style.transform = 'scale(1)'); setTimeout(() => { circle.style.opacity = '0'; }, 420); setTimeout(() => { try { btn.removeChild(circle); } catch(e){} }, 900); }
    ['.btn-search', '.btn-done', '.btn-done, .footer-cta'].forEach(sel => { document.querySelectorAll(sel).forEach(b => b.addEventListener('click', makeRipple)); });

    // Data dari modal (penumpang dan kendaraan) diinisialisasi dari DOM
    // (diasumsikan ID dan class sesuai modal Blade tadi)

    // ===== Variabel untuk penumpang dan kendaraan =====
    // Penumpang: key = slug (lowercase underscore), value = jumlah
const passengerCounts = {};
const passengerPrices = {};
const passengerNames = []; // slug urutan

// Kendaraan
const vehicleCounts = {};
const vehiclePrices = {};

// Ambil semua penumpang yang ada (dari modal)
document.querySelectorAll('.passenger-row').forEach(row => {
    const nameEl = row.querySelector('h6');
    if (!nameEl) return;

    const name = nameEl.textContent.trim();
    const slug = slugify(name);

    // Ambil harga dari elemen price-display di row ini
    const priceText = row.querySelector('.price-display')?.textContent || '';
    const price = parseRupiah(priceText);

    passengerCounts[slug] = 0;
    passengerPrices[slug] = price;
    passengerNames.push(slug);

    // Event plus/minus untuk penumpang
    const plusBtn = document.getElementById('plus' + slug);
    const minusBtn = document.getElementById('minus' + slug);
    const countDisplay = document.getElementById('count' + slug);

    if (plusBtn && minusBtn && countDisplay) {
        plusBtn.addEventListener('click', () => {
            passengerCounts[slug]++;
            countDisplay.textContent = passengerCounts[slug];
            updateTotalPrice();
            updatePassengerButtonText();
        });
        minusBtn.addEventListener('click', () => {
            if (passengerCounts[slug] > 0) {
                passengerCounts[slug]--;
                countDisplay.textContent = passengerCounts[slug];
                updateTotalPrice();
                updatePassengerButtonText();
            }
        });
    }
});

// Ambil semua kendaraan
document.querySelectorAll('.vehicle-checkbox').forEach(checkbox => {
    const type = checkbox.dataset.type;
    const slug = slugify(type);

    vehicleCounts[type] = 0;

    // Ambil harga dari elemen harga kendaraan
    const priceEl = document.getElementById('price_' + slug);
    let price = 0;
    if (priceEl) price = parseRupiah(priceEl.textContent);
    vehiclePrices[type] = price;

    const plusBtn = document.querySelector(`.vehicle-plus[data-type="${type}"]`);
    const minusBtn = document.querySelector(`.vehicle-minus[data-type="${type}"]`);
    const countDisplay = document.getElementById('count_' + slug);

    if (plusBtn && minusBtn && countDisplay) {
        plusBtn.addEventListener('click', () => {
            if (!checkbox.checked) checkbox.checked = true;
            vehicleCounts[type]++;
            countDisplay.textContent = vehicleCounts[type];
            updateTotalPrice();
            updatePassengerButtonText();
        });
        minusBtn.addEventListener('click', () => {
            if (vehicleCounts[type] > 0) {
                vehicleCounts[type]--;
                countDisplay.textContent = vehicleCounts[type];
                if (vehicleCounts[type] === 0) checkbox.checked = false;
                updateTotalPrice();
                updatePassengerButtonText();
            }
        });
    }

    checkbox.addEventListener('change', () => {
        if (!checkbox.checked) {
            vehicleCounts[type] = 0;
            if (countDisplay) countDisplay.textContent = '0';
            updateTotalPrice();
            updatePassengerButtonText();
        } else if (vehicleCounts[type] === 0) {
            vehicleCounts[type] = 1;
            if (countDisplay) countDisplay.textContent = '1';
            updateTotalPrice();
            updatePassengerButtonText();
        }
    });
});

// Tombol SELESAI modal
document.getElementById('donePassenger').addEventListener('click', () => {
    // Update hidden inputs penumpang
    const passengerTypeInput = document.getElementById('passengerTypeInput');
    const passengerCountInput = document.getElementById('passengerCountInput');
    const passengerPriceInput = document.getElementById('passengerPriceInput');

    // Filter penumpang yang jumlahnya > 0
    const selectedPassengerTypes = passengerNames.filter(slug => passengerCounts[slug] > 0);
    passengerTypeInput.value = selectedPassengerTypes.join(', ');

    const totalPassengerCount = selectedPassengerTypes.reduce((sum, slug) => sum + passengerCounts[slug], 0);
    passengerCountInput.value = totalPassengerCount;

    const totalPassengerPrice = selectedPassengerTypes.reduce((sum, slug) => sum + (passengerCounts[slug] * passengerPrices[slug]), 0);
    passengerPriceInput.value = totalPassengerPrice;

    // Update hidden inputs kendaraan
    const vehicleTypeInput = document.getElementById('vehicleTypeInput');
    const vehicleCountInput = document.getElementById('vehicleCountInput');
    const vehiclePriceInput = document.getElementById('vehiclePriceInput');

    const selectedVehicleTypes = Object.entries(vehicleCounts).filter(([type, count]) => count > 0);

    vehicleTypeInput.value = selectedVehicleTypes.map(([type]) => type).join(', ');
    const totalVehicleCount = selectedVehicleTypes.reduce((sum, [, count]) => sum + count, 0);
    vehicleCountInput.value = totalVehicleCount;

    const totalVehiclePrice = selectedVehicleTypes.reduce((sum, [type, count]) => sum + (count * vehiclePrices[type]), 0);
    vehiclePriceInput.value = totalVehiclePrice;

    // Update total price input (gabungan)
    const ticketPriceInput = document.getElementById('ticketPrice');
    const totalPrice = totalPassengerPrice + totalVehiclePrice;
    if (ticketPriceInput) {
        ticketPriceInput.value = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    }

    // Update teks tombol
    updatePassengerButtonText();

    // Tutup modal
    const passengerModal = document.getElementById('passengerModal');
    passengerModal.classList.remove('active');
});

// Update total harga (dipakai juga di plus/minus)
function updateTotalPrice() {
    let total = 0;

    // Total penumpang
    passengerNames.forEach(slug => {
        total += (passengerCounts[slug] * passengerPrices[slug]);
    });

    // Total kendaraan
    Object.entries(vehicleCounts).forEach(([type, count]) => {
        total += (count * (vehiclePrices[type] || 0));
    });

    // Update total harga di input tiket
    const ticketPriceInput = document.getElementById('ticketPrice');
    if (ticketPriceInput) {
        ticketPriceInput.value = `Rp ${total.toLocaleString('id-ID')}`;
    }
}

// Update teks tombol pilih penumpang
function updatePassengerButtonText() {
    const btn = document.getElementById('passengerSelectBtn');
    let parts = [];

    passengerNames.forEach(slug => {
        if (passengerCounts[slug] > 0) {
            parts.push(`${passengerCounts[slug]} ${slug.replace(/_/g, ' ')}`);
        }
    });

    const vehicleTotalCount = Object.values(vehicleCounts).reduce((a, b) => a + b, 0);
    if (vehicleTotalCount > 0) {
        parts.push(`${vehicleTotalCount} kendaraan`);
    }

    if (parts.length === 0) {
        btn.innerHTML = '<span>👥</span> Pilih Penumpang dan Kendaraan';
        btn.classList.remove('has-passengers');
    } else {
        btn.innerHTML = '<span>👥</span> ' + parts.join(', ');
        btn.classList.add('has-passengers');
    }
}

// Utility buat slugify nama
function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/[^a-z0-9\s]/g, '')  // Hapus karakter non-alphanumeric (termasuk < dan >)
        .replace(/\s+/g, '_')         // Ganti spasi dengan underscore
        .replace(/^_+/, '')
        .replace(/_+$/, '');
}
function capitalizeSlug(slug) {
    return slug.charAt(0).toUpperCase() + slug.slice(1);
}

// Parse Rupiah dari string "Harga: Rp 123.000"
function parseRupiah(text) {
    if (!text) return 0;
    const num = text.replace(/[^0-9]/g, '');
    return num ? parseInt(num, 10) : 0;
}

// Inisialisasi tombol teks dan total harga di load halaman
updatePassengerButtonText();
updateTotalPrice();

// Modal buka tutup
const passengerModal = document.getElementById('passengerModal');
const passengerSelectBtn = document.getElementById('passengerSelectBtn');

passengerSelectBtn.addEventListener('click', () => {
    passengerModal.classList.add('active');
});

passengerModal.addEventListener('click', e => {
    if (e.target === passengerModal) {
        passengerModal.classList.remove('active');
    }
});

});
