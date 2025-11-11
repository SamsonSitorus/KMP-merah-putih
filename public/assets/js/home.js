// Externalized JS for resources/views/user/home.blade.php
// Assumes a small inline `window.HomePageData = { muaraId: '...', sipingganId: '...'}` object is present in the Blade before this script is loaded.
document.addEventListener('DOMContentLoaded', function() {
    const asalSelect = document.getElementById('asalSelect');
    const tujuanInput = document.getElementById('tujuanInput');
    const tujuanId = document.getElementById('tujuanId');
    const priceInput = document.getElementById('ticketPrice');
    const timeInput = document.getElementById('jamKeberangkatan');

    const passengerModal = document.getElementById('passengerModal');
    const passengerSelectBtn = document.getElementById('passengerSelectBtn');
    const dewasaPriceDisplay = document.getElementById('dewasaPriceDisplay');
    const anakPriceDisplay = document.getElementById('anakPriceDisplay');

    let dewasa = 0;
    let anak = 0;
    let dewasaPrice = 0;
    let anakPrice = 0;
    // Vehicle booking state
    let vehicleCount = 0;
    let vehiclePrice = 0;
    let vehicleType = '';

    const dewasaCount = document.getElementById('countDewasa');
    const anakCount = document.getElementById('countAnak');
    const vehicleCountDisplay = document.getElementById('countVehicle');
    const vehicleTypeSelect = document.getElementById('vehicleTypeSelect');
    const vehiclePriceDisplay = document.getElementById('vehiclePriceDisplay');

    function updatePassengerButtonText() {
        const totalPassengers = dewasa + anak;
        if (totalPassengers === 0) {
            passengerSelectBtn.innerHTML = '<span>👥</span> Pilih Penumpang';
            passengerSelectBtn.classList.remove('has-passengers');
        } else {
            let summary = '';
            const parts = [];
            if (dewasa > 0) { parts.push(`${dewasa} Dewasa`); }
            if (anak > 0) { parts.push(`${anak} Anak-anak`); }
            summary = '<span>👥</span> ' + parts.join(', ');
            passengerSelectBtn.innerHTML = summary;
            passengerSelectBtn.classList.add('has-passengers');
        }
    }

    passengerSelectBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const origin = asalSelect.value;
        const destination = tujuanId.value;
        if (!origin || !destination) {
            window.showAlert('Pilih pelabuhan asal dan tujuan terlebih dahulu.', 'warning', { title: 'Validasi' });
            return;
        }
        fetchPrices(origin, destination, vehicleTypeSelect.value);
        passengerModal.classList.add('active');
    });

    passengerModal.addEventListener('click', (e) => {
        if (e.target === passengerModal) passengerModal.classList.remove('active');
    });

    async function fetchPrices(origin, destination, vType = '') {
        try {
            const resDewasa = await fetch(`/get-price?origin_port_id=${origin}&destination_port_id=${destination}&passenger_type=Dewasa`);
            const dataDewasa = await resDewasa.json();
            dewasaPrice = dataDewasa.price || 0;
            dewasaPriceDisplay.textContent = `Harga: ${dewasaPrice ? 'Rp ' + parseInt(dewasaPrice).toLocaleString('id-ID') : '-'}`;
            if (dataDewasa.departure_time) timeInput.value = dataDewasa.departure_time;

            const resAnak = await fetch(`/get-price?origin_port_id=${origin}&destination_port_id=${destination}&passenger_type=Anak-anak`);
            const dataAnak = await resAnak.json();
            anakPrice = dataAnak.price || 0;
            anakPriceDisplay.textContent = `Harga: ${anakPrice ? 'Rp ' + parseInt(anakPrice).toLocaleString('id-ID') : '-'}`;
            if (!timeInput.value && dataAnak.departure_time) timeInput.value = dataAnak.departure_time;

            if (vType) {
                const resVehicle = await fetch(`/get-price?origin_port_id=${origin}&destination_port_id=${destination}&vehicle_type=${encodeURIComponent(vType)}`);
                const dataVehicle = await resVehicle.json();
                vehiclePrice = dataVehicle.price || 0;
                vehiclePriceDisplay.textContent = `Harga: ${vehiclePrice ? 'Rp ' + parseInt(vehiclePrice).toLocaleString('id-ID') : '-'}`;
            } else {
                vehiclePrice = 0;
                vehiclePriceDisplay.textContent = 'Harga: -';
            }
        } catch (err) {
            console.error('Error fetching prices:', err);
            window.showAlert('Gagal mengambil data harga tiket.', 'error', { title: 'Network' });
        }
    }

    document.getElementById('plusDewasa').addEventListener('click', (e) => { e.preventDefault(); dewasa++; dewasaCount.textContent = dewasa; document.getElementById('dewasaCountInput').value = dewasa; updateTotalPrice(); updatePassengerButtonText(); });
    document.getElementById('minusDewasa').addEventListener('click', (e) => { e.preventDefault(); if (dewasa > 0) dewasa--; dewasaCount.textContent = dewasa; document.getElementById('dewasaCountInput').value = dewasa; updateTotalPrice(); updatePassengerButtonText(); });
    document.getElementById('plusAnak').addEventListener('click', (e) => { e.preventDefault(); anak++; anakCount.textContent = anak; document.getElementById('anakCountInput').value = anak; updateTotalPrice(); updatePassengerButtonText(); });
    document.getElementById('minusAnak').addEventListener('click', (e) => { e.preventDefault(); if (anak > 0) anak--; anakCount.textContent = anak; document.getElementById('anakCountInput').value = anak; updateTotalPrice(); updatePassengerButtonText(); });

    document.getElementById('plusVehicle').addEventListener('click', (e) => {
        e.preventDefault();
        const selected = vehicleTypeSelect.value;
        if (!selected) { window.showAlert('Pilih jenis kendaraan terlebih dahulu.', 'warning', { title: 'Validasi' }); return; }
        vehicleType = selected;
        vehicleCount++;
        vehicleCountDisplay.textContent = vehicleCount;
        document.getElementById('vehicleCountInput').value = vehicleCount;
        document.getElementById('vehicleTypeInput').value = vehicleType;
        updateTotalPrice();
    });

    document.getElementById('minusVehicle').addEventListener('click', (e) => { e.preventDefault(); if (vehicleCount > 0) vehicleCount--; vehicleCountDisplay.textContent = vehicleCount; document.getElementById('vehicleCountInput').value = vehicleCount; if (vehicleCount === 0) { document.getElementById('vehicleTypeInput').value = ''; vehicleType = ''; } updateTotalPrice(); });

    vehicleTypeSelect.addEventListener('change', (e) => {
        vehicleType = e.target.value; document.getElementById('vehicleTypeInput').value = vehicleType; const origin = asalSelect.value; const destination = tujuanId.value; if (!origin || !destination) { vehiclePrice = 0; vehiclePriceDisplay.textContent = 'Harga: -'; return; } if (vehicleType) { fetchPrices(origin, destination, vehicleType).then(() => { document.getElementById('vehiclePriceInput').value = vehiclePrice; updateTotalPrice(); }); } else { vehiclePrice = 0; vehiclePriceDisplay.textContent = 'Harga: -'; document.getElementById('vehiclePriceInput').value = 0; updateTotalPrice(); } });

    function updateTotalPrice() { const vehicleTotal = vehicleCount * vehiclePrice; const total = (dewasa * dewasaPrice) + (anak * anakPrice) + vehicleTotal; if (total > 0) priceInput.value = `Rp ${parseInt(total).toLocaleString('id-ID')}`; else priceInput.value = 'Rp 0'; }

    // Auto-set destination using window.HomePageData (inlined by Blade)
    if (asalSelect) {
        asalSelect.addEventListener('change', function() {
            const selectedAsal = asalSelect.options[asalSelect.selectedIndex].dataset.name;
            const muaraId = window.HomePageData ? window.HomePageData.muaraId : '';
            const sipingganId = window.HomePageData ? window.HomePageData.sipingganId : '';

            if (selectedAsal === 'muara') {
                tujuanInput.value = 'Sipinggan';
                tujuanId.value = sipingganId || '';
            } else if (selectedAsal === 'sipinggan') {
                tujuanInput.value = 'Muara';
                tujuanId.value = muaraId || '';
            } else {
                tujuanInput.value = '';
                tujuanId.value = '';
            }

            // Reset price display and passenger counts
            priceInput.value = 'Rp 0'; dewasaPriceDisplay.textContent = 'Harga: -'; anakPriceDisplay.textContent = 'Harga: -'; vehiclePriceDisplay.textContent = 'Harga: -'; dewasa = 0; anak = 0; vehicleCount = 0; vehiclePrice = 0; vehicleType = ''; dewasaCount.textContent = '0'; anakCount.textContent = '0'; vehicleCountDisplay.textContent = '0'; updatePassengerButtonText(); document.getElementById('dewasaCountInput').value = 0; document.getElementById('anakCountInput').value = 0; document.getElementById('vehicleCountInput').value = 0; document.getElementById('vehiclePriceInput').value = 0; document.getElementById('vehicleTypeInput').value = '';
        });
    }

    document.getElementById('donePassenger').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('dewasaPriceInput').value = dewasaPrice;
        document.getElementById('anakPriceInput').value = anakPrice;
        document.getElementById('vehiclePriceInput').value = vehiclePrice;
        document.getElementById('vehicleCountInput').value = vehicleCount;
        document.getElementById('vehicleTypeInput').value = vehicleType;
        passengerModal.classList.remove('active');
    });

    const ticketForm = document.getElementById('ticketForm');
    ticketForm.addEventListener('submit', function(e) {
        document.getElementById('dewasaPriceInput').value = dewasaPrice;
        document.getElementById('anakPriceInput').value = anakPrice;
        document.getElementById('vehiclePriceInput').value = vehiclePrice;
        document.getElementById('vehicleCountInput').value = vehicleCount;
        document.getElementById('vehicleTypeInput').value = vehicleType;

        const depInput = document.getElementById('departureDateInput');
        const depValue = depInput ? depInput.value : null;
        if (!depValue) { window.showAlert('Pilih tanggal keberangkatan.', 'warning', { title: 'Validasi' }); e.preventDefault(); return; }
        const today = new Date(); today.setHours(0,0,0,0); const depDate = new Date(depValue + 'T00:00:00'); if (depDate < today) { window.showAlert('Tanggal keberangkatan tidak boleh sebelum hari ini.', 'warning', { title: 'Validasi' }); e.preventDefault(); return; }
        if (anak > 0 && dewasa === 0) { window.showAlert('Jika memesan anak-anak, minimal harus ada 1 orang dewasa.', 'warning', { title: 'Validasi' }); e.preventDefault(); passengerModal.classList.add('active'); return; }
        if (vehicleCount > 0 && !vehicleType) { window.showAlert('Pilih jenis kendaraan untuk kendaraan yang dipesan.', 'warning', { title: 'Validasi' }); e.preventDefault(); passengerModal.classList.add('active'); return; }
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
});
