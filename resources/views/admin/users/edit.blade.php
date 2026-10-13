@extends('layouts.app')

@section('title', 'Modifier Utilisateur - SOSUCO')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- ✅ AFFICHAGE DES ERREURS -->
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

    <div style="background: white; border-radius: 16px; box-shadow: 0 8px 32px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1); overflow: hidden;">
        
        <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 2rem 2.5rem; border-bottom: 1px solid rgba(46, 125, 50, 0.1);">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #2E7D32; margin: 0 0 0.5rem 0;">Modifier l'utilisateur</h2>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
                Mettez à jour les informations de <strong style="color: #2E7D32;">{{ $user->prenom }} {{ $user->nom }}</strong>
            </p>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" style="padding: 2.5rem;">
            @csrf
            @method('PUT')

            <!-- ✅ CORRECTION MATRICULE : Utiliser 'readonly' au lieu de 'disabled' + 'hidden' -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px;">Matricule</label>
                <input type="text" name="matricule" value="{{ old('matricule', $user->matricule) }}" readonly
                       style="width: 100%; padding: 0.9rem 1.2rem; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 12px; color: #64748b; font-size: 0.95rem; cursor: not-allowed;">
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.4rem;">Le matricule ne peut pas être modifié après la création.</p>
            </div>

            <!-- Nom et Prénom -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Nom <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required
                           style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; color: #1e293b; transition: all 0.2s; outline: none;"
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>
                <div>
                    <label for="prenom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Prénom <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" required
                           style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; color: #1e293b; transition: all 0.2s; outline: none;"
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>
            </div>

            <!-- Email -->
            <div style="margin-bottom: 2rem;">
                <label for="email" style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Adresse Email <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; color: #1e293b; transition: all 0.2s; outline: none;"
                       onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
            </div>

            <!-- ✅ NOUVEAU : Section Mot de passe (Optionnelle) -->
            <div style="margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <h3 style="font-size: 1rem; font-weight: 600; color: #334155; margin: 0 0 0.5rem 0;">Changer le mot de passe</h3>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">Laissez ces champs vides pour conserver le mot de passe actuel.</p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label for="password" style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" 
                               style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; color: #1e293b; transition: all 0.2s; outline: none;"
                               onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        @error('password') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; color: #1e293b; transition: all 0.2s; outline: none;"
                               onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    </div>
                </div>
            </div>

                        <!-- RÔLES (Cases à cocher sécurisées) -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.8rem;">
                    Rôles <span style="color: #ef4444;">*</span> 
                    <span style="font-weight: 400; color: #64748b; font-size: 0.8rem;">(Sélectionnez 1 ou 2 rôles)</span>
                </label>
                
                <!-- Message d'erreur spécifique aux rôles -->
                @error('role_ids')
                    <p style="color: #ef4444; font-size: 0.85rem; margin-bottom: 0.5rem; font-weight: 600;">⚠️ {{ $message }}</p>
                @enderror

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 0.8rem;">
                    @foreach($roles as $role)
                        @php
                            // 1. On récupère les rôles actuels de l'utilisateur en base de données
                            $currentRoleIds = $user->roles->pluck('id')->toArray();
                            
                            // 2. On priorise les anciennes données (en cas d'erreur de validation) sinon on prend la BDD
                            $selectedRoles = old('role_ids', $currentRoleIds);
                            
                            // 3. On vérifie si ce rôle précis est dans la liste
                            $isChecked = in_array($role->id, $selectedRoles);
                        @endphp
                        
                        <label class="role-checkbox-label" style="display: flex; align-items: center; padding: 0.8rem 1rem; background: {{ $isChecked ? '#f0fdf4' : '#f8fafc' }}; border: 1px solid {{ $isChecked ? '#4CAF50' : '#e2e8f0' }}; border-radius: 12px; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.borderColor='#4CAF50'; this.style.background='#f0fdf4'"
                               onmouseout="this.style.borderColor='{{ $isChecked ? '#4CAF50' : '#e2e8f0' }}'; this.style.background='{{ $isChecked ? '#f0fdf4' : '#f8fafc' }}'">
                            
                            <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" class="role-checkbox" {{ $isChecked ? 'checked' : '' }}
                                   style="width: 18px; height: 18px; accent-color: #2E7D32; margin-right: 0.8rem; cursor: pointer;">
                            
                            <span style="font-size: 0.95rem; color: #334155; font-weight: 500;">{{ ucfirst($role->nom) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <!-- Département -->
            <div style="margin-bottom: 2rem;">
                <label for="departement_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Département</label>
                <select name="departement_id" id="departement_id"
                        style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; color: #1e293b; background: white; cursor: pointer; transition: all 0.2s; outline: none; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2364748b%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 0.8rem;"
                        onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    <option value="">-- Non assigné --</option>
                    @foreach($departements as $dept)
                        <option value="{{ $dept->id }}" {{ old('departement_id', $user->departement_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Statut Actif -->
            <div style="margin-bottom: 2.5rem; display: flex; align-items: center; padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                       style="width: 20px; height: 20px; accent-color: #2E7D32; cursor: pointer; margin-right: 1rem;">
                <label for="is_active" style="font-size: 0.95rem; font-weight: 500; color: #334155; cursor: pointer;">
                    Utilisateur actif (peut se connecter à la plateforme)
                </label>
            </div>

            <!-- Boutons -->
            <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('admin.users.index') }}" 
                   style="padding: 0.9rem 1.8rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: all 0.2s;"
                   onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#cbd5e1'"
                   onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0'">
                    Annuler
                </a>
                <button type="submit" 
                        style="padding: 0.9rem 2rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script pour limiter à 2 rôles -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.role-checkbox');
        const maxAllowed = 2;

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.role-checkbox:checked').length;
                
                if (checkedCount > maxAllowed) {
                    this.checked = false;
                    alert('Vous ne pouvez sélectionner que 2 rôles maximum.');
                }

                checkboxes.forEach(cb => {
                    const label = cb.closest('.role-checkbox-label');
                    if (cb.checked) {
                        label.style.background = '#f0fdf4';
                        label.style.borderColor = '#4CAF50';
                    } else {
                        label.style.background = '#f8fafc';
                        label.style.borderColor = '#e2e8f0';
                    }
                });
            });
        });
    });
</script>
@endsection