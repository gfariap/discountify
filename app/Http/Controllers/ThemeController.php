<?php

namespace App\Http\Controllers;

use App\Theme;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use View;

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

        $this->generate($request, $store);
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

        $saved_theme = Theme::find($store);

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
            $scss_file = (string) View::make('templates/style', $saved_theme->toArray());

            try {
                $asset_info = $shopify->call($params = [
                    'URL'    => 'themes/'.$theme->id.'/assets.json',
                    'METHOD' => 'PUT',
                    'DATA'   => [ 'asset' => [ 'key' => 'assets/discountify.scss', 'value' => $scss_file ] ]
                ]);
            } catch (Exception $e) {
                $asset_info = $e->getMessage();
            }
        }

        if (isset($asset_info) && isset($asset_info->asset)) {
            $request->session()->flash('success', 'Discountify theme was sucessfully updated on your store.');
        } else {
            $request->session()->flash('error', 'There was an error trying to publish the asset on your theme.');
        }

        return redirect()->route('index');
    }
}
