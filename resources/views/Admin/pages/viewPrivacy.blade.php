@extends('Admin.include.app')
@section('header')
    <script src="{{ asset('asset/script/viewPrivacy.js') }}"></script>
@endsection

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h4>{{ __('Privacy Policy') }}</h4>
            <div class="border-bottom-0 border-dark border"></div>
        </div>
        <div class="card-body">

            <form Autocomplete="off" class="form-group form-border" action="" method="post" id="privacy" required>
                @csrf

                <div class="form-group">
                    <label>{{ __('Content') }}</label>
                    <textarea id="summernote" class="summernote-simple" name="content">
        <?php
        echo $data;
        ?>

                    </textarea>

                </div>
                <div class="form-group">
                    <input class="btn btn-primary mr-1" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
@endsection
