<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //


    public function register(CreateValidation $request)
    {
        try {
            // Valide la requête et récupère les données validées 
            $validated = $request->validated();

            // Vérifier si l'email existe déjà
            if (User::where('email', $validated['email'])->exists()) {
                return response()->json([
                    'statut' => 500,
                    'message' => 'Cet email est déjà utilisé.',
                    'data' => [
                        'errors' => [
                            'email' => 'Cet email est déjà utilisé.'
                        ]
                    ]
                ], 500);
            }
            // Vérifier que password == confirm_password
            if ($validated['password'] !== $validated['confirm_password']) {
                return response()->json([
                    'statut' => 422,
                    'message' => 'Les mots de passe ne correspondent pas.',
                    'data' => [
                        'errors' => [
                            'password' => 'Les mots de passe ne correspondent pas.'
                        ]
                    ]
                ], 422);
            }

            // Créer l'utilisateur
            $user = User::create([
                'prenom' => $validated['prenom'],
                'nom' => $validated['nom'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_actif' => false,
                'must_change_password' => false,
            ]);

            $role = $validated['role'] ?? 'user';
            // Assignation du rôle
            $user->assignRole($role);

            return response()->json([
                'statut' => 200,
                'message' => 'Utilisateur créé avec succès.',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'statut' => 500,
                'message' => 'Erreur lors de la création du compte.',
                'data' => [
                    'errors' => [
                        'exception' => $th->getMessage()
                    ]
                ]
            ], 500);
        }
    }
}
