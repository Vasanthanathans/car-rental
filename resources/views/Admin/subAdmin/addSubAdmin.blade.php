@extends('Admin.include.app')

@section('header')
    <script src="{{ asset('asset/script/subadmin.js') }}"></script>
@endsection

@section('content')
    <div class="card-header">
        <h4>
            @if (isset($title))
                {{ $title }}
            @else
                Add Sub Admin
            @endif
        </h4>
    </div>
    <div class="card-body">

        <form Autocomplete="off" class="form-group form-border" id="addSubAdminForm" method="post"
            enctype="multipart/form-data">

            @csrf

            <div class="form-row ">
                <div class="form-group col-md-12">
                    <label for="">Full Name</label>
                    <input value="@php if(isset($data)) echo $data->fullName @endphp" type="text" class="form-control"
                        name="fullName">
                    @if (isset($data))
                        <input type="hidden" name="id" value="{{ $data->id }}">
                    @endif
                </div>
                <div class="form-group col-md-12">
                    <label for="">Email</label>
                    <input value="@php if(isset($data)) echo $data->email @endphp" type="text"
                        class="form-control" name="email">
                </div>
                <div class="form-group col-md-12">
                    <label for="">Password</label>
                    <input value="" type="password" class="form-control" name="password">
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-12 row">
                        <div class="col-md-3">

                            <label class="d-inline-block mr-4" for="">Permission</label>
                        </div>
                        @php $permissionAccess=explode(',',config('app.permissionAccess')); @endphp
                        @php $permisson=explode(',',config('app.permissionManagement')); @endphp
                        @php
                            if (isset($data)) {
                                $accessPermission = json_decode($data->permissions);
                            }
                        @endphp
                        <div class="col-md-5">
                            <ul class="list-inline d-inline-block">
                                @foreach ($permissionAccess as $access)
                                    <li class="list-inline-item">{{ ucfirst($access) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @foreach ($permisson as $per)
                        <div class="col-md-12 row">
                            <div class="col-md-3">
                                <label class="d-inline-block mr-4" for="">{{ ucfirst($per) }}</label>
                            </div>
                            <div class="col-md-5">
                                <ul class="list-inline d-inline-block">
                                    @foreach ($permissionAccess as $acc)
                                        <li class="list-inline-item ml-3"> <input type="checkbox"
                                                value="{{ $per . '-' . $acc }}" name="permissions[]"
                                                @if (isset($accessPermission)) {{ in_array($per . '-' . $acc, $accessPermission) ? 'checked' : '' }} @endif>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach

                </div>


            </div>
            <div class="form-group-submit">
                <button class="btn btn-primary " id="submitForm" type="button">{{ __('Save') }}</button>
            </div>

        </form>
    </div>
    <script src="https://cdn.tiny.cloud/1/0kvul4vh8bn2ggzavth4pbibrdtzo4y79zc18eeng1md6lrx/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('asset/js/tinyMceScript.js') }}"></script>
@endsection
