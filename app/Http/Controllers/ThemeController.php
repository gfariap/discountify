<?php

namespace App\Http\Controllers;

use App\Theme;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;

class ThemeController extends Controller
{

    public function index($store)
    {
        $theme = Theme::whereStore($store)->get();
        if ($theme->isEmpty()) {
            $array = [
                'store'            => $store,
                'border'           => false,
                'border_color'     => '000000',
                'background_color' => '000000',
                'text_color'       => 'FFFFFF',
                'success_color'    => '22B573',
                'danger_color'     => 'BF5329'
            ];

            $theme = new Theme($array);
            $theme->save();
        }

        $theme = $theme->first();

        return view('customize', compact('store', 'theme'));
    }


    public function update(Request $request, $store)
    {
        $theme = Theme::find($store);
        $theme->fill($request->all());
        $theme->save();

        return view('customize', compact('store', 'theme'));
    }


    public function customize(Request $request)
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
