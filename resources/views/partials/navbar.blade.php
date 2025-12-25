<nav class="navbar navbar-expand-xl navbar-light bg-white shadow-sm sticky-top" id="layout-navbar"
    style="border-bottom: 2px solid #e8f0f7;">
    <div class="container-fluid px-4">

        {{-- Logo dengan animasi --}}
        <a href="/" class="navbar-brand d-flex align-items-center gap-2 position-relative" id="logo-brand">
            <div class="p-2 rounded-lg logo-container"
                style="background: linear-gradient(135deg, #ffffff 0%, #f0f4f8 100%); 
            border: 1px solid #e0e0e0; 
            transition: all 0.4s ease;">
                <img src="{{ asset('assets/img/logo.webp') }}" alt="KMP Muara Putih"
                    class="d-inline-block align-text-top logo-img"
                    style="height: 60px; transition: transform 0.5s ease;">
            </div>

            <div class="lh-1 ms-1 logo-text">
                <span class="fw-bold text-dark d-block logo-main-text"
                    style="font-size: 16px; transition: all 0.3s ease;">KMP Muara Putih</span>
                <small class="text-muted logo-sub-text" style="font-size: 12px; transition: all 0.3s ease;">Easy Ship
                    Booking</small>
            </div>

            {{-- Hover effect line --}}
            <span class="position-absolute bottom-0 start-0 w-100 bg-primary"
                style="height: 2px; transform: scaleX(0); transform-origin: left; transition: transform 0.4s ease; opacity: 0;"></span>
        </a>

        {{-- Toggle untuk mobile dengan animasi --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
            aria-label="Toggle navigation" id="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
            <span class="toggler-close d-none">✕</span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item position-relative">
                    <a href="{{ route('home') }}" class="nav-link fw-500 text-dark transition-all nav-item-link"
                        style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">
                        <span class="nav-text">Beranda</span>
                        <span class="nav-underline"></span>
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a href="#offers" class="nav-link fw-500 text-dark transition-all nav-item-link"
                        style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">
                        <span class="nav-text">Penawaran Terbaru</span>
                        <span class="nav-underline"></span>
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a href="#why-us" class="nav-link fw-500 text-dark transition-all nav-item-link"
                        style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">
                        <span class="nav-text">Mengapa Kami</span>
                        <span class="nav-underline"></span>
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a href="#partners" class="nav-link fw-500 text-dark transition-all nav-item-link"
                        style="padding: 8px 16px; border-radius: 6px; transition: all 0.3s ease;">
                        <span class="nav-text">Mitra</span>
                        <span class="nav-underline"></span>
                    </a>
                </li>

                {{-- User / Guest --}}
                @auth
                    <li class="nav-item dropdown ms-3 user-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 user-avatar-link" href="#"
                            data-bs-toggle="dropdown" style="padding: 6px 12px; transition: all 0.3s ease;">
                            <div class="position-relative avatar-container">
                                <img src="{{ optional(Auth::user()->detail)->foto_profil
                                    ? asset('storage/' . optional(Auth::user()->detail)->foto_profil)
                                    : asset('assets/img/avatars/1.png') }}"
                                    alt="User" class="rounded-circle border border-2 avatar-img"
                                    style="width: 50px; height: 50px; border-color: #0066cc !important; transition: all 0.3s ease;">
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle online-indicator">
                                    <span class="visually-hidden">Online</span>
                                </span>
                            </div>
                            <span class="fw-600 text-dark d-none d-sm-inline username-text">{{ Auth::user()->name }}</span>
                            <i class="bx bx-chevron-down dropdown-arrow" style="transition: transform 0.3s ease;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 dropdown-menu-animated"
                            style="border-radius: 8px; opacity: 0; transform: translateY(10px); transition: all 0.3s ease;">
                            <li><a class="dropdown-item fw-500 dropdown-link" href="{{ route('profile') }}">
                                    <i class="bx bx-user me-2"></i>Profil</a>
                            </li>
                            <li><a class="dropdown-item fw-500 dropdown-link" href="{{ route('history') }}">
                                    <i class="bx bx-history me-2"></i>Riwayat</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-danger fw-500 dropdown-link logout-btn">
                                        <i class="bx bx-log-out me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-3">
                        <a href="{{ route('login') }}" class="btn btn-primary fw-600 px-4 login-btn"
                            style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); border: none; border-radius: 8px; transition: all 0.3s ease; position: relative; overflow: hidden;">
                            <span class="login-text">Masuk</span>
                            <span class="btn-hover-effect"></span>
                            <i class="bx bx-log-in ms-2 login-icon"></i>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Logo Animations */
    #logo-brand:hover .logo-container {
        transform: rotate(-5deg) scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
    }

    #logo-brand:hover .logo-img {
        transform: scale(1.1);
    }

    #logo-brand:hover .logo-main-text {
        color: #0066cc !important;
        transform: translateX(3px);
    }

    #logo-brand:hover .logo-sub-text {
        color: #666 !important;
        transform: translateX(3px);
    }

    #logo-brand:hover span.bg-primary {
        opacity: 1;
        transform: scaleX(1);
    }

    /* Nav Item Animations */
    .nav-item-link {
        position: relative;
        overflow: hidden;
    }

    .nav-text {
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .nav-underline {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #0066cc, #0052a3);
        transform: translateX(-100%);
        transition: transform 0.4s ease;
    }

    .nav-item-link:hover .nav-text {
        transform: translateY(-2px);
        color: #0066cc !important;
    }

    .nav-item-link:hover .nav-underline {
        transform: translateX(0);
    }

    .nav-item-link.active .nav-underline {
        transform: translateX(0);
    }

    /* Navbar Toggler Animation */
    #navbar-toggler {
        transition: all 0.3s ease;
        position: relative;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #navbar-toggler:hover {
        background-color: #f0f5ff;
        border-radius: 8px;
        transform: rotate(90deg);
    }

    #navbar-toggler.collapsed .toggler-close {
        display: none !important;
    }

    #navbar-toggler:not(.collapsed) .navbar-toggler-icon {
        display: none;
    }

    #navbar-toggler:not(.collapsed) .toggler-close {
        display: block !important;
        font-size: 24px;
        color: #0066cc;
        transform: rotate(0deg);
        transition: transform 0.3s ease;
    }

    #navbar-toggler:not(.collapsed):hover .toggler-close {
        transform: rotate(180deg);
    }

    /* User Dropdown Animations */
    .user-avatar-link:hover .avatar-img {
        transform: scale(1.05);
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.2);
    }

    .user-avatar-link:hover .username-text {
        color: #0066cc !important;
        transform: translateX(3px);
        display: inline-block;
    }

    .user-avatar-link:hover .dropdown-arrow {
        transform: translateY(2px);
        color: #0066cc;
    }

    .online-indicator {
        width: 12px;
        height: 12px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(40, 167, 69, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    .dropdown-menu.show {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }

    .dropdown-link {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 10px 20px !important;
        border-radius: 6px;
        margin: 2px 8px;
        width: auto;
    }

    .dropdown-link::before {
        content: '';
        position: absolute;
        left: -100%;
        top: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(0, 102, 204, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .dropdown-link:hover::before {
        left: 100%;
    }

    .dropdown-link:hover {
        background-color: #f0f5ff !important;
        color: #0066cc !important;
        transform: translateX(5px);
        padding-left: 25px !important;
    }

    .logout-btn:hover {
        background-color: #fff5f5 !important;
        transform: translateX(5px);
    }

    /* Login Button Animations */
    .login-btn {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-hover-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: -1;
    }

    .login-btn:hover .btn-hover-effect {
        width: 300px;
        height: 300px;
    }

    .login-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 102, 204, 0.4) !important;
    }

    .login-btn:hover .login-text {
        display: inline-block;
        transform: translateX(-3px);
    }

    .login-btn:hover .login-icon {
        transform: translateX(3px) rotate(-10deg);
    }

    .login-text,
    .login-icon {
        transition: transform 0.3s ease;
        display: inline-block;
    }

    /* Navbar Collapse Animation */
    .navbar-collapse {
        transition: all 0.4s ease;
    }

    .navbar-collapse.collapsing {
        transition: height 0.4s ease;
    }

    /* Smooth scrolling for anchor links */
    html {
        scroll-behavior: smooth;
    }

    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .navbar-nav {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-item-link {
            padding: 12px 20px !important;
            display: block;
        }

        .user-dropdown {
            margin-top: 10px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .login-btn {
            margin-top: 10px;
            width: 100%;
            justify-content: center;
        }
    }

    /* Sticky navbar animation */
    #layout-navbar {
        transition: all 0.3s ease;
        top: 0;
    }

    #layout-navbar.scrolled {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle button animation
        const navbarToggler = document.getElementById('navbar-toggler');
        const navbarCollapse = document.getElementById('navbar-collapse');

        if (navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                this.classList.toggle('collapsed');

                // Add rotation animation
                if (this.classList.contains('collapsed')) {
                    this.style.transform = 'rotate(0deg)';
                } else {
                    this.style.transform = 'rotate(90deg)';
                }
            });
        }

        // Smooth hover animations for nav items
        const navLinks = document.querySelectorAll('.nav-item-link');
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', function(e) {
                const text = this.querySelector('.nav-text');
                if (text) {
                    text.style.transform = 'translateY(-2px)';
                }
            });

            link.addEventListener('mouseleave', function(e) {
                const text = this.querySelector('.nav-text');
                if (text) {
                    text.style.transform = 'translateY(0)';
                }
            });
        });

        // Dropdown animation
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');
            const menu = dropdown.querySelector('.dropdown-menu');

            if (toggle && menu) {
                toggle.addEventListener('show.bs.dropdown', function() {
                    setTimeout(() => {
                        menu.style.opacity = '1';
                        menu.style.transform = 'translateY(0)';
                    }, 10);
                });

                toggle.addEventListener('hide.bs.dropdown', function() {
                    menu.style.opacity = '0';
                    menu.style.transform = 'translateY(10px)';
                });
            }
        });

        // Logo hover effect
        const logoBrand = document.getElementById('logo-brand');
        if (logoBrand) {
            logoBrand.addEventListener('mouseenter', function() {
                const line = this.querySelector('.bg-primary');
                if (line) {
                    line.style.opacity = '1';
                    line.style.transform = 'scaleX(1)';
                }
            });

            logoBrand.addEventListener('mouseleave', function() {
                const line = this.querySelector('.bg-primary');
                if (line) {
                    line.style.opacity = '0';
                    line.style.transform = 'scaleX(0)';
                }
            });
        }

        // Sticky navbar effect
        const navbar = document.getElementById('layout-navbar');
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Add shadow when scrolled
            if (scrollTop > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Hide/show navbar on scroll
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scroll down
                navbar.style.top = '-100px';
            } else {
                // Scroll up
                navbar.style.top = '0';
            }

            lastScrollTop = scrollTop;
        });

        // Active nav link based on scroll position
        const sections = document.querySelectorAll('section[id]');
        const navItems = document.querySelectorAll('.nav-item-link');

        function highlightNavLink() {
            let scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                const navLink = document.querySelector(`.nav-item-link[href="#${sectionId}"]`);

                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    navItems.forEach(item => item.classList.remove('active'));
                    if (navLink) navLink.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', highlightNavLink);

        // Ripple effect for login button
        const loginBtn = document.querySelector('.login-btn');
        if (loginBtn) {
            loginBtn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.7);
                    transform: scale(0);
                    animation: ripple-animation 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    top: ${y}px;
                    left: ${x}px;
                    pointer-events: none;
                `;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Avatar hover effect
        const avatarImg = document.querySelector('.avatar-img');
        if (avatarImg) {
            avatarImg.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05) rotate(5deg)';
            });

            avatarImg.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        }
    });
</script>
