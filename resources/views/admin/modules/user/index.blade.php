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
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Create At</th>
                        <th>Update At</th>
                        @if (Auth::user()->level == 2)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>

                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td><span
                                    class="right badge badge-{{ $user->level == 1 ? 'primary' : ($user->level == 2 && $user->id == '9ab0345b-59de-4d6f-85ac-091cfc88204d' ? 'danger' : 'dark') }}">{{ $user->level == 1 ? 'Member' : ($user->level == 2 && $user->id == '9ab0345b-59de-4d6f-85ac-091cfc88204d' ? 'Superadmin' : 'Admin') }}</span>
                            </td>
                            <td>
                                <span class="right badge badge-{{ $user->status === 1 ? 'success' : 'warning' }}">
                                    {{ $user->status === 1 ? 'Show' : 'Hidden' }}</span>

                            </td>

                            <td>
                                {{ date('d/m/Y  H:i:s', strtotime($user->created_at)) }}
                            </td>
                            <td>
                                {{ date('d/m/Y  H:i:s', strtotime($user->updated_at)) }}
                            </td>
                            @if (Auth::user()->level == 2)
                                <td class="min-width">
                                    <div class="flex">
                                        <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                            class="text-dark btn btn-warning">Edit</a>
                                        <a data-url="{{ route('admin.user.destroy', ['id' => $user->id]) }}"
                                            class="text-white btn btn-danger confirm"
                                            value="{{ $user->email }}">Delete</a>
                                    </div>

                                </td>
                            @endif


                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Create At</th>
                        <th>Update At</th>
                        @if (Auth::user()->level == 2)
                            <th>Action</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card -->


@endsection
