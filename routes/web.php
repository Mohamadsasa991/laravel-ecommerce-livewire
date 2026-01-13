<?php

use App\Livewire\Auth\ForgotPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckOutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersPage;
use App\Livewire\OrderDetailsPage;
use App\Livewire\ProductDetailsPage;
use App\Livewire\ProductsPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/',HomePage::class);
Route::get('/categories',CategoriesPage::class);
Route::get('/products',ProductsPage::class);
Route::get('/cart',CartPage::class);
Route::get('/products/{slug}',ProductDetailsPage::class);



Route::middleware('guest')->group(function(){
    Route::get('/login',LoginPage::class)->name('login');
    Route::get('/register',RegisterPage::class);
    Route::get('/forgot',ForgotPage::class)->name('password.request');
    Route::get('/reset/{token}',ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function(){
    Route::get('checkout',CheckOutPage::class);
    Route::get('/my-orders',MyOrdersPage::class);
    Route::get('/my-orders/{order_id}',OrderDetailsPage::class)->name('my-orders.show');
    Route::get('/cancel',CancelPage::class)->name('cancel');
    Route::get('/success',SuccessPage::class)->name('success');
    Route::get('/logout',function(){
        Auth::logout();
        return redirect('/');
    });
});

