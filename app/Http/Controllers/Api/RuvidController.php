<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ruvid as RuvidResources;
use App\Models\Ruvid;
use Weidner\Goutte\GoutteFacade;

class RuvidController extends Controller
{
    /**
     * Get Ruvid listing on Leaflet JS geoJSON data structure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $ruvids = Ruvid::all();

        $geoJSONdata = $ruvids->map(function ($ruvid) {
            return [
                'type'       => 'Feature',
                'properties' => new RuvidResources($ruvid),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $ruvid['longitude'],
                        $ruvid['latitude'],
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }

    public function searchByName(Request $request) {
        if($request->has('q')) {
            $data = Ruvid::select(['id','name', 'latitude', 'longitude'])->where('name', 'like', '%' . $request->searchTerm . '%')->get();
            return response()->json($data);
        }

        return response()->json([]);
    }
}
