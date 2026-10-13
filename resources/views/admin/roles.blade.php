@extends('layouts.app')

@section('title', 'Gestion des Rôles - SN-SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">Gestion des Rôles et Permissions</h1>
                <p style="color: #64748b; font-size: 1rem; margin-top: 0.4rem;">Définissez les droits d'accès pour chaque rôle du système</p>
            </div>
            <a href="{{ route('courriers.index') }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 12px; color: #475569; text-decoration: none; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.borderColor='#2E7D32'; this.style.color='#2E7D32'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#475569'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour
            </a>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.8rem; font-weight: 600;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Liste des rôles -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
            
            @foreach($roles as $role)
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                
                <!-- En-tête de la carte -->
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #f1f5f9;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0; text-transform: capitalize;">{{ $role->nom }}</h3>
                        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">{{ count($role->permissions ?? []) }} permissions actives</p>
                    </div>
                </div>

                <!-- Formulaire des permissions -->
                <form action="{{ route('roles.updatePermissions', $role->id) }}" method="POST">
                    @csrf
                    
                    <div style="display: flex; flex-direction: column; gap: 0.8rem; max-height: 300px; overflow-y: auto; padding-right: 0.5rem;">
                        
                        @php
                            // Liste de toutes les permissions disponibles avec leurs labels
                            $allPermissions = [
                                'manage_users' => 'Gérer les utilisateurs',
                                'manage_roles' => 'Gérer les rôles et permissions',
                                'manage_types' => 'Gérer les types de courriers',
                                'manage_workflows' => 'Gérer les workflows',
                                'view_all_courriers' => 'Voir tous les courriers',
                                'delete_courrier' => 'Supprimer des courriers',
                                'scan_documents' => 'Numériser / Scanner des documents',
                                'create_courrier_arrivee' => 'Créer un courrier Arrivée',
                                'distribute_courrier' => 'Distribuer les courriers',
                                'view_dept_courriers' => 'Voir les courriers du département',
                                'edit_courrier' => 'Modifier les courriers',
                                'validate_courrier' => 'Valider les courriers',
                                'create_courrier_depart_interne' => 'Créer un courrier Départ / Interne',
                            ];
                            $currentPermissions = $role->permissions ?? [];
                        @endphp

                        @foreach($allPermissions as $key => $label)
                            <label style="display: flex; align-items: center; gap: 0.8rem; padding: 0.6rem; border-radius: 8px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ in_array($key, $currentPermissions) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #2E7D32; cursor: pointer;">
                                <span style="font-size: 0.9rem; color: #475569; font-weight: 500;">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Bouton de sauvegarde -->
                    <button type="submit" style="width: 100%; margin-top: 1.5rem; padding: 0.8rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Enregistrer les modifications
                    </button>
                </form>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection