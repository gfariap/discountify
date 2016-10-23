<?php

namespace App\Http\Controllers;

use App\DiscountCode;
use Exception;
use File;
use Illuminate\Http\Request;

use App\Http\Requests;
use View;

class DiscountsController extends Controller
{

    public function index($store)
    {
        $discounts = DiscountCode::whereStore($store)->get();

        return view('discounts', compact('store', 'discounts'));
    }


    public function store(Request $request, $store)
    {
        $discount = new DiscountCode($request->all());
        $discount->store = $store;
        $discount->save();

        $request->session()->flash('success', 'Discount code registered!');

        return redirect()->route('discounts', compact('store'));
    }


    public function delete(Request $request, $store, $id)
    {
        $discount = DiscountCode::find($id);
        $discount->delete();

        $request->session()->flash('success', 'Discount code removed!');

        return redirect()->route('discounts', compact('store'));
    }


    public function generate(Request $request, $store)
    {
        $access_token = $request->session()->get('access_token');

        $shopify = app('ShopifyAPI', [
            'API_KEY'      => env('SHOPIFY_API_KEY'),
            'API_SECRET'   => env('SHOPIFY_API_SECRET'),
            'SHOP_DOMAIN'  => $store,
            'ACCESS_TOKEN' => $access_token
        ]);

        $discounts = DiscountCode::whereStore($store)->get();
        $discounts_string = '';

        foreach ($discounts as $discount) {
            $discounts_string = "'".json_encode($discount)."',";
        }

        $discounts_string = trim($discounts_string, ",");

        try {
            $themes_info = $shopify->call([
                'URL'    => 'themes.json',
                'METHOD' => 'GET'
            ]);
        } catch (Exception $e) {
            $themes_info = $e->getMessage();
        }

        $theme = '';

        if (isset($themes_info->themes)) {
            foreach ($themes_info->themes as $theme_info) {
                if ($theme_info->role == 'main') {
                    $theme = $theme_info;
                }
            }
        }

        if (isset($theme->id)) {
            $bar_liquid = (string) View::make('templates/script', [ 'discounts' => $discounts_string ]);
            $preview_liquid = (string) File::get(storage_path('templates/discountify_preview.liquid'));

            try {
                $bar_info = $shopify->call($params = [
                    'URL'    => 'themes/'.$theme->id.'/assets.json',
                    'METHOD' => 'PUT',
                    'DATA'   => [ 'asset' => [ 'key' => 'snippets/discountify_bar.liquid', 'value' => $bar_liquid ] ]
                ]);
            } catch (Exception $e) {
                $bar_info = $e->getMessage();
            }

            try {
                $preview_info = $shopify->call($params = [
                    'URL'    => 'themes/'.$theme->id.'/assets.json',
                    'METHOD' => 'PUT',
                    'DATA'   => [
                        'asset' => [
                            'key'   => 'snippets/discountify_preview.liquid',
                            'value' => $preview_liquid
                        ]
                    ]
                ]);
            } catch (Exception $e) {
                $preview_info = $e->getMessage();
            }
        }

        if (isset($bar_info) && isset($bar_info->asset) && isset($preview_info) && isset($preview_info->asset)) {
            $request->session()->flash('success', 'Discountify snippets were sucessfully updated on your store.');
        } else {
            $request->session()->flash('error', 'There was an error trying to publish the assets on your theme.');
        }

        return redirect()->route('index');
    }
}
