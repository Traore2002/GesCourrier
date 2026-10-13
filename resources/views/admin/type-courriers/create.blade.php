@extends('layouts.app')

@section('title', 'Créer un Type de Courrier - SOSUCO')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête -->
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <a href="{{ route('admin.type-courriers.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 500; padding: 0.5rem 1rem; background: white; border-radius: 8px; border: 1px solid #e2e8f0;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour
        </a>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">Créer un Type de Courrier</h1>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
        
        <!-- Formulaire de création (Gauche) -->
        <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
            <form action="{{ route('admin.type-courriers.store') }}" method="POST">
                @csrf

                <!-- Nom du type -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="nom" style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Nom du type <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                           style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none;"
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                           placeholder="Ex: Arrivée, Départ, Urgent, Interne...">
                    @error('nom') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ CORRECTION : Préfixe (avec un 'e' à la fin) -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="prefixe" style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Préfixe <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="prefixe" id="prefixe" value="{{ old('prefixe') }}" required
                           style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none; text-transform: uppercase;"
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'; this.value = this.value.toUpperCase()"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'; this.value = this.value.toUpperCase()"
                           placeholder="Ex: ARR, DEP, URG, INT..."
                           maxlength="5">
                    <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.4rem;">
                        Ce préfixe sera utilisé pour générer les numéros de courrier (ex: <strong>ARR</strong>-2026-001)
                    </p>
                    @error('prefixe') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="description" style="display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              style="width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 3px rgba(76, 175, 80, 0.1)'"
                              onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                              placeholder="Description optionnelle du type de courrier...">{{ old('description') }}</textarea>
                    @error('description') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.4rem;">{{ $message }}</p> @enderror
                </div>

                <!-- Statut Actif -->
                <div style="margin-bottom: 2rem; display: flex; align-items: center; padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <input type="hidden" name="actif" value="0">
                    <input type="checkbox" name="actif" id="actif" value="1" {{ old('actif', true) ? 'checked' : '' }}
                           style="width: 20px; height: 20px; accent-color: #2E7D32; cursor: pointer; margin-right: 1rem;">
                    <label for="actif" style="font-size: 0.95rem; font-weight: 500; color: #334155; cursor: pointer;">
                        Type actif (visible dans l'application)
                    </label>
                </div>

                <!-- Boutons -->
                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <a href="{{ route('admin.type-courriers.index') }}" 
                       style="padding: 0.9rem 1.8rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 600; text-decoration: none;">
                        Annuler
                    </a>
                    <button type="submit" 
                            style="padding: 0.9rem 2rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
                        💾 Créer le type
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des types existants (Droite) -->
        <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #2E7D32; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Types existants
            </h3>
            <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 1rem;">
                Évitez les doublons en vérifiant cette liste
            </p>

            @if($existingTypes->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                    @foreach($existingTypes as $type)
                        <div style="padding: 0.9rem; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #1e293b; font-size: 0.95rem;">
                                    {{ ucfirst($type->nom) }}
                                </div>
                                @if($type->description)
                                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.2rem;">
                                        {{ Str::limit($type->description, 40) }}
                                    </div>
                                @endif
                            </div>
                            <!-- ✅ CORRECTION : Affichage du préfixe avec un 'e' -->
                            <span style="display: inline-flex; padding: 0.3rem 0.7rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border-radius: 6px; font-weight: 700; font-size: 0.85rem; letter-spacing: 0.5px; margin-left: 0.8rem;">
                                {{ strtoupper($type->prefixe) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem 1rem; color: #94a3b8;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 0.5rem; opacity: 0.5;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <p style="font-size: 0.9rem;">Aucun type défini</p>
                    <p style="font-size: 0.8rem; margin-top: 0.3rem;">Vous créez le premier !</p>
                </div>
            @endif

            <!-- Information importante -->
            <div style="margin-top: 1.5rem; padding: 1rem; background: #FFF3E0; border-left: 4px solid #F57C00; border-radius: 8px;">
                <p style="color: #E65100; margin: 0; font-size: 0.85rem;">
                    <strong>⚠️ Important :</strong> Le préfixe doit être unique. Il sera utilisé pour générer automatiquement les numéros de courrier.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection