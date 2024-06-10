<?php

use App\Models\Event;
use App\Models\PastEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InsightsController;
use App\Http\Controllers\NetworthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MarketingMessageController;
use App\Http\Controllers\GoalController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index']);
Route::post('/', [IndexController::class, 'storeEvent']);
Route::get('/logout', [HomeController::class, 'logout']);

Route::get('about', function () {
    return view('about');
});

Route::get('budgetplanner', function () {
    return view('budgetplanner');
});

Route::get('networthcalculator', function () {
    return view('networthcalculator');
});

Route::get('debtmanager', function () {
    return view('debtmanager');
});

Route::get('investmentplanner', function () {
    return view('investmentplanner');
});

Route::get('feedback', function () {
    $events = Event::all();
    $pastevents = PastEvent::all();
    return view('feedback', ['events' => $events, 'pastevents' => $pastevents]);
});

Route::get('login', function () {
    return view('login');
});

Route::get('register', function () {
    return view('register');
});

Route::post('Register', function () {
    return view('/');
});
Auth::routes();


Route::get('/budget-planner', [UserController::class, 'showBudgetPlanner']);

Route::get('admin', function(){
    return view('admin');
})->name('admin')->middleware('admin');

Route::get('editor', function(){
    return view('editor');
})->name('editor')->middleware('editor');

Route::get('user', function(){
    return view('user');
})->name('user')->middleware('user');

Route::get('books_admindash', function () {
    return view('books_admindash');
})->name('books_admindash');

Route::get('blogs', function () {
    return view('blogs');
});

Route::get('blogs_admindash', function () {
    return view('blogs_admindash');
})->name('blogs_admindash');

Route::get('training', function () {
    return view('training');
});
Route::get('advisory', function () {
    return view('advisory');
});
Route::get('user_debtcalc', function () {
    return view('user_debtcalc');
});
Route::get('terms_and_conditions', function () {
    return view('terms_and_conditions');
})->name('termsandconditions');

Route::get('blogs', [BlogController::class, 'index'])->name('bloglist');
Route::get('blogdetails/{slug}',[BlogController::class,'view'])->name('blogdetails');

Route::get('books', [BookController::class, 'index']);
Route::get('bookdetails/{id}',[BookController::class,'show'])->name('bookdetails');
Route::get('booklist',[BookController::class,'index'])->name('booklist');

