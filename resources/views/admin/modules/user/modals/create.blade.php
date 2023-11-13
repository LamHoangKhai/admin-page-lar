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
            $("#addUser").modal("show");
        </script>
    @endpush
@endif
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">+ Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" placeholder="Enter full name"
                                    name="full_name" value="{{ old('full_name') }}">
                                @if ($errors->has('full_name'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('full_name')[0] }}
                                    <p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" placeholder="Enter phone" name="phone"
                                    value={{ old('phone') }}>
                                @if ($errors->has('phone'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('phone')[0] }}
                                    <p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Enter email" name="email"
                                    value={{ old('email') }}>
                                @if ($errors->has('email'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('email')[0] }}
                                    <p>
                                @endif
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
                                    <label>Level</label>
                                    <select class="form-control" name="level">
                                        <option value="1" {{ old('level', 1) == 1 ? 'selected' : '' }}>Member
                                        </option>
                                        <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Enter password"
                                    name="password">
                                @if ($errors->has('password'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('password')[0] }}
                                    <p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Enter password"
                                    name="confirmation_password">
                                @if ($errors->has('confirmation_password'))
                                    <p class="invalid-feedback" style="display: block">*
                                        {{ $errors->get('confirmation_password')[0] }}
                                    <p>
                                @endif
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
