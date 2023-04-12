<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\MenusController;
use App\Http\Controllers\SubMenusController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\TablesController;

use App\Http\Controllers\ChefsController;

use App\Http\Controllers\AboutUsController;

use App\Http\Controllers\OrderController;

use App\Http\Controllers\ChatController;

use App\Http\Controllers\WebNotificationController;
use App\Http\Controllers\RestaurentWebsiteController;


//Route::group(['middleware' => 'prevent-back-history'],function(){

Auth::routes();
//Login
Route::get('/', [LoginController::class, 'index'])->name('userlogin');

//Route::post('/loginCheck', [LoginController::class, 'checkLogin'])->name('admin/loginCheck');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword']);
Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password');

Route::get('/resetpassword/{token}', [LoginController::class, 'resetpassword']);
Route::post('/resetpassword', [LoginController::class, 'resetpassword'])->name('admin/resetpassword');


Route::group(['middleware' => ['is_admin']], function(){

    Route::get('/admin/dashboard', [LoginController::class, 'dashboard'])->name('admin/dashboard');
    Route::any('/admin/settings', [LoginController::class, 'settings'])->name('admin/settings');
    Route::any('/admin/change_password', [LoginController::class, 'change_password'])->name('admin/change_password');
    
    Route::get('admin/dashboard/data', [HomeController::class, 'data'])->name('admin.dashboard.data');
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/prodile', [LoginController::class, 'prodile'])->name('admin.prodile');

    //Menu /Category
    Route::any('admin/menu/data', [App\Http\Controllers\MenusController::class, 'data'])->name('admin/menu/data');
    Route::any('admin/menu', [App\Http\Controllers\MenusController::class, 'index'])->name('admin.menu');
    Route::any('admin/menu/create', [App\Http\Controllers\MenusController::class, 'create'])->name('admin.menu.create');
    Route::any('admin/menu/edit/{id}', [App\Http\Controllers\MenusController::class, 'edit'])->name('admin.menu.edit');
    Route::any('admin/menu/store', [App\Http\Controllers\MenusController::class, 'store'])->name('admin.menu.store');
    Route::any('admin/menu/update', [App\Http\Controllers\MenusController::class, 'update'])->name('admin.menu.update');
    Route::any('admin/menu/status_change', [App\Http\Controllers\MenusController::class, 'status_change'])->name('admin.menu.status_change');

    //Sub Category
    Route::any('admin/sub_menu/data', [App\Http\Controllers\SubMenusController::class, 'data'])->name('admin/sub_menu/data');
    
    Route::any('admin/sub_menu', [App\Http\Controllers\SubMenusController::class, 'index'])->name('admin.sub_menu');
    Route::any('admin/sub_menu/create', [App\Http\Controllers\SubMenusController::class, 'create'])->name('admin.sub_menu.create');
    Route::any('admin/sub_menu/edit/{id}', [App\Http\Controllers\SubMenusController::class, 'edit'])->name('admin.sub_menu.edit');
    Route::any('admin/sub_menu/show/{id}', [App\Http\Controllers\SubMenusController::class, 'show'])->name('admin.sub_menu.show');
    Route::any('admin/sub_menu/store', [App\Http\Controllers\SubMenusController::class, 'store'])->name('admin.sub_menu.store');
    Route::any('admin/sub_menu/update', [App\Http\Controllers\SubMenusController::class, 'update'])->name('admin.sub_menu.update');
    Route::any('admin/sub_menu/status_change', [App\Http\Controllers\SubMenusController::class, 'status_change'])->name('admin.sub_menu.status_change');
    Route::any('admin/sub_menu/get_menu_by_restaurent_id', [App\Http\Controllers\SubMenusController::class, 'get_menu_by_restaurent_id'])->name('admin.sub_menu.get_menu_by_restaurent_id');
      
    //Customer Register
    Route::any('admin/customer/data', [App\Http\Controllers\CustomerController::class, 'data'])->name('admin/customer/data');
   

    Route::any('admin/customer', [App\Http\Controllers\CustomerController::class, 'customer_list'])->name('admin/customer');
    Route::any('admin/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('admin.customer.create');
    Route::any('admin/customer/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('admin.customer.store');
    Route::any('admin/customer/index', [App\Http\Controllers\CustomerController::class, 'index'])->name('admin.customer.index');
    Route::any('admin/customer/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('admin.customer.edit');
    Route::any('admin/customer/show/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('admin.customer.show');
    Route::any('admin/customer/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('admin.customer.update');
    Route::any('admin/customer/status_change', [App\Http\Controllers\CustomerController::class, 'status_change'])->name('admin.customer.status_change');
    
    //Branch
    Route::any('admin/branch/{id}', [App\Http\Controllers\CustomerController::class, 'branch_list'])->name('admin.branch');
    Route::any('admin/customerBranch/data', [App\Http\Controllers\CustomerController::class, 'branchdata'])->name('admin/customerBranch/data');
    Route::any('admin/branch_status_change', [App\Http\Controllers\CustomerController::class, 'branch_status_change'])->name('admin.branch.branch_status_change');
   
    
    //Manager
    Route::any('admin/manager/{id}', [App\Http\Controllers\ManagerController::class, 'index'])->name('admin.manager');
    Route::any('admin/manager', [App\Http\Controllers\ManagerController::class, 'managerdata'])->name('admin.managerdata');
    Route::any('admin/managerstatus_change', [App\Http\Controllers\ManagerController::class, 'status_change'])->name('admin.managerstatus_change');
    
       //Chefs
    Route::any('admin/chefs/data', [App\Http\Controllers\ChefsController::class, 'adminData'])->name('admin/chefs/data');
    Route::any('admin/chefs', [App\Http\Controllers\ChefsController::class, 'index'])->name('admin.chefs');
    Route::any('admin/chefs/status_change', [App\Http\Controllers\ChefsController::class, 'status_change'])->name('admin.chefs.status_change');
    
    //Chat
    Route::any('admin/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('admin.chat');
   
    //restaurentGraph
    Route::any('admin/restaurentGraph', [App\Http\Controllers\HomeController::class, 'restaurentGraph'])->name('admin.restaurentGraph');
    
      //Logout Admin Panel
      Route::get('/admin/logout', [LoginController::class, 'logout']);
//});


});

Route::group(['middleware' => ['is_restaurent']], function(){
Route::any('restaurent/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('restaurent.dashboard');

   //Branch  Management
   Route::any('restaurent/branch/data', [App\Http\Controllers\BranchController::class, 'branchdata'])->name('restaurent/branch/data');
   Route::any('restaurent/branch', [App\Http\Controllers\BranchController::class, 'index'])->name('restaurent.branch');
   Route::any('restaurent/branch/create', [App\Http\Controllers\BranchController::class, 'create'])->name('restaurent.branch.create');
   Route::any('restaurent/branch/edit/{id}', [App\Http\Controllers\BranchController::class, 'edit'])->name('restaurent.branch.edit');
   Route::any('restaurent/branch/show/{id}', [App\Http\Controllers\BranchController::class, 'show'])->name('restaurent.branch.show');
   Route::any('restaurent/branch/store', [App\Http\Controllers\BranchController::class, 'store'])->name('restaurent.branch.store');
   Route::any('restaurent/branch/update', [App\Http\Controllers\BranchController::class, 'update'])->name('restaurent.branch.update');
   Route::any('restaurent/branch/status_change', [App\Http\Controllers\BranchController::class, 'status_change'])->name('restaurent.branch.status_change');


   //Banner Manager
   Route::any('restaurent/banner/data', [App\Http\Controllers\BannersController::class, 'data'])->name('restaurent/banner/data');
   Route::any('restaurent/banner', [App\Http\Controllers\BannersController::class, 'index'])->name('restaurent.banner');
   Route::any('restaurent/banner/create', [App\Http\Controllers\BannersController::class, 'create'])->name('restaurent.banner.create');
   Route::any('restaurent/banner/edit/{id}', [App\Http\Controllers\BannersController::class, 'edit'])->name('restaurent.banner.edit');
   Route::any('restaurent/banner/show/{id}', [App\Http\Controllers\BannersController::class, 'show'])->name('restaurent.banner.show');
   Route::any('restaurent/banner/store', [App\Http\Controllers\BannersController::class, 'store'])->name('restaurent.banner.store');
   Route::any('restaurent/banner/update', [App\Http\Controllers\BannersController::class, 'update'])->name('restaurent.banner.update');
   Route::any('restaurent/banner/status_change', [App\Http\Controllers\BannersController::class, 'status_change'])->name('restaurent.banner.status_change');
   
   //Servuces Manager
   Route::any('restaurent/services/data', [App\Http\Controllers\ServicesController::class, 'data'])->name('restaurent/services/data');
   Route::any('restaurent/services', [App\Http\Controllers\ServicesController::class, 'index'])->name('restaurent.services');
   Route::any('restaurent/services/create', [App\Http\Controllers\ServicesController::class, 'create'])->name('restaurent.services.create');
   Route::any('restaurent/services/edit/{id}', [App\Http\Controllers\ServicesController::class, 'edit'])->name('restaurent.services.edit');
   Route::any('restaurent/services/show/{id}', [App\Http\Controllers\ServicesController::class, 'show'])->name('restaurent.services.show');
   Route::any('restaurent/services/store', [App\Http\Controllers\ServicesController::class, 'store'])->name('restaurent.services.store');
   Route::any('restaurent/services/update', [App\Http\Controllers\ServicesController::class, 'update'])->name('restaurent.services.update');
   Route::any('restaurent/services/status_change', [App\Http\Controllers\ServicesController::class, 'status_change'])->name('restaurent.services.status_change');
   
   //Banner Manager
   Route::any('restaurent/banner/data', [App\Http\Controllers\BannersController::class, 'data'])->name('restaurent/banner/data');
   Route::any('restaurent/banner', [App\Http\Controllers\BannersController::class, 'index'])->name('restaurent.banner');
   Route::any('restaurent/banner/create', [App\Http\Controllers\BannersController::class, 'create'])->name('restaurent.banner.create');
   Route::any('restaurent/banner/edit/{id}', [App\Http\Controllers\BannersController::class, 'edit'])->name('restaurent.banner.edit');
   Route::any('restaurent/banner/show/{id}', [App\Http\Controllers\BannersController::class, 'show'])->name('restaurent.banner.show');
   Route::any('restaurent/banner/store', [App\Http\Controllers\BannersController::class, 'store'])->name('restaurent.banner.store');
   Route::any('restaurent/banner/update', [App\Http\Controllers\BannersController::class, 'update'])->name('restaurent.banner.update');
   Route::any('restaurent/banner/status_change', [App\Http\Controllers\BannersController::class, 'status_change'])->name('restaurent.banner.status_change');
   
   //Manager  Management
   Route::any('restaurent/manager/data', [App\Http\Controllers\ManagerController::class, 'managerdata'])->name('restaurent/manager/data');
   Route::any('restaurent/manager', [App\Http\Controllers\ManagerController::class, 'index'])->name('restaurent.manager');
   Route::any('restaurent/manager/create', [App\Http\Controllers\ManagerController::class, 'create'])->name('restaurent.manager.create');
   Route::any('restaurent/manager/edit/{id}', [App\Http\Controllers\ManagerController::class, 'edit'])->name('restaurent.manager.edit');
   Route::any('restaurent/manager/show/{id}', [App\Http\Controllers\ManagerController::class, 'show'])->name('restaurent.manager.show');
   Route::any('restaurent/manager/store', [App\Http\Controllers\ManagerController::class, 'store'])->name('restaurent.manager.store');
   Route::any('restaurent/manager/update', [App\Http\Controllers\ManagerController::class, 'update'])->name('restaurent.manager.update');
   Route::any('restaurent/manager/status_change', [App\Http\Controllers\ManagerController::class, 'status_change'])->name('restaurent.manager.status_change');
 
});








