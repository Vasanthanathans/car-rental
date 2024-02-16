@extends('Admin.include.app')
@section('header')
    <script src="{{ asset('asset/script/cms.js') }}"></script>
@endsection

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h4>CMS Pages</h4>
            <a href="{{ route('admin.addCmsPage') }}" class="ml-auto btn btn-primary text-white">Add
                CMS Pages</a>
        </div>
        <div class="card-body">
            <div class="table-responsive col-12">
                <table class="table table-striped w-100 word-wrap" id="cmsPagesTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Footer Type</th>
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
