<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckOutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;


Route::get('/',HomePage::class)->name('home-page');


Route::get('categories',CategoriesPage::class)->name('categories.index');
Route::get('products',ProductsPage::class)->name('products.index');
Route::get('cart',CartPage::class)->name('cart.index');
Route::get('products/{slug}',ProductDetailPage::class)->name('product-detail');

Route::get('login',LoginPage::class)->name('login');
Route::get('register',RegisterPage::class)->name(name: 'register');
Route::get('forgot',ForgotPasswordPage::class)->name(name: 'forgot_password');
Route::get('reset',ResetPasswordPage::class)->name('reset_password');

// Route::middleware(['guest'])->group(function () {
   
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/logout',function(){
        auth()->logout();
        return redirect('/');
    })->name('logout');
    Route::get('checkout',CheckOutPage::class)->name('checkout');
    Route::get('my-orders',MyOrdersPage::class)->name('my-orders');
    Route::get('my-orders/{order}',MyOrderDetailPage::class)->name('my-orders.show');
    Route::get('success',SuccessPage::class)->name('success');
Route::get('cancel',CancelPage::class)->name('cancel');
});

