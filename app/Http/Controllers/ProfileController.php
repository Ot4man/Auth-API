<?php

namespace App\Http\Controllers;
use App\Models\User;
use OpenApi\Attributes as OA;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    #[OA\Get(
        path: "/api/me",
        summary: "Consulter son propre profil",
        tags: ["Profil"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Profil récupéré avec succès",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Profile fetched successfully"),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function me(Request $request)
{
    return response()->json([
        'message' => 'Profile fetched successfully',
        'data' => $request->user()
    ], 200);
}
    #[OA\Put(
        path: "/api/me",
        summary: "Modifier ses informations",
        tags: ["Profil"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "New Name"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "new@example.com")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Profil modifié avec succès",
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: "message", type: "string", example: "Profile updated successfully")]
                )
            ),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 422, description: "Erreur de validation")
        ]
    )]
    public function update(UpdateProfileRequest $request)
{
    $user = $request->user();

    $user->update($request->only(['name','email']));

    return response()->json([
        'message' => 'Profile updated successfully'
    ], 200);
}
    #[OA\Put(
        path: "/api/me/password",
        summary: "Changer son mot de passe",
        tags: ["Profil"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["current_password", "new_password", "new_password_confirmation"],
                properties: [
                    new OA\Property(property: "current_password", type: "string", format: "password", example: "old_password123"),
                    new OA\Property(property: "new_password", type: "string", format: "password", minLength: 8, example: "new_password123"),
                    new OA\Property(property: "new_password_confirmation", type: "string", format: "password", minLength: 8, example: "new_password123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Mot de passe mis à jour avec succès",
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: "message", type: "string", example: "Password updated successfully")]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Mot de passe actuel incorrect ou erreur de validation",
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: "message", type: "string", example: "Current password is incorrect")]
                )
            ),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function changePassword(ChangePasswordRequest $request)
{
    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'message' => 'Current password is incorrect'
        ], 422);
    }

    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'message' => 'Password updated successfully'
    ], 200);
}
    #[OA\Delete(
        path: "/api/me",
        summary: "Supprimer son compte",
        tags: ["Profil"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Compte supprimé avec succès",
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: "message", type: "string", example: "Account deleted successfully")]
                )
            ),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function delete(Request $request)
{
    $user = $request->user();

    $user->tokens()->delete();
    $user->delete();
    
    return response()->json([
        'message' => 'Account deleted successfully'
    ], 200);
}

}
