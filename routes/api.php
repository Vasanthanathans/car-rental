<?php


use App\Http\Controllers\BookingsController;

use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//******************/ Users
Route::prefix('user')->group(function () {
    // Common
    Route::post('registerUser', [UsersController::class, 'registerUser'])->middleware('checkHeader');
    Route::post('editUserDetails', [UsersController::class, 'editUserDetails'])->middleware('checkHeader');
    Route::post('fetchFavoriteData', [UsersController::class, 'fetchFavoriteData'])->middleware('checkHeader');
    Route::post('fetchHomePageData', [SalonController::class, 'fetchHomePageData'])->middleware('checkHeader');
    Route::post('deleteMyUserAccount', [UsersController::class, 'deleteMyUserAccount'])->middleware('checkHeader');
    Route::post('fetchUserDetails', [UsersController::class, 'fetchUserDetails'])->middleware('checkHeader');
    Route::post('updateOtpVerify', [UsersController::class, 'updateOtpVerify'])->middleware('checkHeader');
    Route::post('checkNumberAlreadyExist', [UsersController::class, 'checkNumberAlreadyExist'])->middleware('checkHeader');

    // Service and Salons by category
    Route::post('salonAndServiceByCategory', [SalonController::class, 'salonAndServiceByCategory'])->middleware('checkHeader');
    Route::post('searchServicesOfCategory', [SalonController::class, 'searchServicesOfCategory'])->middleware('checkHeader');
    Route::post('searchTopRatedSalonsOfCategory', [SalonController::class, 'searchTopRatedSalonsOfCategory'])->middleware('checkHeader');
    Route::post('fetchService', [ServiceController::class, 'fetchService'])->middleware('checkHeader');
    Route::post('fetchSalonByCoordinates', [SalonController::class, 'fetchSalonByCoordinates'])->middleware('checkHeader');

    // Search
    Route::post('searchServices', [SalonController::class, 'searchServices'])->middleware('checkHeader');
    Route::post('searchSalon', [SalonController::class, 'searchSalon'])->middleware('checkHeader');

    // Notification
    Route::post('fetchNotification', [UsersController::class, 'fetchNotification'])->middleware('checkHeader');
    Route::post('fetchSalonDetails', [SalonController::class, 'fetchSalonDetails'])->middleware('checkHeader');
    Route::post('fetchSalonReviews', [SalonController::class, 'fetchSalonReviews'])->middleware('checkHeader');

    // Bookings
    Route::post('fetchAcceptedPendingBookingsOfSalonByDate', [BookingsController::class, 'fetchAcceptedPendingBookingsOfSalonByDate'])->middleware('checkHeader');
    Route::post('fetchCoupons', [BookingsController::class, 'fetchCoupons'])->middleware('checkHeader');
    Route::post('placeBooking', [BookingsController::class, 'placeBooking'])->middleware('checkHeader');
    Route::post('fetchUserBookings', [BookingsController::class, 'fetchUserBookings'])->middleware('checkHeader');
    Route::post('fetchUserUpcomingBookings', [BookingsController::class, 'fetchUserUpcomingBookings'])->middleware('checkHeader');
    Route::post('fetchBookingDetails', [BookingsController::class, 'fetchBookingDetails'])->middleware('checkHeader');
    Route::post('rescheduleBooking', [BookingsController::class, 'rescheduleBooking'])->middleware('checkHeader');
    Route::post('cancelBooking', [BookingsController::class, 'cancelBooking'])->middleware('checkHeader');
    Route::post('addRating', [BookingsController::class, 'addRating'])->middleware('checkHeader');


    // Wallet
    Route::post('addMoneyToUserWallet', [UsersController::class, 'addMoneyToUserWallet'])->middleware('checkHeader');
    Route::post('fetchWalletStatement', [UsersController::class, 'fetchWalletStatement'])->middleware('checkHeader');
    Route::post('submitUserWithdrawRequest', [UsersController::class, 'submitUserWithdrawRequest'])->middleware('checkHeader');
    Route::post('fetchUserWithdrawRequests', [UsersController::class, 'fetchUserWithdrawRequests'])->middleware('checkHeader');
});


