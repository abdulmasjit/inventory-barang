<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/custom.style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/all/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/all/sort-table/sort-table.css') }}">
  @yield('css')
</head>
<body>
  <div class="container-scroller">
    <!-- partial:header -->
    @include('layouts/header')
    <div class="page-body-wrapper">
      <!-- partial:sidebar -->
      @include('layouts/sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- partial:footer -->
        @include('layouts.footer')
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/all/sort-table/sort-table.js') }}"></script>
  <script src="{{ asset('assets/all/sweetalert2/sweetalert2.all.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
    })

    var base_url = "{{ url('') }}";
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  </script>
  @yield('js')
</body>
</html>

