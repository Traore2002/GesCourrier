@extends('layouts.app')

@section('title', 'Recherche - SN-SOSUCO')

@section('content')
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: calc(100vh - 100px); padding: 2rem;">
    
    <!-- Header -->
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="width: 90px; height: 90px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
            </div>
            <h1 style="font-size: 2.4rem; font-weight: 700; color: white; margin: 0; text-shadow: 0 2px 8px rgba(0,0,0,0.2); letter-spacing: -0.5px;">Recherche de courriers</h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.05rem; margin-top: 0.8rem; font-weight: 400;">Trouvez rapidement vos courriers par numéro, objet ou date</p>
        </div>

        <!-- Barre de recherche principale -->
        <div style="background: white; border-radius: 24px; padding: 2.5rem; box-shadow: 0 12px 40px rgba(0,0,0,0.15); margin-bottom: 2.5rem;">
            <div style="position: relative; margin-bottom: 2rem;">
                <svg style="position: absolute; left: 1.8rem; top: 50%; transform: translateY(-50%); width: 26px; height: 26px; stroke: #94a3b8;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                <input type="text" id="searchInput" placeholder="Rechercher par numéro d'enregistrement, objet, expéditeur..." style="width: 100%; padding: 1.3rem 1.8rem 1.3rem 4.5rem; border: 2px solid #e2e8f0; border-radius: 16px; font-size: 1.05rem; outline: none; transition: all 0.3s; font-weight: 500;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 5px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
            </div>

            <!-- Filtres avancés -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #334155; margin-bottom: 0.7rem; font-size: 0.95rem; letter-spacing: 0.3px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#667eea" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.6rem;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        Type de courrier
                    </label>
                    <select id="filterType" style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; background: white; outline: none; cursor: pointer; font-weight: 500; transition: all 0.3s;" onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 4px rgba(102, 126, 234, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        <option value="">Tous les types</option>
                        <option value="arrivee">Arrivée</option>
                        <option value="depart">Départ</option>
                        <option value="interne">Interne</option>
                    </select>
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #334155; margin-bottom: 0.7rem; font-size: 0.95rem; letter-spacing: 0.3px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.6rem;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Statut
                    </label>
                    <select id="filterStatut" style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; background: white; outline: none; cursor: pointer; font-weight: 500; transition: all 0.3s;" onfocus="this.style.borderColor='#4CAF50'; this.style.boxShadow='0 0 0 4px rgba(76, 175, 80, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        <option value="">Tous les statuts</option>
                        <option value="en_cours">En cours</option>
                        <option value="traite">Traité</option>
                        <option value="archive">Archivé</option>
                    </select>
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #334155; margin-bottom: 0.7rem; font-size: 0.95rem; letter-spacing: 0.3px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#F57C00" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.6rem;"><path d="M3 21h18M5 21V7l8-4 8 4v14M8 21v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4"></path></svg>
                        Département
                    </label>
                    <select id="filterDept" style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; background: white; outline: none; cursor: pointer; font-weight: 500; transition: all 0.3s;" onfocus="this.style.borderColor='#F57C00'; this.style.boxShadow='0 0 0 4px rgba(245, 124, 0, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        <option value="">Tous les départements</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: flex; align-items: center; font-weight: 600; color: #334155; margin-bottom: 0.7rem; font-size: 0.95rem; letter-spacing: 0.3px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1976D2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.6rem;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        Date de
                    </label>
                    <input type="date" id="filterDateFrom" style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; outline: none; font-weight: 500; transition: all 0.3s;" onfocus="this.style.borderColor='#1976D2'; this.style.boxShadow='0 0 0 4px rgba(25, 118, 210, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>
            </div>

            <div style="display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;">
                <button onclick="resetFilters()" style="padding: 1rem 2.2rem; border: 2px solid #e2e8f0; background: white; color: #64748b; border-radius: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 0.7rem; font-size: 0.95rem; letter-spacing: 0.3px;" onmouseover="this.style.borderColor='#94a3b8'; this.style.color='#475569'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                    Réinitialiser
                </button>
                <button onclick="performSearch()" style="padding: 1rem 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 14px; font-weight: 600; cursor: pointer; box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35); transition: all 0.3s; display: flex; align-items: center; gap: 0.7rem; font-size: 0.95rem; letter-spacing: 0.3px;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 30px rgba(102, 126, 234, 0.45)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.35)'">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                    Rechercher
                </button>
            </div>
        </div>

        <!-- Résultats de recherche -->
        <div id="searchResults" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.2); letter-spacing: -0.3px;">Résultats de la recherche</h2>
                <span id="resultCount" style="background: rgba(255,255,255,0.25); color: white; padding: 0.7rem 1.5rem; border-radius: 24px; font-weight: 600; font-size: 1rem; backdrop-filter: blur(10px); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">0 résultat(s)</span>
            </div>

            <div id="resultsList" style="display: flex; flex-direction: column; gap: 1.2rem;">
                <!-- Les résultats seront injectés ici par JavaScript -->
            </div>
        </div>

        <!-- Message aucun résultat -->
        <div id="noResults" style="display: none; background: white; border-radius: 20px; padding: 4rem 2rem; text-align: center; box-shadow: 0 12px 40px rgba(0,0,0,0.1);">
            <div style="width: 90px; height: 90px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
            </div>
            <p style="color: #334155; font-size: 1.3rem; font-weight: 700; margin: 0 0 0.8rem 0; letter-spacing: -0.3px;">Aucun courrier trouvé</p>
            <p style="color: #94a3b8; font-size: 1rem; margin: 0; font-weight: 400;">Essayez de modifier vos critères de recherche</p>
        </div>
    </div>
</div>

<script>
// Données des courriers
const courriersData = @json($courriers ?? []);

function performSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const filterType = document.getElementById('filterType').value;
    const filterStatut = document.getElementById('filterStatut').value;
    const filterDept = document.getElementById('filterDept').value;
    const filterDateFrom = document.getElementById('filterDateFrom').value;

    let filtered = courriersData.filter(courrier => {
        const matchSearch = !searchTerm || 
            courrier.numero_enregistrement.toLowerCase().includes(searchTerm) ||
            courrier.objet.toLowerCase().includes(searchTerm) ||
            (courrier.expediteur && courrier.expediteur.toLowerCase().includes(searchTerm));
        
        const matchType = !filterType || courrier.type === filterType;
        const matchStatut = !filterStatut || courrier.statut === filterStatut;
        const matchDept = !filterDept || courrier.departement_id == filterDept;
        const matchDate = !filterDateFrom || new Date(courrier.created_at) >= new Date(filterDateFrom);

        return matchSearch && matchType && matchStatut && matchDept && matchDate;
    });

    displayResults(filtered);
}

function displayResults(results) {
    const resultsDiv = document.getElementById('searchResults');
    const resultsList = document.getElementById('resultsList');
    const noResults = document.getElementById('noResults');
    const resultCount = document.getElementById('resultCount');

    resultsDiv.style.display = 'block';
    resultCount.textContent = results.length + ' résultat' + (results.length > 1 ? 's' : '');

    if (results.length === 0) {
        resultsList.innerHTML = '';
        noResults.style.display = 'block';
        return;
    }

    noResults.style.display = 'none';
    
    resultsList.innerHTML = results.map(courrier => {
        const typeIcons = {
            'arrivee': '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>',
            'depart': '<path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path>',
            'interne': '<path d="M17 1l4 4-4 4"></path><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><path d="M7 23l-4-4 4-4"></path><path d="M21 13v2a4 4 0 0 1-4 4H3"></path>'
        };
        const typeColors = {
            'arrivee': { bg: '#E8F5E9', text: '#2E7D32', border: '#81C784', icon: typeIcons['arrivee'] },
            'depart': { bg: '#E3F2FD', text: '#1976D2', border: '#64B5F6', icon: typeIcons['depart'] },
            'interne': { bg: '#FFF3E0', text: '#F57C00', border: '#FFB74D', icon: typeIcons['interne'] }
        };
        const statutColors = {
            'en_cours': { bg: '#FFF3E0', text: '#F57C00', dot: '#F57C00' },
            'traite': { bg: '#E8F5E9', text: '#2E7D32', dot: '#2E7D32' },
            'archive': { bg: '#F5F5F5', text: '#757575', dot: '#9E9E9E' }
        };
        const typeConfig = typeColors[courrier.type] || typeColors['interne'];
        const statutConfig = statutColors[courrier.statut] || statutColors['en_cours'];
        const typeLabel = courrier.type === 'arrivee' ? 'Arrivée' : courrier.type === 'depart' ? 'Départ' : 'Interne';
        const statutLabel = courrier.statut === 'en_cours' ? 'En cours' : courrier.statut === 'traite' ? 'Traité' : 'Archivé';

        return `
            <div style="background: white; border-radius: 20px; padding: 1.8rem; box-shadow: 0 4px 16px rgba(0,0,0,0.08); border-left: 6px solid ${typeConfig.border}; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.boxShadow='0 12px 32px rgba(0,0,0,0.12)'; this.style.transform='translateX(8px) scale(1.01)'" onmouseout="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)'; this.style.transform='translateX(0) scale(1)'">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.3rem; flex-wrap: wrap; gap: 1.2rem;">
                    <div style="flex: 1; min-width: 280px;">
                        <h3 style="font-weight: 700; color: #1e293b; font-size: 1.2rem; margin: 0 0 1rem 0; line-height: 1.4; letter-spacing: -0.2px;">${courrier.objet}</h3>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.1rem; background: ${typeConfig.bg}; color: ${typeConfig.text}; border-radius: 24px; font-size: 0.9rem; font-weight: 600; letter-spacing: 0.3px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">${typeConfig.icon}</svg>
                                ${typeLabel}
                            </span>
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; font-size: 0.95rem; font-weight: 500;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                ${courrier.numero_enregistrement}
                            </span>
                        </div>
                    </div>
                    <span style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; background: ${statutConfig.bg}; color: ${statutConfig.text}; border-radius: 24px; font-size: 0.9rem; font-weight: 600; letter-spacing: 0.3px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <span style="width: 10px; height: 10px; background: ${statutConfig.dot}; border-radius: 50%; box-shadow: 0 0 0 3px ${statutConfig.bg};"></span>
                        ${statutLabel}
                    </span>
                </div>
                <div style="display: flex; gap: 1.2rem; justify-content: space-between; align-items: center; padding-top: 1.5rem; border-top: 2px solid #f1f5f9; flex-wrap: wrap;">
                    <div style="color: #64748b; font-size: 0.95rem; display: flex; align-items: center; gap: 0.6rem; font-weight: 500;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        ${new Date(courrier.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })}
                    </div>
                    <a href="/courriers/${courrier.id}" style="color: white; text-decoration: none; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.4rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 14px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); letter-spacing: 0.3px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)'">
                        Voir détails
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                </div>
            </div>
        `;
    }).join('');
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterType').value = '';
    document.getElementById('filterStatut').value = '';
    document.getElementById('filterDept').value = '';
    document.getElementById('filterDateFrom').value = '';
    document.getElementById('searchResults').style.display = 'none';
}

// Recherche en temps réel
document.getElementById('searchInput').addEventListener('input', function() {
    if (this.value.length >= 2) {
        performSearch();
    } else if (this.value.length === 0) {
        document.getElementById('searchResults').style.display = 'none';
    }
});
</script>
@endsection