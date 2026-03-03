<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Identifiants incorrects'
            ], 401);
        }

        $user = Auth::user();

        // Vérifier si actif
        if (!$user->is_actif) {
            return response()->json([
                'message' => 'Votre compte n\'est pas encore activé par l\'administrateur.'
            ], 403);
        }

        // Supprimer anciens tokens si tu veux
        // $user->tokens()->delete();

        // Créer token
        $token = $user->createToken('api_token',['*'],now()->addHour() )->plainTextToken;
        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'user' => $user
        ]);
    }
}
    