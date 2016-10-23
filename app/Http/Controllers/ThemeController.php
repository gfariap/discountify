<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ThemeController extends Controller
{

    public function index(Request $request)
    {
        $shop = $request->session()->get('shop');
        $access_token = $request->session()->get('access_token');

        $shopify = app('ShopifyAPI', [
            'API_KEY'      => env('SHOPIFY_API_KEY'),
            'API_SECRET'   => env('SHOPIFY_API_SECRET'),
            'SHOP_DOMAIN'  => $shop,
            'ACCESS_TOKEN' => $access_token
        ]);

        try {
            $themes = $shopify->call([
                'URL'    => 'themes.json',
                'METHOD' => 'GET'
            ]);
        } catch (Exception $e) {
            $themes = $e->getMessage();
        }

        return view('customize', compact('themes'));
    }
}
