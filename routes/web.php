<?php
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\ProductController;
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

Route::post('/login', [UserController::class, 'loginprocess'])->name('loginprocess');
Route::get('/forgotpassword',[UserController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('/forgotpassword',[UserController::class, 'resetpassrequest'])->name('resetpassrequest');
Route::get('/register', function () {
    return view('register');
});/*
Route::post('/save', [UserController::class, 'saveuser'])->name('save');
Route::get('/admin', function () {
    return back();
});*/
Route::get('/company', function () {
    return back();
});
Route::get('/admin/editproduct', function () {
    return back();
});
Route::get('/admin/partnerproduct', function () {
    return back();
});
Route::get('/admin/readbugreport', function () {
    return back();
});
Route::get('/admin/storecompupdate', function () {
    return back();
});
Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('/login',[UserController::class, 'login'])->name('login');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::group(['middleware' => ['userStatus']], function () {
        Route::get('/lockscreen', [UserController::class, 'lockscreen'])->name('lockscreen');
        Route::post('/lockscreen', [UserController::class, 'unlock'])->name('unlock');
        Route::group(['middleware' => ['inactivityTimeout']], function () {
            Route::prefix('admin')->group(function () {
                Route::get('/dashboard', function () {
                    return view('admin-dashboard');
                })->name('admin.dashboard');
                Route::get('/dashboard2', function () {
                    return view('admin-dashboard2');
                })->name('admin.dashboard2');
                Route::get('/users', function () {
                    return view('users');
                })->name('users');
                Route::get('/user/{id}', [UserController::class, 'user'])->name('user');
                Route::get('/userinfo', [UserController::class, 'userinfo'])->name('userinfo');
                Route::match(['get','post'],'/adduser', [UserController::class, 'adduser'])->name('adduser');
                Route::get('/userrequest', [AdminController::class, 'userrequest'])->name('userrequest');
                Route::post('/grantrequest', [AdminController::class, 'grantrequest'])->name('grantrequest');
                Route::post('/removerequest', [AdminController::class, 'removerequest'])->name('removerequest');
                Route::post('/saveuser', [UserController::class, 'saveuser'])->name('saveuser');
                Route::post('/userupdate', [UserController::class, 'userupdate'])->name('userupdate');
                Route::match(['get','post'],'/restoreuser', [UserController::class, 'restoreuser'])->name('restoreuser');
                Route::match(['get','post'],'/userdelete', [UserController::class, 'userdelete'])->name('userdelete');
                Route::get('/trash', [UserController::class, 'trash'])->name('trash');
                Route::match(['get','post'],'/trashuser', [UserController::class, 'trashuser'])->name('trashuser');
                Route::get('/products',[ProductController::class, 'products'])->name('products');
                Route::match(['get','post'],'/partnerproduct/{company}',[ProductController::class, 'partnerproduct'])->name('partnerproduct');
                Route::get('/addproduct',[ProductController::class, 'addproducts'])->name('addproduct');
                Route::get('/editproduct/{id}',[ProductController::class, 'editproducts'])->name('editproduct');
                Route::post('/storeproduct',[ProductController::class, 'store'])->name('storeproduct');
                Route::post('/storeupdateproduct',[ProductController::class, 'storeupdateproducts'])->name('storeupdateproduct');
                Route::get('/trashproduct', [ProductController::class, 'trashproduct'])->name('trashproduct');
                Route::match(['get','post'],'/trashproducts', [ProductController::class, 'trash'])->name('trashproducts');
                Route::match(['get','post'],'/restoreproduct', [ProductController::class, 'restoreproduct'])->name('restoreproduct');
                Route::match(['get','post'],'/deleteproduct',[ProductController::class, 'deleteproduct'])->name('deleteproduct');
                Route::get('/addcompany',[AdminController::class, 'addcompany'])->name('addcompany');
                Route::post('/storecomp',[AdminController::class, 'storecomp'])->name('storecomp');
                Route::get('/partners',[AdminController::class, 'partners'])->name('partners');
                Route::get('/updatecomp',[AdminController::class, 'compupdate'],)->name('updatecomp');
                Route::put('/storecompupdate/{id}',[AdminController::class, 'storecompupdate'],)->name('storecompupdate');
                Route::get('/trashcompany',[AdminController::class, 'trashcompany'],)->name('trashcompany');
                Route::match(['get','post'],'/restorecomp',[AdminController::class, 'restorecomp'],)->name('restorecomp');
                Route::match(['get','post'],'/trashcomp',[AdminController::class, 'trashcomp'],)->name('trashcomp');
                Route::match(['get','post'],'/deletecomp',[AdminController::class, 'compdelete'],)->name('deletecomp');
                Route::post('/tmp-upload',[ProductController::class, 'tmpUpload']);
                Route::delete('/tmp-delete',[ProductController::class, 'tmpDelete']);
                Route::get('/activitylogs',[AdminController::class, 'activitylogs'])->name('activitylogs');
                Route::match(['get','post'],'/partneredcompany', [PartnersController::class, 'partneredcompany'])->name('partneredcompany');
                Route::match(['get','post'],'/accesslists', [PartnersController::class, 'adminaccesslists'])->name('adminaccesslists');
                Route::match(['get','post'],'/reportedbugs', [BugReportController::class, 'reportedbugs'])->name('reportedbugs');
                Route::match(['get','post'],'/readbugreport/{id}', [BugReportController::class, 'readbugreport'])->name('readbugreport');
                Route::match(['get','post'],'/updatereport', [BugReportController::class, 'updatereport'])->name('updatereport');
            });
            
            Route::get('/edituser', [UserController::class, 'edituser'])->name('edituser');
            Route::match(['get','post'],'/storeuserupdate', [UserController::class, 'storeuserupdate'])->name('storeuserupdate');
            Route::match(['get','post'],'/', [PartnersController::class, 'companylist']);
            Route::match(['get','post'],'/company/{company}', [PartnersController::class, 'company'])->name('company');
            Route::match(['get','post'],'/bugreport', [BugReportController::class, 'index'])->name('bugreport');
            Route::match(['get','post'],'/savebugreport', [BugReportController::class, 'savereport'])->name('savebugreport');
        });
    });
});

