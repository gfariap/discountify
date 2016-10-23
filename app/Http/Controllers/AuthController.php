<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{

    public function index(Request $request)
    {
        if ($request->session()->has('access_token')) {
            $shop = $request->session()->get('shop');
            $access_token = $request->session()->get('access_token');

            $shopify = app('ShopifyAPI', [
                'API_KEY'      => env('SHOPIFY_API_KEY'),
                'API_SECRET'   => env('SHOPIFY_API_SECRET'),
                'SHOP_DOMAIN'  => $shop,
                'ACCESS_TOKEN' => $access_token
            ]);

            try {
                $response = $shopify->call([
                    'URL'    => 'shop.json',
                    'METHOD' => 'GET'
                ]);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }

            return view('index', compact('response'));
        } else {
            if ($request->has('shop') && ! is_null($request->get('shop')) && ! empty($request->get('shop'))) {
                $shop = $request->get('shop');
                session(compact('shop'));

                return $this->store($shop);
            } else {
                return view('welcome');
            }
        }
    }


    public function store($shop)
    {
        $shopify = app('ShopifyAPI', [
            'API_KEY'      => env('SHOPIFY_API_KEY'),
            'API_SECRET'   => env('SHOPIFY_API_SECRET'),
            'SHOP_DOMAIN'  => $shop,
            'ACCESS_TOKEN' => ''
        ]);

        $permissions_url = $shopify->installURL([
            'permissions' => [ 'read_themes', 'write_themes', 'read_script_tags', 'write_script_tags' ],
            'redirect'    => route('callback', [], true)
        ]);

        return view('redirect', [ 'installUrl' => $permissions_url ]);
    }


    public function callback(Request $request)
    {
        if ($request->has('code')) {
            $shop = $request->get('shop');

            $shopify = app('ShopifyAPI', [
                'API_KEY'      => env('SHOPIFY_API_KEY'),
                'API_SECRET'   => env('SHOPIFY_API_SECRET'),
                'SHOP_DOMAIN'  => $shop,
                'ACCESS_TOKEN' => ''
            ]);

            $access_token = $shopify->getAccessToken($request->get('code'));

            session(compact('shop', 'access_token'));

            try {
                $shopify = app('ShopifyAPI', [
                    'API_KEY'      => env('SHOPIFY_API_KEY'),
                    'API_SECRET'   => env('SHOPIFY_API_SECRET'),
                    'SHOP_DOMAIN'  => $shop,
                    'ACCESS_TOKEN' => $access_token
                ]);

                $shop_info = $shopify->call([
                    'URL'    => 'shop.json',
                    'METHOD' => 'GET'
                ]);
            } catch (Exception $e) {
                $shop_info = $e->getMessage();
            }

            $shop = Shop::firstOrNew([ 'name' => $shop ]);
            $shop->name = $request->session()->get('shop');
            $shop->access_token = $access_token;
            $shop->shop_name = $shop_info->shop->name;
            $shop->email = $shop_info->shop->email;
            $shop->owner = $shop_info->shop->shop_owner;
            $shop->save();

            return redirect('/');
        }
    }

}
