<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderItemTemp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.pages.sidenav', function($view){
            $user = Auth::user();

            $order = Order::where('user_id', $user->id_number)->where('date_submitted', null)->first();

            // dd($order);

            $itemcount = null;

            if($order == null){
                $itemcount = 0;
            }else{
                $items = OrderItemTemp::where('order_id', $order->id)->get();

                $itemcount = count($items);
            }
            
            $view->with([
                'itemcount' => $itemcount
            ]);


        });
    }
}
