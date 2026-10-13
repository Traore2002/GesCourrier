@extends('layouts.app')

@section('title', 'Nouvel Utilisateur - SOSUCO')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- ✅ GROS MESSAGE D'ERREUR GLOBAL -->
    @if ($errors->any())
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <strong style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                Veuillez corriger les erreurs suivantes :
            </strong>
            <ul style="padding-left: 1.5rem; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li style="margin-bottom: 0.3rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- En-tête -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.users.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500; padding: 0.5rem 1rem; background: white; border-radius: 8px; border: 1px solid #e2e8f0;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour à la liste
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">Nouvel Utilisateur</h1>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
        @csrf

        <!-- Matricule -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Matricule <span style="color: #ef4444;">*</span></label>
            <input type="text" name="matricule" value="{{ old('matricule') }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
            @error('matricule') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Nom -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Nom <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nom" value="{{ old('nom') }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                @error('nom') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <!-- Prénom -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Prénom <span style="color: #ef4444;">*</span></label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                @error('prenom') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Email -->
        <div style="margin-top: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Adresse Email <span style="color: #ef4444;">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
            @error('email') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
            <!-- Mot de passe -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Mot de passe <span style="color: #ef4444;">*</span></label>
                <input type="password" name="password" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                @error('password') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
            </div>

            <!-- Confirmation Mot de passe -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Confirmer le mot de passe <span style="color: #ef4444;">*</span></label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;" onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
        </div>

        <!-- ✅ Rôles (Cases à cocher) - C'EST ICI QU'ÉTAIT LE PROBLÈME ! -->
        <div style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Rôles <span style="color: #ef4444;">*</span></label>
            
            @error('role_ids') 
                <p style="color: #ef4444; font-size: 0.8rem; margin-bottom: 0.5rem;">{{ $message }}</p> 
            @enderror

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.8rem;">
                @foreach($roles as $role)
                    <label style="display: flex; align-items: center; padding: 0.8rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.borderColor='#4CAF50'; this.style.background='#f0fdf4'"
                           onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'">
                        
                        <!-- ✅ Le nom DOIT être role_ids[] avec les crochets pour que le contrôleur le reconnaisse -->
                        <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" 
                               style="width: 18px; height: 18px; accent-color: #2E7D32; margin-right: 0.8rem; cursor: pointer;">
                        
                        <span style="font-size: 0.95rem; color: #334155; font-weight: 500;">{{ ucfirst($role->nom) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Département -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Département</label>
            <select name="departement_id" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background: white;">
                <option value="">Non assigné</option>
                @foreach($departements as $dept)
                    <option value="{{ $dept->id }}" {{ old('departement_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Statut Actif -->
        <div style="margin-top: 1.5rem; display: flex; align-items: center; padding: 1rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #2E7D32; margin-right: 0.8rem; cursor: pointer;">
            <label for="is_active" style="font-size: 0.95rem; font-weight: 500; color: #334155; cursor: pointer;">Compte actif (l'utilisateur pourra se connecter)</label>
        </div>

        <!-- Boutons -->
        <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('admin.users.index') }}" style="padding: 0.8rem 1.5rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 600; text-decoration: none;">Annuler</a>
            <button type="submit" style="padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);">
                💾 Créer l'utilisateur
            </button>
        </div>
    </form>
</div>
@endsection