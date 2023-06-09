<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();

        return response()->json($restaurants->map(function ($restaurant) {
            return [
                'id' => $restaurant->id,
                'title' => $restaurant->title,
                'address' => $restaurant->address,
                'menu_type' => $restaurant->menu_type,
                'phone_number' => $restaurant->phone_number,
                'total_points' => $restaurant->total_points,
                'total_votes' => $restaurant->total_votes,
                'image' => $restaurant->image,
            ];
        }));
    }

    /**
     * Get information for a specific store by id.
     * 
     * @param int $id The id of the store.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStoreById($id)
    {
        $restaurant = Restaurant::select('id', 'title', 'address', 'menu_type', 'phone_number', 'total_points', 'total_votes', 'image')->where('id', $id)->firstOrFail();

        $reviews = $restaurant->reviews()->where('restaurant_id', $restaurant->id)->select('id', 'author_id', 'nickname', 'restaurant_id', 'rating', 'review_text', 'image_file')->get();

        return response()->json([
            'restaurant' => $restaurant,
            'reviews' => $reviews,
        ]);
    }

    public function store(Request $request)
    {
        $restaurant = new Restaurant($request->all());
        $restaurant->save();

        return response()->json($restaurant, 201);
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update($request->all());

        return response()->json($restaurant, 200);
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();

        return response()->json(null, 204);
    }
}