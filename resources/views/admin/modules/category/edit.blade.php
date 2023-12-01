@extends('admin.master')

@section('module', 'Category')
@section('action', 'Edit')

@section('content')
    <form method="post" action="{{ route('admin.category.update', ['id' => $id]) }}">
        @csrf
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Category update</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Category parent</label>
                    <select class="form-control" name="parent_id">
                        <option value="0">----- Root -----</option>
                        @php
                            RootCategory($categories, old('parent_id', 0));
                        @endphp
                    </select>
                </div>

                <div class="form-group">
                    <label>Category name</label>
                    <input type="text" class="form-control" placeholder="Enter category name" name="name"
                        value="{{ old('name', $data->name) }}">
                    @if ($errors->has('name'))
                        <p class="invalid-feedback" style="display: block">*
                            {{ $errors->get('name')[0] }}
                        <p>
                    @endif
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{ old('status', $data->status) == 1 ? 'selected' : '' }}>Show</option>
                        <option value="2" {{ old('status', $data->status) == 2 ? 'selected' : '' }}>Hidden</option>
                    </select>
                </div>
            </div>

            <div class="card-footer d-grid gap-2">

                <button type="submit" class="btn btn-primary " style="width: 100%">Update</button>
            </div>

        </div>
        <!-- /.card -->
    </form>
@endsection
