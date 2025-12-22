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
    // Vehicle bocls
    // oking state (support multiple vehicle types)
    // vehicleSelections: { 'Motor Bebek': count, ... }
    let vehicleSelections = {};
    // vehiclePrices: { 'Motor Bebek': unitPrice, ... }
    let vehiclePrices = {};

    const dewasaCount = document.getElementById('countDewasa');
    const anakCount = document.getElementById('countAnak');
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
        // fetch prices for currently selected vehicle types (if any)
        const selectedTypes = Array.from(document.querySelectorAll('.vehicle-checkbox:checked')).map(c => c.dataset.type);
        fetchPrices(origin, destination, selectedTypes);
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

            // vType can be string or array. For multi-selection, vType is an array.
            if (!vType) {
                vehiclePrices = {};
                vehiclePriceDisplay.textContent = 'Harga: -';
            } else if (Array.isArray(vType)) {
                // fetch each selected vehicle's price
                vehiclePrices = vehiclePrices || {};
                for (let t of vType) {
                    try {
                        const res = await fetch(`/get-price?origin_port_id=${origin}&destination_port_id=${destination}&vehicle_type=${encodeURIComponent(t)}`);
                        const data = await res.json();
                        vehiclePrices[t] = data.price || 0;
                        // populate per-item price display if exists
                        const slug = t.toString().toLowerCase().replace(/[^a-z0-9]+/g, '_');
                        const el = document.getElementById('price_' + slug);
                        if (el) el.textContent = vehiclePrices[t] ? ('Rp ' + parseInt(vehiclePrices[t]).toLocaleString('id-ID')) : '-';
                    } catch (err) {
                        console.warn('Error fetching vehicle price for', t, err);
                        vehiclePrices[t] = 0;
                    }
                }
                // update aggregate vehicle price display (sum of selected unit prices)
                const sum = Object.values(vehiclePrices).reduce((s, v) => s + (v || 0), 0);
                vehiclePriceDisplay.textContent = sum ? ('Harga: Rp ' + parseInt(sum).toLocaleString('id-ID')) : 'Harga: -';
            } else {
                // single string
                const resVehicle = await fetch(`/get-price?origin_port_id=${origin}&destination_port_id=${destination}&vehicle_type=${encodeURIComponent(vType)}`);
                const dataVehicle = await resVehicle.json();
                vehiclePrices = {};
                vehiclePrices[vType] = dataVehicle.price || 0;
                vehiclePriceDisplay.textContent = vehiclePrices[vType] ? ('Harga: Rp ' + parseInt(vehiclePrices[vType]).toLocaleString('id-ID')) : 'Harga: -';
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

    // Bind plus/minus buttons per vehicle type
    document.querySelectorAll('.vehicle-plus').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const t = btn.dataset.type;
            // ensure checkbox is checked
            const chk = document.querySelector(`.vehicle-checkbox[data-type="${t}"]`);
            if (chk && !chk.checked) { chk.checked = true; }
            vehicleSelections[t] = (vehicleSelections[t] || 0) + 1;
            const slug = t.toString().toLowerCase().replace(/[^a-z0-9]+/g, '_');
            const display = document.getElementById('count_' + slug);
            if (display) display.textContent = vehicleSelections[t];
            // fetch price for this type if not present
            const origin = asalSelect.value; const destination = tujuanId.value;
            if (origin && destination) fetchPrices(origin, destination, [t]).then(() => updateTotalPrice());
            else updateTotalPrice();
        });
    });

    document.querySelectorAll('.vehicle-minus').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const t = btn.dataset.type;
            if (!vehicleSelections[t]) return;
            vehicleSelections[t] = Math.max(0, vehicleSelections[t] - 1);
            const slug = t.toString().toLowerCase().replace(/[^a-z0-9]+/g, '_');
            const display = document.getElementById('count_' + slug);
            if (display) display.textContent = vehicleSelections[t];
            if (vehicleSelections[t] === 0) {
                const chk = document.querySelector(`.vehicle-checkbox[data-type="${t}"]`);
                if (chk) chk.checked = false;
                delete vehicleSelections[t];
            }
            updateTotalPrice();
        });
    });

    // When a checkbox toggles, initialize or remove selection
    document.querySelectorAll('.vehicle-checkbox').forEach(chk => {
        chk.addEventListener('change', (e) => {
            const t = chk.dataset.type;
            if (chk.checked) {
                vehicleSelections[t] = vehicleSelections[t] || 1;
                const slug = t.toString().toLowerCase().replace(/[^a-z0-9]+/g, '_');
                const display = document.getElementById('count_' + slug);
                if (display) display.textContent = vehicleSelections[t];
                const origin = asalSelect.value; const destination = tujuanId.value;
                if (origin && destination) fetchPrices(origin, destination, [t]).then(() => updateTotalPrice());
                else updateTotalPrice();
            } else {
                delete vehicleSelections[t];
                const slug = t.toString().toLowerCase().replace(/[^a-z0-9]+/g, '_');
                const display = document.getElementById('count_' + slug);
                if (display) display.textContent = '0';
                updateTotalPrice();
            }
        });
    });

    function updateTotalPrice() {
        // compute vehicle total from selections and their unit prices
        let vehicleTotal = 0;
        for (const [t, cnt] of Object.entries(vehicleSelections)) {
            const unit = vehiclePrices[t] || 0;
            vehicleTotal += (cnt || 0) * unit;
        }
        const total = (dewasa * dewasaPrice) + (anak * anakPrice) + vehicleTotal;
        if (total > 0) priceInput.value = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
        else priceInput.value = 'Rp 0';
    }

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

        // remove any previously injected vehicle hidden inputs
        const form = document.getElementById('ticketForm');
        form.querySelectorAll('.injected-vehicle-input').forEach(n => n.remove());

        // populate hidden inputs for selected vehicles (arrays)
        const types = Object.keys(vehicleSelections);
        let firstType = '';
        let firstCount = 0;
        let firstPrice = 0;
        types.forEach((t, idx) => {
            const cnt = vehicleSelections[t] || 0;
            const unit = vehiclePrices[t] || 0;
            const inpT = document.createElement('input'); inpT.type = 'hidden'; inpT.name = 'vehicle_types[]'; inpT.value = t; inpT.className = 'injected-vehicle-input';
            const inpC = document.createElement('input'); inpC.type = 'hidden'; inpC.name = 'vehicle_counts[]'; inpC.value = cnt; inpC.className = 'injected-vehicle-input';
            const inpP = document.createElement('input'); inpP.type = 'hidden'; inpP.name = 'vehicle_prices[]'; inpP.value = unit; inpP.className = 'injected-vehicle-input';
            form.appendChild(inpT); form.appendChild(inpC); form.appendChild(inpP);
            if (idx === 0) { firstType = t; firstCount = cnt; firstPrice = unit; }
        });

        // keep legacy single fields for backward compatibility
        document.getElementById('vehiclePriceInput').value = firstPrice || 0;
        document.getElementById('vehicleCountInput').value = firstCount || 0;
        document.getElementById('vehicleTypeInput').value = firstType || '';

        passengerModal.classList.remove('active');
    });

    const ticketForm = document.getElementById('ticketForm');
    ticketForm.addEventListener('submit', function(e) {
        document.getElementById('dewasaPriceInput').value = dewasaPrice;
        document.getElementById('anakPriceInput').value = anakPrice;

        // ensure hidden vehicle array inputs are present before submit (in case user didn't click DONE)
        const form = document.getElementById('ticketForm');
        form.querySelectorAll('.injected-vehicle-input').forEach(n => n.remove());
        const types = Object.keys(vehicleSelections);
        let firstType = '';
        let firstCount = 0;
        let firstPrice = 0;
        types.forEach((t, idx) => {
            const cnt = vehicleSelections[t] || 0;
            const unit = vehiclePrices[t] || 0;
            const inpT = document.createElement('input'); inpT.type = 'hidden'; inpT.name = 'vehicle_types[]'; inpT.value = t; inpT.className = 'injected-vehicle-input';
            const inpC = document.createElement('input'); inpC.type = 'hidden'; inpC.name = 'vehicle_counts[]'; inpC.value = cnt; inpC.className = 'injected-vehicle-input';
            const inpP = document.createElement('input'); inpP.type = 'hidden'; inpP.name = 'vehicle_prices[]'; inpP.value = unit; inpP.className = 'injected-vehicle-input';
            form.appendChild(inpT); form.appendChild(inpC); form.appendChild(inpP);
            if (idx === 0) { firstType = t; firstCount = cnt; firstPrice = unit; }
        });

        // set legacy fields
        document.getElementById('vehiclePriceInput').value = firstPrice || 0;
        document.getElementById('vehicleCountInput').value = firstCount || 0;
        document.getElementById('vehicleTypeInput').value = firstType || '';

        const depInput = document.getElementById('departureDateInput');
        const depValue = depInput ? depInput.value : null;
        if (!depValue) { window.showAlert('Pilih tanggal keberangkatan.', 'warning', { title: 'Validasi' }); e.preventDefault(); return; }
        const today = new Date(); today.setHours(0,0,0,0); const depDate = new Date(depValue + 'T00:00:00'); if (depDate < today) { window.showAlert('Tanggal keberangkatan tidak boleh sebelum hari ini.', 'warning', { title: 'Validasi' }); e.preventDefault(); return; }
        if (anak > 0 && dewasa === 0) { window.showAlert('Jika memesan anak-anak, minimal harus ada 1 orang dewasa.', 'warning', { title: 'Validasi' }); e.preventDefault(); passengerModal.classList.add('active'); return; }
        if (Object.keys(vehicleSelections).length > 0 && Object.values(vehicleSelections).reduce((s,v) => s + (v||0), 0) > 0 && Object.keys(vehicleSelections).length === 0) {
            window.showAlert('Pilih jenis kendaraan untuk kendaraan yang dipesan.', 'warning', { title: 'Validasi' }); e.preventDefault(); passengerModal.classList.add('active'); return;
        }
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
