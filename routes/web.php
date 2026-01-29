<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotPayController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customer\AuthController as CustomerAuth;
use App\Http\Controllers\Customer\HomeController as HomeCustomer;
use App\Http\Controllers\Customer\AccountController as CustomerAccount;
use App\Http\Controllers\Customer\GroupController as CustomerGroup;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\PostCategoriesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostStatusController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankReportController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\NotificationController;

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

Route::get('/', [FrontendHomeController::class, 'index'])->name('frontend.home');
Route::get('/about', [FrontendHomeController::class, 'about'])->name('frontend.about');
Route::get('/service', [FrontendHomeController::class, 'service'])->name('frontend.service');

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [FrontendBlogController::class, 'index'])->name('frontend.blog');
    Route::get('/view/{slug}', [FrontendBlogController::class, 'show'])->name('frontend.blog.show');
});

Route::get('management/login', [AuthController::class, 'getLogin'])->name('login');
Route::post('management/login', [AuthController::class, 'postLogin'])->name('checkLogin');
Route::get('management/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('customer/login', [CustomerAuth::class, 'getLogin'])->name('customer.login');
Route::post('customer/login', [CustomerAuth::class, 'postLogin'])->name('customer.checkLogin');
Route::get('customer/logout', [CustomerAuth::class, 'logout'])->name('customer.logout');

Route::group(['prefix' => 'customer', 'middleware' => 'customerCheckLogin'], function(){
    Route::get('/', [HomeCustomer::class, 'dashboard'])->name('customer.home');
    Route::get('/account', [CustomerAccount::class, 'index'])->name('customer.account');
    Route::get('/account/show/{id}', [CustomerAccount::class, 'show'])->name('customer.account.show');
    Route::get('/account/export', [CustomerAccount::class, 'export'])->name('customer.account.export');
    Route::get('/customer/profile', [HomeCustomer::class, 'profile'])->name('customer.profile');
    Route::post('/customer/updateProfile', [HomeCustomer::class, 'updateProfile'])->name('customer.updateProfile');

    Route::get('/history', [HistoryController::class, 'index'])->name('customer.history');

    Route::get('/group/create', [CustomerGroup::class, 'create'])->name('customer.group.create');
    Route::post('/group/store', [CustomerGroup::class, 'store'])->name('customer.group.store');
    Route::get('/group/edit/{id}', [CustomerGroup::class, 'edit'])->name('customer.group.edit');
    Route::post('/group/update/{id}', [CustomerGroup::class, 'update'])->name('customer.group.update');
    Route::get('/group/delete/{id}', [CustomerGroup::class, 'delete'])->name('customer.group.delete');
    Route::get('/group', [CustomerGroup::class, 'index'])->name('customer.group');
    Route::get('/group/show/{id}', [CustomerGroup::class, 'show'])->name('customer.group.show');
    Route::get('/group/addCustomer/{id}/', [CustomerGroup::class, 'addCustomer'])->name('customer.group.addCustomer');
    Route::get('/group/saveToGroup/{id}/{customerId}', [CustomerGroup::class, 'saveToGroup'])->name('customer.group.saveToGroup');
    Route::get('/group/remove/{id}/{customerId}', [CustomerGroup::class, 'remove'])->name('customer.group.remove');


    Route::get('notification', [NotificationController::class, 'customerNotification'])->name('customer.notification');
    Route::get('notification/show/{id}', [NotificationController::class, 'show'])->name('customer.notification.show');
});


Route::group(['prefix' => 'management', 'middleware' => 'checkLogin'], function(){

    Route::get('/', [HomeController::class, 'dashboard'])->name('management.home');
    Route::get('/realSpend', [HomeController::class, 'realSpend'])->name('management.realSpend');

    // Customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('management.customer');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('management.customer.create');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('management.customer.store');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('management.customer.edit');
    Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->name('management.customer.show');
    Route::get('/customer/transfer/{id}', [CustomerController::class, 'transfer'])->name('management.customer.transfer');
    Route::get('/customer/fixBalance/{id}', [CustomerController::class, 'fixBalance'])->name('management.customer.fixBalance');
    Route::get('/customer/cal-balance/{id}', [CustomerController::class, 'calBalance'])->name('management.customer.cal-balance');
    Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('management.customer.update');
    Route::post('/customer/updateBalance/{id}', [CustomerController::class, 'updateBalance'])->name('management.customer.updateBalance');
    Route::post('/customer/updateFixBalance/{id}', [CustomerController::class, 'updateFixBalance'])->name('management.customer.updateFixBalance');
    Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('management.customer.delete');
    Route::get('/customer/export', [CustomerController::class, 'export'])->name('management.customer.export');
    Route::get('/customer/exportAccount/{customer}', [CustomerController::class, 'exportAccount'])->name('management.customer.exportAccount');

    // Account
    Route::get('/account', [AccountController::class, 'index'])->name('management.account');
    Route::get('/account/create', [AccountController::class, 'create'])->name('management.account.create');
    Route::post('/account/store', [AccountController::class, 'store'])->name('management.account.store');
    Route::get('/account/edit/{id}', [AccountController::class, 'edit'])->name('management.account.edit');
    Route::post('/account/update/{id}', [AccountController::class, 'update'])->name('management.account.update');
    Route::get('/account/delete/{id}', [AccountController::class, 'delete'])->name('management.account.delete');

    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('management.history');
    Route::get('/history/create', [HistoryController::class, 'create'])->name('management.history.create');
    Route::post('/history/store', [HistoryController::class, 'store'])->name('management.history.store');
    Route::get('/history/edit/{id}', [HistoryController::class, 'edit'])->name('management.history.edit');
    Route::post('/history/update/{id}', [HistoryController::class, 'update'])->name('management.history.update');
    Route::get('/history/delete/{id}', [HistoryController::class, 'delete'])->name('management.history.delete');

    // Report
    Route::get('/report', [ReportController::class, 'index'])->name('management.report');
    Route::get('/report/create', [ReportController::class, 'create'])->name('management.report.create');
    Route::post('/report/store', [ReportController::class, 'store'])->name('management.report.store');
    Route::get('/report/edit/{id}', [ReportController::class, 'edit'])->name('management.report.edit');
    Route::get('/report/import', [ReportController::class, 'import'])->name('management.report.import');
    Route::post('/report/saveImport', [ReportController::class, 'saveImport'])->name('management.report.saveImport');

    // Group
    Route::get('/group', [GroupController::class, 'index'])->name('management.group');
    Route::get('/group/create', [GroupController::class, 'create'])->name('management.group.create');
    Route::post('/group/store', [GroupController::class, 'store'])->name('management.group.store');
    Route::get('/group/edit/{id}', [GroupController::class, 'edit'])->name('management.group.edit');
    Route::post('/group/update/{id}', [GroupController::class, 'update'])->name('management.group.update');
    Route::get('/group/delete/{id}', [GroupController::class, 'delete'])->name('management.group.delete');
    Route::get('/group/addCustomer/{id}/', [GroupController::class, 'addCustomer'])->name('management.group.addCustomer');
    Route::get('/group/saveToGroup/{id}/{customerId}', [GroupController::class, 'saveToGroup'])->name('management.group.saveToGroup');
    Route::get('/group/show/{id}', [GroupController::class, 'show'])->name('management.group.show');
    Route::get('/group/remove/{id}/{customerId}', [GroupController::class, 'remove'])->name('management.group.remove');

    // Post
    Route::get('/post', [PostController::class, 'index'])->name('management.post');
    Route::get('/post/create', [PostController::class, 'create'])->name('management.post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('management.post.store');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('management.post.edit');
    Route::post('/post/update/{id}', [PostController::class, 'update'])->name('management.post.update');
    Route::get('/post/delete/{id}', [PostController::class, 'delete'])->name('management.post.delete');
    Route::get('/post/show/{id}', [PostController::class, 'show'])->name('management.post.show');
    Route::post('post/ckeditorUpload', [PostController::class, 'ckeditorUpload'])->name('management.post.ckeditorUpload');

    Route::get('/postCategories', [PostCategoriesController::class, 'index'])->name('management.postCategories');
    Route::get('/postCategories/create', [PostCategoriesController::class, 'create'])->name('management.postCategories.create');
    Route::post('/postCategories/store', [PostCategoriesController::class, 'store'])->name('management.postCategories.store');
    Route::get('/postCategories/edit/{id}', [PostCategoriesController::class, 'edit'])->name('management.postCategories.edit');
    Route::post('/postCategories/update/{id}', [PostCategoriesController::class, 'update'])->name('management.postCategories.update');
    Route::get('/postCategories/delete/{id}', [PostCategoriesController::class, 'delete'])->name('management.postCategories.delete');
    Route::get('/postCategories/show/{id}', [PostCategoriesController::class, 'show'])->name('management.postCategories.show');

    Route::get('/postStatus', [PostStatusController::class, 'index'])->name('management.postStatus');
    Route::get('/postStatus/create', [PostStatusController::class, 'create'])->name('management.postStatus.create');
    Route::post('/postStatus/store', [PostStatusController::class, 'store'])->name('management.postStatus.store');
    Route::get('/postStatus/edit/{id}', [PostStatusController::class, 'edit'])->name('management.postStatus.edit');
    Route::post('/postStatus/update/{id}', [PostStatusController::class, 'update'])->name('management.postStatus.update');
    Route::get('/postStatus/delete/{id}', [PostStatusController::class, 'delete'])->name('management.postStatus.delete');
    Route::get('/postStatus/show/{id}', [PostStatusController::class, 'show'])->name('management.postStatus.show');

    Route::get('/notpay/create', [NotPayController::class, 'create'])->name('management.notpay.create');
    Route::get('/notpay', [NotPayController::class, 'index'])->name('management.notpay');
    Route::get('/notpay/listAccount', [NotPayController::class, 'listAccount'])->name('management.notpay.listAccount');
    Route::post('/notpay/store', [NotPayController::class, 'store'])->name('management.notpay.store');

    // Tech
    Route::get('/admin', [AdminController::class, 'index'])->name('management.admin');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('management.admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('management.admin.store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('management.admin.edit');
    Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('management.admin.update');
    Route::get('/admin/delete/{id}', [AdminController::class, 'delete'])->name('management.admin.delete');

    // Bank
    Route::get('/bank', [BankController::class, 'index'])->name('management.bank');
    Route::get('/bank/create', [BankController::class, 'create'])->name('management.bank.create');
    Route::post('/bank/store', [BankController::class, 'store'])->name('management.bank.store');
    Route::get('/bank/edit/{id}', [BankController::class, 'edit'])->name('management.bank.edit');
    Route::post('/bank/update/{id}', [BankController::class, 'update'])->name('management.bank.update');
    Route::get('/bank/delete/{id}', [BankController::class, 'delete'])->name('management.bank.delete');


    // Bank Report
    Route::get('/bankReport', [BankReportController::class, 'index'])->name('management.bankReport');
    Route::get('/bankreport/create/{bank_id}', [BankReportController::class, 'create'])->name('management.bankreport.create');
    Route::post('/bankreport/store', [BankReportController::class, 'store'])->name('management.bankreport.store');

    // Currency
    Route::get('/currency', [CurrencyController::class, 'index'])->name('management.currency');
    Route::get('/currency/edit/{id}', [CurrencyController::class, 'edit'])->name('management.currency.edit');
    Route::post('/currency/update/{id}', [CurrencyController::class, 'update'])->name('management.currency.update');

    Route::get('notification', [NotificationController::class, 'index'])->name('management.notification');
    Route::get('/notification/create', [NotificationController::class, 'create'])->name('management.notification.create');
    Route::post('/notification/store', [NotificationController::class, 'store'])->name('management.notification.store');
    Route::get('/notification/edit/{id}', [NotificationController::class, 'edit'])->name('management.notification.edit');
    Route::post('/notification/update/{id}', [NotificationController::class, 'update'])->name('management.notification.update');
    Route::get('/notification/chooseCustomer/{id}', [NotificationController::class, 'chooseCustomer'])->name('management.notification.chooseCustomer');
    Route::post('/notification/send/{id}', [NotificationController::class, 'send'])->name('management.notification.send');


    Route::get('/setup', function () {
        return view('management.setup.index');
    })->name('management.setup');
});
