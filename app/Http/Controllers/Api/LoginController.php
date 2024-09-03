<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     summary="Login a user",
     *     description="Authenticates a user and returns a token if successful. The user must not be soft-deleted (deleted_at must be null).",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Email or password is incorrect"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="array", @OA\Items(type="string", example="The email field is required.")),
     *             @OA\Property(property="password", type="array", @OA\Items(type="string", example="The password field is required."))
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt(array_merge($credentials, ['deleted_at' => null]));

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil login',
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }
}
