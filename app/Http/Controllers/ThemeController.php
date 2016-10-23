<?php

namespace App\Http\Controllers;

use Exception;
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
                    'URL'    => 'themes/#'.$theme->id.'/assets.json',
                    'METHOD' => 'GET'
                ]);
            } catch (Exception $e) {
                $assets_info = $e->getMessage();
            }

            return view('customize', [ 'themes' => $assets_info ]);
        }

        return view('customize');
    }
}
