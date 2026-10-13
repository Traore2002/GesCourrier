@extends('layouts.app')

@section('title', 'Créer un Workflow - SN-SOSUCO')

@section('content')
<!-- Inclusion de SortableJS via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<div style="max-width: 1400px; margin: 0 auto; padding: 2rem 1rem;">
    
    <!-- En-tête -->
    <div style="background: white; border-radius: 16px; padding: 1.5rem 2rem; margin-bottom: 1.5rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #2E7D32; margin: 0;">Créer un Workflow</h2>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0.3rem 0 0 0;">Glissez les blocs depuis la palette pour construire le flux</p>
        </div>
        <a href="{{ route('admin.workflows.index') }}" style="padding: 0.7rem 1.5rem; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
            ← Retour
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 280px 1fr 300px; gap: 1.5rem; align-items: start;">
        
        <!-- PALETTE DE BLOCS (Gauche) -->
        <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
            <h3 style="font-size: 1rem; font-weight: 700; color: #2E7D32; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                Palette de blocs
            </h3>
            <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">Glissez les blocs vers la zone de construction</p>
            
            <div id="palette" style="display: flex; flex-direction: column; gap: 0.8rem;">
                <!-- Bloc : Courrier arrivé -->
                <div class="workflow-block" data-type="arrivee" data-icon="inbox" style="padding: 0.9rem; background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); border: 2px solid #4CAF50; border-radius: 10px; cursor: grab; display: flex; align-items: center; gap: 0.7rem; transition: all 0.2s;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                    <div>
                        <div style="font-weight: 700; color: #2E7D32; font-size: 0.9rem;">Courrier arrivé</div>
                        <div style="font-size: 0.75rem; color: #558B2F;">Point de départ</div>
                    </div>
                </div>

                <!-- Bloc : Distribution -->
                <div class="workflow-block" data-type="distribution" data-icon="share" style="padding: 0.9rem; background: white; border: 2px solid #e2e8f0; border-radius: 10px; cursor: grab; display: flex; align-items: center; gap: 0.7rem; transition: all 0.2s;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                    <div>
                        <div style="font-weight: 700; color: #334155; font-size: 0.9rem;">Distribution</div>
                        <div style="font-size: 0.75rem; color: #64748b;">Affectation à un service</div>
                    </div>
                </div>

                <!-- Bloc : Traitement -->
                <div class="workflow-block" data-type="traitement" data-icon="edit" style="padding: 0.9rem; background: white; border: 2px solid #e2e8f0; border-radius: 10px; cursor: grab; display: flex; align-items: center; gap: 0.7rem; transition: all 0.2s;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <div>
                        <div style="font-weight: 700; color: #334155; font-size: 0.9rem;">Traitement</div>
                        <div style="font-size: 0.75rem; color: #64748b;">Action sur le courrier</div>
                    </div>
                </div>

                <!-- Bloc : Validation -->
                <div class="workflow-block" data-type="validation" data-icon="check" style="padding: 0.9rem; background: white; border: 2px solid #e2e8f0; border-radius: 10px; cursor: grab; display: flex; align-items: center; gap: 0.7rem; transition: all 0.2s;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <div>
                        <div style="font-weight: 700; color: #334155; font-size: 0.9rem;">Validation</div>
                        <div style="font-size: 0.75rem; color: #64748b;">Approbation finale</div>
                    </div>
                </div>

                <!-- Bloc : Archivage -->
                <div class="workflow-block" data-type="archivage" data-icon="archive" style="padding: 0.9rem; background: white; border: 2px solid #e2e8f0; border-radius: 10px; cursor: grab; display: flex; align-items: center; gap: 0.7rem; transition: all 0.2s;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                    <div>
                        <div style="font-weight: 700; color: #334155; font-size: 0.9rem;">Archivage</div>
                        <div style="font-size: 0.75rem; color: #64748b;">Clôture du courrier</div>
                    </div>
                </div>

                <!-- Bloc : Notification -->
                <div class="workflow-block" data-type="notification" data-icon="bell" style="padding: 0.9rem; background: white; border: 2px solid #e2e8f0; border-radius: 10px; cursor: grab; display: flex; align-items: center; gap: 0.7rem; transition: all 0.2s;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <div>
                        <div style="font-weight: 700; color: #334155; font-size: 0.9rem;">Notification</div>
                        <div style="font-size: 0.75rem; color: #64748b;">Alerte par email</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ZONE DE CONSTRUCTION (Centre) -->
        <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1); min-height: 500px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #2E7D32; margin: 0;">
                    🎯 Zone de construction
                </h3>
                <span id="block-count" style="font-size: 0.8rem; color: #64748b; background: #f1f5f9; padding: 0.3rem 0.7rem; border-radius: 20px;">0 bloc(s)</span>
            </div>

            <div id="workflow-canvas" style="min-height: 400px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; transition: all 0.2s;">
                <div id="empty-state" style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1rem; opacity: 0.5;">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <p style="font-size: 1rem; font-weight: 500; margin: 0;">Glissez un bloc ici pour commencer</p>
                    <p style="font-size: 0.85rem; margin: 0.5rem 0 0 0;">Commencez par "Courrier arrivé"</p>
                </div>
            </div>

            <!-- Champs de configuration du workflow -->
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Nom du workflow <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="workflow-name" placeholder="Ex: Workflow courrier arrivée standard" 
                           style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; outline: none;"
                           onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Description</label>
                    <textarea id="workflow-description" rows="2" placeholder="Description optionnelle..." 
                              style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; outline: none; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#4CAF50'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Type de courrier concerné</label>
                    <select id="workflow-type" style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; outline: none; background: white;">
                        <option value="arrivee">Courrier Arrivée</option>
                        <option value="depart">Courrier Départ</option>
                        <option value="interne">Courrier Interne</option>
                    </select>
                </div>
            </div>

            <!-- Bouton de sauvegarde -->
            <button id="save-workflow" style="width: 100%; margin-top: 1rem; padding: 1rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); transition: all 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(46, 125, 50, 0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(46, 125, 50, 0.3)'">
                💾 Enregistrer le workflow
            </button>
        </div>

        <!-- PANNEAU PROPRIÉTÉS (Droite) -->
        <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); border: 1px solid rgba(46, 125, 50, 0.1);">
            <h3 style="font-size: 1rem; font-weight: 700; color: #2E7D32; margin: 0 0 1rem 0;">⚙️ Propriétés</h3>
            
            <div id="properties-panel" style="display: none;">
                <div style="padding: 1rem; background: #f0fdf4; border-radius: 10px; border: 1px solid #bbf7d0; margin-bottom: 1rem;">
                    <div style="font-size: 0.75rem; color: #166534; font-weight: 600; text-transform: uppercase;">Bloc sélectionné</div>
                    <div id="prop-block-name" style="font-size: 1.1rem; font-weight: 700; color: #2E7D32; margin-top: 0.3rem;">-</div>
                    <div id="prop-block-type" style="font-size: 0.8rem; color: #15803d; margin-top: 0.2rem;">-</div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Rôle responsable</label>
                    <select id="prop-role" style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; background: white;">
                        <option value="">-- Sélectionner --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->nom) }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Délai maximum (heures)</label>
                    <input type="number" id="prop-deadline" min="1" value="24" style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Description de l'étape</label>
                    <textarea id="prop-description" rows="3" style="width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; resize: vertical; font-family: inherit;"></textarea>
                </div>

                <button id="apply-properties" style="width: 100%; padding: 0.7rem; background: #2E7D32; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer;">
                    Appliquer
                </button>
            </div>

            <div id="no-selection" style="text-align: center; padding: 2rem 1rem; color: #94a3b8;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 0.5rem; opacity: 0.5;">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                <p style="font-size: 0.85rem; margin: 0;">Cliquez sur un bloc pour voir ses propriétés</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style des blocs dans le canvas */
    .canvas-block {
        padding: 1rem;
        background: white;
        border: 2px solid #4CAF50;
        border-radius: 10px;
        cursor: grab;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        transition: all 0.2s;
        position: relative;
    }
    .canvas-block:hover {
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
        transform: translateX(5px);
    }
    .canvas-block.selected {
        border-color: #2E7D32;
        background: #f0fdf4;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
    }
    .canvas-block .step-number {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .canvas-block .remove-btn {
        margin-left: auto;
        width: 28px;
        height: 28px;
        background: #fee2e2;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .canvas-block .remove-btn:hover {
        background: #ef4444;
    }
    .canvas-block .remove-btn:hover svg {
        stroke: white;
    }
    .canvas-block .remove-btn svg {
        width: 14px;
        height: 14px;
        stroke: #ef4444;
    }
    
    /* Style pendant le drag */
    .sortable-ghost {
        opacity: 0.4;
        background: #f0fdf4;
    }
    .sortable-chosen {
        cursor: grabbing;
    }
    
    /* Flèche de connexion entre blocs */
    .workflow-canvas .canvas-block + .canvas-block::before {
        content: '↓';
        position: absolute;
        top: -22px;
        left: 50%;
        transform: translateX(-50%);
        color: #4CAF50;
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('workflow-canvas');
    const palette = document.getElementById('palette');
    const emptyState = document.getElementById('empty-state');
    const blockCount = document.getElementById('block-count');
    const propertiesPanel = document.getElementById('properties-panel');
    const noSelection = document.getElementById('no-selection');
    let selectedBlock = null;
    let stepCounter = 1;

    // Configuration de la palette (source des blocs)
    new Sortable(palette, {
        group: {
            name: 'workflow',
            pull: 'clone',  // Clone au lieu de déplacer
            put: false       // Ne peut pas recevoir de blocs
        },
        sort: false,         // Pas de réorganisation dans la palette
        animation: 150,
        ghostClass: 'sortable-ghost'
    });

    // Configuration du canvas (zone de construction)
    new Sortable(canvas, {
        group: 'workflow',
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onAdd: function(evt) {
            // Quand un bloc est ajouté depuis la palette
            const item = evt.item;
            const blockType = item.dataset.type;
            const blockName = item.querySelector('div > div:first-child').textContent;
            
            // Remplacer le bloc cloné par un bloc canvas stylisé
            const newBlock = createCanvasBlock(blockType, blockName, stepCounter++);
            item.replaceWith(newBlock);
            
            updateEmptyState();
            updateBlockCount();
        },
        onUpdate: function() {
            // Quand l'ordre change, mettre à jour les numéros
            renumberBlocks();
        }
    });

    function createCanvasBlock(type, name, step) {
        const block = document.createElement('div');
        block.className = 'canvas-block';
        block.dataset.type = type;
        block.dataset.step = step;
        
        // Icônes SVG selon le type
        const icons = {
            'arrivee': '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
            'distribution': '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>',
            'traitement': '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
            'validation': '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>',
            'archivage': '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>',
            'notification': '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>'
        };

        block.innerHTML = `
            <div class="step-number">${step}</div>
            ${icons[type] || icons['traitement']}
            <div style="flex: 1;">
                <div style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">${name}</div>
                <div style="font-size: 0.75rem; color: #64748b;">Étape ${step}</div>
            </div>
            <button class="remove-btn" title="Supprimer ce bloc">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        `;

        // Événements
        block.addEventListener('click', function(e) {
            if (e.target.closest('.remove-btn')) return;
            selectBlock(block, name, type);
        });

        block.querySelector('.remove-btn').addEventListener('click', function() {
            block.remove();
            renumberBlocks();
            updateEmptyState();
            updateBlockCount();
            if (selectedBlock === block) {
                selectedBlock = null;
                propertiesPanel.style.display = 'none';
                noSelection.style.display = 'block';
            }
        });

        return block;
    }

    function selectBlock(block, name, type) {
        // Désélectionner l'ancien
        document.querySelectorAll('.canvas-block').forEach(b => b.classList.remove('selected'));
        
        // Sélectionner le nouveau
        block.classList.add('selected');
        selectedBlock = block;
        
        // Afficher le panneau de propriétés
        noSelection.style.display = 'none';
        propertiesPanel.style.display = 'block';
        
        document.getElementById('prop-block-name').textContent = name;
        document.getElementById('prop-block-type').textContent = 'Type : ' + type;
    }

    function renumberBlocks() {
        const blocks = canvas.querySelectorAll('.canvas-block');
        blocks.forEach((block, index) => {
            block.dataset.step = index + 1;
            block.querySelector('.step-number').textContent = index + 1;
            const stepLabel = block.querySelector('div > div:last-child > div:last-child');
            if (stepLabel) stepLabel.textContent = 'Étape ' + (index + 1);
        });
        stepCounter = blocks.length + 1;
    }

    function updateEmptyState() {
        const hasBlocks = canvas.querySelectorAll('.canvas-block').length > 0;
        emptyState.style.display = hasBlocks ? 'none' : 'block';
    }

    function updateBlockCount() {
        const count = canvas.querySelectorAll('.canvas-block').length;
        blockCount.textContent = count + ' bloc(s)';
    }

    // Appliquer les propriétés
    document.getElementById('apply-properties').addEventListener('click', function() {
        if (!selectedBlock) return;
        
        const role = document.getElementById('prop-role').value;
        const deadline = document.getElementById('prop-deadline').value;
        const description = document.getElementById('prop-description').value;
        
        selectedBlock.dataset.role = role;
        selectedBlock.dataset.deadline = deadline;
        selectedBlock.dataset.description = description;
        
        // Feedback visuel
        this.textContent = '✓ Appliqué';
        this.style.background = '#4CAF50';
        setTimeout(() => {
            this.textContent = 'Appliquer';
            this.style.background = '#2E7D32';
        }, 1500);
    });

    // Sauvegarder le workflow
    document.getElementById('save-workflow').addEventListener('click', function() {
        const name = document.getElementById('workflow-name').value.trim();
        const description = document.getElementById('workflow-description').value.trim();
        const type = document.getElementById('workflow-type').value;
        const blocks = canvas.querySelectorAll('.canvas-block');
        
        if (!name) {
            alert('⚠️ Veuillez donner un nom au workflow');
            document.getElementById('workflow-name').focus();
            return;
        }
        
        if (blocks.length === 0) {
            alert('⚠️ Veuillez ajouter au moins un bloc au workflow');
            return;
        }

        // Construire le JSON du workflow
        const workflowData = {
            name: name,
            description: description,
            type: type,
            steps: Array.from(blocks).map((block, index) => ({
                order: index + 1,
                type: block.dataset.type,
                role_id: block.dataset.role || null,
                deadline_hours: block.dataset.deadline || 24,
                description: block.dataset.description || ''
            }))
        };

        console.log('Workflow à sauvegarder:', workflowData);

        // Envoi AJAX vers Laravel
        const btn = this;
        btn.textContent = ' Enregistrement...';
        btn.disabled = true;

        fetch('{{ route("admin.workflows.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(workflowData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Workflow enregistré avec succès !');
                window.location.href = '{{ route("admin.workflows.index") }}';
            } else {
                alert('❌ Erreur : ' + (data.message || 'Erreur inconnue'));
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('❌ Erreur de communication avec le serveur');
        })
        .finally(() => {
            btn.textContent = '💾 Enregistrer le workflow';
            btn.disabled = false;
        });
    });
});
</script>
@endsection