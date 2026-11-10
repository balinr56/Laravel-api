<?php

namespace App\Http\Controllers;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    /**
 * @api {get} /counties Megyék listázása
 * @apiName GetCounties
 * @apiGroup Counties
 *
 * @apiDescription Az összes megye lekérdezése a hozzájuk tartozó településekkel.
 *
 * @apiSuccess {Object[]} counties A megyék listája.
 */
    public function index()
    {
        $counties = County::with('cities')->get();
        return response()->json([
            'counties' => $counties,
        ]);
    }
    /**
 * @api {post} /counties Új megye létrehozása
 * @apiName CreateCounty
 * @apiGroup Counties
 * @apiPermission authenticated
 *
 * @apiHeader {String} Authorization Bearer token.
 * @apiBody {String} name A megye neve.
 *
 * @apiSuccess {Object} county A létrehozott megye.
 * @apiError (401) Unauthorized Hiányzó vagy érvénytelen token.
 * @apiError (422) ValidationError Hibás vagy hiányzó név.
 */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $county = County::create($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }
    /**
 * @api {put} /counties/:id Megye módosítása
 * @apiName UpdateCounty
 * @apiGroup Counties
 * @apiPermission authenticated
 *
 * @apiHeader {String} Authorization Bearer token.
 * @apiParam {Number} id A megye azonosítója.
 * @apiBody {String} name A megye új neve.
 *
 * @apiSuccess {Object} county A módosított megye.
 * @apiError (401) Unauthorized Hiányzó vagy érvénytelen token.
 * @apiError (404) NotFound A megye nem található.
 */
    public function update(Request $request, $id)
    {
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }
    /**
 * @api {delete} /counties/:id Megye törlése
 * @apiName DeleteCounty
 * @apiGroup Counties
 * @apiPermission authenticated
 *
 * @apiHeader {String} Authorization Bearer token.
 * @apiParam {Number} id A törlendő megye azonosítója.
 *
 * @apiSuccess {String} message Sikeres törlés üzenete.
 * @apiError (401) Unauthorized Hiányzó vagy érvénytelen token.
 * @apiError (404) NotFound A megye nem található.
 */
    public function destroy($id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'County deleted',
        ]);
    }
}
