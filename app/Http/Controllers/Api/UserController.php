<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Services\JSonDataClient;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/autobots",
     *     tags={"AutoBots"},
     *     summary="The resource collection",
     *     description="The resource collection",
     *     operationId="Api/UserController::index",
     *
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search the resource by name",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="quantity",
     *         in="query",
     *         description="The quantity",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="The resource collection",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *
     *    @OA\Response(response=400, ref="#/components/responses/400"),
     *    @OA\Response(response=403, ref="#/components/responses/403"),
     *    @OA\Response(response=404, ref="#/components/responses/404"),
     *    @OA\Response(response=422, ref="#/components/responses/422"),
     *    @OA\Response(response="default", ref="#/components/responses/500")
     * )
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index(GeneralRequest $request, JSonDataClient $client)
    {

        $bots = (new User)
            ->search($request->search ?? '')
            ->paginate($request->quantity ?? 10);

        return new UserCollection($bots);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
