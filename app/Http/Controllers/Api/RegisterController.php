<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="registerUser",
     *     summary="Create a new user / register",
     *     description="This endpoint allows you to create a new user / register",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "role_id", "institute", "province_id", "regency_id"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="role_id", type="integer", example=1),
     *             @OA\Property(property="institute", type="string", example="XYZ University"),
     *             @OA\Property(property="province_id", type="integer", example=1),
     *             @OA\Property(property="regency_id", type="integer", example=1),
     *             @OA\Property(property="password", type="string", format="password", example="password1"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", additionalProperties=@OA\Property(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict - User could not be created",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => [
                    'required',
                    'min:6',
                    'confirmed',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
                ],
                'role_id' => 'required|exists:roles,id',
                'institute' => 'required',
                'province_id' => 'required|exists:reg_provinces,id',
                'regency_id' => [
                    'required',
                    'exists:reg_regencies,id',
                    function ($attribute, $value, $fail) use ($request) {
                        $regency = \App\Models\Regency::where('id', $value)
                            ->where('province_id', $request->province_id)
                            ->first();

                        if (!$regency) {
                            $fail('The selected regency does not belong to the selected province.');
                        }
                    },
                ],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::create([
                'name' => $request->name,
                'role_id' => $request->role_id,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'institute' => $request->institute,
                'province_id' => $request->province_id,
                'regency_id' => $request->regency_id,
            ]);

            if ($user) {
                return response()->json([
                    'success' => true,
                    'user'    => $user,
                ], 201);
            }

            return response()->json([
                'success' => false,
            ], 409);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
