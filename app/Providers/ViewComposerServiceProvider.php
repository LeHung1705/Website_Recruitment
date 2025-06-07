<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ThongBao;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $notifications = ThongBao::where('nguoi_nhan_id', Auth::user()->id)->get();
            } else {
                $notifications = collect(); // Empty collection if user is not logged in
            }
            $view->with('notifications', $notifications);
        });
    }
}
