@push('css')
    <style>
        .inline {
            display: flex;
            justify-content: space-around;
        }

        .inline .col-md-6 {
            padding: 0 !important;
        }

        .margin-right-4 {
            margin: 0 6px 0 0;
        }
    </style>
@endpush
@if ($errors->any())
    @push('handlejs')
        <script>
            $("#addNewProduct").modal("show");
        </script>
    @endpush
@endif

<div class="modal fade" id="addNewProduct" tabindex="-1" role="dialog" aria-labelledby="addNewProductLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewProductLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <label>Product name</label>
                                <input type="text" class="form-control" placeholder="Enter product name"
                                    name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('name')[0] }}
                                    <p>
                                @endif
                            </div>

                            <div class="form-group inline">
                                <div class="w-50 margin-right-4">
                                    <label>Price</label>
                                    <input type="number" class="form-control" placeholder="Enter product price"
                                        name="price" value="{{ old('price') }}">
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
                                <div class="w-50 margin-right-4">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Show
                                        </option>
                                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Hidden
                                        </option>
                                    </select>
                                </div>

                                <div class="w-50">
                                    <label>Featured</label>
                                    <select class="form-control" name="featured">
                                        <option value="1"{{ old('featured', 1) == 1 ? 'selected' : '' }}>
                                            Featured
                                        </option>
                                        <option value="2" {{ old('featured') == 2 ? 'selected' : '' }}>
                                            Unfeatured
                                        </option>
                                    </select>
                                </div>

                            </div>



                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control" rows="3" name="content">{{ old('content') }}</textarea>
                            </div>



                            <div class="form-group">
                                <label>Image</label>
                                <div class="mb-4">
                                    <img id="selectedImage"
                                        src='https://mdbootstrap.com/img/Photos/Others/placeholder.jpg'
                                        alt="example placeholder" style="width: 120px;" />
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
