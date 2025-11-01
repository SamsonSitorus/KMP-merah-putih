<!doctype html>
<html lang="en" data-assets-path="{{ asset('assets/') }}">
  @include('layouts.head')
  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- Layout page -->
        <div class="layout-page">

          {{-- Navbar di atas --}}
          @include('partials.navbar')

          {{-- Konten halaman --}}
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              @yield('content')
            </div>
          </div>

          {{-- Footer --}}
          @include('partials.footer')

        </div>
      </div>
    </div>

    @include('layouts.scripts')

  </body>
</html>
