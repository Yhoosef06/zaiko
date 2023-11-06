<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderItemTemp;
use Carbon\Carbon;
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

            //BORROWER SIDE NAV
            $pendingItems = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNull('date_returned')->whereNull('approval_date')->get();
            $borrowedItems = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('approval_date')->whereNull('date_returned')->get();
            $orderHistory = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('date_returned')->get();

            $cartcount = null;

            if($order == null){
                $cartcount = 0;
            }else{
                $items = OrderItemTemp::where('order_id', $order->id)->get();

                $cartcount = count($items);
            }

            //END OF BORROWER SIDE NAV
            
            $view->with([
                'cartcount' => $cartcount,
                "pendingcount" => count($pendingItems),
                'borrowedcount' => count($borrowedItems),
                'historycount' => count($orderHistory)
            ]);


        });

    }
}