//******************/ Salon 
Route::post('salonRegistration', [SalonController::class, 'salonRegistration'])->middleware('checkHeader');
Route::post('updateSalonDetails', [SalonController::class, 'updateSalonDetails'])->middleware('checkHeader');
Route::post('updateSalonBankAccount', [SalonController::class, 'updateSalonBankAccount'])->middleware('checkHeader');
Route::post('fetchSalonCategories', [SalonController::class, 'fetchSalonCategories'])->middleware('checkHeader');
Route::post('fetchSalonNotifications', [SalonController::class, 'fetchSalonNotifications'])->middleware('checkHeader');
Route::post('fetchMySalonDetails', [SalonController::class, 'fetchMySalonDetails'])->middleware('checkHeader');
Route::post('fetchMySalonReviews', [SalonController::class, 'fetchMySalonReviews'])->middleware('checkHeader');
Route::post('deleteMySalonAccount', [SalonController::class, 'deleteMySalonAccount'])->middleware('checkHeader');

// Appointment Slots
Route::post('addBookingSlots', [SalonController::class, 'addBookingSlots'])->middleware('checkHeader');
Route::post('deleteBookingSlots', [SalonController::class, 'deleteBookingSlots'])->middleware('checkHeader');


// Services
Route::post('addServiceToSalon', [ServiceController::class, 'addServiceToSalon'])->middleware('checkHeader');
Route::post('editService', [ServiceController::class, 'editService'])->middleware('checkHeader');
Route::post('deleteService', [ServiceController::class, 'deleteService'])->middleware('checkHeader');
Route::post('fetchAllServicesOfSalon', [ServiceController::class, 'fetchAllServicesOfSalon'])->middleware('checkHeader');
Route::post('fetchServicesByCatOfSalon', [ServiceController::class, 'fetchServicesByCatOfSalon'])->middleware('checkHeader');
Route::post('changeServiceStatus', [ServiceController::class, 'changeServiceStatus'])->middleware('checkHeader');

// Awards
Route::post('addSalonAward', [SalonController::class, 'addSalonAward'])->middleware('checkHeader');
Route::post('editSalonAward', [SalonController::class, 'editSalonAward'])->middleware('checkHeader');
Route::post('deleteSalonAward', [SalonController::class, 'deleteSalonAward'])->middleware('checkHeader');

// Gallery
Route::post('addSalonGalleryImage', [SalonController::class, 'addSalonGalleryImage'])->middleware('checkHeader');
Route::post('deleteSalonGalleryImage', [SalonController::class, 'deleteSalonGalleryImage'])->middleware('checkHeader');

// Settings
Route::post('fetchGlobalSettings', [SalonController::class, 'fetchGlobalSettings'])->middleware('checkHeader');
Route::post('fetchFaqCats', [SettingsController::class, 'fetchFaqCats'])->middleware('checkHeader');

// Bookings
Route::post('fetchSalonBookingRequests', [BookingsController::class, 'fetchSalonBookingRequests'])->middleware('checkHeader');
Route::post('fetchBookingDetails', [BookingsController::class, 'Salon_fetchBookingDetails'])->middleware('checkHeader');
Route::post('acceptBooking', [BookingsController::class, 'acceptBooking'])->middleware('checkHeader');
Route::post('rejectBooking', [BookingsController::class, 'rejectBooking'])->middleware('checkHeader');
Route::post('completeBooking', [BookingsController::class, 'completeBooking'])->middleware('checkHeader');
Route::post('fetchBookingsByDate', [BookingsController::class, 'fetchBookingsByDate'])->middleware('checkHeader');
Route::post('fetchSalonBookingHistory', [BookingsController::class, 'fetchSalonBookingHistory'])->middleware('checkHeader');
Route::post('fetchSalonWalletStatement', [BookingsController::class, 'fetchSalonWalletStatement'])->middleware('checkHeader');
Route::post('fetchSalonEarningHistory', [BookingsController::class, 'fetchSalonEarningHistory'])->middleware('checkHeader');
Route::post('SubmitSalonWithdrawRequest', [SalonController::class, 'SubmitSalonWithdrawRequest'])->middleware('checkHeader');
Route::post('fetchSalonPayoutHistory', [BookingsController::class, 'fetchSalonPayoutHistory'])->middleware('checkHeader');

Route::post('uploadFileGivePath', [SettingsController::class, 'uploadFileGivePath'])->middleware('checkHeader');
