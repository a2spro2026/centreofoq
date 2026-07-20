<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>L'HORIZON — مركز أفق للعلوم و المعرفة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500;600;700;800&family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-deep: #000d2b;
            --gold: #d4a017;
            --gold-bright: #f0c14b;
            --cyan: #6ee7ff;
            --white: #ffffff;
            --font-ar: 'Cairo', sans-serif;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-fr: 'Outfit', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: var(--font-ar);
            background: var(--navy-deep);
            color: var(--white);
        }

        .landing {
            position: relative;
            width: 100vw;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
        }

        /* Fond : interface vide fournie */
        .landing__bg {
            position: absolute;
            inset: 0;
            background: url('{{ asset('images/horizon-bg.png') }}') center / cover no-repeat;
            z-index: 0;
        }

        /* Étoiles scintillantes */
        .stars {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }

        .star {
            position: absolute;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 0 6px 1px rgba(255, 255, 255, 0.85), 0 0 14px 3px rgba(110, 231, 255, 0.35);
            animation: twinkle var(--d, 3s) ease-in-out var(--t, 0s) infinite alternate;
            opacity: 0.25;
        }

        .star--gold {
            box-shadow: 0 0 6px 1px rgba(240, 193, 75, 0.9), 0 0 14px 3px rgba(240, 193, 75, 0.4);
            background: var(--gold-bright);
        }

        @keyframes twinkle {
            from { opacity: 0.12; transform: scale(0.8); }
            to   { opacity: 1; transform: scale(1.25); }
        }

        /* Étoile filante discrète */
        .shooting-star {
            position: absolute;
            top: 12%;
            left: 55%;
            width: 130px;
            height: 2px;
            background: linear-gradient(90deg, rgba(255,255,255,0.9), transparent);
            border-radius: 2px;
            transform: rotate(-24deg);
            opacity: 0;
            animation: shoot 9s ease-in 4s infinite;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes shoot {
            0%   { opacity: 0; transform: rotate(-24deg) translateX(0); }
            3%   { opacity: 0.9; }
            8%   { opacity: 0; transform: rotate(-24deg) translateX(260px); }
            100% { opacity: 0; }
        }

        /* Contenu : branding centré + panneau à droite */
        .landing__grid {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            direction: ltr;
            padding: 0 clamp(1.25rem, 4vw, 3.25rem);
        }

        /* —— Branding : en haut, centré —— */
        .brand {
            position: absolute;
            left: 42%;
            top: clamp(4rem, 13vh, 8rem);
            transform: translateX(-50%);
            width: max-content;
            max-width: 48vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            direction: ltr;
            animation: fade-up 0.9s ease both;
        }

        .brand__logo {
            width: min(190px, 26vw);
            margin-bottom: 0.75rem;
        }

        .brand__logo img {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(0 10px 34px rgba(0, 0, 0, 0.5));
        }

        .brand__title {
            font-family: var(--font-display);
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 700;
            letter-spacing: 0.04em;
            line-height: 1;
            text-shadow: 0 4px 28px rgba(0, 0, 0, 0.5);
        }

        .brand__ar {
            margin-top: 0.5rem;
            font-family: var(--font-ar);
            font-size: clamp(1rem, 2vw, 1.3rem);
            font-weight: 700;
            direction: rtl;
        }

        .brand__ar .gold { color: var(--gold-bright); }

        .brand__slogan {
            margin-top: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            font-family: var(--font-fr);
            font-size: clamp(0.85rem, 1.4vw, 1rem);
            font-weight: 500;
            color: rgba(255, 255, 255, 0.92);
        }

        .brand__slogan::before,
        .brand__slogan::after {
            content: '';
            width: clamp(1.8rem, 4vw, 3rem);
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-bright), transparent);
        }

        /* Options */
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.1rem 1.6rem;
            margin-top: 1.6rem;
            direction: rtl;
        }

        .feature {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.45rem;
            width: 5.8rem;
        }

        .feature__icon {
            width: 2.9rem;
            height: 2.9rem;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.88);
            display: grid;
            place-items: center;
            color: var(--white);
            background: rgba(0, 30, 80, 0.3);
            box-shadow: 0 0 16px rgba(110, 231, 255, 0.22);
        }

        .feature__icon svg { width: 1.25rem; height: 1.25rem; }

        .feature span {
            font-size: 0.72rem;
            font-weight: 600;
            line-height: 1.35;
            color: rgba(255, 255, 255, 0.95);
        }

        .brand__tagline {
            margin-top: 1.7rem;
            font-size: clamp(0.95rem, 1.8vw, 1.2rem);
            font-weight: 600;
            direction: rtl;
        }

        .brand__tagline::after {
            content: '';
            display: block;
            width: 3rem;
            height: 2px;
            margin: 0.5rem auto 0;
            background: linear-gradient(90deg, transparent, var(--gold-bright), transparent);
            border-radius: 2px;
        }

        /* —— Panneau de connexion lumineux —— */
        .login-card {
            position: relative;
            width: min(440px, 36vw);
            direction: ltr;
            background: linear-gradient(168deg, rgba(8, 26, 64, 0.72) 0%, rgba(2, 12, 34, 0.82) 100%);
            border-radius: 1.15rem;
            padding: 2rem 1.8rem 1.5rem;
            backdrop-filter: blur(14px) saturate(1.2);
            -webkit-backdrop-filter: blur(14px) saturate(1.2);
            border: 1px solid rgba(110, 231, 255, 0.3);
            box-shadow:
                0 0 26px rgba(110, 231, 255, 0.2),
                0 0 60px rgba(62, 140, 255, 0.14),
                0 22px 48px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(200, 240, 255, 0.16);
            animation: card-in 0.9s cubic-bezier(0.22, 1, 0.36, 1) 0.15s both;
        }

        /* Bordure lumineuse animée */
        .login-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(
                135deg,
                rgba(110, 231, 255, 0.7),
                rgba(110, 231, 255, 0.08) 30%,
                rgba(240, 193, 75, 0.45) 55%,
                rgba(110, 231, 255, 0.1) 80%,
                rgba(110, 231, 255, 0.6)
            );
            background-size: 250% 250%;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            animation: border-flow 7s linear infinite;
            pointer-events: none;
        }

        @keyframes border-flow {
            from { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            to   { background-position: 0% 50%; }
        }

        /* Halo supérieur */
        .login-card::after {
            content: '';
            position: absolute;
            top: -28%;
            left: 12%;
            width: 76%;
            height: 50%;
            background: radial-gradient(ellipse at center, rgba(110, 231, 255, 0.18), transparent 70%);
            filter: blur(20px);
            animation: halo-pulse 4.5s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes halo-pulse {
            from { opacity: 0.4; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1.06); }
        }

        .login-card > * { position: relative; z-index: 1; }

        .login-card__logo {
            width: 88px;
            margin: 0 auto 0.6rem;
        }

        .login-card__logo img {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(0 0 18px rgba(110, 231, 255, 0.35));
        }

        .login-card__head {
            text-align: center;
            margin-bottom: 1.2rem;
            direction: ltr;
        }

        .login-card__head h1 {
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            background: linear-gradient(120deg, #f6e27a 0%, var(--gold-bright) 35%, #fff5d6 55%, var(--gold) 80%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 18px rgba(240, 193, 75, 0.35));
        }

        .login-card__head p {
            margin-top: 0.3rem;
            font-size: 0.85rem;
            color: #dbe9fb;
            font-weight: 600;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            direction: ltr;
        }

        .field { position: relative; }

        .field input,
        .field select {
            width: 100%;
            padding: 0.82rem 2.6rem;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 0.8rem;
            background: rgba(255, 255, 255, 0.07);
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 500;
            color: #f6faff;
            outline: none;
            text-align: left;
            direction: ltr;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .field input::placeholder { color: rgba(225, 236, 250, 0.62); }

        .field select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
        }

        .field select:invalid { color: rgba(225, 236, 250, 0.62); }

        .field select option {
            background: #0a1f44;
            color: #f6faff;
        }

        .field input:hover,
        .field select:hover {
            border-color: rgba(240, 193, 75, 0.5);
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--cyan);
            background: rgba(255, 255, 255, 0.11);
            box-shadow:
                0 0 0 3px rgba(110, 231, 255, 0.18),
                0 0 20px rgba(110, 231, 255, 0.32);
        }

        .field__icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 1.15rem;
            height: 1.15rem;
            color: var(--gold-bright);
            pointer-events: none;
        }

        .field__icon--start { left: 0.9rem; }

        .field__icon--end {
            right: 0.9rem;
            left: auto;
            pointer-events: auto;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: grid;
            place-items: center;
            color: rgba(220, 235, 250, 0.75);
        }

        .field__icon--end:hover { color: var(--cyan); }

        .field__icon--chevron {
            pointer-events: none;
            color: rgba(220, 235, 250, 0.75);
        }

        .field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            font-size: 0.8rem;
            direction: ltr;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #e4eefb;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            width: 0.95rem;
            height: 0.95rem;
            accent-color: var(--gold-bright);
        }

        .forgot {
            color: var(--gold-bright);
            text-decoration: none;
            font-weight: 700;
        }

        .forgot:hover {
            color: #fff;
            text-shadow: 0 0 12px rgba(240, 193, 75, 0.65);
        }

        .btn-login {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.82rem 1rem;
            border: none;
            border-radius: 0.65rem;
            background: linear-gradient(135deg, #7deaff 0%, #3ec8e8 55%, #1f8fc9 100%);
            color: #02203a;
            font-family: inherit;
            font-size: 0.98rem;
            font-weight: 800;
            cursor: pointer;
            overflow: hidden;
            box-shadow:
                0 0 22px rgba(110, 231, 255, 0.45),
                0 10px 26px rgba(30, 140, 210, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
        }

        /* reflet balayant le bouton */
        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -60%;
            width: 45%;
            height: 100%;
            background: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.55), transparent);
            transform: skewX(-20deg);
            animation: btn-sheen 3.6s ease-in-out 1.2s infinite;
        }

        @keyframes btn-sheen {
            0%   { left: -60%; }
            35%  { left: 120%; }
            100% { left: 120%; }
        }

        .btn-login:hover {
            transform: translateY(-1px);
            filter: brightness(1.06);
            box-shadow:
                0 0 32px rgba(110, 231, 255, 0.65),
                0 14px 32px rgba(30, 140, 210, 0.45);
        }

        .btn-login svg { width: 1.1rem; height: 1.1rem; }

        .signup {
            text-align: center;
            font-size: 0.82rem;
            color: #e4eefb;
            font-weight: 500;
        }

        .signup a {
            color: var(--cyan);
            font-weight: 700;
            text-decoration: none;
        }

        .signup a:hover {
            color: #fff;
            text-shadow: 0 0 12px rgba(110, 231, 255, 0.6);
        }

        .login-card__foot {
            margin-top: 0.95rem;
            padding-top: 0.7rem;
            border-top: 1px solid rgba(240, 193, 75, 0.25);
            text-align: center;
            font-size: 0.7rem;
            font-weight: 500;
            color: #c9d9ef;
            direction: ltr;
        }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes card-in {
            from { opacity: 0; transform: translateX(-22px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 900px) {
            html, body { overflow: auto; }

            .landing {
                height: auto;
                min-height: 100vh;
                min-height: 100dvh;
            }

            .landing__grid {
                flex-direction: column;
                justify-content: flex-start;
                padding: 2rem 1rem 1.5rem;
                gap: 1.5rem;
            }

            .brand {
                position: static;
                transform: none;
                width: 100%;
                max-width: none;
                margin-top: 0;
            }

            .login-card {
                max-width: 420px;
                width: 100%;
                margin: 0 auto;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .star, .shooting-star, .login-card, .login-card::before, .login-card::after,
            .btn-login::after, .brand { animation: none; }
        }
    </style>
</head>
<body>
    <div class="landing">
        <div class="landing__bg" aria-hidden="true"></div>

        <div class="stars" aria-hidden="true">
            <span class="star" style="top:8%; left:48%; width:3px; height:3px; --d:2.6s; --t:0.2s;"></span>
            <span class="star star--gold" style="top:14%; left:62%; width:2px; height:2px; --d:3.4s; --t:1.1s;"></span>
            <span class="star" style="top:6%; left:72%; width:2px; height:2px; --d:2.9s; --t:0.6s;"></span>
            <span class="star" style="top:18%; left:80%; width:3px; height:3px; --d:3.8s; --t:0.3s;"></span>
            <span class="star star--gold" style="top:9%; left:88%; width:2px; height:2px; --d:2.4s; --t:1.6s;"></span>
            <span class="star" style="top:26%; left:56%; width:2px; height:2px; --d:3.1s; --t:0.9s;"></span>
            <span class="star" style="top:32%; left:68%; width:2px; height:2px; --d:2.7s; --t:1.4s;"></span>
            <span class="star star--gold" style="top:28%; left:90%; width:3px; height:3px; --d:3.6s; --t:0.5s;"></span>
            <span class="star" style="top:40%; left:60%; width:2px; height:2px; --d:2.8s; --t:1.9s;"></span>
            <span class="star" style="top:45%; left:76%; width:2px; height:2px; --d:3.3s; --t:0.7s;"></span>
            <span class="star" style="top:12%; left:35%; width:2px; height:2px; --d:3s; --t:1.2s;"></span>
            <span class="star star--gold" style="top:5%; left:22%; width:2px; height:2px; --d:2.5s; --t:0.4s;"></span>
            <span class="star" style="top:52%; left:85%; width:2px; height:2px; --d:3.7s; --t:1s;"></span>
            <span class="star" style="top:60%; left:70%; width:2px; height:2px; --d:2.6s; --t:0.8s;"></span>
            <span class="star star--gold" style="top:55%; left:94%; width:2px; height:2px; --d:3.2s; --t:1.5s;"></span>
        </div>
        <span class="shooting-star" aria-hidden="true"></span>

        <div class="landing__grid">
            <section class="brand" aria-label="L'HORIZON">
                <div class="brand__logo">
                    <img
                        src="{{ asset('images/horizon-logo.png') }}?v={{ filemtime(public_path('images/horizon-logo.png')) }}"
                        alt="Logo L'HORIZON"
                        width="190"
                        height="190"
                    >
                </div>

                <h1 class="brand__title">L’HORIZON</h1>
                <p class="brand__ar">مركز <span class="gold">أفق</span> للعلوم و المعرفة</p>
                <p class="brand__slogan">Votre avenir, notre horizon</p>

                <div class="features">
                    <div class="feature">
                        <div class="feature__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M2 9l10-5 10 5-10 5L2 9z"/>
                                <path d="M6 11.5v4.5c0 1.5 2.7 3 6 3s6-1.5 6-3v-4.5"/>
                                <path d="M22 9v6"/>
                            </svg>
                        </div>
                        <span>تكوين بجودة عالية</span>
                    </div>
                    <div class="feature">
                        <div class="feature__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M4 5h7a3 3 0 013 3v11H7a3 3 0 01-3-3V5z"/>
                                <path d="M20 5h-7a3 3 0 00-3 3v11h7a3 3 0 003-3V5z"/>
                            </svg>
                        </div>
                        <span>برامج متنوعة</span>
                    </div>
                    <div class="feature">
                        <div class="feature__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <circle cx="9" cy="8" r="3"/>
                                <circle cx="16" cy="9" r="2.5"/>
                                <path d="M3 19c0-2.8 2.7-5 6-5s6 2.2 6 5"/>
                                <path d="M14 19c0-1.8 1.6-3.3 3.8-3.8"/>
                            </svg>
                        </div>
                        <span>مهنيون متخصصون</span>
                    </div>
                    <div class="feature">
                        <div class="feature__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <circle cx="12" cy="8" r="5"/>
                                <path d="M9 12.5l-2 7 5-2.5 5 2.5-2-7"/>
                            </svg>
                        </div>
                        <span>شهادات معتمدة</span>
                    </div>
                </div>

                <p class="brand__tagline">تعلم اليوم ... لتقود الغد</p>
            </section>

            <aside class="login-card" aria-labelledby="login-heading">
                <div class="login-card__logo">
                    <img src="{{ asset('images/horizon-logo.png') }}?v={{ filemtime(public_path('images/horizon-logo.png')) }}" alt="" aria-hidden="true">
                </div>

                <div class="login-card__head">
                    <h1 id="login-heading">BIENVENUS</h1>
                    <p>L'ORIZON, La solution qui Gère</p>
                </div>

                <form class="login-form" method="POST" action="{{ route('login.attempt') }}">
                    @csrf

                    <div class="field">
                        <svg class="field__icon field__icon--start" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path d="M12 3l8 4v5c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V7l8-4z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                        <select id="role" name="role" required>
                            <option value="" disabled selected>Sélectionnez votre statut</option>
                            <option value="administration">Administration</option>
                            <option value="professeur">Professeur</option>
                            <option value="parental">Parental</option>
                        </select>
                        <svg class="field__icon field__icon--end field__icon--chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>

                    <div class="field">
                        <svg class="field__icon field__icon--start" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.5"/>
                            <path d="M5 19c0-3.3 3.1-6 7-6s7 2.7 7 6"/>
                        </svg>
                        <input
                            id="email"
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            placeholder="E-mail ou nom d'utilisateur"
                            required
                            autofocus
                        >
                    </div>

                    <div class="field">
                        <svg class="field__icon field__icon--start" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <rect x="5" y="11" width="14" height="10" rx="2"/>
                            <path d="M8 11V8a4 4 0 118 0v3"/>
                        </svg>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Mot de passe"
                            required
                        >
                        <button type="button" class="field__icon field__icon--end" id="toggle-password" aria-label="Afficher le mot de passe">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" width="18" height="18">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>

                    <div class="field-row">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            Se souvenir de moi
                        </label>
                        <a class="forgot" href="#">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn-login">
                        Se connecter
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                            <path d="M21 5v14a2 2 0 01-2 2h-4"/>
                        </svg>
                    </button>

                    <p class="signup">
                        Pas encore de compte ?
                        <a href="#">Inscrivez-vous</a>
                    </p>
                </form>

                <p class="login-card__foot">
                    © A2S — Solution qui Gère. Tous Droits Réservés.
                </p>
            </aside>
        </div>
    </div>

    <script>
        document.getElementById('toggle-password')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>
