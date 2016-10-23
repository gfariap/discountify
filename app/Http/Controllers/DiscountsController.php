<?php

namespace App\Http\Controllers;

use App\DiscountCode;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;

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
            try {
                $assets_info = $shopify->call([
                    'URL'    => 'themes/'.$theme->id.'/assets.json?asset[key]=snippets/discountify_toolbar.liquid&theme_id='.$theme->id,
                    'METHOD' => 'GET'
                ]);
            } catch (Exception $e) {
                $assets_info = $e->getMessage();
            }

            if (isset($assets_info->asset)) {

            } else {

            }
        }

        $request->session()->flash('error', 'There was an error trying to publish the asset on your theme.');

        return redirect()->route('index');
    }
}
