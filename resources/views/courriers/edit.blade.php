@extends('layouts.app')

@section('title', 'Traitement du Courrier - SOSUCO')

@section('content')
<div style="background: #f8fafc; min-height: calc(100vh - 100px); padding: 2rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Header avec retour -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <a href="{{ url()->previous() }}" style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#64748b'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour aux détails
            </a>
        </div>

        <!-- Carte principale -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden;">
            
            <!-- En-tête de la carte -->
            <div style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); padding: 2rem; color: white;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </div>
                    <div>
                        <h1 style="font-size: 1.8rem; font-weight: 800; margin: 0; letter-spacing: -0.5px;">Traitement du Courrier</h1>
                        <p style="margin: 0.3rem 0 0 0; opacity: 0.9; font-size: 0.95rem;">Mettez à jour les informations et le statut</p>
                    </div>
                </div>
                
                <!-- Info du courrier -->
                <div style="background: rgba(255,255,255,0.15); border-radius: 12px; padding: 1.2rem; margin-top: 1.5rem; backdrop-filter: blur(10px);">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 0.3rem;">Référence actuelle</div>
                            <div style="font-weight: 700; font-size: 1.1rem;">{{ $courrier->reference ?? 'Non définie' }}</div>
                        </div>
                        <div style="width: 2px; height: 40px; background: rgba(255,255,255,0.3);"></div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 0.3rem;">Objet</div>
                            <div style="font-weight: 600; font-size: 1.05rem;">{{ $courrier->objet }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('courriers.update', $courrier) }}" method="POST" style="padding: 2.5rem;">
                @csrf
                @method('PUT')

                <!-- ✅ NOUVEAU : Objet (Obligatoire) -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; font-weight: 700; color: #1e293b; margin-bottom: 0.8rem; font-size: 0.95rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.5rem;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        Objet du courrier <span style="color: #ef4444; margin-left: 0.2rem;">*</span>
                    </label>
                    <input type="text" name="objet" value="{{ old('objet', $courrier->objet) }}" required 
                           style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; background: white; outline: none; transition: all 0.3s;" 
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 4px rgba(76, 175, 80, 0.1)'" 
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    @error('objet') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ NOUVEAU : Référence (Obligatoire) -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; font-weight: 700; color: #1e293b; margin-bottom: 0.8rem; font-size: 0.95rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.5rem;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        Référence du courrier <span style="color: #ef4444; margin-left: 0.2rem;">*</span>
                    </label>
                    <input type="text" name="reference" value="{{ old('reference', $courrier->reference) }}" required 
                           placeholder="Ex: N° 2024/001, LETTRE-RH-05"
                           style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; background: white; outline: none; transition: all 0.3s;" 
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 4px rgba(76, 175, 80, 0.1)'" 
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    @error('reference') <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p> @enderror
                </div>

                <!-- Destinataire final -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; font-weight: 700; color: #1e293b; margin-bottom: 0.8rem; font-size: 0.95rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.5rem;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Destinataire final <span style="color: #94a3b8; font-weight: 400; margin-left: 0.3rem;">(si modification nécessaire)</span>
                    </label>
                    <input type="text" name="destinataire" value="{{ old('destinataire', $courrier->destinataire ?? '') }}" placeholder="Non spécifié" 
                           style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.3s;" 
                           onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 4px rgba(76, 175, 80, 0.1)'" 
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>

                <!-- Contenu / Observations (Correspond au champ 'contenu' du contrôleur) -->
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: flex; align-items: center; font-weight: 700; color: #1e293b; margin-bottom: 0.8rem; font-size: 0.95rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" style="margin-right: 0.5rem;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        Contenu / Compte-rendu de traitement
                    </label>
                    <textarea name="contenu" rows="5" placeholder="Ajoutez des détails sur le traitement effectué..." 
                              style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; resize: vertical; transition: all 0.3s;" 
                              onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 4px rgba(76, 175, 80, 0.1)'" 
                              onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">{{ old('contenu', $courrier->contenu ?? '') }}</textarea>
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1.5rem; border-top: 2px solid #f1f5f9;">
                    <a href="{{ url()->previous() }}" style="padding: 1rem 2rem; border: 2px solid #e2e8f0; background: white; color: #64748b; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'; this.style.color='#475569'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                        Annuler
                    </a>
                    <button type="submit" style="padding: 1rem 2.5rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 16px rgba(46, 125, 50, 0.3); transition: all 0.2s; display: flex; align-items: center; gap: 0.6rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(46, 125, 50, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(46, 125, 50, 0.3)'">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        Mettre à jour le courrier
                    </button>
                </div>
            </form>
        </div>

        <!-- Info complémentaire -->
        <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 16px; padding: 1.5rem; margin-top: 1.5rem; display: flex; gap: 1rem; align-items: start;">
            <div style="width: 40px; height: 40px; background: #2E7D32; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            </div>
            <div>
                <h3 style="color: #166534; font-weight: 700; margin: 0 0 0.5rem 0; font-size: 1rem;">Information importante</h3>
                <p style="color: #166534; font-size: 0.9rem; margin: 0; line-height: 1.6;">
                    La mise à jour sera enregistrée dans l'historique du courrier. Assurez-vous que la référence et l'objet sont corrects avant de valider.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection