@extends('Admin.include.app')

@section('header')
    <script src="{{ asset('asset/script/cms.js') }}"></script>
@endsection

@section('content')
    @if (\Session::has('success'))
        <script>
            iziToast.success({
                title: "Success",
                message: 'Successfully Updated',
                position: "topRight",
            });
        </script>
    @endif
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <script>
                iziToast.error({
                    title: "Error",
                    message: "{!! $error !!}",
                    position: "topRight",
                });
            </script>
        @endforeach
    @else
    @endif
    <div class="card-header">
        <h4>
            @if (isset($title))
                {{ $title }}
            @else
                Add CMS Page
            @endif
        </h4>
    </div>
    <div class="card-body">

        <form Autocomplete="off" class="form-group form-border" id="addCMSPageForm" method="post" enctype="multipart/form-data">

            @csrf

            <div class="form-row ">
                <div class="form-group col-md-12">
                    <label for="">Title</label>
                    <input value="@if (isset($page)) {{ $page->title }} @endif" type="text"
                        class="form-control" name="title">
                    @if (isset($page))
                        <input type="hidden" name="id" value="{{ $page->id }}">
                    @endif
                </div>

                <div class="form-group col-md-12">
                    <label for="">Content</label>
                    <textarea class="form-control textEditor" name="content">
@if (isset($page))
{!! html_entity_decode($page->content) !!}
@endif
</textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="">Footer Type</label>
                    <select name="footer_type" class="form-control">
                        <option @if (isset($page)) {{ $page->footer_type == 0 ? 'Selected' : '' }} @endif
                            value="0">Footer</option>
                        <option @if (isset($page)) {{ $page->footer_type == 1 ? 'Selected' : '' }} @endif
                            value="1">Other</option>
                    </select>
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
