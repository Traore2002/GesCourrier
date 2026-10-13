@extends('layouts.app')

@section('title', 'Nouveau Courrier - SOSUCO')

@section('content')
<div style="background: #f1f5f9; min-height: calc(100vh - 100px); padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 0;">Nouveau Courrier</h1>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.3rem;">Enregistrez un nouveau courrier dans le système</p>
        </div>
        <a href="{{ route('courriers.index') }}" style="color: #64748b; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour à la liste
        </a>
    </div>

    <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data" id="courrierForm">
        @csrf
        
        @if ($errors->any())
            <div style="background: #fee2e2; border: 2px solid #fca5a5; color: #b91c1c; padding: 1.2rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <strong>⚠️ Des erreurs empêchent l'enregistrement :</strong>
                <ul style="margin: 0; padding-left: 1.8rem;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
            <!-- COLONNE GAUCHE -->
            <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); height: fit-content;">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.2rem;">
                    {{ request('type') ? 'Type : ' . ucfirst(request('type')) : 'Choisir le type de courrier' }}
                </h2>
                
                @php
                    $userRole = Auth::user()->role;
                    $canCreateArrivee = in_array($userRole, ['standardiste', 'administrateur']);
                    $forcedType = request('type') ? strtolower(str_replace(['é', 'è', 'ê'], 'e', request('type'))) : null;
                @endphp

                <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                    @forelse($typesCourrier as $typeCourrier)
                        @php
                            $typeName = strtolower(str_replace(['é', 'è', 'ê'], 'e', $typeCourrier->nom));
                            if ($forcedType && $forcedType !== $typeName) { continue; }
                            $isInterne = ($typeName === 'interne');
                            $typeColor = $isInterne ? ['#F57C00', '#FFF3E0'] : ['#e2e8f0', 'white'];
                            $isDisabled = ($typeName === 'arrivee' && !$canCreateArrivee);
                        @endphp
                        
                        @if(!$isDisabled)
                            <div>
                                <label style="display: flex; align-items: center; padding: 1rem; border: 2px solid {{ $typeColor[0] }}; border-radius: 10px; cursor: pointer; background: {{ $typeColor[1] }};">
                                    <input type="radio" name="type" value="{{ $typeCourrier->nom }}" required
                                           {{ ($forcedType === $typeName || old('type') === $typeCourrier->nom) ? 'checked' : '' }}
                                           style="width: 20px; height: 20px; margin-right: 0.8rem; accent-color: #F57C00;" onchange="changerFormulaire()">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; color: #1e293b;">{{ ucfirst($typeCourrier->nom) }}</div>
                                    </div>
                                </label>
                                @if($isInterne)
                                    <div id="interne-sub-options" style="display: {{ ($forcedType === 'interne' || old('type') === 'interne') ? 'block' : 'none' }}; padding-left: 1rem; margin-top: 0.5rem; border-left: 3px solid #F57C00;">
                                        <label style="display: flex; align-items: center; padding: 0.5rem; cursor: pointer;">
                                            <input type="radio" name="sous_type" value="initie" {{ old('sous_type', 'initie') === 'initie' ? 'checked' : '' }} style="margin-right: 0.5rem;" onchange="changerFormulaire()">
                                            <span style="font-weight: 600; color: #2E7D32;">Interne Initié</span>
                                        </label>
                                        <label style="display: flex; align-items: center; padding: 0.5rem; cursor: pointer;">
                                            <input type="radio" name="sous_type" value="transit" {{ old('sous_type') === 'transit' ? 'checked' : '' }} style="margin-right: 0.5rem;" onchange="changerFormulaire()">
                                            <span style="font-weight: 600; color: #1976D2;">Interne Transit</span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @empty
                        <p style="color: #ef4444;">Aucun type actif.</p>
                    @endforelse
                </div>
            </div>

            <!-- COLONNE DROITE -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                {{-- ✅ BANNIÈRE DE LIEN SI ON CRÉE UNE RÉPONSE --}}
                @if(isset($lieA) && $lieA)
                    <input type="hidden" name="courrier_arrive_lie_id" value="{{ $lieA }}">
                    <div style="background: #F0FDF4; border: 2px solid #4CAF50; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 1rem;">
                        <span style="font-size: 1.5rem;">🔗</span>
                        <div>
                            <div style="font-weight: 700; color: #166534; font-size: 1rem;">Ce courrier est une réponse</div>
                            <div style="color: #15803d; font-size: 0.9rem;">Lié au courrier arrivé N° <strong>{{ $lieA }}</strong></div>
                        </div>
                    </div>
                @endif

                @php
                    $currentType = strtolower(str_replace(['é', 'è', 'ê'], 'e', request('type', '')));
                    $oldType = old('type') ? strtolower(str_replace(['é', 'è', 'ê'], 'e', old('type'))) : '';
                    $showArrivee = ($currentType === 'arrivee' || $oldType === 'arrivee');
                    $showDepart = ($currentType === 'depart' || $oldType === 'depart');
                    $showInitie = ($currentType === 'interne' && (request('sous_type') === 'initie' || old('sous_type', 'initie') === 'initie'));
                    $showTransit = ($currentType === 'interne' && request('sous_type') === 'transit');
                @endphp

                <!-- Informations générales -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Informations générales</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="grid-column: 1 / -1;">
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Objet <span style="color: red;">*</span></label>
                            <input type="text" name="objet" value="{{ old('objet') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Référence <span style="color: red;">*</span></label>
                            <input type="text" name="reference" value="{{ old('reference') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <!-- Section ARRIVÉE -->
                <div id="sectionArrivee" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: {{ $showArrivee ? 'block' : 'none' }};">
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #2E7D32; margin-bottom: 1rem; border-bottom: 2px solid #E8F5E9; padding-bottom: 0.5rem;">📥 Détails Courrier Arrivée</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; background: #F0FDF4; padding: 1rem; border-radius: 8px; border: 1px solid #BBF7D0;">
                        <div>
                            <label style="font-weight: 600; color: #166534; display: block; margin-bottom: 0.3rem;">📅 Date d'arrivée</label>
                            <input type="date" name="date_arrivee" value="{{ date('Y-m-d') }}" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9; cursor: not-allowed; color: #64748b;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #166534; display: block; margin-bottom: 0.3rem;">🕒 Heure d'arrivée</label>
                            <input type="time" name="heure_arrivee" value="{{ date('H:i') }}" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9; cursor: not-allowed; color: #64748b;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">👤 Expéditeur (Externe) <span style="color: red;">*</span></label>
                            <input type="text" name="expediteur_nom" value="{{ old('expediteur_nom') }}" placeholder="Nom société/personne" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">🏢 Département Destinataire <span style="color: red;">*</span></label>
                            <select name="destinataire_dept_id" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}" {{ old('destinataire_dept_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">📆 Date du courrier (Expéditeur) <span style="color: red;">*</span></label>
                            <input type="date" name="date_courrier_expediteur" value="{{ old('date_courrier_expediteur') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">📄 Type du document <span style="color: red;">*</span></label>
                            <select name="type_document" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="">-- Sélectionner le type --</option>
                                <option value="lettre" {{ old('type_document') == 'lettre' ? 'selected' : '' }}>Lettre</option>
                                <option value="facture" {{ old('type_document') == 'facture' ? 'selected' : '' }}>Facture</option>
                                <option value="rapport" {{ old('type_document') == 'rapport' ? 'selected' : '' }}>Rapport</option>
                                <option value="note" {{ old('type_document') == 'note' ? 'selected' : '' }}>Note de service</option>
                                <option value="commande" {{ old('type_document') == 'commande' ? 'selected' : '' }}>Bon de commande</option>
                                <option value="contrat" {{ old('type_document') == 'contrat' ? 'selected' : '' }}>Contrat</option>
                                <option value="autre" {{ old('type_document') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>
                    </div>
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #475569; margin: 1.5rem 0 0.8rem 0; border-top: 1px dashed #e2e8f0; padding-top: 1rem;">🎯 Qualification du courrier</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">📎 Pièces jointes</label>
                            <input type="number" name="nombre_pieces_jointes" value="{{ old('nombre_pieces_jointes', 1) }}" min="1" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">❓ Nécessite réponse ?</label>
                            <div style="display: flex; gap: 0.5rem; margin-top: 0.3rem;">
                                <label style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; background: {{ old('necessite_reponse') ? '#F0FDF4' : '#f8fafc' }};">
                                    <input type="radio" name="necessite_reponse" value="1" {{ old('necessite_reponse') ? 'checked' : '' }} style="margin-right: 0.4rem; accent-color: #2E7D32;">
                                    <span style="font-weight: 600; color: #2E7D32;">Oui</span>
                                </label>
                                <label style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; background: {{ !old('necessite_reponse') ? '#FEF2F2' : '#f8fafc' }};">
                                    <input type="radio" name="necessite_reponse" value="0" {{ old('necessite_reponse', '0') == '0' ? 'checked' : '' }} style="margin-right: 0.4rem; accent-color: #DC2626;">
                                    <span style="font-weight: 600; color: #DC2626;">Non</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;"> Priorité</label>
                            <div style="display: flex; gap: 0.5rem; margin-top: 0.3rem;">
                                <label style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; background: {{ old('priorite', 'normal') == 'normal' ? '#EFF6FF' : '#f8fafc' }};">
                                    <input type="radio" name="priorite" value="normal" {{ old('priorite', 'normal') == 'normal' ? 'checked' : '' }} style="margin-right: 0.4rem; accent-color: #1976D2;">
                                    <span style="font-weight: 600; color: #1976D2;">Normal</span>
                                </label>
                                <label style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; background: {{ old('priorite') == 'urgent' ? '#FEF2F2' : '#f8fafc' }};">
                                    <input type="radio" name="priorite" value="urgent" {{ old('priorite') == 'urgent' ? 'checked' : '' }} style="margin-right: 0.4rem; accent-color: #DC2626;">
                                    <span style="font-weight: 600; color: #DC2626;">Urgent</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section DÉPART -->
                <div id="sectionDepart" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: {{ $showDepart ? 'block' : 'none' }};">
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #1976D2; margin-bottom: 1rem; border-bottom: 2px solid #E3F2FD; padding-bottom: 0.5rem;">📤 Détails Courrier Départ</h2>
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #475569; margin: 1rem 0 0.8rem 0;">1. Destinataire & Signataire</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div style="grid-column: 1 / -1;">
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Nom / Fonction du destinataire <span style="color: red;">*</span></label>
                            <input type="text" name="destinataire_nom_fonction" value="{{ old('destinataire_nom_fonction') }}" placeholder="Ex: M. Jean Dupont, DG" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Structure / Organisme <span style="color: red;">*</span></label>
                            <input type="text" name="destinataire_structure" value="{{ old('destinataire_structure') }}" placeholder="Ex: Direction Régionale" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Ville / Adresse</label>
                            <input type="text" name="destinataire_ville_adresse" value="{{ old('destinataire_ville_adresse') }}" placeholder="Ex: Ouagadougou" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Nom du signataire <span style="color: red;">*</span></label>
                            <input type="text" name="signataire_nom" value="{{ old('signataire_nom') }}" placeholder="Nom complet" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Fonction du signataire</label>
                            <input type="text" name="signataire_fonction" value="{{ old('signataire_fonction') }}" placeholder="Ex: Directeur Général" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #475569; margin: 1.5rem 0 0.8rem 0; border-top: 1px dashed #e2e8f0; padding-top: 1rem;">2. Transmission pour envoi</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">📅 Date de transmission</label>
                            <input type="date" name="date_transmission" value="{{ date('Y-m-d') }}" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9; cursor: not-allowed; color: #64748b;">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">⚡ Priorité d'envoi</label>
                            <select name="priorite_envoi" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="normal" {{ old('priorite_envoi', 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="urgent" {{ old('priorite_envoi') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div style="grid-column: 1 / -1; display: flex; align-items: center; padding: 0.8rem; background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 8px;">
                            <input type="hidden" name="transmis_standardiste" value="0">
                            <input type="checkbox" name="transmis_standardiste" id="transmis_standardiste" value="1" {{ old('transmis_standardiste') ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: #1976D2; margin-right: 0.8rem; cursor: pointer;">
                            <label for="transmis_standardiste" style="font-weight: 600; color: #0369A1; cursor: pointer; font-size: 0.9rem;">📬 Transmettre à la standardiste pour envoi</label>
                        </div>
                    </div>
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #475569; margin: 1.5rem 0 0.8rem 0; border-top: 1px dashed #e2e8f0; padding-top: 1rem;">3. Expédition physique</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Mode d'envoi effectif</label>
                            <select name="mode_envoi_effectif" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="">-- Sélectionner le mode --</option>
                                <option value="Poste simple" {{ old('mode_envoi_effectif') == 'Poste simple' ? 'selected' : '' }}>Poste simple</option>
                                <option value="Recommandé avec AR" {{ old('mode_envoi_effectif') == 'Recommandé avec AR' ? 'selected' : '' }}>Recommandé avec AR</option>
                                <option value="Coursier" {{ old('mode_envoi_effectif') == 'Coursier' ? 'selected' : '' }}>Coursier</option>
                                <option value="Remise en main propre" {{ old('mode_envoi_effectif') == 'Remise en main propre' ? 'selected' : '' }}>Remise en main propre</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Date d'envoi physique</label>
                            <input type="date" name="date_envoi_physique" value="{{ old('date_envoi_physique') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">N° de suivi / référence postale</label>
                            <input type="text" name="numero_suivi" value="{{ old('numero_suivi') }}" placeholder="Ex: RR123456789FR" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        </div>
                    </div>
                    <h3 style="font-size: 0.95rem; font-weight: 600; color: #475569; margin: 1.5rem 0 0.8rem 0; border-top: 1px dashed #e2e8f0; padding-top: 1rem;">4. Suivi post-envoi (Accusé de réception)</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Accusé de réception reçu ?</label>
                            <div style="display: flex; gap: 0.5rem; margin-top: 0.3rem;">
                                <label style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; background: {{ old('ar_recu') ? '#F0FDF4' : '#f8fafc' }};">
                                    <input type="radio" name="ar_recu" value="1" {{ old('ar_recu') ? 'checked' : '' }} style="margin-right: 0.4rem; accent-color: #2E7D32;">
                                    <span style="font-weight: 600; color: #2E7D32;">Oui</span>
                                </label>
                                <label style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; background: {{ !old('ar_recu') ? '#FEF2F2' : '#f8fafc' }};">
                                    <input type="radio" name="ar_recu" value="0" {{ old('ar_recu', '0') == '0' ? 'checked' : '' }} style="margin-right: 0.4rem; accent-color: #DC2626;">
                                    <span style="font-weight: 600; color: #DC2626;">Non</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Date de réception de l'AR</label>
                            <input type="date" name="date_reception_ar" value="{{ old('date_reception_ar') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Scan de l'Accusé de Réception</label>
                            <input type="file" name="fichier_ar" accept=".pdf,.jpg,.jpeg,.png" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        </div>
                    </div>
                </div>

                <!-- Section INTERNE INITIÉ -->
                <div id="sectionInterneInitie" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: {{ $showInitie ? 'block' : 'none' }};">
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #2E7D32; margin-bottom: 1rem;">️ Détails Interne Initié</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Date/Heure Enregistrement</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="date" name="date_enregistrement" value="{{ date('Y-m-d') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                                <input type="time" name="heure_enregistrement" value="{{ date('H:i') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                            </div>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Département Expéditeur</label>
                            <input type="text" value="{{ Auth::user()->departement->nom ?? 'Non défini' }}" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #E8F5E9; font-weight: 600;">
                            <input type="hidden" name="expediteur_dept_id" value="{{ Auth::user()->departement_id }}">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Département Destinataire <span style="color: red;">*</span></label>
                            <select name="destinataire_dept_id" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Date/Heure Envoi</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="date" name="date_envoi" value="{{ date('Y-m-d') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                                <input type="time" name="heure_envoi" value="{{ date('H:i') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section INTERNE TRANSIT -->
                <div id="sectionInterneTransit" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: {{ $showTransit ? 'block' : 'none' }};">
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #1976D2; margin-bottom: 1rem;">🚚 Détails Interne Transit</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Date/Heure Validation</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="date" name="date_validation" value="{{ date('Y-m-d') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                                <input type="time" name="heure_validation" value="{{ date('H:i') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                            </div>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Département Expéditeur</label>
                            <input type="text" value="{{ Auth::user()->departement->nom ?? 'Non défini' }}" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #E3F2FD; font-weight: 600;">
                            <input type="hidden" name="expediteur_dept_id" value="{{ Auth::user()->departement_id }}">
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Département Destinataire <span style="color: red;">*</span></label>
                            <select name="destinataire_dept_id" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Date/Heure Réception</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="date" name="date_reception" value="{{ date('Y-m-d') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                                <input type="time" name="heure_reception" value="{{ date('H:i') }}" readonly style="flex: 1; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f1f5f9;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu et Document joint -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">📎 Contenu et Document</h2>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">📝 Contenu / Observations</label>
                        <textarea name="contenu" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; resize: vertical;">{{ old('contenu') }}</textarea>
                    </div>
                    <div>
                        <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">📁 Document joint <span style="color: red;">*</span></label>
                        @if(session('fichier_scanne_path'))
                            <input type="hidden" name="fichier_scanne_path" value="{{ session('fichier_scanne_path') }}">
                            <div style="padding: 1rem; border: 2px solid #4CAF50; border-radius: 10px; background: #F0FDF4; display: flex; align-items: center; gap: 1rem;">
                                <span style="font-weight: 700; color: #166534;">✅ Document numérisé avec succès !</span>
                            </div>
                        @else
                            <input type="file" name="fichier_scanne" id="fichier_scanne" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" onchange="afficherApercu(this)">
                            <label for="fichier_scanne" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; border: 2px dashed #cbd5e1; border-radius: 10px; cursor: pointer; background: #f8fafc; transition: all 0.2s;" 
                                   onmouseover="this.style.borderColor='#4CAF50'; this.style.background='#F0FDF4'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" style="margin-bottom: 0.5rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <span style="font-weight: 600; color: #1e293b;">Cliquez ici pour sélectionner un fichier</span>
                                <span id="file-name" style="font-size: 0.85rem; color: #2E7D32; font-weight: 600; margin-top: 0.5rem;"></span>
                                <span style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.3rem;">(PDF, JPG ou PNG)</span>
                            </label>
                            <div id="pdf-preview-container" style="display: none; margin-top: 1.5rem; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                                <div style="background: #f1f5f9; padding: 0.8rem 1rem; font-weight: 600; color: #475569; font-size: 0.9rem; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 0.5rem;">
                                    👁️ Aperçu du document
                                </div>
                                <iframe id="pdf-preview" style="width: 100%; height: 350px; border: none; background: white;"></iframe>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Boutons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="{{ route('courriers.index') }}" style="padding: 1rem 2rem; border: 2px solid #e2e8f0; background: white; color: #64748b; border-radius: 12px; font-weight: 600; text-decoration: none;">Annuler</a>
                    <button type="submit" formaction="{{ route('courriers.store') }}" style="padding: 1rem 2rem; background: #64748b; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">Enregistrer</button>
                    <button type="submit" formaction="{{ route('courriers.storeAndSend') }}" style="padding: 1rem 2rem; background: #2E7D32; color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">Enregistrer et Envoyer</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function changerFormulaire() {
    ['sectionArrivee', 'sectionDepart', 'sectionInterneInitie', 'sectionInterneTransit'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
    const subOptionsDiv = document.getElementById('interne-sub-options');
    if (subOptionsDiv) subOptionsDiv.style.display = 'none';
    
    const typeRadio = document.querySelector('input[name="type"]:checked');
    if (!typeRadio) return;
    
    const typeValue = typeRadio.value.toLowerCase().replace(/[éèê]/g, 'e');
    
    if (typeValue === 'arrivee') {
        const el = document.getElementById('sectionArrivee');
        if (el) el.style.display = 'block';
    } else if (typeValue === 'depart') {
        const el = document.getElementById('sectionDepart');
        if (el) el.style.display = 'block';
    } else if (typeValue === 'interne') {
        const subEl = document.getElementById('interne-sub-options');
        if (subEl) subEl.style.display = 'block';
        const checkedSousType = document.querySelector('input[name="sous_type"]:checked');
        if (!checkedSousType) {
            const defaultSub = document.querySelector('input[name="sous_type"][value="initie"]');
            if (defaultSub) defaultSub.checked = true;
        }
        const finalSousType = document.querySelector('input[name="sous_type"]:checked');
        if (finalSousType && finalSousType.value === 'transit') {
            const el = document.getElementById('sectionInterneTransit');
            if (el) el.style.display = 'block';
        } else {
            const el = document.getElementById('sectionInterneInitie');
            if (el) el.style.display = 'block';
        }
    }
}

function afficherApercu(input) {
    const file = input.files[0];
    const fileNameSpan = document.getElementById('file-name');
    const previewContainer = document.getElementById('pdf-preview-container');
    const previewFrame = document.getElementById('pdf-preview');
    if (file) {
        fileNameSpan.textContent = "📄 " + file.name;
        if (file.type === 'application/pdf' || file.type.startsWith('image/')) {
            previewFrame.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
            setTimeout(() => previewContainer.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
        } else {
            previewContainer.style.display = 'none';
            previewFrame.src = '';
            alert("⚠️ Format non supporté. Veuillez choisir un fichier PDF, JPG ou PNG.");
            input.value = '';
            fileNameSpan.textContent = '';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const typeFromUrl = urlParams.get('type');
    const lieA = urlParams.get('lie_a'); // ✅ Récupère le paramètre lie_a
    
    if (typeFromUrl || lieA) {
        // Si lie_a est présent, on force le type à 'depart'
        const finalType = lieA ? 'depart' : typeFromUrl;
        const normalizedUrlType = finalType.toLowerCase().replace(/[éèê]/g, 'e');
        
        document.querySelectorAll('input[name="type"]').forEach(radio => {
            if (radio.value.toLowerCase().replace(/[éèê]/g, 'e') === normalizedUrlType) {
                radio.checked = true;
            }
        });
    }
    changerFormulaire();
});
</script>
@endsection