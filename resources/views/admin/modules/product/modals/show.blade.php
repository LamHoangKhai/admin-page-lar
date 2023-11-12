<div class="modal fade " id="showModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel">Product Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul>
                    <li>Name: {{ $product->name }}</li>
                    <li>Price: {{ $product->price }}</li>
                    <li>Status: <span
                            class="right badge badge-{{ $product->status == 1 ? 'success' : 'secondary' }}">{{ $product->status == 1 ? 'Show' : 'Hidden' }}</span>
                    </li>
                    <li>Featured: <span
                            class="right badge badge-{{ $product->featured == 1 ? 'primary' : 'danger' }}">{{ $product->featured == 1 ? 'Featured' : 'Unfeatured' }}</span>
                    </li>
                </ul>
                <hr>
                <div>
                    <h4>Description</h4>
                    <textarea class="form-control" rows="4" style="font-size:1.2rem;background:white;" disabled>{{ $product->description }}</textarea>
                </div>
                <div>
                    <h4>Content</h4>
                    <textarea class="form-control " rows="4" style="font-size:1.2rem;background:white;" disabled>{{ $product->content }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}"
                    class="text-dark btn btn-warning ">Edit</a>
                <a href="{{ route('admin.product.destroy', ['id' => $product->id]) }}"
                    class="text-white confirm btn btn-danger" value="{{ $product->name }}">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
