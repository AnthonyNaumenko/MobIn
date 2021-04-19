<?php

namespace App\Http\Controllers\Api;

use App\Games;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ids = $request->session()->get('cart');
        $response = Games::find($ids);

        return response($response, 200);

    }

    public function addToCart(Request $request, $id)
    {
        $game = Games::find($id);
        if (isset($game)) {
            if (!is_array($value = $request->session()->get('cart')))
                $value = (array)$value;
            array_push($value, $id);
            $request->session()->put('cart', $value);
            return [
                'message' => $game->title . ' add to cart'
            ];
        } else {
            return [
                'message' => 'Game not exist'
            ];
        }
    }

    public function removeFromCart(Request $request, $id)
    {
        $value = $request->session()->get('cart');
        if (in_array($id, $value)) {
            $value = array_diff($value, [$id]);
            $request->session()->put('cart', $value);
            $game = Games::find($id);
            return [
                'message' => $game->title . ' remove from cart'
            ];
        } else {
            return [
                'message' => 'Game not exist'
            ];
        }
    }
}
