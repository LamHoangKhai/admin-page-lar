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
            $("#addNewCategory").modal("show");
        </script>
    @endpush
@endif

<div class="modal fade" id="addNewCategory" tabindex="-1" role="dialog" aria-labelledby="addNewCategoryLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewCategoryLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{ route('admin.category.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category parent</label>
                            <select class="form-control" name="parent_id">
                                <option value="0">----- Root -----</option>
                                <?php
                                
                                RootCategory($categories, old('parent_id', 0));
                                ?>



                            </select>


                        </div>


                        <div class="form-group">
                            <label>Category name</label>
                            <input type="text" class="form-control" placeholder="Enter category name" name="name"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <p class="invalid-feedback" style="display: block">*
                                    {{ $errors->get('name')[0] }}
                                <p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Show</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Hidden</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
            </div>
            <!-- /.card -->
            </form>
        </div>

    </div>
</div>
