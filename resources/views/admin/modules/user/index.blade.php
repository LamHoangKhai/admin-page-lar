@extends('admin.master')

@section('module', 'User')
@section('action', 'List')

@push('css')
    <link rel="stylesheet" href="{{ asset('administrator/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('administrator/plugins/datatables-responsive/css/responsive.bootstrap4.min.css ') }}">
    <link rel="stylesheet" href="{{ asset('administrator/plugins/datatables-buttons/css/buttons.bootstrap4.min.css ') }}">
@endpush

@push('js')
    <script src="{{ asset('administrator/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endpush

@push('handlejs')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush

@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="">Users</h3>

            <button style="position: absolute;right:18px" type="button" class="btn btn-primary align-self-end"
                data-toggle="modal" data-target="#addUser">+ Add
                User</button>
        </div>
        {{--  modal add user --}}
        @include('admin.modules.user.modals.create')

        {{--  modal add user --}}

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Full Name</th>
                        <th>Phone</th>

                        <th>Create At</th>
                        <th>Update At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span
                                    class="right badge badge-{{ $user->level == 1 ? 'primary' : 'dark' }}">{{ $user->level == 1 ? 'Member' : 'Admin' }}</span>
                            </td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->phone }}</td>

                            <td>
                                {{ date('d/m/Y  H:i:s', strtotime($user->created_at)) }}
                            </td>
                            <td>
                                {{ date('d/m/Y  H:i:s', strtotime($user->updated_at)) }}
                            </td>

                            <td class="min-width">
                                <div class="flex">
                                    <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                        class="text-dark btn btn-warning">Edit</a>
                                    <a data-url="{{ route('admin.user.destroy', ['id' => $user->id]) }}"
                                        class="text-white btn btn-danger confirm" value="{{ $user->email }}">Delete</a>
                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Create At</th>
                        <th>Update At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card -->


@endsection
