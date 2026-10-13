<?php

use App\Http\Controllers\Admin\WorkflowController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\TypeCourrierController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;

// =================================================================
// 1. Page d'accueil
// =================================================================
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// =================================================================
// 2. Routes d'authentification (Publiques)
// =================================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =================================================================
// 3. Routes protégées (nécessite d'être connecté)
// =================================================================
Route::middleware(['auth'])->group(function () {
    
    // ✅ Route dédiée pour la réception des courriers par la secrétaire
    Route::get('/courriers/a-receptionner', [CourrierController::class, 'aReceptionner'])->name('courriers.aReceptionner');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Recherche avancée
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    // Historique des courriers
    Route::get('/courriers/historique', [CourrierController::class, 'historique'])->name('courriers.historique');

    // Routes Courriers (CRUD standard)
    Route::resource('courriers', CourrierController::class);

    // ✅ ACTIONS DU DIRECTEUR
Route::post('/courriers/{courrier}/valider', [CourrierController::class, 'validerCourrier'])->name('courriers.valider');
Route::post('/courriers/{courrier}/transmettre-apres-validation', [CourrierController::class, 'transmettreApresValidation'])->name('courriers.transmettreApresValidation');
Route::get('/courriers/{courrier}/creer-reponse', [CourrierController::class, 'creerReponseLiee'])->name('courriers.creerReponseLiee');

    // ✅ NOUVEAU : Route pour enregistrer et envoyer directement dans le workflow
    Route::post('/courriers/store-and-send', [CourrierController::class, 'storeAndSend'])->name('courriers.storeAndSend');

    // ✅ Envoi au directeur du même département
Route::post('/courriers/{courrier}/envoyer-directeur', [CourrierController::class, 'envoyerAuDirecteur'])->name('courriers.envoyerAuDirecteur');
    // ✅ WORKFLOW INTERNE : Réception et Transit (URLs renommées pour éviter les conflits)
Route::post('/courriers/{courrier}/receptionner-interne', [CourrierController::class, 'receptionnerInterne'])->name('courriers.receptionnerInterne');
Route::get('/courriers/{courrier}/transit', [CourrierController::class, 'showTransmettreInterneForm'])->name('courriers.transmettreInterneForm');
Route::post('/courriers/{courrier}/transit', [CourrierController::class, 'transmettreInterne'])->name('courriers.transmettreInterne');
    // Route pour le Scan Rapide
    Route::post('/scan-upload', [CourrierController::class, 'scanUpload'])->name('scan.upload');

    // Routes Distribution (Standardiste)
    Route::get('/courriers/{courrier}/distribuer', [CourrierController::class, 'distribuer'])->name('courriers.distribuer');
    Route::post('/courriers/{courrier}/distribuer', [CourrierController::class, 'traiterDistribution'])->name('courriers.traiterDistribution');

    // ✅ WORKFLOW AUTOMATIQUE DES COURRIERS (Actions spécifiques)
    Route::post('/courriers/{courrier}/receptionner', [CourrierController::class, 'receptionner'])->name('courriers.receptionner');
    Route::post('/courriers/{courrier}/envoyer-direction', [CourrierController::class, 'envoyerDirection'])->name('courriers.envoyerDirection');
    Route::post('/courriers/{courrier}/traiter', [CourrierController::class, 'traiter'])->name('courriers.traiter');

    // ✨ WORKFLOW PHASE 3
Route::get('/courriers/{courrier}/transmettre', [CourrierController::class, 'showTransmettreForm'])->name('courriers.showTransmettreForm');
Route::post('/courriers/{courrier}/transmettre', [CourrierController::class, 'transmettre'])->name('courriers.transmettre');
Route::post('/courriers/{courrier}/prendre-en-charge', [CourrierController::class, 'prendreEnCharge'])->name('courriers.prendreEnCharge');
Route::post('/courriers/{courrier}/classer-sans-reponse', [CourrierController::class, 'classerSansReponse'])->name('courriers.classerSansReponse');
    // =================================================================
    // 4. Routes Administration
    // =================================================================
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // ✅ Gestion complète des utilisateurs (CRUD)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

      
        // Journal d'audit
        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
        
   // Types de courriers (on autorise maintenant la suppression/désactivation)
   Route::resource('type-courriers', TypeCourrierController::class)->except(['edit', 'show']);
           
        // Workflows
        Route::resource('workflows', WorkflowController::class)->except(['edit']);

        // ✅ Gestion complète des rôles (CRUD dynamique)
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // =================================================================
    // 5. Routes pour les notifications
    // =================================================================
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    
});