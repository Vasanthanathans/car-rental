@extends('Admin.include.app')

@section('header')
    <script>
        $(document).ready(function() {

            $(".sideBarli").removeClass("activeLi");
            $(".AdminSettingsSideA").addClass("activeLi");
        })
    </script>
    <style>
        .uploadImagesLogo {
            width: 155px;
        }
    </style>
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
        <h4>Admin Settings</h4>
    </div>
    <div class="card-body">

        <form Autocomplete="off" class="form-group form-border" id="globalSettingsForm"
            action="{{ route('admin.updateAdminSettings') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="form-row ">
                <div class="form-group col-md-6">
                    <label for="">Site Name</label>
                    <input value="{{ $adminSettings->site_name }}" type="text" class="form-control" name="site_name"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Admin Email</label>
                    <input value="{{ $adminSettings->admin_email }}" type="text" class="form-control" name="admin_email"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Meta Title</label>
                    <input value="{{ $adminSettings->meta_title }}" type="text" class="form-control" name="meta_title"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Meta Description</label>
                    <input value="{{ $adminSettings->meta_description }}" type="text" class="form-control"
                        name="meta_description" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Meta Keywords</label>
                    <input value="{{ $adminSettings->meta_keywords }}" type="text" class="form-control"
                        name="meta_keywords" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">FaceBook App Id</label>
                    <input value="{{ $adminSettings->fb_app_id }}" type="text" class="form-control" name="fb_app_id">
                </div>
                <div class="form-group col-md-6">
                    <label for="">FaceBook Secrect</label>
                    <input value="{{ $adminSettings->fb_app_secret }}" type="text" class="form-control"
                        name="fb_app_secret">
                </div>
                <div class="form-group col-md-6">
                    <label for="">FaceBook Access Token</label>
                    <input value="{{ $adminSettings->fb_access_token }}" type="text" class="form-control"
                        name="fb_access_token">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twitter App Id</label>
                    <input value="{{ $adminSettings->twitter_app_id }}" type="text" class="form-control"
                        name="twitter_app_id">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twitter Name</label>
                    <input value="{{ $adminSettings->twitter_name }}" type="text" class="form-control"
                        name="twitter_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Copyrights</label>
                    <textarea class="form-control" name="copy_right">{!! html_entity_decode($adminSettings->copy_right) !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Gmail Client Id</label>
                    <input value="{{ $adminSettings->gmail_client_id }}" type="text" class="form-control"
                        name="gmail_client_id">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Gmail Client Secret</label>
                    <input value="{{ $adminSettings->gmail_client_secret }}" type="text" class="form-control"
                        name="gmail_client_secret">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Gmail Redirect URL</label>
                    <input value="{{ $adminSettings->gmail_redirect_url }}" type="text" class="form-control"
                        name="gmail_redirect_url">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Google Map Key</label>
                    <input value="{{ $adminSettings->gmap_key }}" type="text" class="form-control" name="gmap_key">
                </div>
                <div class="form-group col-md-6">
                    <label for="">FaceBook Link</label>
                    <input value="{{ $adminSettings->facebook_link }}" type="text" class="form-control"
                        name="facebook_link">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twitter Link</label>
                    <input value="{{ $adminSettings->twitter_link }}" type="text" class="form-control"
                        name="twitter_link">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Linkedin Link</label>
                    <input value="{{ $adminSettings->linkedin_link }}" type="text" class="form-control"
                        name="linkedin_link">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Instagram Link</label>
                    <input value="{{ $adminSettings->instagram_link }}" type="text" class="form-control"
                        name="instagram_link">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Youtube Link</label>
                    <input value="{{ $adminSettings->youtube_link }}" type="text" class="form-control"
                        name="youtube_link">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Google Data Studio</label>
                    <textarea class="form-control" name="google_data_studio_link">{!! html_entity_decode($adminSettings->google_data_studio_link) !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Google Analytics</label>
                    <textarea class="form-control" name="google_analytics">{!! html_entity_decode($adminSettings->google_analytics) !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twillo Account SID</label>
                    <input value="{{ $adminSettings->twillio_account_sid }}" type="text" class="form-control"
                        name="twillio_account_sid">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twillo Auth Token</label>
                    <input value="{{ $adminSettings->twillio_auth_token }}" type="text" class="form-control"
                        name="twillio_auth_token">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twillo Number</label>
                    <input value="{{ $adminSettings->twillio_number }}" type="text" class="form-control"
                        name="twillio_number">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Twillo Mode</label><br>
                    <label for="tsandbox" class="mr-3 "><input type="radio" id="tsandbox" class="form-radio"
                            name="twillio_mode" value="0" {{ $adminSettings->twillio_mode == 0 ? 'checked' : '' }}>
                        Sandbox</label>
                    <label for="tlive"><input type="radio" id="tlive" class="form-radio" name="twillio_mode"
                            value="1" {{ $adminSettings->twillio_mode == 1 ? 'checked' : '' }}> Live</label>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Paypal Email</label>
                    <input value="{{ $adminSettings->paypal_email }}" type="text" class="form-control"
                        name="paypal_email">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Paypal Mode</label><br>
                    <label for="psandbox" class="mr-3 "><input type="radio" id="psandbox" class="form-radio"
                            name="paypal_mode" value="0" {{ $adminSettings->paypal_mode == 0 ? 'checked' : '' }}>
                        Sandbox</label>
                    <label for="plive"><input type="radio" id="plive" class="form-radio" name="paypal_mode"
                            value="1" {{ $adminSettings->paypal_mode == 1 ? 'checked' : '' }}> Live</label>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Site Logo</label>
                    <input class="form-control " type="file" name="site_logo"><br>
                    @if ($adminSettings->site_logo != '')
                        <img src="{{ env('FILES_BASE_URL') . $adminSettings->site_logo }}" class="uploadImagesLogo"
                            alt="Footer Logo">
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="">Footer Logo</label>
                    <input class="form-control " type="file" name="footer_logo"><br>
                    @if ($adminSettings->footer_logo != '')
                        <img src="{{ env('FILES_BASE_URL') . $adminSettings->footer_logo }}" class="uploadImagesLogo"
                            alt="Footer Logo">
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="">Fav Icon</label>
                    <input class="form-control " type="file" name="fav_icon"><br>
                    @if ($adminSettings->fav_icon != '')
                        <img src="{{ env('FILES_BASE_URL') . $adminSettings->fav_icon }}" class="uploadImagesLogo"
                            alt="Footer Logo">
                    @endif
                </div>
            </div>
            <div class="form-group-submit">
                <button class="btn btn-primary " type="submit">{{ __('Save') }}</button>
            </div>

        </form>
    </div>
@endsection
