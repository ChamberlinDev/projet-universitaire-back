<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function activate($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur introuvable'
            ], 404);
        }

        $user->is_actif = true;
        $user->save();

        return response()->json([
            'message' => 'Utilisateur activé avec succès'
        ], 200);
    }
}
