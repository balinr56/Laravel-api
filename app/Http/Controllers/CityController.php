<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;


class CityController extends Controller
{
    /**
 * @api {get} /cities Települések listázása
 * @apiName GetCities
 * @apiGroup Cities
 *
 * @apiDescription Települések listázása, név szerinti keresése és megye szerinti szűrése.
 *
 * @apiQuery {String} [search] Keresés a település nevében.
 * @apiQuery {Number} [county_id] Szűrés megyeazonosító alapján.
 *
 * @apiSuccess {Object[]} cities A települések listája.
 */
    public function index(Request $request)
    {
        $query = City::with('county');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('county_id')) {
            $query->where('county_id', $request->county_id);
        }

        $cities = $query->get();

        return response()->json([
            'cities' => $cities,
        ]);
    }
/**
 * @api {post} /cities Új település létrehozása
 * @apiName CreateCity
 * @apiGroup Cities
 * @apiPermission authenticated
 *
 * @apiHeader {String} Authorization Bearer token.
 * @apiBody {String} name A település neve.
 * @apiBody {Number} county_id A megye azonosítója.
 *
 * @apiSuccess {Object} city A létrehozott település.
 * @apiError (401) Unauthorized Hiányzó vagy érvénytelen token.
 * @apiError (422) ValidationError Hibás vagy hiányzó adatok.
 */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'county_id' => 'required|exists:counties,id',
        ]);

        $city = City::create($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }
    /**
 * @api {put} /cities/:id Település módosítása
 * @apiName UpdateCity
 * @apiGroup Cities
 * @apiPermission authenticated
 *
 * @apiHeader {String} Authorization Bearer token.
 * @apiParam {Number} id A település azonosítója.
 * @apiBody {String} name A település új neve.
 * @apiBody {Number} county_id Az új megye azonosítója.
 *
 * @apiSuccess {Object} city A módosított település.
 * @apiError (401) Unauthorized Hiányzó vagy érvénytelen token.
 * @apiError (404) NotFound A település nem található.
 */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }
    /**
 * @api {delete} /cities/:id Település törlése
 * @apiName DeleteCity
 * @apiGroup Cities
 * @apiPermission authenticated
 *
 * @apiHeader {String} Authorization Bearer token.
 * @apiParam {Number} id A törlendő település azonosítója.
 *
 * @apiSuccess {String} message Sikeres törlés üzenete.
 * @apiError (401) Unauthorized Hiányzó vagy érvénytelen token.
 * @apiError (404) NotFound A település nem található.
 */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => 'City deleted',
        ]);
    }
}
