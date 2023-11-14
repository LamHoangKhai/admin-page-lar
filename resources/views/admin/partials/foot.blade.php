<!-- jQuery -->
<script src="{{ asset('administrator/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('administrator/plugins/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('administrator/plugins/sweetalert2/sweetalert2.min.js') }}" defer></script>
<script src="{{ asset('administrator/custom/js/alert-confirm.js') }}" defer></script>

@stack('js')

<!-- AdminLTE App -->
<script src="{{ asset('administrator/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('administrator/dist/js/demo.js') }}"></script>

@stack('handlejs')
