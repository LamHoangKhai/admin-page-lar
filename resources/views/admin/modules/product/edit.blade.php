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
    <script src="{{ asset('administrator/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(document).ready(() => {

            $(".file_old").change((e) => {
                let file = e.target.files[0];
                let number = e.target.getAttribute("data-image");
                let url = $(`#urlUpdate`).attr("data-url");
                if (file) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        $(`#file_old-image-${number}`).attr("src", e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
                uploadImage(e.target.files[0], url);
            })

            $(".delete-image").click((e) => {
                let imageNumner = e.target.getAttribute("data-image");
                let url = $(`#deleteURL`).attr("data-url");
                $("#image-" + imageNumner).closest(".col-md-2").remove();
                deleteImage(url);
            })

            let countImage = 0
            $("#add-image").click(() => {
                countImage++;
                let newInputImage = `<div class="col-md-2 mt-2 mr-2 p-0 newImg">
                            <div class="w-100">
                             <button type="button" class="bnt btn-danger  w-100 delete-image"
                                 data-image="${countImage}"><i class="fas fa-minus"></i></button>
                            </div>
                              <div class="w-100 mt-1 mb-1"> <img
                                  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTaEOJh-qPS_3nv3Nj8kx59uWRtOSdLGvsYQg&usqp=CAU"
                                   alt="" width="100%" height="150" id="image-${countImage}">
                                   </div>
                                 <div class=" w-100"><input type="file" name="images[]"
                                    class="form-control w-100" data-image="${countImage}"></div>
                                </div>`
                $(".imageGroup").append(newInputImage)
            })

            $(".imageGroup").on("click", '.delete-image', (e) => {
                let imageNumner = e.target.getAttribute("data-image");
                $("#image-" + imageNumner).closest(".newImg").remove();
            })

            $(".imageGroup").on("change", 'input[name="images[]"]', (e) => {
                let imageNumner = e.target.getAttribute("data-image");
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = (e) => {
                        $(`#image-${imageNumner}`).attr("src", e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            })

        });
        const deleteImage = (url) => {
            $.ajax({
                type: "GET",
                url: url,
                success: (res) => {
                    console.log(res);
                },
                error: function(error) {
                    console.log(error.message);
                },
            });
        }
        const uploadImage = (file, url) => {
            let formData = new FormData();
            formData.append('image', file);
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    console.log(res);
                },
                error: function(error) {
                    console.log(error.message);
                },
            });
        }
        $("#description").summernote();
        $("#content").summernote();
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
                                    @if (count($categories) === 0)
                                        <option value="0">--Root--</option>
                                    @else
                                        @php
                                            RootCategory($categories, old('category_id', 0));
                                        @endphp
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group inline">
                            <div class="col-md-6 margin-right-4">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" {{ old('status', $data->status) == 1 ? 'selected' : '' }}>
                                        Show
                                    </option>
                                    <option value="2" {{ old('status', $data->status) == 2 ? 'selected' : '' }}>
                                        Hidden
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Featured</label>
                                <select class="form-control" name="featured">
                                    <option value="1" {{ old('featured', $data->featured) == 1 ? 'selected' : '' }}>
                                        Featured
                                    </option>
                                    <option value="2"{{ old('featured', $data->featured) == 2 ? 'selected' : '' }}>
                                        UnFeatured
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="4" id="description" name="description">{{ old('description', $data->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control" rows="4" id="content" name="content">{{ old('content', $data->content) }}</textarea>
                        </div>


                        <div class="form-group">
                            <label>Current Images</label>
                            <div class="d-flex gap-auto  flex-wrap imageGroup-old w-100 ">
                                @foreach ($data->product_images as $item)
                                    <div class="col-md-2 mt-2 mr-2 p-0">
                                        <input type="hidden" id="updateURL"
                                            data-url="{{ route('admin.product.uploadFile', ['id' => $item->id]) }}">
                                        <input type="hidden" id="deleteURL"
                                            data-url="{{ route('admin.product.deleteFile', ['id' => $item->id]) }}">

                                        <div class="w-100">
                                            <button type="button" class="bnt btn-danger  w-100 delete-image"
                                                data-image="{{ $item->id }}"><i class="fas fa-minus"></i></button>
                                        </div>

                                        <div class="w-100 mt-1 mb-1"> <img src="{{ asset('uploads/' . $item->images) }}"
                                                alt="{{ $item->id }}" width="100%" height="150"
                                                id="file_old-image-{{ $item->id }}">
                                        </div>

                                        <div class=" w-100"><input type="file" name="images_old"
                                                class="form-control w-100 file_old" data-image="{{ $item->id }}">
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <label class="mt-2">Add Images</label>
                            <div class="d-flex gap-auto  flex-wrap imageGroup w-100 ">


                            </div>
                            @if ($errors->has('images'))
                                <p class="invalid-feedback" style="display: block">*
                                    {{ $errors->get('images')[0] }}
                                <p>
                            @endif


                            <div class="row mt-2 col-md-2">
                                <button type="button" class="btn btn-info w-100" id="add-image"><i class="fas fa-plus"></i>
                                    Add image detaile</button>
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
