@extends('admin.master')

@section('module', 'Product')
@section('action', 'Edit')
@push('css')
    <style>
        .inline {
            display: flex;
            justify-content: space-between;
        }

        .col-md-6 {
            padding: 0 !important;
        }

        .margin-right-4 {
            margin: 0 6px 0 0;
        }
    </style>
@endpush
@push('handlejs')
    <script>
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

    <form method="post" action="{{ route('admin.product.update', ['id' => $id]) }}" enctype="multipart/form-data">
        @csrf
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product update</h3>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Product name</label>
                            <input type="text" class="form-control" placeholder="Enter product name" name="name"
                                value="{{ old('name', $data->name) }}">
                        </div>

                        <div class="form-group inline">
                            <div class="w-50 margin-right-4">
                                <label>Price</label>
                                <input type="number" class="form-control" placeholder="Enter product price" name="price"
                                    value="{{ old('price', $data->price) }}">
                                @if ($errors->has('price'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('price')[0] }}
                                    <p>
                                @endif
                            </div>

                            <div class="w-50">
                                <label>Categories</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group inline">
                            <div class="col-md-6 margin-right-4">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1"
                                        {{ old('status', $data->status) == 1
                                            ? 'selected
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                selected'
                                            : '' }}>
                                        Show
                                    </option>
                                    <option value="2"
                                        {{ old('status', $data->status) == 2
                                            ? 'selected
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                selected'
                                            : '' }}">
                                        Hidden
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Featured</label>
                                <select class="form-control" name="featured">
                                    <option value="1"
                                        {{ old('featured', $data->featured) == 1
                                            ? 'selected
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                selected'
                                            : '' }}>
                                        Featured
                                    </option>
                                    <option
                                        value="2"{{ old('featured', $data->featured) == 2
                                            ? 'selected
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                selected'
                                            : '' }}>
                                        UnFeatured
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="4"name="description">{{ old('description', $data->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control" rows="4" name="content">{{ old('content', $data->content) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <div class="mb-4">
                                <img id="selectedImage" src='{{ asset('uploads/' . $data->image) }}'
                                    alt="example placeholder" style="width: 120px;" name="currentImage" />
                            </div>
                            @if ($errors->has('image'))
                                <p class="invalid-feedback" style="display: block">*
                                    {{ $errors->get('image')[0] }}
                                <p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="btn btn-dark btn-rounded">
                                <label class="form-label text-white m-1" for="customFile1">Choose
                                    file</label>
                                <input type="file" class="form-control d-none" id="customFile1"
                                    onchange="displaySelectedImage(event, 'selectedImage')" name="image" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer d-grid gap-2">

                <button type="submit" class="btn btn-primary " style="width: 100%">Update</button>
            </div>

        </div>
        <!-- /.card -->
    </form>
@endsection
