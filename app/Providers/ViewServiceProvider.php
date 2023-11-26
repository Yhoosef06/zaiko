<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
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
            $cartcount = count(Order::where('user_id', $user->id_number)->where('date_submitted', null)->get());

            //BORROWED ITEMS
            $releasedOrders = Order::where('user_id', Auth::user()->id_number)->whereNotNull('date_submitted')->whereNotNull('approval_date')->whereNull('date_returned')->get();
            $releasedorderItems =collect();
            $releaseditems = collect();
            
            foreach($releasedOrders as $order){
                $orderItemsCollect = OrderItem::where('order_id',$order->id)->where('status','borrowed')->get();
                $releasedorderItems = $releasedorderItems->merge($orderItemsCollect);
            }

            foreach($releasedorderItems as $orderItem){
                $itemsCollect = Item::where('id',$orderItem->item_id)->get();
                $releaseditems = $releaseditems->merge($itemsCollect);
            }
            //END OF BORROWED ITEMS
            
            $view->with([
                'cartcount' => $cartcount,
                "pendingcount" => count($pendingItems),
                'borrowedcount' => count($releaseditems),
            ]);


        });

    }
}
