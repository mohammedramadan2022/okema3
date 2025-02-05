<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CoreController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\RankingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ThawaniOnlinePaymentController;
use App\Models\Quote;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('/validate-identifier', [AuthController::class, 'validateIdentifier']);
    Route::post('/socialAuth', [AuthController::class, 'socialAuth']);
    Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

Route::group(['prefix' => 'core'], function () {
    Route::get('languages', [CoreController::class, 'languages']);
    Route::get('countries', [CoreController::class, 'countries']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('skills', [CoreController::class, 'skills']);
    Route::get('social-media-links', [CoreController::class, 'socialMediaLinks']);
    Route::get('types', [CoreController::class, 'types']);
    Route::get('projects', [CoreController::class, 'projects']);
    Route::get('goals', [CoreController::class, 'goals']);
     Route::get('badges', [CoreController::class, 'badges']);
     Route::get('covers', [CoreController::class, 'covers']);
     Route::get('categories', [CoreController::class, 'categories']);
     Route::get('colors', [CoreController::class, 'colors']);
    });
});

Route::get('quote', [CoreController::class, 'quotes']);


Route::group(['prefix' => 'settings','middleware'=>'auth:sanctum'], function () {
    Route::get('settings', [SettingController::class, 'index']);
});

Route::group(['prefix' => 'portfolios','middleware'=>'auth:sanctum'], function () {
    Route::get('/', [PortfolioController::class, 'index']);
    Route::post('/store', [PortfolioController::class, 'store']);
    Route::post('update/{portfolio}', [PortfolioController::class, 'update']);
    Route::patch('add-post/{portfolio_id}/{post_id}', [PortfolioController::class, 'addPostToCampaign']);
    Route::put('/changeStatus/{portfolio}', [PortfolioController::class, 'changeStatus']);
    Route::put('/makePinned/{portfolio}', [PortfolioController::class, 'makePinned']);
});

Route::post('/send-evaluation-request', [ReviewController::class, 'sendEvaluationRequest'])->middleware('auth:sanctum');
Route::post('review/delete/{id}', [ReviewController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('reviewed/before', [ReviewController::class, 'reviewedBefore'])->middleware('auth:sanctum');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/experience/store', [ExperienceController::class, 'store']);
    Route::post('/experience/{id}', [ExperienceController::class, 'update']);
    Route::delete('/experience/{id}', [ExperienceController::class, 'destroy']);
});
Route::get('/experiences/{username}', [ExperienceController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/projects/store', [ProjectController::class, 'store']);
    Route::post('/projects/update/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    Route::delete('/files/delete', [ProjectController::class, 'deleteFile'])->name('files.delete');

});

Route::get('/projects/{username}', [ProjectController::class, 'index']);



Route::middleware('auth:sanctum')->prefix('portfolios')->group(function () {
    Route::get('/portfolios', [PortfolioController::class, 'index']);
    Route::get('/draft', [PortfolioController::class, 'draft']);
    Route::post('/', [PortfolioController::class, 'store']);
    Route::put('/{id}', [PortfolioController::class, 'update']);
    Route::delete('/{id}', [PortfolioController::class, 'destroy']);
});

Route::get('portfolios/show/{portfolio}', [PortfolioController::class,'show']);
Route::get('/portfolios/{username}', [PortfolioController::class, 'indexGust']);
Route::post('statistics', [PortfolioController::class, 'statistics']);
Route::post('portfolios/{portfolioId}/reviews', [ReviewController::class, 'store']);
Route::post('reviews', [ReviewController::class, 'index']);

Route::post('portfolios/{portfolioId}/reviews', [ReviewController::class, 'store']);

Route::middleware('auth:sanctum')->prefix('portfolios')->group(function () {
    Route::post('/user/update-cv', [UserController::class, 'updateCv']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow', [SocialController::class, 'follow']);
    Route::post('/like', [SocialController::class, 'like']);
    Route::post('/likers', [SocialController::class, 'likers']);
    Route::post('/view/profile', [SocialController::class, 'profileViewed']);
    Route::post('/view/portfolio', [SocialController::class, 'portfolioViewed']);
    Route::get('/followers', [SocialController::class, 'followers']);
    Route::get('/followings', [SocialController::class, 'followings']);
    Route::post('/isFollow', [SocialController::class, 'isFollow']);
    Route::post('/isLike', [SocialController::class, 'isLike']);
    Route::post('/make/favorite', [SocialController::class, 'makeFavorite']);
    Route::get('/favorites', [SocialController::class, 'favourites']);
});
Route::get('subscriptions', [UserController::class, 'subscriptions']);
Route::get('properties', [UserController::class, 'properties']);

Route::get('updates', [UserController::class, 'updates']);

Route::get('updates/{id}', [UserController::class, 'show']);

Route::post('/view/guest-portfolio', [SocialController::class, 'portfolioViewedGuest']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);
    Route::get('/notifications', [NotificationController::class, 'getAllNotifications']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::post('/contacts', [UserController::class, 'store']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('profile/update', [ProfileController::class, 'update']);
    Route::get('my-profile', [ProfileController::class, 'myProfile']);
    Route::post('user/change-password', [UserController::class, 'changePassword']);
    Route::get('user/payments', [UserController::class, 'payments']);
    Route::post('subscriptions/pay', [UserController::class, 'pay']);
    Route::post('/{table}/update-rankings', [RankingController::class, 'updateRankings']);
    Route::post('/request/verify', [UserController::class, 'requestVerify']);

});

Route::get('gust/profile/{username}', [ProfileController::class, 'gustProfile']);

Route::get('gust/profiles', [ProfileController::class, 'gustProfiles']);

Route::get('/send-test-email', function () {
    Mail::raw('This is a test email sent from Gmail SMTP.', function ($message) {
        $message->to('mahmoud.diab07796@gmail.com')
            ->subject('Test Email');
    });

    return 'Test email sent successfully!';
});


//Thawani Online Payment Routes
Route::any('thawani/callback/success', [ThawaniOnlinePaymentController::class, 'success'])->name('thawani.callback.success');
Route::any('thawani/callback/cancel', [ThawaniOnlinePaymentController::class, 'cancel'])->name('thawani.callback.cancel');

Route::get('/thwani',[ThawaniOnlinePaymentController::class,'createSession']);



Route::get('/paymob',function (){
    $cash = new \Nafezly\Payments\Classes\PaymobPayment();
   return  $res = $cash->setUserId(1)
        ->setUserFirstName("maad")
        ->setUserLastName("diab")
        ->setUserEmail("mail@mada.com")
        ->setUserPhone("201099912408")
        ->setCurrency("EGP")
        ->setAmount(100)
        ->pay();
   dd($res);
});

Route::get('/payments/verify/{payment?}',function (\Illuminate\Http\Request $request){
    return $request->all();
    $paym = new \Nafezly\Payments\Classes\PaymobPayment();
    return $paym->verify($request);
})->name('verify-payment');

