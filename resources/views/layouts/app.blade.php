<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SOSUCO')</title>
    <style>
        /* Reset et base */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f6f8; 
            color: #333; 
            padding-top: 100px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* ===== NAVBAR MODERNE STYLE PINTEREST ===== */
        .navbar-modern {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            max-width: 1200px;
            background: white;
            border-radius: 50px;
            box-shadow: 0 8px 32px rgba(46, 125, 50, 0.15);
            padding: 0.6rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            border: 1px solid rgba(46, 125, 50, 0.1);
        }

        /* Logo à gauche */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .navbar-brand .logo-circle {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
            overflow: hidden;
        }
        .navbar-brand .logo-circle img {
            height: 30px;
            width: auto;
            object-fit: contain;
        }
        .navbar-brand .brand-text {
            color: #2E7D32;
            font-size: 1.1rem;
            font-weight: 700;
            display: none;
        }
        @media (min-width: 768px) {
            .navbar-brand .brand-text { display: block; }
        }

        /* Menu de navigation central */
        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 0.3rem;
            align-items: center;
            flex: 1;
            justify-content: center;
            overflow-x: auto;
            padding: 0 1rem;
        }
        .navbar-menu::-webkit-scrollbar { display: none; }
        
        .navbar-menu li {
            flex-shrink: 0;
        }

        .navbar-menu a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            white-space: nowrap;
        }

        /* Icônes SVG modernes */
        .navbar-menu a .nav-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .navbar-menu a .nav-icon svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            transition: all 0.3s;
        }
        .navbar-menu a:hover {
            color: #2E7D32;
            background: rgba(46, 125, 50, 0.08);
        }
        .navbar-menu a:hover .nav-icon svg {
            transform: scale(1.15);
            stroke-width: 2.5;
        }

        /* Élément ACTIF avec le "blob" vert */
        .navbar-menu a.active {
            color: white;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4);
            font-weight: 600;
        }
        .navbar-menu a.active .nav-icon svg {
            stroke-width: 2.5;
        }

        /* Liens Admin spéciaux (orange) */
        .navbar-menu a.admin-link {
            color: #F57C00;
            background: rgba(245, 124, 0, 0.08);
        }
        .navbar-menu a.admin-link:hover {
            background: rgba(245, 124, 0, 0.15);
            color: #E65100;
        }
        .navbar-menu a.admin-link.active {
            background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 124, 0, 0.4);
        }

        /* ✅ Liens Secrétaire spéciaux (bleu) */
        .navbar-menu a.secretaire-link {
            color: #1976D2;
            background: rgba(25, 118, 210, 0.08);
        }
        .navbar-menu a.secretaire-link:hover {
            background: rgba(25, 118, 210, 0.15);
            color: #0D47A1;
        }
        .navbar-menu a.secretaire-link.active {
            background: linear-gradient(135deg, #1976D2 0%, #2196F3 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.4);
        }

        /* Badge de notification dans le menu */
        .menu-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #e74c3c;
            color: white;
            font-size: 0.55rem;
            font-weight: bold;
            padding: 1px 4px;
            border-radius: 10px;
            min-width: 14px;
            text-align: center;
            border: 1.5px solid white;
        }

        /* Section utilisateur à droite */
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-shrink: 0;
        }

        /* Cloche notifications avec SVG */
        .notif-btn {
            position: relative;
            background: #f1f5f9;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            color: #475569;
        }
        .notif-btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
        }
        .notif-btn:hover {
            background: #E8F5E9;
            color: #2E7D32;
            transform: scale(1.05);
        }
        .notif-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #e74c3c;
            color: white;
            font-size: 0.6rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
            border: 2px solid white;
        }

        /* Infos utilisateur */
        .user-info {
            text-align: right;
            display: none;
        }
        @media (min-width: 768px) {
            .user-info { display: block; }
        }
        .user-name { font-weight: 600; font-size: 0.85rem; color: #1e293b; }
        .user-role { font-size: 0.7rem; color: #64748b; }

        /* Bouton déconnexion avec SVG */
        .btn-logout {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(46, 125, 50, 0.3);
        }
        .btn-logout svg {
            width: 16px;
            height: 16px;
            stroke: white;
        }
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4);
        }

        /* Dropdown notifications */
        .notif-container { position: relative; }
        #notif-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 55px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
            width: 320px;
            z-index: 1001;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        /* Contenu principal */
        .main-content { 
            max-width: 1200px; 
            margin: 2rem auto; 
            padding: 0 1.5rem; 
            flex: 1;
            width: 100%;
        }
        
        /* Messages flash */
        .alert { 
            padding: 1rem; 
            border-radius: 12px; 
            margin-bottom: 1.5rem; 
            font-weight: 500; 
        }
        .alert-success { 
            background: #C8E6C9; 
            color: #1B5E20; 
            border-left: 4px solid #2E7D32; 
        }
        .alert-error { 
            background: #FFCDD2; 
            color: #B71C1C; 
            border-left: 4px solid #C62828; 
        }

        /* Background image subtil */
        .page-with-background {
            position: relative;
            min-height: calc(100vh - 120px);
        }
        .page-with-background::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('{{ asset('images/background.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            opacity: 0.04;
            z-index: -1;
        }

        /* ===== FOOTER MODERNE ===== */
        .footer-modern {
            background: #0f172a;
            color: white;
            margin-top: auto;
        }
        .footer-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem 3rem;
        }
        .footer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .footer-brand .logo-box {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(46, 125, 50, 0.3);
        }
        .footer-brand .logo-box img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }
        .footer-brand h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }
        .footer-brand p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.6);
            margin: 0.2rem 0 0 0;
        }
        .footer-cta {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .footer-cta-text { text-align: right; }
        .footer-cta-text p:first-child {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            margin: 0;
        }
        .footer-cta-text p:last-child {
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            margin: 0.2rem 0 0 0;
        }
        .btn-support {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 24px rgba(46, 125, 50, 0.3);
            transition: all 0.3s;
        }
        .btn-support:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(46, 125, 50, 0.5);
        }
        .btn-support svg {
            width: 18px;
            height: 18px;
            stroke: white;
        }
        .footer-columns {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
            gap: 3rem;
        }
        .footer-col h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
            position: relative;
            padding-bottom: 0.8rem;
        }
        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #2E7D32 0%, #4CAF50 100%);
            border-radius: 2px;
        }
        .footer-col p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        .footer-social {
            display: flex;
            gap: 0.8rem;
        }
        .footer-social a {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            text-decoration: none;
        }
        .footer-social a:hover {
            background: #2E7D32;
            border-color: #2E7D32;
            transform: translateY(-3px);
        }
        .footer-social a svg {
            width: 18px;
            height: 18px;
            stroke: white;
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        .footer-links a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .footer-links a:hover {
            color: #4CAF50;
            padding-left: 5px;
        }
        .footer-links a svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
        }
        .footer-contact-item {
            margin-bottom: 1rem;
            display: flex;
            gap: 0.8rem;
            align-items: flex-start;
        }
        .footer-contact-icon {
            width: 32px;
            height: 32px;
            background: rgba(46, 125, 50, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .footer-contact-icon svg {
            width: 16px;
            height: 16px;
            stroke: #4CAF50;
        }
        .footer-contact-item p:first-child {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.6);
            margin: 0;
        }
        .footer-contact-item p:last-child {
            font-size: 0.85rem;
            color: white;
            margin: 0.2rem 0 0 0;
            font-weight: 500;
        }
        .newsletter-form {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .newsletter-form input {
            flex: 1;
            padding: 0.8rem 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: white;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .newsletter-form input::placeholder {
            color: rgba(255,255,255,0.4);
        }
        .newsletter-form input:focus {
            outline: none;
            border-color: #4CAF50;
            background: rgba(76, 175, 80, 0.05);
        }
        .newsletter-form button {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border: none;
            padding: 0 1.2rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .newsletter-form button:hover {
            transform: translateX(3px);
        }
        .newsletter-form button svg {
            width: 18px;
            height: 18px;
            stroke: white;
        }
        .newsletter-note {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
            margin: 0;
        }
        .footer-bottom {
            background: #0a0f1a;
            padding: 1.5rem 2rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-bottom-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-bottom p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
            margin: 0;
        }
        .footer-bottom-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .footer-bottom-links a {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s;
        }
        .footer-bottom-links a:hover {
            color: #4CAF50;
        }
        .footer-bottom-social {
            display: flex;
            gap: 0.8rem;
        }
        .footer-bottom-social a {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-bottom-social a:hover {
            color: #4CAF50;
        }
        .footer-bottom-social svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        /* Responsive mobile */
        @media (max-width: 768px) {
            body { padding-top: 90px; }
            .navbar-modern {
                top: 10px;
                width: calc(100% - 20px);
                padding: 0.5rem 1rem;
                border-radius: 30px;
            }
            .navbar-menu a {
                padding: 0.4rem 0.7rem;
                font-size: 0.65rem;
            }
            .btn-logout .btn-text { display: none; }
            .footer-columns {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .footer-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .footer-cta {
                width: 100%;
                justify-content: space-between;
            }
            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR MODERNE -->
    <nav class="navbar-modern">
        <!-- Logo -->
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="navbar-brand">
            <div class="logo-circle">
                <img src="{{ asset('images/logo-sosuco.jpg') }}" alt="SOSUCO Logo">
            </div>
            <span class="brand-text">SOSUCO</span>
        </a>

        <!-- Menu central (Affiché UNIQUEMENT si connecté) -->
        @auth
        <ul class="navbar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span>Accueil</span>
                </a>
            </li>
            
            @if(in_array(auth()->user()->role, ['administrateur', 'standardiste', 'secretaire', 'directeur']))
                <li>
                    <a href="{{ route('courriers.index', ['type' => 'arrivee']) }}" class="@if(request('type') === 'arrivee' && !request()->routeIs('courriers.historique') && !request()->routeIs('search.index')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </span>
                        <span>Arrivée</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('courriers.index', ['type' => 'depart']) }}" class="@if(request('type') === 'depart' && !request()->routeIs('courriers.historique') && !request()->routeIs('search.index')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 2L11 13"></path>
                                <path d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                            </svg>
                        </span>
                        <span>Départ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('courriers.index', ['type' => 'interne']) }}" class="@if(request('type') === 'interne' && !request()->routeIs('courriers.historique') && !request()->routeIs('search.index')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 1l4 4-4 4"></path>
                                <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                                <path d="M7 23l-4-4 4-4"></path>
                                <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                            </svg>
                        </span>
                        <span>Interne</span>
                    </a>
                </li>
            @endif

            {{-- ✅ NOUVEAU LIEN : À réceptionner (visible pour secrétaire et admin) --}}
            @if(in_array(auth()->user()->role, ['secretaire', 'administrateur']))
                <li>
                    <a href="{{ route('courriers.aReceptionner') }}" class="secretaire-link @if(request()->routeIs('courriers.aReceptionner')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </span>
                        <span>À réceptionner</span>
                        {{-- Badge avec le nombre de courriers en attente --}}
                        @php
                            $aReceptionnerCount = \App\Models\Courrier::where('statut', 'en_attente_reception')
                                ->where('departement_id', auth()->user()->departement_id)
                                ->count();
                        @endphp
                        @if($aReceptionnerCount > 0)
                            <span class="menu-badge">{{ $aReceptionnerCount }}</span>
                        @endif
                    </a>
                </li>
            @endif
            
            <li>
                <a href="{{ route('search.index') }}" class="@if(request()->routeIs('search.index')) active @endif">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </span>
                    <span>Recherche</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('courriers.historique') }}" class="@if(request()->routeIs('courriers.historique')) active @endif">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </span>
                    <span>Historique</span>
                </a>
            </li>
            
            @if(auth()->user()->role === 'administrateur')
                <li>
                    <a href="{{ route('admin.users.index') }}" class="admin-link @if(request()->is('admin/users*')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.audit.index') }}" class="admin-link @if(request()->is('admin/audit*')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </span>
                        <span>Audit</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.type-courriers.index') }}" class="admin-link @if(request()->is('admin/type-courriers*')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </span>
                        <span>Types</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}" class="admin-link @if(request()->is('admin/roles*')) active @endif">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <span>Rôles</span>
                    </a>
                </li>
               
            @endif
        </ul>
        @endauth

        <!-- Section utilisateur (Affichée UNIQUEMENT si connecté) -->
        @auth
        <div class="navbar-user">
            
            <!-- Notifications avec SVG -->
            <div class="notif-container">
                <button class="notif-btn" onclick="toggleNotifDropdown()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notif-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>

                <!-- Dropdown notifications -->
                <div id="notif-dropdown">
                    <div style="padding: 0.8rem 1rem; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700; color: white; font-size: 0.9rem;">Notifications</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" style="background: rgba(255,255,255,0.2); border: none; color: white; font-size: 0.75rem; cursor: pointer; font-weight: 600; padding: 0.3rem 0.6rem; border-radius: 12px;">Tout marquer lu</button>
                            </form>
                        @endif
                    </div>
                    
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse(auth()->user()->notifications->take(5) as $notif)
                            <a href="{{ route('courriers.show', $notif->data['courrier_id'] ?? 0) }}" onclick="markNotifAsRead('{{ $notif->id }}')" style="display: block; padding: 0.8rem 1rem; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: #334155; font-size: 0.85rem; background: {{ $notif->read_at ? '#ffffff' : '#F1F8E9' }};">
                                <div style="font-weight: {{ $notif->read_at ? '400' : '700' }}; margin-bottom: 0.3rem;">
                                    {{ $notif->data['message'] ?? 'Notification' }}
                                </div>
                                <div style="font-size: 0.7rem; color: #64748b;">
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </a>
                        @empty
                            <div style="padding: 1.5rem; text-align: center; color: #64748b; font-size: 0.85rem;">
                                Aucune notification.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Infos utilisateur -->
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</div>
                <div class="user-role">
                    @php
                        $rolesLabels = [
                            'administrateur' => 'Administrateur',
                            'standardiste' => 'Standardiste',
                            'secretaire' => 'Secrétaire',
                            'directeur' => 'Directeur',
                        ];
                    @endphp
                    {{ $rolesLabels[auth()->user()->role] ?? 'Non assigné' }}
                </div>
            </div>
            
            <!-- Déconnexion avec SVG -->
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="btn-text">Déconnexion</span>
                </button>
            </form>
        </div>
        @endauth
    </nav>

    <!-- CONTENU -->
    <main class="main-content page-with-background">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <!-- ===== FOOTER MODERNE ===== -->
    <footer class="footer-modern">
        <div class="footer-main">
            <!-- En-tête du footer -->
            <div class="footer-header">
                <div class="footer-brand">
                    <div class="logo-box">
                        <img src="{{ asset('images/logo-sosuco.jpg') }}" alt="SOSUCO">
                    </div>
                    <div>
                        <h3>SOSUCO</h3>
                        <p>Gestion Électronique de Courriers</p>
                    </div>
                </div>
                <div class="footer-cta">
                    <div class="footer-cta-text">
                        <p>Besoin d'aide ?</p>
                        <p>Contactez le support</p>
                    </div>
                    <a href="mailto:support@sosuco.com" class="btn-support">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Support
                    </a>
                </div>
            </div>

            <!-- 4 colonnes -->
            <div class="footer-columns">
                <!-- Colonne 1 : À propos -->
                <div class="footer-col">
                    <h4>À propos</h4>
                    <p>SOSUCO est une solution moderne de gestion électronique de courriers, conçue pour optimiser vos flux documentaires et améliorer la traçabilité de votre entreprise.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="#" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                <rect x="2" y="9" width="4" height="12"></rect>
                                <circle cx="4" cy="4" r="2"></circle>
                            </svg>
                        </a>
                        <a href="#" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Colonne 2 : Liens rapides -->
                <div class="footer-col">
                    <h4>Liens rapides</h4>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                Tableau de bord
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courriers.index') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                Courriers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('search.index') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                Recherche
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courriers.historique') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                Historique
                            </a>
                        </li>
                        @if(auth()->check() && auth()->user()->role === 'administrateur')
                        <li>
                            <a href="{{ route('admin.users.index') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                Administration
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- Colonne 3 : Contact -->
                <div class="footer-col">
                    <h4>Contact</h4>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div>
                            <p>Siège social</p>
                            <p>Dakar, Sénégal</p>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div>
                            <p>Email</p>
                            <p>contact@sosuco.com</p>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div>
                            <p>Téléphone</p>
                            <p>+221 33 XXX XX XX</p>
                        </div>
                    </div>
                </div>

                <!-- Colonne 4 : Newsletter -->
                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Recevez les dernières actualités et mises à jour de l'application directement dans votre boîte mail.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Merci pour votre inscription !');">
                        <input type="email" placeholder="Votre email" required>
                        <button type="submit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </form>
                    <p class="newsletter-note">En vous inscrivant, vous acceptez notre politique de confidentialité.</p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>© 2026 SOSUCO. Tous droits réservés.</p>
                <div class="footer-bottom-links">
                    <a href="#">Politique de confidentialité</a>
                    <a href="#">Conditions d'utilisation</a>
                </div>
                <div class="footer-bottom-social">
                    <a href="#" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleNotifDropdown() {
            var dropdown = document.getElementById('notif-dropdown');
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        }

        document.addEventListener('click', function(event) {
            var container = event.target.closest('.notif-container');
            var dropdown = document.getElementById('notif-dropdown');
            if (!container && dropdown && dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            }
        });

        function markNotifAsRead(id) {
            fetch('/notifications/mark-as-read/' + id, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(() => {
                setTimeout(() => { window.location.reload(); }, 300);
            });
        }
    </script>
</body>
</html>