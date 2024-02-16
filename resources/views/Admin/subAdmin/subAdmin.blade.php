@extends('Admin.include.app')
@section('header')
    <script src="{{ asset('asset/script/subadmin.js') }}"></script>
@endsection

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h4>{{$headTitle}}</h4>
            <a href="{{ route('admin.addSubAdmin') }}" class="ml-auto btn btn-primary text-white">Add
                {{$headTitle}}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive col-12">
                <table class="table table-striped w-100 word-wrap" id="subAdminTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