Route::middleware(['auth', 'verified'])->group(function () {

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('users/{user}', [UserController::class, 'edit'])->name('user.edit');

Route::get('bookadd',[BookController::class,'create'])->name('bookadd');
Route::post('bookadd',[BookController::class,'store'])->name('bookadd.store'); 
Route::get('/editbook/{id}',[BookController::class,'edit']);
Route::put('/editbook/{id}',[BookController::class,'update'])->name('bookedit.update');
Route::delete('bookdelete/{id}',[BookController::class,'destroy'])->name('bookdelete'); 


Route::get('blogadd',[BlogController::class,'create'])->name('blogadd');
Route::post('blogadd',[BlogController::class,'store'])->name('blogadd.store'); 
Route::get('/editblog/{id}',[BlogController::class,'edit']);
Route::put('/editblog/{id}',[BlogController::class,'update'])->name('blogedit.update');
Route::delete('blogdelete/{id}',[BlogController::class,'destroy'])->name('blogdelete');

//Goal Setting Routes
Route::get('init', function () {
    return view('init');
});
Route::post('/goal/store', [GoalController::class, 'storeGoal'])->name('storeGoal');
Route::get('user_goalsetting', [GoalController::class, 'showGoalData'])->name('showGoalData');
Route::post('/goals/{id}/add', [GoalController::class, 'addcurrentamount']);

//Budget Planner Routes
Route::post('/storeIncome', [BudgetController::class, 'storeIncome'])->name('storeIncome');
Route::post('/storeExpense', [BudgetController::class, 'storeExpense'])->name('storeExpense');
Route::get('user_budgetplanner', [BudgetController::class, 'showBudgetData']);
Route::get('budget', [BudgetController::class, 'showBudgetData'])->name('user_budgetplanner');
Route::get('netIncome', [BudgetController::class, 'showNetIncome']);
Route::get('user_debtcalc', [BudgetController::class, 'pushtoDebtCalc']);
Route::delete('/income/{id}', [BudgetController::class, 'destroyIncome'])->name('income.destroy');
Route::delete('/expenses/{id}', [BudgetController::class, 'destroyExpense'])->name('expenses.destroy');

//Investment Calculator Routes
Route::post('storemonthlyInvestment', [InvestmentController::class, 'storemonthlyInvestment'])->name('storemonthlyInvestment');
Route::get('user_investmentplanner', [InvestmentController::class, 'showinvestmentData'])->name('user_investmentplanner');
Route::delete('/investment/{id}', [InvestmentController::class, 'destroy'])->name('investment.destroy');


//Net Worth Calculator Routes
Route::post('storeAsset', [NetworthController::class, 'storeAsset'])->name('storeAsset');
Route::post('storeLiability', [NetworthController::class, 'storeLiability'])->name('storeLiability');
Route::get('user_networthcalc', [NetworthController::class, 'showNetworth']);

//Insights Routes
Route::get('insights_admindash', function () {
    return view('insights_admindash');
})->name('insights_admindash');

Route::get('/insights_admindash', 'InsightsController@index');

Route::get('/insights_admindash', [InsightsController::class, 'insightdata']);

Route::get('/events_admindash', [EventsController::class, 'index'])->name('events.index');
Route::post('/events_admindash', [EventsController::class, 'store'])->name('events.store');
Route::delete('/delete-event/{event}', [EventsController::class, 'destroy'])->name('events.destroy');
Route::post('/give-feedback', [EventsController::class, 'eventFeedback']);
Route::get('/editEvent/{id}', [EventsController::class, 'edit'])->name('editEvent');
Route::post('editEvent/{id}', [EventsController::class, 'update'])->name('updateEvent');

Route::get('/marketing_contacts_admindash', [MarketingController::class, 'index']);
Route::post('/add_one_contact', [MarketingController::class, 'add_one_contact']);
Route::post('/upload_contacts', [MarketingController::class, 'upload_contacts']);

//Password reset Routes
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');

//Contact Messages for admin Routes
Route::get('contacts_admindash', function () {
    return view('contacts_admindash');
})->name('contacts_admindash');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/contacts_admindash', [ContactController::class, 'showAdminDashboard'])->name('contacts_admindash');

//subscription Routes
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');
Route::get('/subscription_admindash', [SubscriptionController::class, 'index'])->name('subscriptions.index');

//user edit route
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

//acconut management routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account_admindash', [UserController::class, 'account_admin'])->name('account_admindash');
    Route::post('/update-profile', [UserController::class, 'updateadminProfile'])->name('update-adminprofile');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account_userdash', [UserController::class, 'account_user'])->name('account_userdash');
    Route::post('/update-profile', [UserController::class, 'updateuserProfile'])->name('update-userprofile');
});

//Marketing emails routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/marketing_admindash', [MarketingMessageController::class, 'index'])->name('marketing_admindash');
    Route::post('sendMessage', [MarketingMessageController::class, 'sendMessage'])->name('send.message');
});

//Debt Manager Routes
Route::post('debt_store', [DebtController::class, 'store'])->name('debt_store');
Route::get('user_debtcalc', [DebtController::class, 'showDebtFreeCountdown']);
Route::post('extraPayment_store',[DebtController::class, 'storeExtraPayment'])->name('extraPayment_store');

});

//Imge optimization
Route::get('optimize-images', [ImageController::class, 'optimizeImagesInDirectory'])->name('optimizeImages');

// Mpesa stk push
Route::post('stkpush', [PaymentController::class, 'stkPushRequest']);
Route::post('callback', [PaymentController::class, 'callback']);

// training enrollment
Route::post('/enroll', [TrainingController::class, 'store'])->name('enroll');

//google auth sign in
Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'GoogleCallback']);

//email verification
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/user_budgetplanner');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


