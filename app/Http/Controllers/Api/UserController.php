<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResources;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/me",
     *     operationId="getCurrentUser",
     *     tags={"User"},
     *     summary="Get current authenticated user",
     *     description="Returns the details of the currently authenticated user.",
     *     security={{
     *         "api_auth": {}
     *     }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data user"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - User is not authenticated"
     *     )
     * )
     */
    public  function me(Request $request)
    {
        $data = $request->user();

        return new PostResources(true, 'Data user', $data);
    }


    /**
     * @OA\Get(
     *     path="/api/user",
     *     operationId="getuserList",
     *     tags={"User"},
     *     summary="Get list of user",
     *     description="Returns a list of user",
     *     security={{
     *         "api_auth": {}
     *     }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="List data user"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function index()
    {
        $data = User::get();
        // $data = $users->map(function ($q) {
        //     $q->role = Role::find($q->role_id)->name;
        //     return $q;
        // });

        return new PostResources(true, 'List data user', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     operationId="getUserById",
     *     tags={"User"},
     *     summary="Get a user by ID",
     *     description="Returns a single user based on the provided ID",
     *     security={{
     *         "api_auth": {}
     *     }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data user"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return new PostResources(true, 'Data user', $user);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
