<!doctype html>
<html lang="en" data-assets-path="{{ asset('assets/') }}">
  @include('layouts.head')

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          {{-- Konten login/register --}}
          @yield('content')
        </div>
      </div>
    </div>

    @include('layouts.scripts')
   @stack('scripts')
  </body>
</html>
