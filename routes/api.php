<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\SettingController;
use App\Http\Controllers\API\v1\SuggestionController;
use App\Http\Controllers\API\v1\SubscriptionController;
use App\Http\Controllers\API\v1\BannerController;
use App\Http\Controllers\API\v1\LanguageController;
use App\Http\Controllers\API\v1\CharacterController;
use App\Http\Controllers\ConversationController;
use App\Http\Middleware\GuestUser;

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

Route::group(['middleware' => ['envKeyAuth']], function () {
    Route::post('v1/check-email/', [UserController::class, 'CheckEmail']);
    Route::post('v1/register/', [UserController::class, 'register']);
    Route::post('v1/login/', [UserController::class, 'login']);
    Route::post('v1/guest/', [UserController::class, 'guest']);
    Route::post('v1/social-login/', [UserController::class, 'SocialLogin']);
    Route::get('v1/settings/', [SettingController::class, 'index']);
    Route::get('v1/categories/', [CategoryController::class, 'index']);
    Route::get('v1/suggestions/', [SuggestionController::class, 'index']);
    Route::get('v1/suggestion-by-categpry/{id}', [SuggestionController::class, 'ByCategpry']);
    Route::get('v1/subscriptions/', [SubscriptionController::class, 'index']);
    Route::post('v1/guest-reset-limit/', [UserController::class, 'GuestResetLimit']);
    Route::get('v1/banners/', [BannerController::class, 'index']);
    Route::post('v1/forgot-password/', [UserController::class, 'ForgotPassword']);
    Route::get('v1/languages/', [LanguageController::class, 'index']);
    Route::post('v1/characters/', [CharacterController::class, 'index']);
    Route::post('v1/ads-seen-unlock-character/', [CharacterController::class, 'AddSeenUnlockCharacter']);
    Route::post('v1/ads-seen-limit-increase/', [CharacterController::class, 'AddSeenLimitIncrease']);
    Route::post('v1/chat-statistics/', [UserController::class, 'chatStatistics']);
    Route::post('v1/proms-statistics/', [UserController::class, 'promsStatistics']);
    Route::post('v1/image-statistics/', [UserController::class, 'imageStatistics']);
    Route::post('v1/get-statistics/', [UserController::class, 'getStatistics']);
});

Route::group(['middleware' => ['apiKeyAuth']], function () {
    Route::post('v1/update-profile/', [UserController::class, 'UpdateProfile']);
    Route::post('v1/update-profile-picture/', [UserController::class, 'UpdateProfilePicture']);
    Route::post('v1/update-password/', [UserController::class, 'UpdatePassword']);
    Route::post('v1/get-user/', [UserController::class, 'GetUser']);
    Route::post('v1/get-word/', [UserController::class, 'wordCount']);
    Route::post('v1/reset-limit/', [UserController::class, 'ResetLimit']);
    Route::post('v1/get-user-subscription/', [SubscriptionController::class, 'GetUserSubscription']);
    Route::post('v1/create-user-subscription/', [SubscriptionController::class, 'CreateUserSubscription']);
    Route::post('v1/delete-account/', [UserController::class, 'DeleteAccount']);
    Route::post('v1/save-chat-history/', [UserController::class, 'SaveChatHistory']);
    Route::post('v1/get-chat-history/', [UserController::class, 'GetChatHistory']);
    Route::post('v1/save-proms-history/', [UserController::class, 'SavePromsHistory']);
    Route::post('v1/get-proms-history/', [UserController::class, 'GetPromsHistory']);
    Route::post('v1/delete-proms-history/', [UserController::class, 'DeletePromsHistory']);
    Route::post('v1/delete-chat-history/', [UserController::class, 'DeleteChatHistory']);
});
Route::middleware([GuestUser::class])->group(function () {
    Route::get('/assistants', [ConversationController::class, 'getAssistant']);
    Route::get('/room', [ConversationController::class, 'getRoom']);
    Route::post('/room', [ConversationController::class, 'store']);
    Route::post('/chat', [ConversationController::class, 'send_message']);
    Route::get('/chat/{id}', [ConversationController::class, 'getMessages']);
});
