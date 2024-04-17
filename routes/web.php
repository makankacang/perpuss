<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpusController;
use App\Http\Middleware\CheckLevel;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [PerpusController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        // Check the user's level
        if (Auth::user()->level == 'admin' || Auth::user()->level == 'petugas') {
            return redirect()->route('home');
        } elseif (Auth::user()->level == 'user') {
            return redirect()->route('homep');
        }
    });
    
    Route::middleware(['check.level:petugas,admin'])->group(function () {
        // Route untuk admin
        Route::get('/homeadmin', [PerpusController::class, 'index'])->name('home');
        Route::get('/buku',  [PerpusController::class, 'buku'])->name('admin.buku');
        Route::post('/bukuedit/{BukuID}', [PerpusController::class, 'bookedit'])->name('bukuedit');
        Route::post('/bukuinput', [PerpusController::class, 'bookinput'])->name('bukuinput'); 
        Route::get('/deletebuku/{BukuID}', [PerpusController::class, 'deletebuku'])->name('deletebuku'); 
        Route::get('/profiles', [perpusController::class, 'showProfile'])->name('profiles');
        Route::post('/cetak/report', [perpusController::class, 'cetakReport'])->name('cetak.report');

        Route::get('/kategori',  [PerpusController::class, 'katbuku'])->name('admin.kategori');
        Route::post('/katbukuedit/{katBukuID}', [PerpusController::class, 'katbukuedit'])->name('katbukuedit');
        Route::post('/katbukuinput', [PerpusController::class, 'katbukuinput'])->name('katbukuinput'); 
        Route::get('/katbukudelete/{katBukuID}', [PerpusController::class, 'deletekatbuku'])->name('deletekatbuku'); 


        Route::get('/koleksis',  [PerpusController::class, 'koleksi'])->name('admin.koleksi');
        Route::get('/koleksidelete/{katBukuID}', [PerpusController::class, 'koleksidelete'])->name('koleksidelete'); 

        Route::get('/peminjaman',  [PerpusController::class, 'peminjaman'])->name('admin.pinjaman');
        Route::post('/konfirmasi-peminjaman/{id}', [PerpusController::class, 'konfirmasiPeminjaman'])->name('konfirmasiPeminjaman');
        Route::delete('/peminjaman/{id}', [PerpusController::class, 'cancelPeminjaman'])->name('peminjaman.cancel');
        Route::post('/generate-report', [PerpusController::class, 'generate'])->name('generate.report');
        Route::get('/ulasan', [PerpusController::class, 'ulasanadmin'])->name('ulasanadmin');
        Route::delete('/ulasanBuku/delete/{id}', [PerpusController::class, 'ulasandelete'])->name('ulasanBuku.delete');
        Route::get('/user', [PerpusController::class, 'showUsers'])->name('users.show');
        Route::get('/users/change-level/{id}/{level}', [PerpusController::class, 'changeLevel'])->name('user.changeLevel');
    });

    // Route untuk user
    Route::get('/home', [PerpusController::class, 'indexp'])->name('homep');
    Route::get('/profile', [PerpusController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [PerpusController::class, 'updateProfile'])->name('update-profile');
    Route::get('/perpustakaan', [PerpusController::class, 'perpustakaan'])->name('peminjam.perpus');
    Route::get('/peminjamansaya',  [PerpusController::class, 'peminjamansaya'])->name('peminjam.pinjaman');
    Route::get('/koleksi',  [PerpusController::class, 'koleksip'])->name('peminjam.koleksi');
    Route::post('/kembalikan-buku/{id}', [PerpusController::class, 'kembalikanBuku'])->name('kembalikanBuku');
    Route::post('/add-to-collection', [PerpusController::class, 'addToCollection'])->name('add-to-collection');
    Route::post('/remove-from-collection', [PerpusController::class, 'removeFromCollection'])->name('remove-from-collection');
    Route::post('/remove-from-collections', [PerpusController::class, 'removeFromCollections'])->name('remove-from-collections');
    Route::post('/submit-review', [PerpusController::class, 'submitReview'])->name('submit_review');
    Route::put('/update-review', [PerpusController::class, 'updateReview'])->name('update_review');
    Route::get('/other-reviews', [perpusController::class, 'fetchOtherReviews'])->name('other_reviews');




    Route::get('/check-borrow-status', [PerpusController::class, 'checkBorrowStatus'])->name('check_borrow_status');
    Route::get('/check-review', [perpusController::class, 'checkReview'])->name('check_review');
    Route::post('/cancel-borrow', [PerpusController::class, 'cancelBorrow'])->name('cancel.borrow');
    Route::post('/store', [PerpusController::class, 'store'])->name('borrow.store'); 
    Route::view('/unauthorized', 'errors.unauthorized')->name('unauthorized');

});

