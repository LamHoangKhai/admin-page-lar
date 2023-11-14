@extends('admin.master')

@section('module', 'Product')
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
    <script defer>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
@endpush

@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="">Products</h3>

            <button style="position: absolute;right:18px" type="button" class="btn btn-primary align-self-end"
                data-toggle="modal" data-target="#addNewProduct">+ Add
                Product</button>
        </div>


        @include('admin.modules.product.modals.create')

        {{-- Render data --}}
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Create At</th>
                        <th>Update At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }} VND</td>
                            <td><span
                                    class="right badge badge-{{ $product->status == 1 ? 'success' : 'secondary' }}">{{ $product->status == 1 ? 'Show' : 'Hidden' }}</span>
                            </td>
                            <td><span
                                    class="right badge badge-{{ $product->featured == 1 ? 'primary' : 'danger' }}">{{ $product->featured == 1 ? 'Featured' : 'Unfeatured' }}</span>
                            </td>
                            <td>
                                {{ date('d/m/Y  H:i:s', strtotime($product->created_at)) }}
                            </td>
                            <td>
                                {{ date('d/m/Y  H:i:s', strtotime($product->updated_at)) }}
                            </td>
                            <td class="col-md-3">
                                <div class="flex">
                                    <button type="button" class="text-dark btn btn-info" data-toggle="modal"
                                        data-target="#showModal{{ $product->id }}">
                                        Detail
                                    </button>

                                    <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}"
                                        class="text-dark btn btn-warning ">Edit</a>
                                    <a data-url="{{ route('admin.product.destroy', ['id' => $product->id]) }}"
                                        class="text-white confirm btn btn-danger" value="{{ $product->name }}">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @include('admin.modules.product.modals.show')
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Create At</th>
                        <th>Update At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            {{-- End Render data --}}
        </div>

    </div>
    <!-- /.card -->


@endsection
