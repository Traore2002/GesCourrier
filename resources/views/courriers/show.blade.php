@extends('layouts.app')

@section('title', 'Détails du Courrier - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <!-- Header avec retour et actions -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <a href="{{ route('courriers.index', request()->query()) }}" 
               style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 600; transition: color 0.2s;" 
               onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#64748b'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour à la liste
            </a>
            
            <div style="display: flex; gap: 0.8rem;">
                <a href="{{ route('courriers.edit', $courrier) }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.2rem; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #475569; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.borderColor='#2E7D32'; this.style.color='#2E7D32'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#475569'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    Modifier
                </a>
                
                @if(Auth::check() && Auth::user()->hasPermission('supprimer_courrier'))
                <form action="{{ route('courriers.destroy', $courrier) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce courrier ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.2rem; background: white; border: 1px solid #fee2e2; border-radius: 10px; color: #ef4444; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#ef4444'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Supprimer
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Carte principale d'information -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 1.5rem;">
            
            <!-- En-tête de la carte avec badges -->
            <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 2rem; border-bottom: 1px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">N° {{ $courrier->numero_enregistrement }}</span>
                        </div>
                        <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0; line-height: 1.3;">{{ $courrier->objet }}</h1>
                    </div>
                    <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
                        @php
                            $typeColors = [
                                'arrivee' => ['bg' => '#E8F5E9', 'text' => '#2E7D32'],
                                'depart' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
                                'interne' => ['bg' => '#FFF3E0', 'text' => '#F57C00']
                            ];
                            $statutColors = [
                                'brouillon' => ['bg' => '#F1F5F9', 'text' => '#64748B'],
                                'en_attente_reception' => ['bg' => '#FFE0B2', 'text' => '#F57C00'],
                                'receptionne' => ['bg' => '#E3F2FD', 'text' => '#1976D2'],
                                'en_attente_decision' => ['bg' => '#FFF3E0', 'text' => '#F57C00'],
                                'traite' => ['bg' => '#E8F5E9', 'text' => '#2E7D32'],
                                'pris_en_charge' => ['bg' => '#E0F2FE', 'text' => '#0284C7'],
                                'transmis' => ['bg' => '#F3E8FF', 'text' => '#9333EA'],
                                'archive' => ['bg' => '#F5F5F5', 'text' => '#757575']
                            ];
                            $typeConfig = $typeColors[$courrier->type] ?? $typeColors['interne'];
                            $statutConfig = $statutColors[$courrier->statut] ?? $statutColors['brouillon'];
                            $typeLabels = ['arrivee' => 'Arrivée', 'depart' => 'Départ', 'interne' => 'Interne'];
                            $typeLabel = $typeLabels[$courrier->type] ?? ucfirst($courrier->type);
                            $statutLabels = [
                                'brouillon' => 'Brouillon',
                                'en_attente_reception' => 'En attente de réception',
                                'receptionne' => 'Réceptionné',
                                'en_attente_decision' => 'En attente de décision',
                                'traite' => 'Traité',
                                'pris_en_charge' => 'Pris en charge',
                                'transmis' => 'En transit',
                                'archive' => 'Archivé'
                            ];
                            $statutLabel = $statutLabels[$courrier->statut] ?? ucfirst(str_replace('_', ' ', $courrier->statut));
                        @endphp
                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: {{ $typeConfig['bg'] }}; color: {{ $typeConfig['text'] }}; border-radius: 24px; font-size: 0.9rem; font-weight: 700;">
                            {{ $typeLabel }}
                        </span>
                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: {{ $statutConfig['bg'] }}; color: {{ $statutConfig['text'] }}; border-radius: 24px; font-size: 0.9rem; font-weight: 700;">
                            <span style="width: 8px; height: 8px; background: {{ $statutConfig['text'] }}; border-radius: 50%;"></span>
                            {{ $statutLabel }}
                        </span>
                    </div>
                </div>
                
                <!-- Métadonnées rapides -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <div style="width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Date de création</div>
                            <div style="font-size: 0.95rem; color: #1e293b; font-weight: 600;">{{ $courrier->created_at->format('d M Y à H:i') }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <div style="width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l8-4 8 4v14M8 21v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4"></path></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Département destinataire</div>
                            <div style="font-size: 0.95rem; color: #1e293b; font-weight: 600;">{{ $courrier->departement->nom ?? 'Non assigné' }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <div style="width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Créé par</div>
                            <div style="font-size: 0.95rem; color: #1e293b; font-weight: 600;">{{ $courrier->user->prenom ?? 'Inconnu' }} {{ $courrier->user->nom ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu du courrier -->
            <div style="padding: 2rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    Contenu / Observations
                </h3>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; color: #475569; line-height: 1.7; font-size: 0.95rem; white-space: pre-wrap;">
                    {{ $courrier->contenu ?: 'Aucun contenu détaillé fourni pour ce courrier.' }}
                </div>
            </div>

            <!-- Détails Expéditeur / Destinataire -->
            @if($courrier->expediteur || $courrier->destinataire)
            <div style="padding: 0 2rem 2rem 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                @if($courrier->expediteur)
                <div style="background: #f8fafc; border-radius: 12px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 0.8rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path></svg>
                        Expéditeur
                    </h4>
                    <p style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0;">{{ $courrier->expediteur }}</p>
                </div>
                @endif
                @if($courrier->destinataire)
                <div style="background: #f8fafc; border-radius: 12px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 0.8rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="7 17 3 13 7 9"></polyline><path d="M21 13V15a4 4 0 0 1-4 4H3"></path></svg>
                        Destinataire
                    </h4>
                    <p style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0;">{{ $courrier->destinataire }}</p>
                </div>
                @endif
            </div>
            @endif

            <!-- Pièce jointe -->
            @if($courrier->fichier_scanne)
            <div style="padding: 0 2rem 2rem 2rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                    Pièce jointe
                </h3>
                <a href="{{ asset('storage/' . $courrier->fichier_scanne) }}" target="_blank" style="display: flex; align-items: center; gap: 1rem; padding: 1.2rem; background: #E8F5E9; border: 1px solid #A5D6A7; border-radius: 12px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#C8E6C9'; this.style.transform='translateX(4px)'" onmouseout="this.style.background='#E8F5E9'; this.style.transform='translateX(0)'">
                    <div style="width: 48px; height: 48px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">Document Scanné</div>
                        <div style="color: #64748b; font-size: 0.85rem; margin-top: 0.2rem;">Cliquez pour ouvrir ou télécharger</div>
                    </div>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </a>
            </div>
            @endif
        </div>

                {{-- ✅ BLOC : RETOUR DU DIRECTEUR (Visible par la secrétaire de ce département) --}}
        @if(in_array($courrier->statut, ['traite', 'rejete', 'a_modifier']) && Auth::user()->departement_id === $courrier->departement_id)
            @php
                $decisionColor = $courrier->statut === 'traite' ? '#10B981' : ($courrier->statut === 'rejete' ? '#EF4444' : '#F59E0B');
                $decisionBg = $courrier->statut === 'traite' ? '#ECFDF5' : ($courrier->statut === 'rejete' ? '#FEF2F2' : '#FFFBEB');
                $decisionLabel = $courrier->statut === 'traite' ? '✅ Validé / Approuvé' : ($courrier->statut === 'rejete' ? '❌ Rejeté' : '🔄 Modifications demandées');
            @endphp
            <div style="background: {{ $decisionBg }}; border: 2px solid {{ $decisionColor }}; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                <h4 style="font-weight: 700; color: {{ $decisionColor }}; margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    👔 Retour du Directeur : {{ $decisionLabel }}
                </h4>
                <p style="color: #475569; font-size: 0.95rem; margin: 0;">
                    Le directeur a rendu sa décision. Veuillez consulter la section <strong>"Contenu / Observations"</strong> ci-dessus pour lire ses directives détaillées.
                </p>
            </div>
        @endif 

        {{-- ==========================================
           ✨ BOUTONS D'ACTION WORKFLOW COMPLET
           ========================================== --}}
        <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 2rem; border-top: 3px solid #2E7D32;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">⚡ Actions disponibles</h3>
            
            <div style="display: flex; flex-wrap: wrap; gap: 0.8rem;">
                
                {{-- 📡 TRANSMETTRE AU DÉPARTEMENT (Standardiste / Admin) --}}
                @if($courrier->statut === 'enregistre' && Auth::user()->hasPermission('distribuer_courrier'))
                    <a href="{{ route('courriers.showTransmettreForm', $courrier) }}" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #1976D2 0%, #2196F3 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3); transition: all 0.2s;"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(25, 118, 210, 0.4)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(25, 118, 210, 0.3)'">
                        📡 Transmettre au département
                    </a>
                @endif

                {{-- 📥 RÉCEPTIONNER (Pour la secrétaire qui reçoit le courrier - Arrivée OU Interne) --}}
                @if(in_array($courrier->type, ['interne', 'arrivee']) && in_array($courrier->statut, ['en_attente_reception', 'transmis']) && Auth::user()->departement_id === $courrier->departement_id)
                    <form action="{{ route('courriers.receptionnerInterne', $courrier) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);"
                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            📥 Réceptionner (Noter date/heure)
                        </button>
                    </form>
                @endif

                {{-- 📤 ENVOYER AU DIRECTEUR (Secrétaire → Son propre directeur - Arrivée OU Interne) --}}
                @if(in_array($courrier->type, ['interne', 'arrivee']) && $courrier->statut === 'pris_en_charge' && Auth::user()->departement_id === $courrier->departement_id && Auth::user()->hasPermission('envoyer_courrier'))
                    <form action="{{ route('courriers.envoyerAuDirecteur', $courrier) }}" method="POST" style="display: inline;" onsubmit="return confirm('Confirmer l\'envoi de ce courrier à votre directeur ?');">
                        @csrf
                        <button type="submit" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);"
                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            📤 Envoyer au Directeur
                        </button>
                    </form>
                @endif

                {{-- 👔 ACTIONS DU DIRECTEUR (quand le courrier est en attente de décision) --}}
                @if($courrier->statut === 'en_attente_decision' && Auth::user()->hasPermission('traiter_courrier') && ($courrier->user_id === Auth::id() || Auth::user()->role === 'directeur' || Auth::user()->departement_id === $courrier->departement_id))
                    <div style="width: 100%; background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 12px; padding: 1rem; margin-bottom: 1rem;">
                        <h4 style="font-weight: 700; color: #92400E; margin: 0 0 0.5rem 0;">👔 Actions du Directeur</h4>
                        <p style="color: #78350F; font-size: 0.9rem; margin: 0;">Ce courrier attend votre décision ou directive.</p>
                    </div>

                    {{-- Formulaire de validation --}}
                    <form action="{{ route('courriers.valider', $courrier) }}" method="POST" style="width: 100%; background: white; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; border: 1px solid #e2e8f0;">
                        @csrf
                        <div style="margin-bottom: 1rem;">
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">Votre décision <span style="color: red;">*</span></label>
                            <select name="decision" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="">-- Choisir une décision --</option>
                                <option value="valide">✅ Valider / Approuver</option>
                                <option value="rejete">❌ Rejeter / Refuser</option>
                                <option value="modifie">🔄 Demander des modifications</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">Commentaire / Directive</label>
                            <textarea name="commentaire_directeur" rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;" placeholder="Ex: Approuvé, merci de procéder à l'envoi...">{{ old('commentaire_directeur') }}</textarea>
                        </div>
                        <button type="submit" style="width: 100%; padding: 0.8rem; background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            ✅ Enregistrer ma décision
                        </button>
                    </form>

                    {{-- Bouton: Transmettre à un autre département --}}
                    <a href="{{ route('courriers.transmettreInterneForm', $courrier) }}" 
                       style="display: block; text-align: center; padding: 0.8rem; background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; margin-bottom: 0.5rem;">
                        🚚 Transmettre à un autre département
                    </a>

                    {{-- Bouton: Créer une réponse liée (si Arrivée) --}}
                    @if($courrier->type === 'arrivee')
                        <a href="{{ route('courriers.creerReponseLiee', $courrier) }}" 
                           style="display: block; text-align: center; padding: 0.8rem; background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                            ✍️ Créer une réponse liée
                        </a>
                    @endif
                @endif
                
                {{-- 🚚 TRANSMETTRE EN MODE TRANSIT (Pour la secrétaire ou le chef qui envoie à un autre service) --}}
                @if(in_array($courrier->type, ['interne', 'arrivee']) && $courrier->statut === 'pris_en_charge' && Auth::user()->departement_id === $courrier->departement_id)
                    <a href="{{ route('courriers.transmettreInterneForm', $courrier) }}"
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);"
                       onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        🚚 Transmettre (Mode Transit)
                    </a>
                @endif

                {{-- ✍️ CRÉER UNE RÉPONSE LIÉE (Uniquement pour Arrivée) --}}
                @if($courrier->type === 'arrivee' && in_array($courrier->statut, ['pris_en_charge', 'transmis', 'enregistre']) && $courrier->necessite_reponse)
                    <a href="{{ route('courriers.create', ['type' => 'depart', 'lie_a' => $courrier->id]) }}" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(245, 124, 0, 0.3); transition: all 0.2s;"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(245, 124, 0, 0.4)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(245, 124, 0, 0.3)'">
                        ✍️ Créer une réponse liée
                    </a>
                @endif

                                {{-- ✅ ACTIONS DE LA SECRÉTAIRE APRÈS DÉCISION DU DIRECTEUR --}}
                @if(in_array($courrier->statut, ['traite', 'rejete', 'a_modifier']) && Auth::user()->departement_id === $courrier->departement_id)
                    
                    {{-- Si c'est un courrier Arrivée et qu'il est validé, on peut créer la réponse officielle --}}
                    @if($courrier->type === 'arrivee' && $courrier->statut === 'traite')
                        <a href="{{ route('courriers.create', ['type' => 'depart', 'lie_a' => $courrier->id]) }}" 
                           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(245, 124, 0, 0.3);"
                           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            ✍️ Rédiger la réponse officielle
                        </a>
                    @endif

                    {{-- Si c'est un courrier Interne, on peut le transmettre à un autre service pour exécution --}}
                    @if($courrier->type === 'interne' && $courrier->statut === 'traite')
                        <a href="{{ route('courriers.transmettreInterneForm', $courrier) }}"
                           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);"
                           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            🚚 Transmettre pour exécution (Transit)
                        </a>
                    @endif

                    {{-- Bouton pour clôturer si le directeur a rejeté ou si le traitement est fini --}}
                    <form action="{{ route('courriers.classerSansReponse', $courrier) }}" method="POST" style="display: inline;" onsubmit="return confirm('🔒 Confirmer la clôture de ce courrier ?');">
                        @csrf
                        <input type="text" name="note_cloture" placeholder="Motif de clôture..." style="padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-right: 0.5rem; font-size: 0.9rem; width: 200px;">
                        <button type="submit" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">
                            🔒 Clôturer le dossier
                        </button>
                    </form>

                @endif
                
                {{-- 🔒 CLASSER SANS RÉPONSE --}}
                @if(in_array($courrier->statut, ['pris_en_charge', 'transmis', 'traite']) && Auth::user()->departement_id === $courrier->departement_id && Auth::user()->hasPermission('traiter_courrier'))
                    <form action="{{ route('courriers.classerSansReponse', $courrier) }}" method="POST" style="display: inline;" onsubmit="return confirm('🔒 Confirmer la clôture sans réponse de ce courrier ?');">
                        @csrf
                        <input type="text" name="note_cloture" placeholder="Note de clôture (optionnel)" style="padding: 0.7rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-right: 0.5rem; font-size: 0.9rem; width: 250px;">
                        <button type="submit" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); transition: all 0.2s;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(100, 116, 139, 0.4)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(100, 116, 139, 0.3)'">
                            🔒 Classer sans réponse
                        </button>
                    </form>
                @endif

            </div>

            {{-- 💡 Indicateur de statut actuel --}}
            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">Statut actuel :</span>
                <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 1rem; background: {{ $statutConfig['bg'] }}; color: {{ $statutConfig['text'] }}; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid {{ $statutConfig['text'] }}30;">
                    {{ $statutLabel }}
                </span>
            </div>
        </div>

    </div>
</div>
@endsection