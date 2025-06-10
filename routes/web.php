<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AccountController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/deals/{deal}/edit', [DealController::class, 'edit'])->name('deals.edit');
Route::put('/deals/{deal}', [DealController::class, 'update'])->name('deals.update');


Route::post('/deals/assign-task', [DealController::class, 'assignTask'])->name('deals.assignTask');


Route::post('/tasks/mass-update', [TaskController::class, 'massUpdate'])->name('tasks.massUpdate');

Route::post('/tasks/mass-action', [TaskController::class, 'massAction'])->name('tasks.massAction');

Route::post('/tasks/mass-delete', [TaskController::class, 'massDelete'])->name('tasks.massDelete');

Route::resource('tasks', TaskController::class);


Route::get('deals', [DealController::class, 'index'])->name('deals.index');
Route::post('deals/bulk-action', [DealController::class, 'bulkAction'])->name('deals.bulkAction');

Route::get('deals/mass-update-form', [DealController::class, 'massUpdateForm'])->name('deals.mass.update.form');
Route::post('deals/mass-update', [DealController::class, 'massUpdate'])->name('deals.mass.update');

Route::post('/tasks/assign-to-leads', [TaskController::class, 'assignToLeads'])->name('tasks.assignToLeads');


Route::post('/leads/{id}/convert', [LeadController::class, 'convert'])->name('leads.convert');

Route::post('/leads/{lead}/email', [LeadController::class, 'sendEmail'])->name('leads.email');

Route::get('/leads/{lead}/clone', [LeadController::class, 'clone'])->name('leads.clone');

Route::post('/leads/mass-convert', [LeadController::class, 'massConvert'])->name('leads.massConvert');
Route::post('/leads/mass-email', [LeadController::class, 'massEmail'])->name('leads.massEmail');
Route::post('/leads/print-view', [LeadController::class, 'printView'])->name('leads.printView');

Route::post('/leads/assign-task', [TaskController::class, 'assignToLeads'])->name('leads.assignTask');

Route::post('/deals/mass-action', [DealController::class, 'massAction'])->name('deals.massAction');


Route::post('deals/assign-task', [DealController::class, 'assignTask'])->name('deals.assignTask');


Route::post('deals/mass-update', [DealController::class, 'massUpdate'])->name('deals.massUpdate');



Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');


Route::post('/deals/mass-action', [DealController::class, 'massAction'])->name('deals.massAction');

Route::post('/deals/mass-delete', [DealController::class, 'massDelete'])->name('deals.massDelete');
Route::post('/deals/mass-email', [DealController::class, 'massEmail'])->name('deals.massEmail');
Route::post('/tasks/assign-to-deals', [TaskController::class, 'assignToDeals'])->name('tasks.assignToDeals');


Route::get('/deals/create-from-lead/{leadId}', [DealController::class, 'createFromLead'])->name('deals.createFromLead');
Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
Route::get('deals/show/{deal}', [DealController::class, 'show'])->name('deals.show');


Route::post('/leads/mass-action', [LeadController::class, 'massAction'])->name('leads.massAction');
Route::get('/leads/print-view', [LeadController::class, 'printView'])->name('leads.printView');
Route::post('/leads/mass-update', [LeadController::class, 'massUpdate'])->name('leads.massUpdate');

Route::get('/leads/{lead}/print', [LeadController::class, 'print'])->name('leads.print');
Route::get('/leads/{lead}/timeline', [LeadController::class, 'timeline'])->name('leads.timeline');

Route::resource('accounts', AccountController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('leads', LeadController::class);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('deals', DealController::class);
});

Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
//     Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
// });

Route::resource('meetings', MeetingController::class);


Route::resource('tasks', TaskController::class);
Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');


Route::resource('contacts', ContactController::class);

require __DIR__.'/auth.php';
