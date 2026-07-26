<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration — L'HORIZON / A2S</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #eaf4fb;
            --bg-deep: #d7ebf7;
            --surface: #ffffff;
            --surface-soft: #f3f9fd;
            --primary: #1a7fc2;
            --primary-deep: #0e5f96;
            --accent: #2db6e4;
            --accent-soft: rgba(45, 182, 228, 0.14);
            --gold: #d4a017;
            --gold-bright: #e8b923;
            --cyan: #2db6e4;
            --cyan-soft: rgba(45, 182, 228, 0.14);
            --text: #143a58;
            --muted: #5d7f99;
            --line: rgba(20, 90, 140, 0.12);
            --danger: #e0455a;
            --navy: #eaf4fb;
            --navy-mid: #ffffff;
            --navy-soft: #e3f1fa;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font: 'Outfit', sans-serif;
            --sidebar-w: 280px;
            --nav-h: 72px;
            --shadow: 0 10px 28px rgba(30, 100, 150, 0.1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            min-height: 100%;
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
        }

        body {
            background:
                radial-gradient(ellipse 70% 50% at 8% -5%, rgba(45, 182, 228, 0.22), transparent 55%),
                radial-gradient(ellipse 55% 45% at 100% 0%, rgba(26, 127, 194, 0.14), transparent 50%),
                linear-gradient(165deg, #f4faff 0%, #e5f3fb 48%, #d9ecf8 100%);
            min-height: 100vh;
            min-height: 100dvh;
        }

        .app {
            display: grid;
            grid-template-columns: var(--sidebar-w) 1fr;
            grid-template-rows: var(--nav-h) 1fr;
            min-height: 100vh;
            min-height: 100dvh;
        }

        /* ——— Navbar ——— */
        .navbar {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            padding: 0 1.5rem 0 1.1rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(243, 249, 253, 0.94));
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(16px);
            box-shadow: 0 4px 20px rgba(30, 100, 150, 0.06);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .navbar__brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 0;
        }

        .navbar__logo {
            height: 48px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(26, 127, 194, 0.2));
        }

        .navbar__title-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            min-width: 0;
        }

        .navbar__eyebrow {
            font-size: 0.68rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--primary);
            font-weight: 600;
        }

        .navbar__title {
            font-family: var(--font-display);
            font-size: clamp(1.15rem, 2vw, 1.55rem);
            font-weight: 700;
            line-height: 1.15;
            background: linear-gradient(90deg, var(--primary-deep) 10%, var(--accent) 70%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .navbar__profile {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.35rem 0.45rem 0.35rem 0.9rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--line);
            box-shadow: 0 4px 14px rgba(30, 100, 150, 0.08);
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .navbar__profile:hover {
            background: #fff;
            border-color: rgba(45, 182, 228, 0.4);
            box-shadow: 0 6px 18px rgba(45, 182, 228, 0.16);
        }

        .navbar__profile-meta {
            text-align: right;
        }

        .navbar__profile-name {
            font-size: 0.92rem;
            font-weight: 600;
            line-height: 1.2;
            color: var(--text);
        }

        .navbar__profile-role {
            font-size: 0.72rem;
            color: var(--muted);
            letter-spacing: 0.04em;
        }

        .navbar__avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(45, 182, 228, 0.55);
            box-shadow: 0 0 0 3px rgba(26, 127, 194, 0.12), 0 6px 14px rgba(30, 100, 150, 0.15);
        }

        .menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--text);
            cursor: pointer;
        }

        /* ——— Sidebar ——— */
        .sidebar {
            grid-row: 2;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            padding: 1.25rem 0.9rem 1.5rem;
            background: linear-gradient(180deg, #ffffff 0%, #f0f8fc 100%);
            border-right: 1px solid var(--line);
            box-shadow: 6px 0 24px rgba(30, 100, 150, 0.05);
            overflow-y: auto;
        }

        .sidebar__label {
            position: relative;
            padding: 0.55rem 0.85rem 1rem;
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: none;
            line-height: 1.15;
            background: linear-gradient(92deg, var(--primary-deep) 5%, var(--accent) 55%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .sidebar__label::after {
            content: '';
            position: absolute;
            left: 0.85rem;
            bottom: 0.45rem;
            width: 2.75rem;
            height: 2px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--primary), var(--accent), transparent);
            box-shadow: 0 0 10px rgba(45, 182, 228, 0.35);
        }

        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            width: 100%;
            padding: 0.85rem 0.95rem;
            border: 1px solid transparent;
            border-radius: 14px;
            background: transparent;
            color: var(--muted);
            font: inherit;
            font-size: 0.92rem;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            transition: color 0.2s, background 0.2s, border-color 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        .nav-item__icon {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: rgba(26, 127, 194, 0.06);
            border: 1px solid var(--line);
            color: var(--primary);
            flex-shrink: 0;
            transition: background 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s;
        }

        .nav-item__icon svg {
            width: 18px;
            height: 18px;
        }

        .nav-item__text {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
            min-width: 0;
        }

        .nav-item__title {
            line-height: 1.2;
        }

        .nav-item__hint {
            font-size: 0.68rem;
            color: rgba(93, 127, 153, 0.85);
            font-weight: 400;
        }

        .nav-item:hover {
            color: var(--primary-deep);
            background: rgba(45, 182, 228, 0.08);
            border-color: rgba(45, 182, 228, 0.22);
            transform: translateX(3px);
        }

        .nav-item:hover .nav-item__icon {
            background: var(--accent-soft);
            border-color: rgba(45, 182, 228, 0.4);
            box-shadow: 0 0 14px rgba(45, 182, 228, 0.2);
        }

        .nav-item.is-active {
            color: var(--primary-deep);
            background: linear-gradient(120deg, rgba(45, 182, 228, 0.16), rgba(26, 127, 194, 0.1));
            border-color: rgba(45, 182, 228, 0.35);
            box-shadow: 0 8px 22px rgba(30, 100, 150, 0.1);
        }

        .nav-item.is-active::before {
            content: '';
            position: absolute;
            left: -0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 55%;
            border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, var(--accent), var(--primary));
            box-shadow: 0 0 10px rgba(45, 182, 228, 0.45);
        }

        .nav-item.is-active .nav-item__icon {
            background: linear-gradient(145deg, rgba(45, 182, 228, 0.28), rgba(26, 127, 194, 0.16));
            border-color: rgba(26, 127, 194, 0.35);
            color: var(--primary-deep);
            box-shadow: 0 0 14px rgba(45, 182, 228, 0.25);
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .nav-group__toggle .nav-item__chevron {
            margin-left: auto;
            display: grid;
            place-items: center;
            width: 22px;
            height: 22px;
            color: var(--muted);
            transition: transform 0.22s ease, color 0.2s;
            flex-shrink: 0;
        }

        .nav-group__toggle .nav-item__chevron svg {
            width: 14px;
            height: 14px;
        }

        .nav-group.is-open > .nav-group__toggle .nav-item__chevron {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .nav-group.is-open > .nav-group__toggle {
            color: var(--primary-deep);
            background: rgba(45, 182, 228, 0.08);
            border-color: rgba(45, 182, 228, 0.22);
        }

        .nav-group.is-active-section > .nav-group__toggle {
            color: var(--primary-deep);
            background: linear-gradient(120deg, rgba(45, 182, 228, 0.16), rgba(26, 127, 194, 0.1));
            border-color: rgba(45, 182, 228, 0.35);
            box-shadow: 0 8px 22px rgba(30, 100, 150, 0.1);
        }

        .nav-group.is-active-section > .nav-group__toggle::before {
            content: '';
            position: absolute;
            left: -0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 55%;
            border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, var(--accent), var(--primary));
            box-shadow: 0 0 10px rgba(45, 182, 228, 0.45);
        }

        .nav-group.is-active-section > .nav-group__toggle .nav-item__icon {
            background: linear-gradient(145deg, rgba(45, 182, 228, 0.28), rgba(26, 127, 194, 0.16));
            border-color: rgba(26, 127, 194, 0.35);
            color: var(--primary-deep);
            box-shadow: 0 0 14px rgba(45, 182, 228, 0.25);
        }

        .panel-placeholder {
            border-radius: 22px;
            padding: 1.5rem 1.6rem;
            background: linear-gradient(180deg, #ffffff 0%, #f3f9fd 100%);
            border: 1px solid rgba(45, 182, 228, 0.22);
            box-shadow: 0 12px 32px rgba(30, 100, 150, 0.1);
        }

        .panel-placeholder p {
            margin-top: 0.45rem;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .nav-group:not(:has(.nav-sub)) .nav-item__chevron {
            display: none;
        }

        .nav-sub {
            display: none;
            flex-direction: column;
            gap: 0.15rem;
            padding: 0.15rem 0 0.35rem 0.55rem;
            margin-left: 1.15rem;
            border-left: 2px solid rgba(45, 182, 228, 0.28);
        }

        .nav-group.is-open > .nav-sub {
            display: flex;
            animation: panel-in 0.28s ease both;
        }

        .nav-sub__item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            width: 100%;
            padding: 0.55rem 0.7rem;
            border: 1px solid transparent;
            border-radius: 12px;
            background: transparent;
            color: var(--muted);
            font: inherit;
            font-size: 0.86rem;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            transition: color 0.2s, background 0.2s, border-color 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        .nav-sub__item:hover {
            color: var(--primary-deep);
            background: rgba(45, 182, 228, 0.08);
            border-color: rgba(45, 182, 228, 0.18);
            transform: translateX(2px);
        }

        .nav-sub__item.is-active {
            color: var(--primary-deep);
            background: linear-gradient(120deg, rgba(45, 182, 228, 0.16), rgba(26, 127, 194, 0.1));
            border-color: rgba(45, 182, 228, 0.32);
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(30, 100, 150, 0.08);
        }

        .nav-sub__icon {
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border-radius: 9px;
            flex-shrink: 0;
            background: rgba(26, 127, 194, 0.07);
            border: 1px solid rgba(45, 182, 228, 0.22);
            color: var(--primary);
            transition: background 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
        }

        .nav-sub__icon svg {
            width: 15px;
            height: 15px;
        }

        .nav-sub__item:hover .nav-sub__icon {
            background: var(--accent-soft);
            border-color: rgba(45, 182, 228, 0.45);
            color: var(--primary-deep);
            box-shadow: 0 0 12px rgba(45, 182, 228, 0.22);
            transform: scale(1.05);
        }

        .nav-sub__item.is-active .nav-sub__icon {
            background: linear-gradient(145deg, rgba(45, 182, 228, 0.32), rgba(26, 127, 194, 0.18));
            border-color: rgba(26, 127, 194, 0.4);
            color: var(--primary-deep);
            box-shadow: 0 0 14px rgba(45, 182, 228, 0.28);
        }

        .nav-sub__item[data-section="fiche-centre"] .nav-sub__icon { color: #1a7fc2; }
        .nav-sub__item[data-section="documents-administratifs"] .nav-sub__icon { color: #0e8a6a; }
        .nav-sub__item[data-section="parametres-financiers"] .nav-sub__icon { color: #c48a12; }
        .nav-sub__item[data-section="calendrier-academique"] .nav-sub__icon { color: #c94d5c; }
        .nav-sub__item[data-section="filieres-specialites"] .nav-sub__icon { color: #6b5ce0; }
        .nav-sub__item[data-section="fiche-eleve"] .nav-sub__icon { color: #1a7fc2; }
        .nav-sub__item[data-section="affectation-suivi"] .nav-sub__icon { color: #0e8a6a; }
        .nav-sub__item[data-section="discipline"] .nav-sub__icon { color: #c94d5c; }
        .nav-sub__item[data-section="notes-evaluations"] .nav-sub__icon { color: #c48a12; }
        .nav-sub__item[data-section="rapports-etudiants"] .nav-sub__icon { color: #6b5ce0; }
        .nav-sub__item[data-section="frais-formation"] .nav-sub__icon { color: #1a7fc2; }
        .nav-sub__item[data-section="tresorerie"] .nav-sub__icon { color: #0e8a6a; }
        .nav-sub__item[data-section="rapports-financiers"] .nav-sub__icon { color: #6b5ce0; }
        .nav-sub__item[data-section="relances"] .nav-sub__icon { color: #c94d5c; }
        .nav-sub__item[data-section="echeancier"] .nav-sub__icon { color: #c48a12; }
        .nav-sub__item[data-section="fiche-prof"] .nav-sub__icon { color: #1a7fc2; }
        .nav-sub__item[data-section="liste-recrutement"] .nav-sub__icon { color: #0e8a6a; }
        .nav-sub__item[data-section="affectation-cours"] .nav-sub__icon { color: #6b5ce0; }
        .nav-sub__item[data-section="emploi-temps"] .nav-sub__icon { color: #c48a12; }
        .nav-sub__item[data-section="gestion-remplacements"] .nav-sub__icon { color: #c94d5c; }
        .nav-sub__item[data-section="rapports-profs"] .nav-sub__icon { color: #2db6e4; }

        .form-window {
            border-radius: 22px;
            padding: 1.5rem 1.6rem 1.7rem;
            background: linear-gradient(180deg, #ffffff 0%, #f3f9fd 100%);
            border: 1px solid rgba(45, 182, 228, 0.22);
            box-shadow: 0 12px 32px rgba(30, 100, 150, 0.1);
        }

        .form-window__head {
            margin-bottom: 1.35rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--line);
        }

        .form-window__title {
            font-family: var(--font-display);
            font-size: clamp(1.45rem, 2.4vw, 1.9rem);
            font-weight: 700;
            background: linear-gradient(92deg, var(--primary-deep) 5%, var(--accent) 55%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .form-window__desc {
            margin-top: 0.4rem;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .form-alert {
            margin-bottom: 1.1rem;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-alert--success {
            color: #1a7a5c;
            background: rgba(34, 170, 130, 0.1);
            border: 1px solid rgba(34, 170, 130, 0.28);
        }

        .form-alert--error {
            color: #b83245;
            background: rgba(224, 69, 90, 0.08);
            border: 1px solid rgba(224, 69, 90, 0.25);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 1.35rem 1.5rem;
            align-items: start;
        }

        .form-photo {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .form-photo__preview {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            border-radius: 18px;
            overflow: hidden;
            background:
                linear-gradient(145deg, rgba(45, 182, 228, 0.08), rgba(26, 127, 194, 0.05)),
                #fff;
            border: 1px dashed rgba(45, 182, 228, 0.45);
            display: grid;
            place-items: center;
            box-shadow: 0 8px 22px rgba(30, 100, 150, 0.08);
        }

        .form-photo__preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .form-photo__preview.has-image img { display: block; }
        .form-photo__preview.has-image .form-photo__placeholder { display: none; }

        .form-photo__placeholder {
            text-align: center;
            padding: 1rem;
            color: var(--muted);
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .form-photo__placeholder strong {
            display: block;
            margin-bottom: 0.25rem;
            color: var(--primary-deep);
            font-size: 0.9rem;
        }

        .form-photo__btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            width: 100%;
            padding: 0.7rem 0.9rem;
            border-radius: 12px;
            border: 1px solid rgba(45, 182, 228, 0.35);
            background: #fff;
            color: var(--primary-deep);
            font: inherit;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
        }

        .form-photo__btn:hover {
            background: rgba(45, 182, 228, 0.08);
            border-color: rgba(26, 127, 194, 0.45);
            box-shadow: 0 6px 16px rgba(45, 182, 228, 0.15);
        }

        .form-photo input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            overflow: hidden;
        }

        .form-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.95rem 1rem;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-field--full {
            grid-column: 1 / -1;
        }

        .form-field label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--primary-deep);
        }

        .form-field input,
        .form-field textarea {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border-radius: 12px;
            border: 1px solid rgba(45, 182, 228, 0.28);
            background: #fff;
            color: var(--text);
            font: inherit;
            font-size: 0.92rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(30, 100, 150, 0.05);
        }

        .form-field textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.5;
        }

        .form-field input:focus,
        .form-field textarea:focus {
            border-color: rgba(26, 127, 194, 0.55);
            box-shadow: 0 0 0 3px rgba(45, 182, 228, 0.18);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.35rem;
            padding-top: 1.1rem;
            border-top: 1px solid var(--line);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            border: 1px solid transparent;
            font: inherit;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.2s, background 0.2s, border-color 0.2s;
        }

        .btn:active { transform: translateY(1px); }

        .btn--primary {
            color: #fff;
            background: linear-gradient(135deg, var(--accent), var(--primary-deep));
            box-shadow: 0 8px 22px rgba(26, 127, 194, 0.28);
        }

        .btn--primary:hover {
            box-shadow: 0 10px 26px rgba(26, 127, 194, 0.36);
        }

        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-photo {
                max-width: 240px;
            }
        }

        @media (max-width: 640px) {
            .form-fields {
                grid-template-columns: 1fr;
            }
        }

        .sidebar__foot {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .sidebar__logout-form {
            width: 100%;
        }

        .sidebar__logout {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            width: 100%;
            padding: 0.85rem 0.95rem;
            border-radius: 14px;
            border: 1px solid rgba(224, 69, 90, 0.22);
            background: linear-gradient(135deg, rgba(224, 69, 90, 0.08), rgba(255, 255, 255, 0.9));
            color: #b83245;
            font: inherit;
            font-size: 0.92rem;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s, background 0.2s, box-shadow 0.2s, color 0.2s;
            box-shadow: 0 4px 14px rgba(224, 69, 90, 0.08);
        }

        .sidebar__logout:hover {
            transform: translateY(-1px);
            color: #fff;
            border-color: rgba(224, 69, 90, 0.45);
            background: linear-gradient(135deg, #e0455a, #c9364a);
            box-shadow: 0 8px 22px rgba(224, 69, 90, 0.25);
        }

        .sidebar__logout:active {
            transform: translateY(0);
        }

        .sidebar__logout-icon {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: rgba(224, 69, 90, 0.1);
            border: 1px solid rgba(224, 69, 90, 0.28);
            color: #e0455a;
            flex-shrink: 0;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .sidebar__logout:hover .sidebar__logout-icon {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.35);
            color: #fff;
        }

        .sidebar__logout-icon svg {
            width: 18px;
            height: 18px;
        }

        .sidebar__logout-text {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
            min-width: 0;
        }

        .sidebar__logout-title {
            line-height: 1.2;
        }

        .sidebar__logout-hint {
            font-size: 0.68rem;
            font-weight: 400;
            color: rgba(184, 50, 69, 0.7);
        }

        .sidebar__logout:hover .sidebar__logout-hint {
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar__credit {
            padding: 0 0.85rem 0.15rem;
            font-size: 0.72rem;
            color: var(--muted);
        }

        /* ——— Main ——— */
        .main {
            grid-row: 2;
            padding: 1.75rem 1.75rem 2rem;
            overflow: auto;
        }

        .panel {
            display: none;
            animation: panel-in 0.35s ease both;
        }

        .panel.is-visible { display: block; }

        @keyframes panel-in {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .panel__hero {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .panel__hero--compact {
            justify-content: flex-end;
            margin-bottom: 1.15rem;
        }

        .panel__eyebrow {
            font-size: 0.72rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--cyan);
            font-weight: 600;
            margin-bottom: 0.45rem;
        }

        .panel__title {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 700;
            line-height: 1.1;
        }

        .panel__desc {
            margin-top: 0.55rem;
            max-width: 42rem;
            color: var(--muted);
            font-size: 0.95rem;
            line-height: 1.55;
        }

        .panel__badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: var(--gold-bright);
            background: rgba(212, 160, 23, 0.12);
            border: 1px solid rgba(240, 193, 75, 0.28);
        }

        .analytics-sticky {
            position: sticky;
            top: 0;
            z-index: 20;
            margin: -0.25rem 0 1.35rem;
            padding: 0.35rem 0 1rem;
            background:
                linear-gradient(180deg, rgba(234, 244, 251, 0.97) 55%, rgba(234, 244, 251, 0.88) 85%, transparent);
            backdrop-filter: blur(10px);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .stats--paiement,
        .stats--profs {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .stats__title {
            font-family: var(--font-display);
            font-size: clamp(1.25rem, 2.2vw, 1.65rem);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.95rem;
            background: linear-gradient(92deg, var(--primary-deep) 5%, var(--accent) 55%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat {
            position: relative;
            overflow: hidden;
            padding: 1.1rem 1.05rem;
            border-radius: 18px;
            background: linear-gradient(160deg, #ffffff 0%, #f0f8fc 100%);
            border: 1px solid rgba(45, 182, 228, 0.28);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.8) inset,
                0 8px 24px rgba(30, 100, 150, 0.1),
                0 0 20px rgba(45, 182, 228, 0.12);
            animation: card-glow 3.6s ease-in-out infinite alternate;
        }

        .stat::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(120deg, transparent 20%, rgba(255, 255, 255, 0.65) 48%, transparent 72%);
            transform: translateX(-120%);
            animation: card-shine 5s ease-in-out infinite;
            pointer-events: none;
        }

        .stat::after {
            content: '';
            position: absolute;
            inset: auto -18% -42% auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 182, 228, 0.22), transparent 70%);
            pointer-events: none;
        }

        .stat:nth-child(2) {
            animation-delay: 0.35s;
            border-color: rgba(26, 127, 194, 0.3);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.8) inset,
                0 8px 24px rgba(26, 127, 194, 0.12),
                0 0 18px rgba(26, 127, 194, 0.12);
        }

        .stat:nth-child(3) { animation-delay: 0.7s; }
        .stat:nth-child(4) {
            animation-delay: 1.05s;
            border-color: rgba(224, 69, 90, 0.25);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.8) inset,
                0 8px 24px rgba(224, 69, 90, 0.1),
                0 0 16px rgba(224, 69, 90, 0.1);
        }
        .stat:nth-child(5) {
            animation-delay: 1.4s;
            border-color: rgba(34, 170, 130, 0.28);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.8) inset,
                0 8px 24px rgba(34, 170, 130, 0.1),
                0 0 16px rgba(34, 170, 130, 0.1);
        }

        @keyframes card-glow {
            from {
                filter: brightness(1);
                transform: translateY(0);
            }
            to {
                filter: brightness(1.08);
                transform: translateY(-1px);
            }
        }

        @keyframes card-shine {
            0%, 55% { transform: translateX(-120%); opacity: 0; }
            60% { opacity: 0.7; }
            75% { transform: translateX(120%); opacity: 0; }
            100% { transform: translateX(120%); opacity: 0; }
        }

        .stat__label {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            max-width: 100%;
            margin-bottom: 0.7rem;
            padding: 0.28rem 0.65rem 0.28rem 0.55rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            line-height: 1.25;
            color: var(--primary-deep);
            background: linear-gradient(90deg, rgba(45, 182, 228, 0.14), rgba(26, 127, 194, 0.08));
            border: 1px solid rgba(45, 182, 228, 0.28);
            position: relative;
            z-index: 1;
            box-shadow: 0 2px 8px rgba(30, 100, 150, 0.06);
        }

        .stat__label::before {
            content: '';
            width: 0.4rem;
            height: 0.4rem;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            box-shadow: 0 0 8px rgba(45, 182, 228, 0.55);
        }

        .stat:nth-child(2) .stat__label {
            color: #0e5f96;
            background: linear-gradient(90deg, rgba(26, 127, 194, 0.14), rgba(14, 95, 150, 0.06));
            border-color: rgba(26, 127, 194, 0.3);
        }

        .stat:nth-child(4) .stat__label {
            color: #b83245;
            background: linear-gradient(90deg, rgba(224, 69, 90, 0.12), rgba(224, 69, 90, 0.05));
            border-color: rgba(224, 69, 90, 0.25);
        }

        .stat:nth-child(4) .stat__label::before {
            background: linear-gradient(135deg, #ff7a8a, #e0455a);
            box-shadow: 0 0 8px rgba(224, 69, 90, 0.45);
        }

        .stat:nth-child(5) .stat__label {
            color: #1a7a5c;
            background: linear-gradient(90deg, rgba(34, 170, 130, 0.12), rgba(34, 170, 130, 0.05));
            border-color: rgba(34, 170, 130, 0.28);
        }

        .stat:nth-child(5) .stat__label::before {
            background: linear-gradient(135deg, #3dd6a5, #1a9a72);
            box-shadow: 0 0 8px rgba(34, 170, 130, 0.45);
        }

        .stat__value {
            font-family: var(--font-display);
            font-size: clamp(1.45rem, 2vw, 1.9rem);
            font-weight: 700;
            line-height: 1;
            position: relative;
            z-index: 1;
            color: var(--text);
            letter-spacing: 0.02em;
            text-shadow: 0 0 14px rgba(45, 182, 228, 0.25);
            font-variant-numeric: tabular-nums;
        }

        .chart-panel {
            margin-top: 0.35rem;
            padding: 1.25rem 1.35rem 1.4rem;
            border-radius: 20px;
            background: linear-gradient(180deg, #ffffff 0%, #f3f9fd 100%);
            border: 1px solid rgba(45, 182, 228, 0.22);
            box-shadow: 0 12px 32px rgba(30, 100, 150, 0.1);
        }

        .chart-panel__head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            margin-bottom: 1rem;
        }

        .chart-panel__title {
            font-family: var(--font-display);
            font-size: clamp(1.2rem, 2vw, 1.5rem);
            font-weight: 700;
            background: linear-gradient(92deg, var(--primary-deep) 10%, var(--accent) 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .chart-panel__filters {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .chart-panel__filters label {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 600;
        }

        .chart-panel__filters select {
            appearance: none;
            -webkit-appearance: none;
            padding: 0.45rem 2rem 0.45rem 0.75rem;
            border-radius: 10px;
            border: 1px solid rgba(45, 182, 228, 0.35);
            background:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%231a7fc2' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 0.65rem center / 12px no-repeat,
                #fff;
            color: var(--text);
            font: inherit;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            box-shadow: 0 4px 12px rgba(30, 100, 150, 0.08);
        }

        .chart-panel__filters select:focus {
            border-color: rgba(26, 127, 194, 0.55);
            box-shadow: 0 0 0 3px rgba(45, 182, 228, 0.18);
        }

        .chart-panel__canvas-wrap {
            position: relative;
            height: min(360px, 52vh);
            width: 100%;
        }

        .workspace {
            border-radius: 22px;
            padding: 1.5rem;
            min-height: 280px;
            background:
                linear-gradient(135deg, rgba(95, 212, 232, 0.05), transparent 40%),
                linear-gradient(180deg, rgba(15, 32, 72, 0.72), rgba(7, 16, 40, 0.88));
            border: 1px solid var(--line);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.22);
        }

        .workspace h3 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 0.55rem;
        }

        .workspace p {
            color: var(--muted);
            line-height: 1.6;
            max-width: 46rem;
        }

        .workspace__grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.85rem;
            margin-top: 1.25rem;
        }

        .workspace__tile {
            padding: 1rem;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--line);
            transition: border-color 0.2s, transform 0.2s, background 0.2s;
        }

        .workspace__tile:hover {
            transform: translateY(-2px);
            border-color: rgba(95, 212, 232, 0.28);
            background: rgba(95, 212, 232, 0.06);
        }

        .workspace__tile strong {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .workspace__tile span {
            font-size: 0.78rem;
            color: var(--muted);
        }

        @media (max-width: 1200px) {
            .stats { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .stats--paiement,
            .stats--profs { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (max-width: 1100px) {
            .stats,
            .stats--paiement,
            .stats--profs { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 900px) {
            .app {
                grid-template-columns: 1fr;
            }

            .menu-toggle { display: inline-grid; place-items: center; }

            .sidebar {
                position: fixed;
                inset: var(--nav-h) auto 0 0;
                width: min(86vw, 300px);
                z-index: 30;
                transform: translateX(-105%);
                transition: transform 0.28s ease;
                box-shadow: 20px 0 40px rgba(0, 0, 0, 0.35);
            }

            .sidebar.is-open { transform: translateX(0); }

            .main { padding: 1.25rem; }

            .navbar__title { font-size: 1.05rem; }

            .navbar__profile-meta { display: none; }
        }

        @media (max-width: 560px) {
            .stats,
            .stats--paiement,
            .stats--profs { grid-template-columns: 1fr; }
            .navbar { padding-inline: 0.85rem; }
            .navbar__logo { height: 40px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .panel, .nav-item, .workspace__tile, .stat, .stat::before { animation: none; transition: none; }
        }
    </style>
</head>
<body>
    <div class="app" id="app">
        <header class="navbar">
            <div class="navbar__brand">
                <button type="button" class="menu-toggle" id="menu-toggle" aria-label="Ouvrir le menu">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
                <img
                    class="navbar__logo"
                    src="{{ asset('images/horizon-logo.png') }}?v={{ filemtime(public_path('images/horizon-logo.png')) }}"
                    alt="L'HORIZON"
                >
                <div class="navbar__title-wrap">
                    <span class="navbar__eyebrow">Centre L'ORIZON</span>
                    <h1 class="navbar__title">Tableau de bord Administration</h1>
                </div>
            </div>

            <div class="navbar__profile">
                <div class="navbar__profile-meta">
                    <div class="navbar__profile-name">{{ $user['name'] ?? 'Directeur général' }}</div>
                    <div class="navbar__profile-role">Profil administrateur</div>
                </div>
                <img
                    class="navbar__avatar"
                    src="{{ asset('images/admin-avatar.svg') }}"
                    alt="Photo de profil — Directeur général"
                >
            </div>
        </header>

        <aside class="sidebar" id="sidebar" aria-label="Navigation principale">
            <div class="sidebar__label">Tableau de Bord</div>

            @php
                $adminSections = [
                    'administration',
                    'fiche-centre',
                    'documents-administratifs',
                    'parametres-financiers',
                    'calendrier-academique',
                    'filieres-specialites',
                ];
                $currentSection = $activeSection ?? 'administration';
            @endphp

            <div class="nav-group {{ in_array($currentSection, $adminSections, true) ? 'is-open is-active-section' : '' }}" data-nav-group="administration">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'administration' ? 'is-active' : '' }}" data-section="administration" data-group-toggle aria-expanded="{{ in_array($currentSection, $adminSections, true) ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M3 21h18"/><path d="M5 21V8l7-4 7 4v13"/><path d="M9 21v-6h6v6"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Administration</span>
                        <span class="nav-item__hint">Pilotage général</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div class="nav-sub" role="group" aria-label="Sous-menus Administration">
                    <button type="button" class="nav-sub__item {{ $currentSection === 'fiche-centre' ? 'is-active' : '' }}" data-section="fiche-centre">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10.5L12 3l9 7.5"/>
                                <path d="M5 9.5V20a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V9.5"/>
                            </svg>
                        </span>
                        <span>Fiche Centre</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'documents-administratifs' ? 'is-active' : '' }}" data-section="documents-administratifs">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 3h6l5 5v12a1 1 0 01-1 1H8a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                                <path d="M14 3v5h5"/>
                                <path d="M10 13h6M10 17h4"/>
                            </svg>
                        </span>
                        <span>Documents administratifs</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'parametres-financiers' ? 'is-active' : '' }}" data-section="parametres-financiers">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="8"/>
                                <path d="M12 7v2.2"/>
                                <path d="M12 14.8V17"/>
                                <path d="M9.6 9.2c.5-.9 1.4-1.4 2.4-1.4 1.4 0 2.5.9 2.5 2.1 0 1.3-1 1.9-2.5 2.4s-2.5 1.1-2.5 2.5c0 1.3 1.1 2.2 2.6 2.2 1.1 0 2-.5 2.5-1.4"/>
                            </svg>
                        </span>
                        <span>Paramètres financiers</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'calendrier-academique' ? 'is-active' : '' }}" data-section="calendrier-academique">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="16" rx="2"/>
                                <path d="M3 10h18"/>
                                <path d="M8 3v4M16 3v4"/>
                                <path d="M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01"/>
                            </svg>
                        </span>
                        <span>Calendrier académique</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'filieres-specialites' ? 'is-active' : '' }}" data-section="filieres-specialites">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19V7l8-3 8 3v12"/>
                                <path d="M4 10l8 3 8-3"/>
                                <path d="M12 13v8"/>
                                <path d="M8 16.5c1.2.9 2.5 1.4 4 1.4s2.8-.5 4-1.4"/>
                            </svg>
                        </span>
                        <span>Filières &amp; Spécialités</span>
                    </button>
                </div>
            </div>

            <div class="nav-group {{ in_array($currentSection, ['paiement', 'frais-formation', 'tresorerie', 'rapports-financiers', 'relances', 'echeancier'], true) ? 'is-open is-active-section' : '' }}" data-nav-group="paiement">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'paiement' ? 'is-active' : '' }}" data-section="paiement" data-group-toggle aria-expanded="{{ in_array($currentSection, ['paiement', 'frais-formation', 'tresorerie', 'rapports-financiers', 'relances', 'echeancier'], true) ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/><path d="M6 15h4"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion Paiement</span>
                        <span class="nav-item__hint">Encaissements & échéances</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div class="nav-sub" role="group" aria-label="Sous-menus Gestion Paiement">
                    <button type="button" class="nav-sub__item {{ $currentSection === 'frais-formation' ? 'is-active' : '' }}" data-section="frais-formation">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19V7l8-3 8 3v12"/>
                                <path d="M4 10l8 3 8-3"/>
                                <path d="M12 13v8"/>
                                <circle cx="17.5" cy="17.5" r="3.5"/>
                                <path d="M17.5 16v3M16 17.5h3"/>
                            </svg>
                        </span>
                        <span>Frais de Formation</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'tresorerie' ? 'is-active' : '' }}" data-section="tresorerie">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="6" width="18" height="13" rx="2"/>
                                <path d="M3 10h18"/>
                                <circle cx="12" cy="14.5" r="2"/>
                                <path d="M7 14.5h1.2M15.8 14.5H17"/>
                            </svg>
                        </span>
                        <span>Trésorerie</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'rapports-financiers' ? 'is-active' : '' }}" data-section="rapports-financiers">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19h16"/>
                                <path d="M7 16V10"/>
                                <path d="M12 16V7"/>
                                <path d="M17 16v-3"/>
                                <path d="M5 5h6l2 2h6v3"/>
                            </svg>
                        </span>
                        <span>Rapports Financiers</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'relances' ? 'is-active' : '' }}" data-section="relances">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 106 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                <path d="M10.3 21a1.8 1.8 0 003.4 0"/>
                                <path d="M16.5 3.5l1.2-1.2M19.2 6.2l1.3-.4"/>
                            </svg>
                        </span>
                        <span>Relances</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'echeancier' ? 'is-active' : '' }}" data-section="echeancier">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="16" rx="2"/>
                                <path d="M3 10h18"/>
                                <path d="M8 3v4M16 3v4"/>
                                <path d="M8 14h.01M12 14h.01M16 14h.01"/>
                                <path d="M8 17h8"/>
                            </svg>
                        </span>
                        <span>Échéancier</span>
                    </button>
                </div>
            </div>

            <div class="nav-group {{ in_array($currentSection, ['profs', 'fiche-prof', 'liste-recrutement', 'affectation-cours', 'emploi-temps', 'gestion-remplacements', 'rapports-profs'], true) ? 'is-open is-active-section' : '' }}" data-nav-group="profs">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'profs' ? 'is-active' : '' }}" data-section="profs" data-group-toggle aria-expanded="{{ in_array($currentSection, ['profs', 'fiche-prof', 'liste-recrutement', 'affectation-cours', 'emploi-temps', 'gestion-remplacements', 'rapports-profs'], true) ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="8" r="3.5"/>
                            <path d="M5 19c0-3.3 3.1-6 7-6s7 2.7 7 6"/>
                            <path d="M16 4l3 1.5L16 7"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion des profs</span>
                        <span class="nav-item__hint">Enseignants & affectations</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div class="nav-sub" role="group" aria-label="Sous-menus Gestion des profs">
                    <button type="button" class="nav-sub__item {{ $currentSection === 'fiche-prof' ? 'is-active' : '' }}" data-section="fiche-prof">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="3.5"/>
                                <path d="M5 20c0-3.4 3.1-6 7-6s7 2.6 7 6"/>
                                <path d="M16 4.2l2.3 1.2L16 6.5"/>
                            </svg>
                        </span>
                        <span>Fiche Prof</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'liste-recrutement' ? 'is-active' : '' }}" data-section="liste-recrutement">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11"/>
                                <circle cx="8.5" cy="9.5" r="1.5"/>
                                <path d="M5.5 15c.6-1.2 1.7-2 3-2s2.4.8 3 2"/>
                            </svg>
                        </span>
                        <span>Liste Recrutement</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'affectation-cours' ? 'is-active' : '' }}" data-section="affectation-cours">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19V7l8-3 8 3v12"/>
                                <path d="M4 10l8 3 8-3"/>
                                <path d="M12 13v8"/>
                                <path d="M9 17h6"/>
                            </svg>
                        </span>
                        <span>Affectation des Cours</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'emploi-temps' ? 'is-active' : '' }}" data-section="emploi-temps">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="16" rx="2"/>
                                <path d="M3 10h18"/>
                                <path d="M8 3v4M16 3v4"/>
                                <path d="M7 14h4M13 14h4M7 17h10"/>
                            </svg>
                        </span>
                        <span>Emploi du Temps</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'gestion-remplacements' ? 'is-active' : '' }}" data-section="gestion-remplacements">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 3h5v5"/>
                                <path d="M8 21H3v-5"/>
                                <path d="M21 3l-7.5 7.5"/>
                                <path d="M3 21l7.5-7.5"/>
                                <circle cx="9" cy="8" r="2.2"/>
                                <circle cx="15" cy="16" r="2.2"/>
                            </svg>
                        </span>
                        <span>Gestion des Remplacements</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'rapports-profs' ? 'is-active' : '' }}" data-section="rapports-profs">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19h16"/>
                                <path d="M7 16V9"/>
                                <path d="M12 16V6"/>
                                <path d="M17 16v-4"/>
                                <path d="M5 4h7l2 2h5v3"/>
                            </svg>
                        </span>
                        <span>Rapports</span>
                    </button>
                </div>
            </div>

            <div class="nav-group {{ in_array($currentSection, ['etudiants', 'fiche-eleve', 'affectation-suivi', 'discipline', 'notes-evaluations', 'rapports-etudiants'], true) ? 'is-open is-active-section' : '' }}" data-nav-group="etudiants">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'etudiants' ? 'is-active' : '' }}" data-section="etudiants" data-group-toggle aria-expanded="{{ in_array($currentSection, ['etudiants', 'fiche-eleve', 'affectation-suivi', 'discipline', 'notes-evaluations', 'rapports-etudiants'], true) ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M4 19V7l8-3 8 3v12"/>
                            <path d="M4 10l8 3 8-3"/><path d="M12 13v8"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion Etudiant</span>
                        <span class="nav-item__hint">Dossiers & inscriptions</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div class="nav-sub" role="group" aria-label="Sous-menus Gestion Etudiant">
                    <button type="button" class="nav-sub__item {{ $currentSection === 'fiche-eleve' ? 'is-active' : '' }}" data-section="fiche-eleve">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="3.5"/>
                                <path d="M5 20c0-3.4 3.1-6 7-6s7 2.6 7 6"/>
                                <path d="M16 4.5l2.2 1.1L16 6.7"/>
                            </svg>
                        </span>
                        <span>Fiche Élève</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'affectation-suivi' ? 'is-active' : '' }}" data-section="affectation-suivi">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11"/>
                                <path d="M8 16h4"/>
                            </svg>
                        </span>
                        <span>Affectation et Suivi Pédagogiques</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'discipline' ? 'is-active' : '' }}" data-section="discipline">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3l8 4v5c0 5-3.4 8.4-8 9.5C7.4 20.4 4 17 4 12V7l8-4z"/>
                                <path d="M9.5 12l1.8 1.8L15 10"/>
                            </svg>
                        </span>
                        <span>Discipline</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'notes-evaluations' ? 'is-active' : '' }}" data-section="notes-evaluations">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19V5a1 1 0 011-1h10l5 5v10a1 1 0 01-1 1H5a1 1 0 01-1-1z"/>
                                <path d="M14 4v5h5"/>
                                <path d="M8 13h8M8 16h5"/>
                                <path d="M8 10h3"/>
                            </svg>
                        </span>
                        <span>Notes &amp; Évaluations</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'rapports-etudiants' ? 'is-active' : '' }}" data-section="rapports-etudiants">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19h16"/>
                                <path d="M7 16V9"/>
                                <path d="M12 16V6"/>
                                <path d="M17 16v-4"/>
                                <circle cx="7" cy="7.5" r="1.2"/>
                                <circle cx="12" cy="4.5" r="1.2"/>
                                <circle cx="17" cy="10.5" r="1.2"/>
                            </svg>
                        </span>
                        <span>Rapports</span>
                    </button>
                </div>
            </div>

            <div class="nav-group {{ $currentSection === 'classes' ? 'is-open is-active-section' : '' }}" data-nav-group="classes">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'classes' ? 'is-active' : '' }}" data-section="classes" data-group-toggle aria-expanded="{{ $currentSection === 'classes' ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <rect x="3" y="4" width="18" height="14" rx="2"/>
                            <path d="M8 21h8"/><path d="M12 18v3"/>
                            <path d="M7 9h4M7 12h10"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion des classes</span>
                        <span class="nav-item__hint">Niveaux & groupes</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="nav-group {{ $currentSection === 'personnels' ? 'is-open is-active-section' : '' }}" data-nav-group="personnels">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'personnels' ? 'is-active' : '' }}" data-section="personnels" data-group-toggle aria-expanded="{{ $currentSection === 'personnels' ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <circle cx="9" cy="8" r="3"/>
                            <circle cx="16" cy="9" r="2.5"/>
                            <path d="M3 19c0-2.8 2.7-5 6-5s6 2.2 6 5"/>
                            <path d="M14 19c0-1.8 1.6-3.3 3.8-3.8"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion Personnels</span>
                        <span class="nav-item__hint">Équipe administrative</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="nav-group {{ $currentSection === 'charges' ? 'is-open is-active-section' : '' }}" data-nav-group="charges">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'charges' ? 'is-active' : '' }}" data-section="charges" data-group-toggle aria-expanded="{{ $currentSection === 'charges' ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M4 19h16"/><path d="M7 19V9l5-4 5 4v10"/>
                            <path d="M10 19v-5h4v5"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion des charges</span>
                        <span class="nav-item__hint">Dépenses & budget</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="nav-group {{ $currentSection === 'configuration' ? 'is-open is-active-section' : '' }}" data-nav-group="configuration">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'configuration' ? 'is-active' : '' }}" data-section="configuration" data-group-toggle aria-expanded="{{ $currentSection === 'configuration' ? 'true' : 'false' }}">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.7 1.7 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.8-.3 1.7 1.7 0 00-1 1.5V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-1-1.5 1.7 1.7 0 00-1.8.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.8 1.7 1.7 0 00-1.5-1H3a2 2 0 110-4h.1a1.7 1.7 0 001.5-1 1.7 1.7 0 00-.3-1.8l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.8.3H9a1.7 1.7 0 001-1.5V3a2 2 0 114 0v.1a1.7 1.7 0 001 1.5 1.7 1.7 0 001.8-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.8V9c.3.6.9 1 1.5 1H21a2 2 0 110 4h-.1a1.7 1.7 0 00-1.5 1z"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Configuration</span>
                        <span class="nav-item__hint">Paramètres du système</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="sidebar__foot">
                <form class="sidebar__logout-form" method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="sidebar__logout" title="Se déconnecter">
                        <span class="sidebar__logout-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M10 17l5-5-5-5"/>
                                <path d="M15 12H3"/>
                                <path d="M21 5v14a2 2 0 01-2 2h-4"/>
                            </svg>
                        </span>
                        <span class="sidebar__logout-text">
                            <span class="sidebar__logout-title">Se déconnecter</span>
                            <span class="sidebar__logout-hint">Fermer la session</span>
                        </span>
                    </button>
                </form>
                <p class="sidebar__credit">A2S — Solution qui Gère</p>
            </div>
        </aside>

        <main class="main">
            <section class="panel {{ ($activeSection ?? 'administration') === 'administration' ? 'is-visible' : '' }}" id="panel-administration" data-panel="administration">
                <div class="analytics-sticky">
                    <h3 class="stats__title">Cartes Analytiques Opérationnelles</h3>
                    <div class="stats">
                        <article class="stat">
                            <div class="stat__label">Chiffre D'affaire</div>
                            <div class="stat__value">125400.00</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Total Etudiants</div>
                            <div class="stat__value">248</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Total Professeurs</div>
                            <div class="stat__value">32</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Total Charges</div>
                            <div class="stat__value">48200.00</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Total Caisse</div>
                            <div class="stat__value">77200.00</div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-centre' ? 'is-visible' : '' }}" id="panel-fiche-centre" data-panel="fiche-centre">
                <div class="form-window">
                    <div class="form-window__head">
                        <h2 class="form-window__title">Fiche Centre</h2>
                        <p class="form-window__desc">Saisissez les informations générales du centre L'HORIZON.</p>
                    </div>

                    @if (session('success'))
                        <div class="form-alert form-alert--success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="form-alert form-alert--error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.centre.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-grid">
                            <div class="form-photo">
                                <div class="form-photo__preview {{ !empty($centre?->photo) ? 'has-image' : '' }}" id="centre-photo-preview">
                                    <img
                                        id="centre-photo-img"
                                        src="{{ !empty($centre?->photo) ? asset('storage/'.$centre->photo) : '' }}"
                                        alt="Photo du centre"
                                    >
                                    <div class="form-photo__placeholder">
                                        <strong>Photo du centre</strong>
                                        JPG, PNG — max 2 Mo
                                    </div>
                                </div>
                                <label class="form-photo__btn" for="centre-photo">
                                    Choisir une photo
                                </label>
                                <input type="file" id="centre-photo" name="photo" accept="image/*">
                            </div>

                            <div class="form-fields">
                                <div class="form-field">
                                    <label for="nom_centre">Nom Centre</label>
                                    <input type="text" id="nom_centre" name="nom_centre" value="{{ old('nom_centre', $centre->nom_centre ?? '') }}" required placeholder="Ex. Centre L'HORIZON">
                                </div>
                                <div class="form-field">
                                    <label for="nom_gerant">Nom Gérant</label>
                                    <input type="text" id="nom_gerant" name="nom_gerant" value="{{ old('nom_gerant', $centre->nom_gerant ?? '') }}" placeholder="Nom du gérant">
                                </div>
                                <div class="form-field">
                                    <label for="contact">Contact</label>
                                    <input type="text" id="contact" name="contact" value="{{ old('contact', $centre->contact ?? '') }}" placeholder="Téléphone ou e-mail">
                                </div>
                                <div class="form-field">
                                    <label for="ville">Ville</label>
                                    <input type="text" id="ville" name="ville" value="{{ old('ville', $centre->ville ?? '') }}" placeholder="Ville">
                                </div>
                                <div class="form-field form-field--full">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $centre->adresse ?? '') }}" placeholder="Adresse complète">
                                </div>
                                <div class="form-field form-field--full">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" placeholder="Description du centre">{{ old('description', $centre->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn--primary">Enregistrer la fiche</button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'documents-administratifs' ? 'is-visible' : '' }}" id="panel-documents-administratifs" data-panel="documents-administratifs">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Documents administratifs</h2>
                    <p>Espace de gestion des documents administratifs du centre.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'parametres-financiers' ? 'is-visible' : '' }}" id="panel-parametres-financiers" data-panel="parametres-financiers">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Paramètres financiers</h2>
                    <p>Configurez les paramètres financiers et les règles de facturation.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'calendrier-academique' ? 'is-visible' : '' }}" id="panel-calendrier-academique" data-panel="calendrier-academique">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Calendrier académique</h2>
                    <p>Planifiez les sessions, vacances et échéances académiques.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'filieres-specialites' ? 'is-visible' : '' }}" id="panel-filieres-specialites" data-panel="filieres-specialites">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Filières &amp; Spécialités</h2>
                    <p>Gérez les filières et spécialités proposées par le centre.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'paiement' ? 'is-visible' : '' }}" id="panel-paiement" data-panel="paiement">
                <div class="analytics-sticky">
                    <h3 class="stats__title">Gestion Paiement</h3>
                    <div class="stats stats--paiement">
                        <article class="stat">
                            <div class="stat__label">Total Paiement du Mois</div>
                            <div class="stat__value">38450.00</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Total en Attente</div>
                            <div class="stat__value">12600.00</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Total en Retard</div>
                            <div class="stat__value">8750.00</div>
                        </article>
                    </div>
                </div>

                <div class="chart-panel">
                    <div class="chart-panel__head">
                        <h3 class="chart-panel__title">Suivi des paiements par mois</h3>
                        <div class="chart-panel__filters">
                            <label for="paiement-year">Année</label>
                            <select id="paiement-year" aria-label="Sélectionner l'année">
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-panel__canvas-wrap">
                        <canvas id="paiement-chart" aria-label="Diagramme Montant Payé, en Attente et en Retard"></canvas>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'frais-formation' ? 'is-visible' : '' }}" id="panel-frais-formation" data-panel="frais-formation">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Frais de Formation</h2>
                    <p>Gérez les frais de formation, tarifs et modalités de paiement.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'tresorerie' ? 'is-visible' : '' }}" id="panel-tresorerie" data-panel="tresorerie">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Trésorerie</h2>
                    <p>Suivez les encaissements, décaissements et la caisse du centre.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'rapports-financiers' ? 'is-visible' : '' }}" id="panel-rapports-financiers" data-panel="rapports-financiers">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Rapports Financiers</h2>
                    <p>Consultez et exportez les rapports financiers du centre.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'relances' ? 'is-visible' : '' }}" id="panel-relances" data-panel="relances">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Relances</h2>
                    <p>Gérez les relances des paiements en attente ou en retard.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'echeancier' ? 'is-visible' : '' }}" id="panel-echeancier" data-panel="echeancier">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Échéancier</h2>
                    <p>Planifiez et suivez les échéances de paiement des élèves.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'profs' ? 'is-visible' : '' }}" id="panel-profs" data-panel="profs">
                <div class="analytics-sticky">
                    <h3 class="stats__title">Gestion des Professeurs</h3>
                    <div class="stats stats--profs">
                        <article class="stat">
                            <div class="stat__label">Nbrs Profs</div>
                            <div class="stat__value" id="stat-profs-count">32</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Matières Actives</div>
                            <div class="stat__value" id="stat-matieres-actives">18</div>
                        </article>
                        <article class="stat">
                            <div class="stat__label">Matière Faible</div>
                            <div class="stat__value" id="stat-matieres-faibles">4</div>
                        </article>
                    </div>
                </div>

                <div class="chart-panel">
                    <div class="chart-panel__head">
                        <h3 class="chart-panel__title">Suivi mensuel — Profs &amp; Matières</h3>
                        <div class="chart-panel__filters">
                            <label for="profs-year">Année</label>
                            <select id="profs-year" aria-label="Sélectionner l'année">
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-panel__canvas-wrap">
                        <canvas id="profs-chart" aria-label="Diagramme Nbrs Profs, Matières Actives et Matière Faible par mois"></canvas>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-prof' ? 'is-visible' : '' }}" id="panel-fiche-prof" data-panel="fiche-prof">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Fiche Prof</h2>
                    <p>Créez et consultez les dossiers individuels des professeurs.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'liste-recrutement' ? 'is-visible' : '' }}" id="panel-liste-recrutement" data-panel="liste-recrutement">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Liste Recrutement</h2>
                    <p>Suivez les candidatures et le processus de recrutement des enseignants.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'affectation-cours' ? 'is-visible' : '' }}" id="panel-affectation-cours" data-panel="affectation-cours">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Affectation des Cours</h2>
                    <p>Affectez les professeurs aux matières et aux classes.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'emploi-temps' ? 'is-visible' : '' }}" id="panel-emploi-temps" data-panel="emploi-temps">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Emploi du Temps</h2>
                    <p>Planifiez et consultez les emplois du temps des professeurs.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'gestion-remplacements' ? 'is-visible' : '' }}" id="panel-gestion-remplacements" data-panel="gestion-remplacements">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Gestion des Remplacements</h2>
                    <p>Organisez les remplacements et absences des enseignants.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'rapports-profs' ? 'is-visible' : '' }}" id="panel-rapports-profs" data-panel="rapports-profs">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Rapports</h2>
                    <p>Consultez et exportez les rapports liés aux professeurs.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'etudiants' ? 'is-visible' : '' }}" id="panel-etudiants" data-panel="etudiants">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Gestion Etudiant</h2>
                    <p>Sélectionnez un sous-menu pour gérer les élèves, le suivi, la discipline, les notes ou les rapports.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-eleve' ? 'is-visible' : '' }}" id="panel-fiche-eleve" data-panel="fiche-eleve">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Fiche Élève</h2>
                    <p>Créez et consultez les dossiers individuels des élèves.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'affectation-suivi' ? 'is-visible' : '' }}" id="panel-affectation-suivi" data-panel="affectation-suivi">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Affectation et Suivi Pédagogiques</h2>
                    <p>Affectez les élèves et suivez leur parcours pédagogique.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'discipline' ? 'is-visible' : '' }}" id="panel-discipline" data-panel="discipline">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Discipline</h2>
                    <p>Gérez les incidents, absences et mesures disciplinaires.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'notes-evaluations' ? 'is-visible' : '' }}" id="panel-notes-evaluations" data-panel="notes-evaluations">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Notes &amp; Évaluations</h2>
                    <p>Saisissez les notes et suivez les évaluations des élèves.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'rapports-etudiants' ? 'is-visible' : '' }}" id="panel-rapports-etudiants" data-panel="rapports-etudiants">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Rapports</h2>
                    <p>Consultez et exportez les rapports liés aux étudiants.</p>
                </div>
            </section>

            <section class="panel" id="panel-classes" data-panel="classes">
                <h2 class="panel__title">Gestion des classes</h2>
            </section>

            <section class="panel" id="panel-personnels" data-panel="personnels">
                <h2 class="panel__title">Gestion Personnels</h2>
            </section>

            <section class="panel" id="panel-charges" data-panel="charges">
                <h2 class="panel__title">Gestion des charges</h2>
            </section>

            <section class="panel" id="panel-configuration" data-panel="configuration">
                <h2 class="panel__title">Configuration</h2>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');
        const navGroups = document.querySelectorAll('[data-nav-group]');
        const groupToggles = document.querySelectorAll('[data-group-toggle]');
        const navSubItems = document.querySelectorAll('.nav-sub__item[data-section]');
        const panels = document.querySelectorAll('.panel');
        const initialSection = @json($activeSection ?? 'administration');

        const groupChildren = {
            administration: [
                'administration',
                'fiche-centre',
                'documents-administratifs',
                'parametres-financiers',
                'calendrier-academique',
                'filieres-specialites',
            ],
            paiement: [
                'paiement',
                'frais-formation',
                'tresorerie',
                'rapports-financiers',
                'relances',
                'echeancier',
            ],
            profs: [
                'profs',
                'fiche-prof',
                'liste-recrutement',
                'affectation-cours',
                'emploi-temps',
                'gestion-remplacements',
                'rapports-profs',
            ],
            etudiants: [
                'etudiants',
                'fiche-eleve',
                'affectation-suivi',
                'discipline',
                'notes-evaluations',
                'rapports-etudiants',
            ],
            classes: ['classes'],
            personnels: ['personnels'],
            charges: ['charges'],
            configuration: ['configuration'],
        };

        const paiementData = {
            2025: {
                paye: [22100, 19850, 24500, 26300, 25100, 27800, 30200, 28900, 31450, 33600, 35100, 37200],
                attente: [8200, 9100, 7600, 8800, 9400, 8700, 10200, 9800, 9100, 8500, 7900, 8600],
                retard: [5400, 6100, 4800, 5200, 6700, 5900, 7100, 6400, 5800, 6200, 5500, 4900],
            },
            2026: {
                paye: [31200, 29800, 33450, 35600, 34800, 37100, 38450, 0, 0, 0, 0, 0],
                attente: [11400, 10800, 12100, 13200, 12600, 11900, 12600, 0, 0, 0, 0, 0],
                retard: [7200, 6800, 8100, 7600, 8400, 7900, 8750, 0, 0, 0, 0, 0],
            },
        };

        const moisLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        let paiementChart = null;
        let profsChart = null;
        let currentSection = initialSection;

        const profsData = {
            2025: {
                profs: [24, 25, 26, 27, 28, 28, 29, 29, 30, 30, 31, 31],
                actives: [12, 13, 13, 14, 14, 15, 15, 15, 16, 16, 17, 17],
                faibles: [5, 5, 4, 5, 4, 4, 3, 4, 3, 3, 3, 2],
            },
            2026: {
                profs: [28, 29, 29, 30, 31, 32, 32, 0, 0, 0, 0, 0],
                actives: [15, 16, 16, 17, 17, 18, 18, 0, 0, 0, 0, 0],
                faibles: [4, 4, 3, 4, 3, 3, 4, 0, 0, 0, 0, 0],
            },
        };

        function findGroupKey(section) {
            return Object.keys(groupChildren).find((key) => groupChildren[key].includes(section)) || section;
        }

        function updateProfsStats(year) {
            const data = profsData[year] || profsData[2026];
            const lastIdx = [...data.profs].map((v, i) => (v > 0 ? i : -1)).filter((i) => i >= 0).pop() ?? 0;

            const elProfs = document.getElementById('stat-profs-count');
            const elActives = document.getElementById('stat-matieres-actives');
            const elFaibles = document.getElementById('stat-matieres-faibles');

            if (elProfs) elProfs.textContent = data.profs[lastIdx];
            if (elActives) elActives.textContent = data.actives[lastIdx];
            if (elFaibles) elFaibles.textContent = data.faibles[lastIdx];
        }

        function buildProfsChart(year) {
            const canvas = document.getElementById('profs-chart');
            if (!canvas || typeof Chart === 'undefined') return;

            const data = profsData[year] || profsData[2026];
            updateProfsStats(year);

            if (profsChart) {
                profsChart.destroy();
            }

            const gradientFill = canvas.getContext('2d').createLinearGradient(0, 0, 0, 320);
            gradientFill.addColorStop(0, 'rgba(26, 127, 194, 0.28)');
            gradientFill.addColorStop(1, 'rgba(26, 127, 194, 0.02)');

            profsChart = new Chart(canvas, {
                data: {
                    labels: moisLabels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Nbrs Profs',
                            data: data.profs,
                            backgroundColor: 'rgba(45, 182, 228, 0.78)',
                            borderColor: 'rgba(14, 95, 150, 0.95)',
                            borderWidth: 1.5,
                            borderRadius: 9,
                            hoverBackgroundColor: 'rgba(45, 182, 228, 0.95)',
                            order: 2,
                            yAxisID: 'y',
                        },
                        {
                            type: 'bar',
                            label: 'Matières Actives',
                            data: data.actives,
                            backgroundColor: 'rgba(34, 170, 130, 0.72)',
                            borderColor: 'rgba(26, 122, 92, 0.95)',
                            borderWidth: 1.5,
                            borderRadius: 9,
                            hoverBackgroundColor: 'rgba(34, 170, 130, 0.95)',
                            order: 3,
                            yAxisID: 'y',
                        },
                        {
                            type: 'line',
                            label: 'Matière Faible',
                            data: data.faibles,
                            borderColor: 'rgba(224, 69, 90, 0.95)',
                            backgroundColor: gradientFill,
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: 'rgba(224, 69, 90, 1)',
                            pointBorderWidth: 2,
                            order: 1,
                            yAxisID: 'y',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#143a58',
                                font: { family: 'Outfit', size: 12, weight: '500' },
                                usePointStyle: true,
                                pointStyle: 'rectRounded',
                                padding: 16,
                            },
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.97)',
                            borderColor: 'rgba(45, 182, 228, 0.35)',
                            borderWidth: 1,
                            titleColor: '#0e5f96',
                            bodyColor: '#143a58',
                            padding: 12,
                            callbacks: {
                                title(items) {
                                    const mois = items[0]?.label || '';
                                    return `${mois} ${year}`;
                                },
                                label(ctx) {
                                    const value = Number(ctx.raw || 0);
                                    return ` ${ctx.dataset.label}: ${value}`;
                                },
                                footer(items) {
                                    const totalActives = Number(items.find((i) => i.dataset.label === 'Matières Actives')?.raw || 0);
                                    const totalFaibles = Number(items.find((i) => i.dataset.label === 'Matière Faible')?.raw || 0);
                                    if (!totalActives) return '';
                                    const ratio = ((totalFaibles / totalActives) * 100).toFixed(1);
                                    return `Ratio matières faibles: ${ratio}%`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(20, 90, 140, 0.08)' },
                            ticks: { color: '#5d7f99', font: { family: 'Outfit', size: 11 } },
                        },
                        y: {
                            beginAtZero: true,
                            suggestedMax: 40,
                            grid: { color: 'rgba(20, 90, 140, 0.1)' },
                            title: {
                                display: true,
                                text: 'Effectifs / Matières',
                                color: '#5d7f99',
                                font: { family: 'Outfit', size: 11, weight: '600' },
                            },
                            ticks: {
                                color: '#5d7f99',
                                font: { family: 'Outfit', size: 11 },
                                precision: 0,
                                callback(value) {
                                    return Number(value).toLocaleString('fr-FR');
                                },
                            },
                        },
                    },
                },
            });
        }

        function refreshProfsChart() {
            if (!profsChart) return;
            requestAnimationFrame(() => profsChart.resize());
        }

        function buildPaiementChart(year) {
            const canvas = document.getElementById('paiement-chart');
            if (!canvas || typeof Chart === 'undefined') return;

            const data = paiementData[year] || paiementData[2026];

            if (paiementChart) {
                paiementChart.destroy();
            }

            paiementChart = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: moisLabels,
                    datasets: [
                        {
                            label: 'Montant Payé',
                            data: data.paye,
                            backgroundColor: 'rgba(95, 212, 232, 0.75)',
                            borderColor: 'rgba(95, 212, 232, 1)',
                            borderWidth: 1.5,
                            borderRadius: 8,
                            hoverBackgroundColor: 'rgba(95, 212, 232, 0.95)',
                        },
                        {
                            label: 'Montant en Attente',
                            data: data.attente,
                            backgroundColor: 'rgba(240, 193, 75, 0.72)',
                            borderColor: 'rgba(240, 193, 75, 1)',
                            borderWidth: 1.5,
                            borderRadius: 8,
                            hoverBackgroundColor: 'rgba(240, 193, 75, 0.95)',
                        },
                        {
                            label: 'Montant en Retard',
                            data: data.retard,
                            backgroundColor: 'rgba(255, 107, 122, 0.72)',
                            borderColor: 'rgba(255, 107, 122, 1)',
                            borderWidth: 1.5,
                            borderRadius: 8,
                            hoverBackgroundColor: 'rgba(255, 107, 122, 0.95)',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#143a58',
                                font: { family: 'Outfit', size: 12, weight: '500' },
                                usePointStyle: true,
                                pointStyle: 'rectRounded',
                                padding: 16,
                            },
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.97)',
                            borderColor: 'rgba(45, 182, 228, 0.35)',
                            borderWidth: 1,
                            titleColor: '#0e5f96',
                            bodyColor: '#143a58',
                            padding: 12,
                            callbacks: {
                                label(ctx) {
                                    const value = Number(ctx.raw || 0).toFixed(2);
                                    return ` ${ctx.dataset.label}: ${value}`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(20, 90, 140, 0.08)' },
                            ticks: { color: '#5d7f99', font: { family: 'Outfit', size: 11 } },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(20, 90, 140, 0.1)' },
                            ticks: {
                                color: '#5d7f99',
                                font: { family: 'Outfit', size: 11 },
                                callback(value) {
                                    return Number(value).toLocaleString('fr-FR');
                                },
                            },
                        },
                    },
                },
            });
        }

        function refreshPaiementChart() {
            if (!paiementChart) return;
            requestAnimationFrame(() => paiementChart.resize());
        }

        function setGroupOpen(groupEl, open) {
            if (!groupEl) return;
            groupEl.classList.toggle('is-open', open);
            const toggle = groupEl.querySelector('[data-group-toggle]');
            if (toggle) {
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
        }

        function closeAllGroups(exceptKey = null) {
            navGroups.forEach((group) => {
                if (exceptKey && group.dataset.navGroup === exceptKey) return;
                setGroupOpen(group, false);
                group.classList.remove('is-active-section');
            });
        }

        function showSection(section, { openGroup = true } = {}) {
            currentSection = section;
            const groupKey = findGroupKey(section);

            document.querySelectorAll('[data-group-toggle]').forEach((el) => {
                el.classList.toggle('is-active', el.dataset.section === section);
            });

            navSubItems.forEach((el) => {
                el.classList.toggle('is-active', el.dataset.section === section);
            });

            navGroups.forEach((group) => {
                const isCurrent = group.dataset.navGroup === groupKey;
                group.classList.toggle('is-active-section', isCurrent);
                if (openGroup) {
                    setGroupOpen(group, isCurrent);
                }
            });

            panels.forEach((panel) => {
                panel.classList.toggle('is-visible', panel.dataset.panel === section);
            });

            sidebar.classList.remove('is-open');

            if (section === 'paiement') {
                refreshPaiementChart();
            }

            if (section === 'profs') {
                refreshProfsChart();
            }
        }

        menuToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('is-open');
        });

        groupToggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const section = toggle.dataset.section;
                const group = toggle.closest('[data-nav-group]');
                const groupKey = group?.dataset.navGroup;
                const isOpen = group?.classList.contains('is-open');

                // Reclic sur la section déjà ouverte → la fermer
                if (isOpen && findGroupKey(currentSection) === groupKey) {
                    setGroupOpen(group, false);
                    group.classList.remove('is-active-section');
                    toggle.classList.remove('is-active');
                    toggle.setAttribute('aria-expanded', 'false');
                    return;
                }

                // Ouvrir cette section et fermer les autres
                closeAllGroups(groupKey);
                showSection(section, { openGroup: true });
            });
        });

        navSubItems.forEach((item) => {
            item.addEventListener('click', (event) => {
                event.stopPropagation();
                showSection(item.dataset.section, { openGroup: true });
            });
        });

        document.getElementById('paiement-year')?.addEventListener('change', (event) => {
            buildPaiementChart(event.target.value);
        });

        document.getElementById('profs-year')?.addEventListener('change', (event) => {
            buildProfsChart(event.target.value);
        });

        const photoInput = document.getElementById('centre-photo');
        const photoPreview = document.getElementById('centre-photo-preview');
        const photoImg = document.getElementById('centre-photo-img');

        photoInput?.addEventListener('change', () => {
            const file = photoInput.files?.[0];
            if (!file || !photoImg || !photoPreview) return;

            const url = URL.createObjectURL(file);
            photoImg.src = url;
            photoPreview.classList.add('has-image');
        });

        showSection(initialSection, { openGroup: true });
        buildPaiementChart('2026');
        buildProfsChart('2026');
    </script>
</body>
</html>
