<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariation;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserProfile;
use Illuminate\Support\Facades\Route;

/* Home */
Route::get('/', [FrontendController::class, 'welcome']);

/* Admin Panel */
Route::get('/dashboard', [BackendController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

/* Authentication Check */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/* Profile Edit */
Route::get('/user/profile', [UserProfile::class, 'user_profile'])->middleware(['auth', 'verified'])->name('user_profile');
Route::post('/basic/update',[UserProfile::class, 'basic_update'])->name('basic.update');
Route::post('/password/update', [UserProfile::class, 'password_update'])->name('password.update');
Route::post('/photo/update', [UserProfile::class, 'photo_update'])->name('photo.update');

/* Users List */
Route::get('/user/list', [BackendController::class, 'user_list'])->middleware(['auth', 'verified'])->name('user.list');
Route::get('/user/delete/{user_id}', [BackendController::class, 'user_delete'])->name('user.delete');
Route::post('/add/user', [BackendController::class, 'add_user'])->name('add.user');

/* Business Categories */
Route::get('/categories', [CategoryController::class, 'categories'])->middleware(['auth', 'verified'])->name('categories');
Route::post('/add/category', [CategoryController::class, 'add_category'])->name('add.category');
Route::get('/trash/categories', [CategoryController::class, 'trash_category'])->name('trash.category');
Route::get('/edit/category/{id}', [CategoryController::class, 'edit_category'])->name('edit.category');
Route::post('/update/category/{id}', [CategoryController::class, 'update_category'])->name('update.category');
Route::get('/soft_delete/category/{id}', [CategoryController::class, 'soft_delete_category'])->name('soft.delete.category');
Route::get('/restore/category/{id}', [CategoryController::class, 'restore_category'])->name('restore.category');
Route::get('/trash/delete/{id}', [CategoryController::class, 'trash_delete'])->name('trash.delete');
Route::post('/checked/trash', [CategoryController::class, 'checked_trash'])->name('checked.trash');

/* Business Sub Category */
Route::get('/sub/categories', [SubCategoryController::class, 'sub_categories'])->name('sub.categories');
Route::post('/add/sub_category', [SubCategoryController::class, 'add_sub_category'])->name('add.sub.category');
Route::get('/edit/sub_category/{id}', [SubCategoryController::class, 'edit_sub_category'])->name('edit.sub.category');
Route::post('/update/sub_category/{id}', [SubCategoryController::class, 'update_sub_category'])->name('update.sub.category');
Route::get('/delete/sub/category/{id}', [SubCategoryController::class, 'delete_sub_category'])->name('delete.sub.category');

/* Business Brand */
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/add/brand', [BrandController::class, 'add_brand'])->name('add.brand');
Route::get('/delete/brand/{id}', [BrandController::class, 'delete_brand'])->name('delete.brand');

/* Business Items */
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::post('/subcategory', [ProductController::class, 'subcategory']);
Route::post('/add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::get('/preview/product', [ProductController::class, 'preview_product'])->name('preview.product');
Route::post('/product_status', [ProductController::class, 'product_status']);
Route::get('/delete/product/{id}', [ProductController::class, 'delete_product'])->name('delete.product');
Route::get('/view/full/product/{id}', [ProductController::class, 'view_full_product'])->name('view.full.product');

/* Product Variation */
Route::get('/product/variation', [ProductVariation::class, 'product_variation'])->name('product.variation');
Route::post('/add/color', [ProductVariation::class, 'add_color'])->name('color.store');
Route::post('/add/size', [ProductVariation::class, 'add_size'])->name('size.store');
Route::post('/add/tags', [ProductVariation::class, 'add_tags'])->name('tags.store');

/* Product Inventory */
Route::get('/add/inventory/{id}', [InventoryController::class, 'add_inventory'])->name('add.inventory');