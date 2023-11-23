@extends('admin.master')

@section('module', 'User')
@section('action', 'Edit')

@section('content')
    <form method="post" action="{{ route('admin.user.update', ['id' => $id]) }}">
        @csrf
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User edit</h3>

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
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter full name" name="full_name"
                        value="{{ old('full_name', $data->full_name) }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Enter email" name="email"
                        @disabled(true) value="{{ $data->email }}">
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Enter password" name="password">
                            @if ($errors->has('password'))
                                <p class="invalid-feedback" style="display: block">*
                                    {{ $errors->get('password')[0] }}
                                <p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
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

                        <div class="form-group">
                            <label>Level</label>

                            <select class="form-control" name="level">
                                <option value="1" {{ old('level', $data->level) == 1 ? 'selected' : '' }}>Member
                                </option>

                                <option value="2" {{ old('level', $data->level) == 2 ? 'selected' : '' }}>Admin
                                </option>

                            </select>
                        </div>


                        <div class="form-group">
                            <label>Status</label>

                            <select class="form-control" name="status">
                                <option value="1" {{ old('status', $data->status) == 1 ? 'selected' : '' }}>Show
                                </option>

                                <option value="2" {{ old('status', $data->Status) == 2 ? 'selected' : '' }}>Hidden
                                </option>

                            </select>
                        </div>



                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" placeholder="Enter phone" name="phone"
                                value="{{ old('phone', $data->phone) }}">
                            @if ($errors->has('phone'))
                                <p class="invalid-feedback" style="display: block">*
                                    {{ $errors->get('phone')[0] }}
                                <p>
                            @endif
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
