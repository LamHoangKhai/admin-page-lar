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
@push('handlejs')
    <script>
        $(document).ready(() => {
            let countImage = 0
            $("#add-image").click(() => {
                countImage++;
                let newInputImage = `<div class="col-md-3 mt-2">
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
                $("#image-" + imageNumner).closest(".col-md-3").remove();
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

        })
    </script>
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
                                <label>Images</label>


                                <div class="d-flex gap-auto  flex-wrap imageGroup w-100 ">


                                </div>
                                @if ($errors->has('images'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('images')[0] }}
                                    <p>
                                @endif


                                <div class="row mt-1">
                                    <button type="button" class="btn btn-info w-100" id="add-image"><i
                                            class="fas fa-plus"></i> Add image detaile</button>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
