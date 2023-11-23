@extends('admin.master')

@section('module', 'Product')
@section('action', 'List')

@push('css')
    <link rel="stylesheet" href="{{ asset('administrator/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('administrator/plugins/datatables-responsive/css/responsive.bootstrap4.min.css ') }}">
    <link rel="stylesheet" href="{{ asset('administrator/plugins/datatables-buttons/css/buttons.bootstrap4.min.css ') }}">
    <style>
        div label span {
            font-weight: 400 !important;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('administrator/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('administrator/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>


    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
@endpush

@push('handlejs')
    <script src="{{ asset('administrator/custom/js/search-fitler.js') }}"></script>
    <script src="{{ asset('administrator/custom/js/get-category.js') }}"></script>
@endpush

@section('content')
    <input type="hidden" id="url" data-url="{{ route('search') }}">
    <!-- Default box -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="">Products</h3>

        </div>



        {{-- Render data --}}
        <div class="card-body">
            <div>
                <div><label>Search: <input type="text" id="search" /></label></div>
                <div>
                    <label for="status">Status:
                        <span>Show</span>
                        <input type="checkbox" class="filter" name="status" value="1">
                        <span>Hidden</span>
                        <input type="checkbox" class="filter" name="status" value="2">
                    </label>
                </div>

                <div>
                    <label for="featured">Featured:
                        <span>Featured</span>
                        <input type="checkbox" class="filter" name="featured" value="1">
                        <span>Unfeatured</span>
                        <input type="checkbox" class="filter" name="featured" value="2">
                    </label>
                </div>


                <div>
                    <label for="featured">Category
                        <select id="category">

                        </select>
                    </label>
                </div>

            </div>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>

                    </tr>
                </thead>

                <tbody id="renderData">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><span class="right badge badge-"></span>
                        </td>
                        <td><span class="right badge badge- "></span>
                        </td>

                    </tr>
                </tbody>
                <tfoot>

                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>

                    </tr>
                </tfoot>

            </table>
            {{-- End Render data --}}
            <div id="pagination" class="text-center"></div>

        </div>

    </div>
    <!-- /.card -->


@endsection
