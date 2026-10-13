@extends('layouts.app')

@section('title', 'Créer un Rôle - SN-SOSUCO')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.roles.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500; padding: 0.5rem 1rem; background: white; border-radius: 8px; border: 1px solid #e2e8f0;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">Créer un Rôle</h1>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            
            <!-- Informations du rôle -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
                <h2 style="font-size: 1.2rem; font-weight: 700; color: #2E7D32; margin: 0 0 1.5rem 0;">Informations</h2>

                <div style="margin-bottom: 1.5rem;">
                    <label for="nom" style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Nom du rôle <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                           style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none;"
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                           placeholder="Ex: Chef de service, Archiviste...">
                    @error('nom') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="description" style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                              onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                              placeholder="Description du rôle...">{{ old('description') }}</textarea>
                </div>

                <div style="display: flex; align-items: center; padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <input type="hidden" name="actif" value="0">
                    <input type="checkbox" name="actif" id="actif" value="1" {{ old('actif', true) ? 'checked' : '' }}
                           style="width: 20px; height: 20px; accent-color: #2E7D32; cursor: pointer; margin-right: 1rem;">
                    <label for="actif" style="font-size: 0.95rem; font-weight: 500; color: #334155; cursor: pointer;">
                        Rôle actif
                    </label>
                </div>
            </div>

            <!-- Permissions -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
                <h2 style="font-size: 1.2rem; font-weight: 700; color: #2E7D32; margin: 0 0 1.5rem 0;">Permissions</h2>

                @php
                    $permissionsByGroup = $permissions->groupBy('groupe');
                @endphp

                @foreach($permissionsByGroup as $groupe => $groupPermissions)
                    <div style="margin-bottom: 1.5rem;">
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 0.8rem 0;">
                            {{ ucfirst($groupe) }}
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                            @foreach($groupPermissions as $permission)
                                <label style="display: flex; align-items: center; padding: 0.7rem; background: #f8fafc; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                                       onmouseover="this.style.background='#f0fdf4'"
                                       onmouseout="this.style.background='#f8fafc'">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                           style="width: 18px; height: 18px; accent-color: #2E7D32; margin-right: 0.8rem; cursor: pointer;">
                                    <span style="font-size: 0.9rem; color: #334155;">{{ $permission->label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('permissions') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Boutons -->
        <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('admin.roles.index') }}" 
               style="padding: 0.9rem 1.8rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 600; text-decoration: none;">
                Annuler
            </a>
            <button type="submit" 
                    style="padding: 0.9rem 2rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
                💾 Créer le rôle
            </button>
        </div>
    </form>
</div>
@endsection