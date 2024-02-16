@extends('Admin.include.app')
@section('header')
    <script src="{{ asset('asset/script/viewUserProfile.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/style/viewUserProfile.css') }}">
@endsection

@section('content')
    <input type="hidden" value="{{ $user->id }}" id="userId">

    <div class="card">
        <div class="card-header">
            <img class="rounded-circle owner-img-border mr-2" width="40" height="40"
                src="{{ env('FILES_BASE_URL') }}{{ $user->profile_image }}" alt="">
            <h4 class="d-inline">
                <span>{{ $user->fullname }}</span>
            </h4>
            <span>- {{ $user->identity }}</span>

            {{-- Add Money To Wallet --}}
            <a href="" id="rechargeWallet" class="ml-auto btn btn-primary text-white">{{ __('Recharge Wallet') }}</a>

            {{-- Block/Unblock --}}
            @if ($user->is_block == 1)
                <a href="" id="unblockUser" class="ml-2 btn btn-success text-white">{{ __('Unblock') }}</a>
            @else
                <a href="{{route('admin.users')}}" id="blockUser" class="ml-2 btn btn-danger text-white">{{ __('Block') }}</a>
            @endif

        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-2">
                    <label class="mb-0 text-grey" for="">{{ __('Wallet') }}</label>
                    <p class="mt-0 p-data">{{ $settings->currency }}{{ $user->wallet }}</p>
                </div>
                <div class="col-md-2">
                    <label class="mb-0 text-grey" for="">{{ __('Contact Phone') }}</label>
                    @if ($user->phone_number != null)
                        <p class="mt-0 p-data">{{ $user->phone_number }}</p>
                    @else
                        <p class="mt-0 p-data">---</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <label class="mb-0 text-grey" for="">{{ __('Registered Phone') }}</label>
                    @if ($user->regPhoneNumber != null)
                        <p class="mt-0 p-data">{{ $user->regPhoneNumber }}{{$user->isPhoneVerified?"(Verified)":"(Not Verified Yet)" }}</p>
                    @else
                        <p class="mt-0 p-data">---</p>
                    @endif
                </div>
                <div class="col-md-2">
                    <label class="mb-0 text-grey" for="">{{ __('Total Bookings') }}</label>
                    <p class="mt-0 p-data">{{ $totalBookings }}</p>
                </div>
            </div>


        </div>
    </div>


@endsection
