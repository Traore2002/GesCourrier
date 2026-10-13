<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Traiter la connexion (avec Email)
     */
    public function login(Request $request)
    {
        // 1. On valide que c'est bien un email et un mot de passe
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. On essaie de connecter l'utilisateur avec son EMAIL (et non plus le matricule)
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Vérifier si le compte est actif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte a été désactivé par l\'administrateur.',
                ]);
            }

            return redirect()->intended(route('dashboard'))->with('success', 'Connexion réussie !');
        }

        // 3. Si échec, on affiche un message d'erreur et on garde l'email en mémoire (mais on efface le mot de passe par sécurité)
        return back()->withErrors([
            'email' => 'L\'adresse email ou le mot de passe est incorrect.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté.');
    }
}