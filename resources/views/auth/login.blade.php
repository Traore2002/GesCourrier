<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion SOSUCO</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            color: white;
        }

        /* ===== CÔTÉ GAUCHE : VISUEL & BRANDING ===== */
        .left-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            background: linear-gradient(135deg, #1a3a1a 0%, #0f172a 100%);
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('{{ asset('images/background.jpeg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            z-index: 0;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(46, 125, 50, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(76, 175, 80, 0.2) 0%, transparent 40%);
            z-index: 0;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-20px, -20px) rotate(5deg); }
        }

        .left-content {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4rem;
        }
        .brand-logo .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(46, 125, 50, 0.4);
        }
        .brand-logo .logo-icon img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        .brand-logo span {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
        }

        .hero-text h1 {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: white;
        }
        .hero-text h1 .highlight {
            color: #4CAF50;
            display: block;
        }
        .hero-text p {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            max-width: 500px;
        }

        .trust-badges {
            position: relative;
            z-index: 1;
            margin-top: 3rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            max-width: 450px;
        }
        .trust-badge {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 18px;
            padding: 1.5rem 1rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }
        .trust-badge:hover {
            background: rgba(76, 175, 80, 0.15);
            transform: translateY(-8px);
            border-color: rgba(76, 175, 80, 0.5);
            box-shadow: 0 20px 40px rgba(46, 125, 50, 0.25);
        }
        .trust-badge-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4);
            transition: all 0.3s;
        }
        .trust-badge:hover .trust-badge-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .trust-badge-icon svg {
            width: 28px;
            height: 28px;
            stroke: white;
        }
        .trust-badge-title {
            font-weight: 700;
            color: white;
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }
        .trust-badge-desc {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
        }

        .footer-left {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        .footer-left .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
        }
        .footer-left .dot.active {
            width: 24px;
            border-radius: 4px;
            background: #4CAF50;
        }

        /* ===== CÔTÉ DROIT : FORMULAIRE ===== */
        .right-panel {
            width: 500px;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .form-header {
            margin-bottom: 2rem;
        }
        .form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        .form-header p {
            color: rgba(255,255,255,0.6);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.3rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            font-size: 0.9rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: rgba(255,255,255,0.4);
            pointer-events: none;
        }
        .form-group input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .form-group input::placeholder {
            color: rgba(255,255,255,0.3);
        }
        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            background: rgba(76, 175, 80, 0.05);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
            cursor: pointer;
        }
        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #4CAF50;
        }
        .forgot-link {
            color: #4CAF50;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(46, 125, 50, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(46, 125, 50, 0.5);
        }
        .btn-submit svg {
            width: 18px;
            height: 18px;
            stroke: white;
        }

        .alert {
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        .alert-error {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        .alert-error svg { stroke: #e74c3c; }
        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }
        .alert-success svg { stroke: #4CAF50; }

        /* Responsive */
        @media (max-width: 900px) {
            body { flex-direction: column; }
            .left-panel {
                min-height: 300px;
                padding: 2rem;
            }
            .hero-text h1 { font-size: 2rem; }
            .trust-badges { display: none; }
            .right-panel {
                width: 100%;
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- CÔTÉ GAUCHE : VISUEL -->
    <div class="left-panel">
        <div class="brand-logo">
            <div class="logo-icon">
                <img src="{{ asset('images/logo-sosuco.jpg') }}" alt="SOSUCO">
            </div>
            <span>SOSUCO</span>
        </div>

        <div class="left-content">
            <div class="hero-text">
                <h1>
                    Votre gestion de courriers
                    <span class="highlight">commence ici.</span>
                </h1>
                <p>
                    Enregistrez, distribuez et suivez vos courriers en temps réel. 
                    Transformez votre flux documentaire en une expérience fluide et sécurisée.
                </p>
            </div>

            <div class="trust-badges">
                <div class="trust-badge">
                    <div class="trust-badge-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <div class="trust-badge-title">100% Sécurisé</div>
                    <div class="trust-badge-desc">Données protégées</div>
                </div>

                <div class="trust-badge">
                    <div class="trust-badge-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="trust-badge-title">Zéro Papier</div>
                    <div class="trust-badge-desc">100% digitalisé</div>
                </div>

                <div class="trust-badge">
                    <div class="trust-badge-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <div class="trust-badge-title">Support</div>
                    <div class="trust-badge-desc">Assistance dédiée</div>
                </div>
            </div>
        </div>

        <div class="footer-left">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <!-- CÔTÉ DROIT : FORMULAIRE -->
    <div class="right-panel">
        <div class="form-container">
            <div class="form-header">
                <h2>Bon retour</h2>
                <p>Connectez-vous à votre espace SOSUCO</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- ✅ CHAMP EMAIL (au lieu de Matricule) -->
                <div class="form-group">
                    <label for="email">Adresse Email professionnelle</label>
                    <div class="input-wrapper">
                        <!-- Icône enveloppe pour l'email -->
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="exemple@sosuco.com">
                    </div>
                    @error('email')
                        <p style="color: #e74c3c; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input type="password" id="password" name="password" required placeholder="Entrez votre mot de passe">
                    </div>
                    @error('password')
                        <p style="color: #e74c3c; font-size: 0.8rem; margin-top: 0.3rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Accéder à l'espace
                </button>
            </form>

            <!-- ✅ Les liens d'inscription ont été SUPPRIMÉS ici -->
        </div>
    </div>

</body>
</html>