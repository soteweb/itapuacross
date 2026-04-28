<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\EventRegistration;
use App\Livewire\EventAdmin;

use App\Livewire\EventList;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Athletes;

Route::get('/', EventList::class)->name('home');
Route::get('/admin', Dashboard::class)->name('admin.dashboard');
Route::get('/admin/events', EventAdmin::class)->name('admin.events');
Route::get('/admin/events/create', \App\Livewire\Admin\EventEditor::class)->name('admin.events.create');
Route::get('/admin/events/{event}/edit', \App\Livewire\Admin\EventEditor::class)->name('admin.events.edit');
Route::get('/admin/event-types', \App\Livewire\Admin\EventTypeAdmin::class)->name('admin.event-types');
Route::get('/admin/pages', \App\Livewire\Admin\PagesAdmin::class)->name('admin.pages');
Route::get('/admin/pages/create', \App\Livewire\Admin\PageEditor::class)->name('admin.pages.create');
Route::get('/admin/pages/{page}/edit', \App\Livewire\Admin\PageEditor::class)->name('admin.pages.edit');
Route::get('/admin/menus', \App\Livewire\Admin\MenuAdmin::class)->name('admin.menus');
Route::get('/admin/athletes', Athletes::class)->name('admin.athletes');
Route::get('/events/{event}/register', EventRegistration::class)->name('events.register');
Route::get('/eventos/{id}', \App\Livewire\EventShow::class)->name('event.show');
Route::get('/buscar-inscripcion', \App\Livewire\RegistrationSearch::class)->name('registration.search');

// CMS Dynamic Catch-All Route (must stay at the bottom)
Route::get('/{slug}', \App\Livewire\PublicPage::class)->name('page.show');
