<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.partials.main-header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="content-wrapper">
            <!-- Loading -->
            <div id="loading" class="page-loader flex-column">
                <div>
                    <span class="spinner-border text-primary" role="status"></span>
                    <span class="text-muted fs-6 fw-semibold ">Loading...</span>
                </div>
            </div>

            <!-- Content Header (Page header) -->
            @include('admin.partials.content-header')

            <!-- Main content -->
            <section class="content">


                <!-- Alert success -->
                @if (Session::has('success'))
                    @push('handlejs')
                        <script>
                            $(function() {
                                var Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: '{{ Session::get('success') }}'
                                })
                            })
                        </script>
                    @endpush
                @endif
                <!-- Alert error -->
                @if ($errors->any())
                    @push('handlejs')
                        <script>
                            $(function() {
                                var Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Action fail'
                                })
                            })
                        </script>
                    @endpush
                @endif

                @yield('content')
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        @include('admin.partials.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('admin.partials.foot')
</body>

</html>
