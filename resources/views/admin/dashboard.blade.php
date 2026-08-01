<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration â€” L'HORIZON / A2S</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            --font-display: 'Plus Jakarta Sans', Arial, sans-serif;
            --font: 'Plus Jakarta Sans', Arial, sans-serif;
            --sidebar-w: 280px;
            --nav-h: 72px;
            --shadow: 0 10px 28px rgba(30, 100, 150, 0.1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: var(--font);
            font-weight: 500;
            letter-spacing: 0.01em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            background: var(--bg);
            color: var(--text);
            text-transform: uppercase;
        }

        input,
        textarea,
        select,
        button {
            text-transform: uppercase;
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
            grid-template-rows: var(--nav-h) minmax(0, 1fr);
            width: 100%;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
        }

        /* â€”â€”â€” Navbar â€”â€”â€” */
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

        /* â€”â€”â€” Sidebar â€”â€”â€” */
        .sidebar {
            grid-row: 2;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            min-height: 0;
            height: 100%;
            padding: 1.25rem 0.9rem 1.5rem;
            background: linear-gradient(180deg, #ffffff 0%, #f0f8fc 100%);
            border-right: 1px solid var(--line);
            box-shadow: 6px 0 24px rgba(30, 100, 150, 0.05);
            overscroll-behavior: contain;
            overflow-y: auto;
        }

        .sidebar__home-btn {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            width: 100%;
            margin: 0 0 0.65rem;
            padding: 0.85rem 0.95rem;
            border: 1px solid rgba(45, 182, 228, 0.35);
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(45, 182, 228, 0.14), rgba(255, 255, 255, 0.95));
            color: var(--primary-deep);
            font: inherit;
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-align: left;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(30, 100, 150, 0.1);
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s, background 0.2s;
        }

        .sidebar__home-btn:hover {
            transform: translateY(-1px);
            border-color: rgba(26, 127, 194, 0.5);
            box-shadow: 0 12px 26px rgba(30, 100, 150, 0.16);
            background: linear-gradient(135deg, rgba(45, 182, 228, 0.2), #fff);
        }

        .sidebar__home-btn.is-active {
            border-color: rgba(26, 127, 194, 0.55);
            background: linear-gradient(135deg, #e8f7ff, #d9effb);
        }

        .sidebar__home-icon {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            border-radius: 11px;
            background: linear-gradient(145deg, rgba(45, 182, 228, 0.22), rgba(26, 127, 194, 0.12));
            border: 1px solid rgba(45, 182, 228, 0.35);
            color: var(--primary-deep);
            flex-shrink: 0;
        }

        .sidebar__home-icon svg {
            width: 18px;
            height: 18px;
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
        .nav-sub__item[data-section="fiche-seances"] .nav-sub__icon { color: #c94d5c; }
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

        .form-alert--error {
            color: #b83245;
            background: rgba(224, 69, 90, 0.08);
            border: 1px solid rgba(224, 69, 90, 0.25);
        }

        #panel-fiche-prof .form-window {
            padding-top: 1rem;
        }

        #panel-fiche-prof .form-window__head {
            margin-bottom: 0.55rem;
            padding-bottom: 0.55rem;
        }

        #panel-matieres .form-window {
            padding-top: 1rem;
        }

        #panel-matieres .form-window__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.65rem;
        }

        .matiere-groups {
            display: flex;
            flex-direction: column;
            gap: 1.35rem;
        }

        .matiere-group__title {
            margin: 0 0 0.7rem;
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--primary-deep);
        }

        .matiere-cards {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .matiere-card {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 78px;
            padding: 0.9rem 0.75rem;
            border: 1px solid rgba(45, 182, 228, 0.28);
            border-radius: 16px;
            background: linear-gradient(180deg, #ffffff 0%, #eef7fc 100%);
            box-shadow: 0 8px 18px rgba(30, 100, 150, 0.08);
            color: var(--primary-deep);
            font: inherit;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        }

        .matiere-card:hover {
            transform: translateY(-2px);
            border-color: rgba(26, 127, 194, 0.55);
            box-shadow: 0 12px 24px rgba(30, 100, 150, 0.14);
        }

        .matiere-card.is-active {
            border-color: #1a7fc2;
            background: linear-gradient(180deg, #e8f5fc 0%, #d4ebf8 100%);
            box-shadow: 0 0 0 2px rgba(26, 127, 194, 0.2);
        }

        .matiere-sheet-overlay {
            position: fixed;
            inset: 0;
            z-index: 120;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(12, 40, 62, 0.28);
            backdrop-filter: blur(2px);
        }

        .matiere-sheet-overlay.is-open {
            display: flex;
        }

        .matiere-sheet {
            width: min(340px, 100%);
            padding: 1.15rem 1.2rem 1.2rem;
            border-radius: 18px;
            border: 1px solid rgba(45, 182, 228, 0.35);
            background: linear-gradient(180deg, #ffffff 0%, #f2f8fc 100%);
            box-shadow: 0 18px 40px rgba(20, 70, 110, 0.22);
            animation: matiere-sheet-in 0.18s ease;
        }

        @keyframes matiere-sheet-in {
            from { opacity: 0; transform: translateY(8px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .matiere-sheet__head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.95rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(45, 182, 228, 0.22);
        }

        .matiere-sheet__eyebrow {
            margin: 0 0 0.2rem;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            color: var(--muted);
            text-transform: uppercase;
        }

        .matiere-sheet__title {
            margin: 0;
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-deep);
            text-transform: uppercase;
        }

        .matiere-sheet__close {
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: 1.35rem;
            line-height: 1;
            cursor: pointer;
            padding: 0.1rem 0.35rem;
        }

        .matiere-sheet__stats {
            display: grid;
            gap: 0.65rem;
        }

        .matiere-sheet__stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.7rem 0.85rem;
            border-radius: 12px;
            border: 1px solid rgba(45, 182, 228, 0.2);
            background: rgba(255, 255, 255, 0.85);
        }

        .matiere-sheet__label {
            font-size: 0.78rem;
            letter-spacing: 0.05em;
            color: var(--muted);
            text-transform: uppercase;
        }

        .matiere-sheet__value {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--primary-deep);
        }

        .matiere-empty {
            color: var(--muted);
            font-size: 0.92rem;
            text-transform: uppercase;
        }

        .matiere-carte-rows {
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .matiere-carte-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.55rem;
            align-items: center;
        }

        .matiere-carte-row input {
            width: 100%;
        }

        @media (max-width: 1100px) {
            .matiere-cards {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .matiere-cards {
                grid-template-columns: 1fr 1fr;
            }

            #panel-matieres .form-window__head {
                flex-direction: column;
                align-items: stretch;
            }
        }

        #panel-etudiants .form-window {
            padding-top: 1rem;
        }

        #etudiant-form-overlay,
        #etudiant-view-overlay {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        #etudiant-form-overlay.is-open,
        #etudiant-view-overlay.is-open {
            display: flex;
        }

        #etudiant-form-overlay .doc-modal,
        #etudiant-view-overlay .doc-modal {
            margin: auto;
            width: min(720px, 100%);
            max-height: min(86vh, 860px);
        }

        .etudiant-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.65rem;
        }

        .etudiant-analytics {
            margin-bottom: 1rem;
        }

        .stats--etudiants {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .etudiant-photo-thumb {
            width: 38px;
            height: 38px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(45, 182, 228, 0.35);
            display: block;
        }

        .etudiant-photo-empty {
            color: var(--muted);
        }

        .etudiant-photo-hint {
            margin: 0.35rem 0 0;
            font-size: 0.78rem;
            color: var(--muted);
            text-transform: uppercase;
        }

        .etudiant-form-photo {
            max-width: 220px;
        }

        .etudiant-form-photo .form-photo__preview {
            aspect-ratio: 1;
            max-height: 220px;
        }

        .etudiant-photo-top {
            justify-items: start;
        }

        @media print {
            body.printing-etudiant * { visibility: hidden !important; }
            body.printing-etudiant #etudiant-print-sheet,
            body.printing-etudiant #etudiant-print-sheet * { visibility: visible !important; }
            body.printing-etudiant #etudiant-print-sheet {
                position: absolute;
                inset: 0;
                padding: 1.5rem;
            }
        }

        .etudiant-print-sheet {
            display: none;
        }

        body.printing-etudiant .etudiant-print-sheet {
            display: block;
        }

        .etudiant-print-sheet__photo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #9ec9e4;
            margin-bottom: 1rem;
        }

        .form-field input[type="file"] {
            padding: 0.45rem;
            background: #fff;
        }

        @media (max-width: 700px) {
            .stats--etudiants {
                grid-template-columns: 1fr;
            }

            .etudiant-head {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .form-grid {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 1.35rem 1.5rem;
            align-items: start;
        }

        .form-photo {
            position: relative;
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

        .form-field input[readonly] {
            background: #eef6fb;
            color: var(--primary-deep);
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: default;
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

        .btn--ghost {
            color: var(--primary-deep);
            background: #fff;
            border-color: rgba(26, 127, 194, 0.28);
        }

        .btn--ghost:hover {
            background: rgba(45, 182, 228, 0.1);
        }

        .btn--secondary {
            color: var(--primary-deep);
            background: #fff;
            border-color: rgba(26, 127, 194, 0.3);
            box-shadow: 0 6px 16px rgba(30, 100, 150, 0.1);
        }

        .btn--secondary:hover {
            background: rgba(45, 182, 228, 0.1);
            border-color: rgba(26, 127, 194, 0.48);
        }

        .btn--danger {
            color: #b83245;
            background: rgba(224, 69, 90, 0.08);
            border-color: rgba(224, 69, 90, 0.24);
        }

        .btn--danger:hover {
            color: #fff;
            background: linear-gradient(135deg, #e0455a, #c9364a);
            box-shadow: 0 8px 20px rgba(224, 69, 90, 0.24);
        }

        .centre-editor[hidden],
        .centre-sheet-wrap[hidden] {
            display: none;
        }

        .centre-sheet-wrap {
            max-width: 920px;
            margin: 0 auto;
        }

        .centre-sheet {
            position: relative;
            overflow: hidden;
            min-height: 620px;
            padding: 2.4rem;
            border-radius: 24px;
            background: #fff;
            border: 1px solid rgba(26, 127, 194, 0.2);
            box-shadow: 0 22px 55px rgba(20, 74, 112, 0.16);
        }

        .centre-sheet::before {
            content: '';
            position: absolute;
            inset: 0 0 auto;
            height: 9px;
            background: linear-gradient(90deg, var(--primary-deep), var(--accent), var(--gold-bright));
        }

        .centre-sheet::after {
            content: '';
            position: absolute;
            right: -90px;
            top: -90px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 182, 228, 0.13), transparent 70%);
            pointer-events: none;
        }

        .centre-sheet__header {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid rgba(26, 127, 194, 0.12);
        }

        .centre-sheet__identity {
            display: flex;
            align-items: center;
            gap: 1.15rem;
            min-width: 0;
        }

        .centre-sheet__photo {
            display: grid;
            place-items: center;
            width: 112px;
            height: 112px;
            overflow: hidden;
            flex-shrink: 0;
            border-radius: 20px;
            color: var(--primary);
            background: linear-gradient(145deg, #edf8fe, #dceff9);
            border: 1px solid rgba(45, 182, 228, 0.36);
            box-shadow: 0 10px 26px rgba(30, 100, 150, 0.14);
        }

        .centre-sheet__photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .centre-sheet__photo svg {
            width: 46px;
            height: 46px;
        }

        .centre-sheet__eyebrow {
            margin-bottom: 0.35rem;
            color: var(--primary);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
        }

        .centre-sheet__name {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 4vw, 2.6rem);
            line-height: 1.05;
            color: var(--primary-deep);
        }

        .centre-sheet__city {
            margin-top: 0.45rem;
            color: var(--muted);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .centre-sheet__stamp {
            flex-shrink: 0;
            padding: 0.65rem 0.9rem;
            border-radius: 12px;
            color: #1a7a5c;
            background: rgba(34, 170, 130, 0.08);
            border: 1px solid rgba(34, 170, 130, 0.28);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .centre-sheet__details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1.6rem;
        }

        .centre-sheet__field {
            padding: 1rem 1.05rem;
            border-radius: 14px;
            background: linear-gradient(145deg, #f8fcff, #eef7fc);
            border: 1px solid rgba(26, 127, 194, 0.12);
        }

        .centre-sheet__field--full {
            grid-column: 1 / -1;
        }

        .centre-sheet__label {
            display: block;
            margin-bottom: 0.35rem;
            color: var(--primary);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.12em;
        }

        .centre-sheet__value {
            color: var(--text);
            font-size: 0.96rem;
            font-weight: 600;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .centre-sheet__description {
            white-space: pre-line;
            font-weight: 500;
        }

        .centre-sheet__footer {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(26, 127, 194, 0.12);
            color: var(--muted);
            font-size: 0.7rem;
            letter-spacing: 0.08em;
        }

        .centre-sheet-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.2rem;
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

            .centre-sheet {
                padding: 1.4rem;
            }

            .centre-sheet__header {
                align-items: flex-start;
                flex-direction: column;
            }

            .centre-sheet__details {
                grid-template-columns: 1fr;
            }

            .centre-sheet__field--full {
                grid-column: auto;
            }

            .centre-sheet__stamp {
                align-self: flex-start;
            }
        }

        .doc-sticky {
            position: relative;
            z-index: 25;
            flex: 0 0 auto;
            margin: 0 0 1rem;
            padding: 0.35rem 0 0.75rem;
            background:
                linear-gradient(180deg, rgba(234, 244, 251, 0.98) 55%, rgba(234, 244, 251, 0.88) 85%, transparent);
            backdrop-filter: blur(10px);
        }

        .doc-cards {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.85rem;
            margin: 0 0 1rem;
        }

        .doc-toolbar .form-field select {
            width: 100%;
            border: 1px solid rgba(45, 182, 228, 0.35);
            border-radius: 12px;
            background: #fff;
            color: var(--text);
            font: inherit;
            text-transform: uppercase;
        }

        .form-fields select {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border: 1px solid rgba(45, 182, 228, 0.35);
            border-radius: 12px;
            background: #fff;
            color: var(--text);
            font: inherit;
            text-transform: uppercase;
        }

        .doc-card {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
            min-height: 132px;
            padding: 1rem 0.95rem;
            border: 1px solid rgba(45, 182, 228, 0.28);
            border-radius: 18px;
            background: linear-gradient(160deg, #ffffff 0%, #f0f8fc 100%);
            color: var(--text);
            text-align: left;
            cursor: pointer;
            box-shadow: 0 10px 28px rgba(30, 100, 150, 0.1);
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            overflow: hidden;
        }

        .doc-card::after {
            content: '';
            position: absolute;
            right: -28px;
            bottom: -34px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 182, 228, 0.18), transparent 70%);
            pointer-events: none;
        }

        .doc-card:hover,
        .doc-card.is-active {
            transform: translateY(-3px);
            border-color: rgba(26, 127, 194, 0.45);
            box-shadow: 0 16px 34px rgba(30, 100, 150, 0.16);
        }

        .doc-card.is-active {
            background: linear-gradient(160deg, #e8f7ff 0%, #d9effb 100%);
        }

        .doc-card__icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(145deg, rgba(45, 182, 228, 0.2), rgba(26, 127, 194, 0.12));
            border: 1px solid rgba(45, 182, 228, 0.35);
            color: var(--primary-deep);
        }

        .doc-card__icon svg {
            width: 20px;
            height: 20px;
        }

        .doc-card__title {
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.15;
            color: var(--primary-deep);
        }

        .doc-card__count {
            margin-top: auto;
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .doc-card[data-type="attestation"] .doc-card__icon { color: #1a7fc2; }
        .doc-card[data-type="diplomes"] .doc-card__icon { color: #c48a12; }
        .doc-card[data-type="certificats"] .doc-card__icon { color: #0e8a6a; }
        .doc-card[data-type="releve-notes"] .doc-card__icon { color: #6b5ce0; }
        .doc-card[data-type="etudiant-stagiaire"] .doc-card__icon { color: #c94d5c; }

        .doc-toolbar {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr)) auto;
            gap: 0.75rem;
            margin-bottom: 1rem;
            align-items: end;
        }

        .doc-toolbar .form-field {
            gap: 0.3rem;
        }

        .doc-toolbar .form-field label {
            font-size: 0.7rem;
        }

        .doc-toolbar .form-field input,
        .doc-toolbar .form-field select {
            padding: 0.65rem 0.8rem;
            font-size: 0.86rem;
        }

        .doc-status {
            display: inline-flex;
            align-items: center;
            padding: 0.28rem 0.65rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .doc-status--livre {
            color: #1a7a5c;
            background: rgba(34, 170, 130, 0.12);
            border: 1px solid rgba(34, 170, 130, 0.28);
        }

        .doc-status--non_livre {
            color: #b83245;
            background: rgba(224, 69, 90, 0.1);
            border: 1px solid rgba(224, 69, 90, 0.24);
        }

        .doc-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .doc-action {
            border: 1px solid rgba(45, 182, 228, 0.28);
            background: #fff;
            color: var(--primary-deep);
            border-radius: 8px;
            padding: 0.35rem 0.55rem;
            font: inherit;
            font-size: 0.68rem;
            font-weight: 700;
            cursor: pointer;
        }

        .doc-action:hover {
            background: rgba(45, 182, 228, 0.1);
        }

        .doc-action--danger {
            color: #b83245;
            border-color: rgba(224, 69, 90, 0.28);
        }

        .doc-action--danger:hover {
            background: rgba(224, 69, 90, 0.1);
        }

        .doc-panel-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow: auto;
            padding-right: 0.2rem;
            overscroll-behavior: contain;
        }

        #panel-documents-administratifs.is-visible {
            height: 100%;
            min-height: 0;
        }

        #panel-documents-administratifs > .form-window {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 0;
            overflow: hidden;
        }

        @media (max-width: 1100px) {
            .doc-cards {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .doc-toolbar {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .doc-cards,
            .doc-toolbar {
                grid-template-columns: 1fr;
            }
        }

        .doc-overlay {
            position: fixed;
            inset: 0;
            z-index: 80;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            background: rgba(12, 40, 64, 0.45);
            backdrop-filter: blur(6px);
        }

        .doc-overlay.is-open {
            display: flex;
        }

        .doc-modal {
            width: min(980px, 100%);
            max-height: min(88vh, 820px);
            overflow: auto;
            border-radius: 22px;
            background: linear-gradient(180deg, #ffffff 0%, #f3f9fd 100%);
            border: 1px solid rgba(45, 182, 228, 0.25);
            box-shadow: 0 24px 60px rgba(20, 70, 110, 0.28);
            padding: 1.4rem 1.45rem 1.5rem;
        }

        .doc-modal--form {
            width: min(720px, 100%);
        }

        .doc-modal__head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
            padding-bottom: 0.95rem;
            border-bottom: 1px solid var(--line);
        }

        .doc-modal__title {
            font-family: var(--font-display);
            font-size: clamp(1.35rem, 2.4vw, 1.8rem);
            font-weight: 700;
            color: var(--primary-deep);
        }

        .doc-modal__subtitle {
            margin-top: 0.3rem;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .doc-modal__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            justify-content: flex-end;
            margin-top: 1.15rem;
        }

        .doc-table-wrap {
            overflow: auto;
            border-radius: 16px;
            border: 1px solid rgba(45, 182, 228, 0.22);
            background: #fff;
        }

        .doc-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 980px;
        }

        .doc-table th,
        .doc-table td {
            padding: 0.85rem 0.95rem;
            text-align: left;
            border-bottom: 1px solid rgba(20, 90, 140, 0.1);
            font-size: 0.82rem;
            vertical-align: middle;
        }

        .doc-table th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: linear-gradient(90deg, rgba(45, 182, 228, 0.18), rgba(26, 127, 194, 0.1));
            color: var(--primary-deep);
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .doc-table tr:last-child td {
            border-bottom: 0;
        }

        .doc-empty {
            padding: 1.6rem 1rem;
            text-align: center;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .doc-view-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .doc-view-value {
            padding: 0.75rem 0.9rem;
            border: 1px solid rgba(45, 182, 228, 0.22);
            border-radius: 12px;
            background: #f7fbfe;
            font-weight: 700;
            min-height: 2.7rem;
        }

        a.doc-action {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .doc-action--icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-grid;
            place-items: center;
        }

        .frais-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .frais-cards {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }

        .doc-card[data-frais-type="frais-formation"] .doc-card__icon { color: #1a7fc2; }
        .doc-card[data-frais-type="frais-profs"] .doc-card__icon { color: #c48a12; }
        .doc-card[data-frais-type="frais-personnels"] .doc-card__icon { color: #0e8a6a; }
        .doc-card[data-frais-type="frais-charges"] .doc-card__icon { color: #c94d5c; }
        .doc-card[data-frais-type="frais-salaires"] .doc-card__icon { color: #6b5ce0; }

        #panel-parametres-financiers.is-visible {
            height: 100%;
            min-height: 0;
        }

        #panel-parametres-financiers > .form-window {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 0;
            overflow: hidden;
        }

        @media print {
            body.printing-frais * { visibility: hidden !important; }
            body.printing-frais #frais-print-area,
            body.printing-frais #frais-print-area * { visibility: visible !important; }
            body.printing-frais #frais-print-area {
                position: absolute;
                inset: 0;
                padding: 0;
            }
            body.printing-frais .doc-actions { display: none !important; }
        }

        @media (max-width: 1100px) {
            .frais-cards {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .frais-cards {
                grid-template-columns: 1fr;
            }

            .frais-head {
                flex-direction: column;
            }
        }

        @media (max-width: 700px) {
            .doc-view-grid {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            body * {
                visibility: hidden !important;
            }

            #centre-sheet,
            #centre-sheet * {
                visibility: visible !important;
            }

            #centre-sheet {
                position: absolute;
                inset: 0;
                width: 100%;
                min-height: 0;
                padding: 0;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            #centre-sheet::before {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
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

        /* â€”â€”â€” Main â€”â€”â€” */
        .main {
            grid-row: 2;
            min-width: 0;
            min-height: 0;
            height: 100%;
            padding: 1.75rem 1.75rem 2rem;
            overflow: auto;
            overscroll-behavior: contain;
        }

        .panel {
            display: none;
            animation: panel-in 0.35s ease both;
        }

        .panel.is-visible { display: block; }

        @keyframes panel-in {
            from { opacity: 0; }
            to   { opacity: 1; }
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

        .prof-action-cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .prof-action-card {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-height: 104px;
            padding: 1rem;
            border: 1px solid rgba(45, 182, 228, 0.3);
            border-radius: 18px;
            background: linear-gradient(145deg, #fff, #eef8fd);
            color: var(--primary-deep);
            font: inherit;
            text-align: left;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 10px 26px rgba(30, 100, 150, 0.1);
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .prof-action-card:hover {
            transform: translateY(-3px);
            border-color: rgba(26, 127, 194, 0.5);
            box-shadow: 0 16px 34px rgba(30, 100, 150, 0.17);
        }

        .prof-action-card__icon {
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            flex: 0 0 auto;
            border-radius: 14px;
            color: var(--primary);
            background: rgba(45, 182, 228, 0.13);
            border: 1px solid rgba(45, 182, 228, 0.28);
        }

        .prof-action-card__icon svg {
            width: 22px;
            height: 22px;
        }

        .prof-action-card__label {
            font-weight: 800;
            line-height: 1.25;
        }

        .prof-action-card:nth-child(2) .prof-action-card__icon { color: #0e8a6a; }
        .prof-action-card:nth-child(3) .prof-action-card__icon { color: #c48a12; }
        .prof-action-card:nth-child(4) .prof-action-card__icon { color: #6b5ce0; }

        .sessions-window {
            padding: 1.4rem;
            border: 1px solid rgba(45, 182, 228, 0.25);
            border-radius: 22px;
            background: linear-gradient(180deg, #fff, #f3f9fd);
            box-shadow: 0 12px 32px rgba(30, 100, 150, 0.1);
        }

        .main.is-dashboard {
            padding-top: 0.65rem;
            padding-bottom: 0.65rem;
            overflow: hidden;
        }

        #panel-administration.is-visible {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            height: 100%;
            min-height: 0;
            overflow: hidden;
        }

        #panel-administration .analytics-sticky {
            position: relative;
            top: auto;
            flex: 0 0 auto;
            margin: 0;
            padding: 0 0 0.4rem;
        }

        #panel-administration .stats__title {
            margin-bottom: 0.45rem;
            font-size: clamp(1rem, 1.6vw, 1.3rem);
        }

        #panel-administration .stat {
            padding: 0.65rem 0.75rem;
            border-radius: 14px;
        }

        #panel-administration .stat__label {
            margin-bottom: 0.35rem;
            padding: 0.2rem 0.45rem;
            font-size: 0.58rem;
        }

        #panel-administration .stat__value {
            font-size: clamp(1.15rem, 2vw, 1.55rem);
        }

        #panel-administration .sessions-window {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            min-height: 0;
            margin-top: 0 !important;
            padding: 0.7rem 0.8rem 0.8rem;
            overflow: hidden;
        }

        #panel-administration .sessions-window__head {
            flex: 0 0 auto;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            align-items: center;
        }

        #panel-administration .sessions-window__filters {
            gap: 0.4rem;
        }

        #panel-administration .sessions-calendar {
            min-width: 132px;
            padding: 0.25rem 0.4rem;
        }

        #panel-administration .sessions-calendar__icon {
            width: 24px;
            height: 24px;
        }

        #panel-administration .sessions-calendar__field input {
            font-size: 0.64rem;
        }

        #panel-administration .sessions-window__head .form-window__title {
            font-size: clamp(1rem, 1.6vw, 1.3rem);
        }

        #panel-administration .sessions-window__head .form-window__desc {
            margin-top: 0.15rem;
            font-size: 0.7rem;
        }

        #panel-administration .sessions-grid {
            flex: 1 1 auto;
            min-height: 0;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            grid-template-rows: repeat(5, minmax(0, 1fr));
            gap: 0.45rem;
            overflow: hidden;
        }

        #panel-administration .session-button {
            min-height: 0;
            padding: 0.45rem 0.55rem;
            border-radius: 11px;
        }

        #panel-administration .session-button__number {
            font-size: 0.64rem;
        }

        #panel-administration .session-button__subject {
            font-size: 0.61rem;
        }

        #panel-administration .session-button__meta {
            gap: 0.05rem;
            font-size: 0.49rem;
        }

        .sessions-window__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            margin-bottom: 1.1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--line);
        }

        .sessions-window__title-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            min-width: 0;
        }

        .sessions-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            width: fit-content;
            padding: 0.45rem 0.8rem;
            border: 1px solid rgba(45, 182, 228, 0.4);
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(45, 182, 228, 0.14), #fff);
            color: var(--primary-deep);
            font: inherit;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 100, 150, 0.08);
            transition: transform 0.15s, box-shadow 0.2s, background 0.2s;
        }

        .sessions-toggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(30, 100, 150, 0.14);
            background: linear-gradient(135deg, rgba(45, 182, 228, 0.22), #fff);
        }

        .sessions-toggle svg {
            width: 15px;
            height: 15px;
            flex: 0 0 auto;
        }

        .sessions-window.is-collapsed .sessions-grid {
            display: none;
        }

        .sessions-window.is-collapsed {
            flex: 0 0 auto;
        }

        #panel-administration .sessions-window.is-collapsed {
            flex: 0 0 auto;
        }

        .sessions-window__filters {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            flex: 1 1 auto;
        }

        .sessions-calendar {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            min-width: 148px;
            padding: 0.35rem 0.55rem;
            border: 1px solid rgba(45, 182, 228, 0.35);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(30, 100, 150, 0.08);
        }

        .sessions-calendar__icon {
            display: grid;
            place-items: center;
            width: 28px;
            height: 28px;
            flex: 0 0 auto;
            border-radius: 8px;
            color: var(--primary-deep);
            background: rgba(45, 182, 228, 0.12);
            border: 1px solid rgba(45, 182, 228, 0.28);
            pointer-events: none;
        }

        .sessions-calendar__icon svg {
            width: 15px;
            height: 15px;
        }

        .sessions-calendar__field {
            display: flex;
            flex-direction: column;
            gap: 0.05rem;
            min-width: 0;
            flex: 1 1 auto;
        }

        .sessions-calendar__field label {
            color: var(--muted);
            font-size: 0.55rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            line-height: 1;
        }

        .sessions-calendar__field input {
            width: 100%;
            min-width: 0;
            border: 0;
            outline: none;
            background: transparent;
            color: var(--primary-deep);
            font: inherit;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0;
            text-transform: uppercase;
        }

        .sessions-calendar__reset {
            width: 24px;
            height: 24px;
            flex: 0 0 auto;
            border: 0;
            border-radius: 7px;
            background: rgba(20, 90, 140, 0.06);
            color: var(--muted);
            font: inherit;
            font-size: 0.95rem;
            line-height: 1;
            cursor: pointer;
        }

        .sessions-calendar__reset:hover {
            background: rgba(224, 69, 90, 0.1);
            color: #b83245;
        }

        .sessions-window__legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 0.5rem;
            flex: 0 0 auto;
        }

        .sessions-legend {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.55rem;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--line);
            color: var(--muted);
            font-size: 0.66rem;
            font-weight: 700;
        }

        .sessions-legend::before {
            content: '';
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--session-color);
        }

        .sessions-legend--reelle { --session-color: #23a879; }
        .sessions-legend--vide { --session-color: #df4b5e; }
        .sessions-legend--reportee { --session-color: #e0a520; }
        .sessions-legend--individuelle { --session-color: #7059d9; }

        .session-button.is-filtered-out {
            display: none;
        }

        .sessions-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            grid-template-rows: repeat(5, minmax(92px, auto));
            gap: 0.75rem;
        }

        .session-button {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 0.5rem;
            min-width: 0;
            min-height: 108px;
            padding: 0.75rem;
            border: 1px solid color-mix(in srgb, var(--session-color) 55%, transparent);
            border-radius: 14px;
            color: var(--session-text);
            background: linear-gradient(145deg, color-mix(in srgb, var(--session-color) 17%, white), #fff);
            font: inherit;
            text-align: left;
            cursor: pointer;
            box-shadow: 0 7px 18px color-mix(in srgb, var(--session-color) 14%, transparent);
            transition: transform 0.18s, box-shadow 0.2s, border-color 0.2s;
        }

        .session-button:hover {
            transform: translateY(-2px);
            border-color: var(--session-color);
            box-shadow: 0 12px 25px color-mix(in srgb, var(--session-color) 23%, transparent);
        }

        .session-button--reelle {
            --session-color: #23a879;
            --session-text: #116b4e;
        }

        .session-button--vide {
            --session-color: #df4b5e;
            --session-text: #a2293a;
        }

        .session-button--reportee {
            --session-color: #e0a520;
            --session-text: #8f6500;
        }

        .session-button--individuelle {
            --session-color: #7059d9;
            --session-text: #4e3ca7;
        }

        .session-button__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.4rem;
        }

        .session-button__number {
            font-size: 0.75rem;
            font-weight: 800;
        }

        .session-button__status {
            width: 9px;
            height: 9px;
            flex: 0 0 auto;
            border-radius: 50%;
            background: var(--session-color);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--session-color) 17%, transparent);
        }

        .session-button__subject {
            overflow: hidden;
            font-size: 0.7rem;
            font-weight: 800;
            line-height: 1.25;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .session-button__meta {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            color: var(--muted);
            font-size: 0.58rem;
            font-weight: 600;
            line-height: 1.25;
        }

        .session-button__date {
            color: inherit;
            font-size: inherit;
            font-weight: inherit;
        }

        @media (max-width: 1200px) {
            .sessions-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .sessions-window__head { flex-direction: column; align-items: stretch; }
            .sessions-window__filters { justify-content: flex-start; }
            .sessions-window__legend { justify-content: flex-start; }
            .sessions-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 460px) {
            .sessions-grid { grid-template-columns: 1fr; }
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

            .prof-action-cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
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
                height: calc(100dvh - var(--nav-h));
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
            .prof-action-cards { grid-template-columns: 1fr; }
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
                    <div class="navbar__profile-name">{{ $user['name'] ?? 'SAMIR JADI' }}</div>
                    <div class="navbar__profile-role">{{ $user['title'] ?? 'DIRECTEUR GENERAL' }}</div>
                </div>
                <img
                    class="navbar__avatar"
                    src="{{ asset('images/profile-samir-jadi.png') }}?v={{ @filemtime(public_path('images/profile-samir-jadi.png')) ?: time() }}"
                    alt="Photo de profil — SAMIR JADI"
                >
            </div>
        </header>

        <aside class="sidebar" id="sidebar" aria-label="Navigation principale">
            <button type="button" class="sidebar__home-btn" id="sidebar-home-btn" data-section="administration" title="Retour à l'interface principale">
                <span class="sidebar__home-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 11.5 12 4l9 7.5"/>
                        <path d="M6 10.5V20h12V10.5"/>
                        <path d="M10 20v-5h4v5"/>
                    </svg>
                </span>
                <span>Tableau de Bord</span>
            </button>

            @php
                $adminSections = [
                    'administration',
                    'fiche-centre',
                    'documents-administratifs',
                    'parametres-financiers',
                    'fiche-seances',
                    'filieres-specialites',
                ];
                $currentSection = $activeSection ?? 'administration';
            @endphp

            <div class="nav-group {{ in_array($currentSection, $adminSections, true) ? 'is-active-section' : '' }}" data-nav-group="administration">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'administration' ? 'is-active' : '' }}" data-section="administration" data-group-toggle aria-expanded="false">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M3 21h18"/><path d="M5 21V8l7-4 7 4v13"/><path d="M9 21v-6h6v6"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Administration</span>
                        <span class="nav-item__hint">Pilotage gÃ©nÃ©ral</span>
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
                        <span>ParamÃ¨tres financiers</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'fiche-seances' ? 'is-active' : '' }}" data-section="fiche-seances">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="16" rx="2"/>
                                <path d="M3 10h18"/>
                                <path d="M8 3v4M16 3v4"/>
                                <path d="M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01"/>
                            </svg>
                        </span>
                        <span>Fiche des Séances</span>
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
                        <span>FiliÃ¨res &amp; SpÃ©cialitÃ©s</span>
                    </button>
                </div>
            </div>

            <div class="nav-group {{ in_array($currentSection, ['paiement', 'frais-formation', 'tresorerie', 'rapports-financiers', 'relances', 'echeancier'], true) ? 'is-active-section' : '' }}" data-nav-group="paiement">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'paiement' ? 'is-active' : '' }}" data-section="paiement" data-group-toggle aria-expanded="false">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/><path d="M6 15h4"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion Paiement</span>
                        <span class="nav-item__hint">Encaissements & Ã©chÃ©ances</span>
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
                        <span>TrÃ©sorerie</span>
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
                        <span>Ã‰chÃ©ancier</span>
                    </button>
                </div>
            </div>

            <div class="nav-group {{ in_array($currentSection, ['profs', 'fiche-prof', 'matieres', 'fiche-analytique-profs', 'liste-recrutement', 'affectation-cours', 'emploi-temps', 'gestion-remplacements', 'rapports-profs'], true) ? 'is-active-section' : '' }}" data-nav-group="profs">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'profs' ? 'is-active' : '' }}" data-section="profs" data-group-toggle aria-expanded="false">
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

            <div class="nav-group {{ in_array($currentSection, ['etudiants', 'fiche-eleve', 'affectation-suivi', 'discipline', 'notes-evaluations', 'rapports-etudiants'], true) ? 'is-active-section' : '' }}" data-nav-group="etudiants">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'etudiants' ? 'is-active' : '' }}" data-section="etudiants" data-group-toggle aria-expanded="false">
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
                        <span>Fiche Ã‰lÃ¨ve</span>
                    </button>
                    <button type="button" class="nav-sub__item {{ $currentSection === 'affectation-suivi' ? 'is-active' : '' }}" data-section="affectation-suivi">
                        <span class="nav-sub__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11"/>
                                <path d="M8 16h4"/>
                            </svg>
                        </span>
                        <span>Affectation et Suivi PÃ©dagogiques</span>
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
                        <span>Notes &amp; Ã‰valuations</span>
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

            <div class="nav-group {{ $currentSection === 'classes' ? 'is-active-section' : '' }}" data-nav-group="classes">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'classes' ? 'is-active' : '' }}" data-section="classes" data-group-toggle aria-expanded="false">
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

            <div class="nav-group {{ $currentSection === 'personnels' ? 'is-active-section' : '' }}" data-nav-group="personnels">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'personnels' ? 'is-active' : '' }}" data-section="personnels" data-group-toggle aria-expanded="false">
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
                        <span class="nav-item__hint">Ã‰quipe administrative</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="nav-group {{ $currentSection === 'charges' ? 'is-active-section' : '' }}" data-nav-group="charges">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'charges' ? 'is-active' : '' }}" data-section="charges" data-group-toggle aria-expanded="false">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M4 19h16"/><path d="M7 19V9l5-4 5 4v10"/>
                            <path d="M10 19v-5h4v5"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Gestion des charges</span>
                        <span class="nav-item__hint">DÃ©penses & budget</span>
                    </span>
                    <span class="nav-item__chevron" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div class="nav-group {{ $currentSection === 'configuration' ? 'is-active-section' : '' }}" data-nav-group="configuration">
                <button type="button" class="nav-item nav-group__toggle {{ $currentSection === 'configuration' ? 'is-active' : '' }}" data-section="configuration" data-group-toggle aria-expanded="false">
                    <span class="nav-item__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.7 1.7 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.8-.3 1.7 1.7 0 00-1 1.5V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-1-1.5 1.7 1.7 0 00-1.8.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.8 1.7 1.7 0 00-1.5-1H3a2 2 0 110-4h.1a1.7 1.7 0 001.5-1 1.7 1.7 0 00-.3-1.8l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.8.3H9a1.7 1.7 0 001-1.5V3a2 2 0 114 0v.1a1.7 1.7 0 001 1.5 1.7 1.7 0 001.8-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.8V9c.3.6.9 1 1.5 1H21a2 2 0 110 4h-.1a1.7 1.7 0 00-1.5 1z"/>
                        </svg>
                    </span>
                    <span class="nav-item__text">
                        <span class="nav-item__title">Configuration</span>
                        <span class="nav-item__hint">ParamÃ¨tres du systÃ¨me</span>
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
                    <button type="submit" class="sidebar__logout" title="Se dÃ©connecter">
                        <span class="sidebar__logout-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M10 17l5-5-5-5"/>
                                <path d="M15 12H3"/>
                                <path d="M21 5v14a2 2 0 01-2 2h-4"/>
                            </svg>
                        </span>
                        <span class="sidebar__logout-text">
                            <span class="sidebar__logout-title">Se dÃ©connecter</span>
                            <span class="sidebar__logout-hint">Fermer la session</span>
                        </span>
                    </button>
                </form>
                <p class="sidebar__credit">A2S â€” Solution qui GÃ¨re</p>
            </div>
        </aside>

        <main class="main {{ ($activeSection ?? 'administration') === 'administration' ? 'is-dashboard' : '' }}">
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

                <div class="sessions-window" id="sessions-window" style="margin-top: 1.25rem;">
                    <div class="sessions-window__head">
                        <div class="sessions-window__title-wrap">
                            <h2 class="form-window__title">Tableau de Bord des Séances</h2>
                            <p class="form-window__desc">Cliquez sur une séance pour afficher ses informations.</p>
                            <button type="button" class="sessions-toggle" id="sessions-toggle" aria-controls="sessions-grid" aria-expanded="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span id="sessions-toggle-label">Masquer</span>
                            </button>
                        </div>

                        <div class="sessions-window__filters" aria-label="Recherche calendrier">
                            <div class="sessions-calendar">
                                <span class="sessions-calendar__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                                        <path d="M3 10h18M8 3v4M16 3v4"/>
                                        <path d="M8 14h.01M12 14h.01M16 14h.01"/>
                                    </svg>
                                </span>
                                <div class="sessions-calendar__field">
                                    <label for="sessions-filter-day">Jour</label>
                                    <input type="date" id="sessions-filter-day" title="Rechercher par jour">
                                </div>
                                <button type="button" class="sessions-calendar__reset" id="sessions-filter-day-reset" title="Effacer le jour">×</button>
                            </div>

                            <div class="sessions-calendar">
                                <span class="sessions-calendar__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                                        <path d="M3 10h18M8 3v4M16 3v4"/>
                                        <path d="M7 14h10M7 17h6"/>
                                    </svg>
                                </span>
                                <div class="sessions-calendar__field">
                                    <label for="sessions-filter-month">Mois</label>
                                    <input type="month" id="sessions-filter-month" title="Rechercher par mois">
                                </div>
                                <button type="button" class="sessions-calendar__reset" id="sessions-filter-month-reset" title="Effacer le mois">×</button>
                            </div>
                        </div>

                        <div class="sessions-window__legend" aria-label="Légende des séances">
                            <span class="sessions-legend sessions-legend--reelle">Réelle</span>
                            <span class="sessions-legend sessions-legend--vide">Vide</span>
                            <span class="sessions-legend sessions-legend--reportee">Reportée</span>
                            <span class="sessions-legend sessions-legend--individuelle">Individuelle</span>
                        </div>
                    </div>

                    @php
                        $seanceStatuses = [
                            'reelle' => 'Séance Réelle',
                            'vide' => 'Séance Vide',
                            'reportee' => 'Séance Reportée',
                            'individuelle' => 'Séance Individuelle',
                        ];
                        $seanceStatusKeys = array_keys($seanceStatuses);
                        $seanceMatieres = ['Mathématiques', 'Français', 'Anglais', 'Informatique', 'Physique', 'Comptabilité'];
                        $seanceProfs = ['M. Benali', 'Mme Amrane', 'M. Kaci', 'Mme Saadi', 'M. Meziane', 'Mme Boudiaf'];
                        $seanceHours = [
                            ['08:00', '09:30'],
                            ['09:45', '11:15'],
                            ['13:00', '14:30'],
                            ['14:45', '16:15'],
                            ['16:30', '18:00'],
                        ];
                    @endphp

                    <div class="sessions-grid" id="sessions-grid">
                        @for ($i = 1; $i <= 30; $i++)
                            @php
                                $statusKey = $seanceStatusKeys[($i - 1) % count($seanceStatusKeys)];
                                $statusLabel = $seanceStatuses[$statusKey];
                                $isEmpty = $statusKey === 'vide';
                                $isIndividual = $statusKey === 'individuelle';
                                $matiere = $isEmpty ? 'À Programmer' : $seanceMatieres[($i - 1) % count($seanceMatieres)];
                                $prof = $isEmpty ? 'Non Affecté' : $seanceProfs[($i - 1) % count($seanceProfs)];
                                $hours = $seanceHours[($i - 1) % count($seanceHours)];
                                $date = now()->startOfMonth()->addDays($i - 1);
                                $classe = $isEmpty ? '—' : 'C'.str_pad((string) ((($i - 1) % 8) + 1), 2, '0', STR_PAD_LEFT);
                                $presents = $isEmpty ? 0 : ($isIndividual ? 1 : 14 + ($i % 9));
                                $absents = $isEmpty || $isIndividual ? 0 : ($i % 5);
                            @endphp
                            <button
                                type="button"
                                class="session-button session-button--{{ $statusKey }}"
                                data-session-number="{{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}"
                                data-session-status="{{ $statusLabel }}"
                                data-session-date="{{ $date->format('d/m/Y') }}"
                                data-session-iso="{{ $date->format('Y-m-d') }}"
                                data-session-month="{{ $date->format('Y-m') }}"
                                data-session-start="{{ $isEmpty ? '—' : $hours[0] }}"
                                data-session-end="{{ $isEmpty ? '—' : $hours[1] }}"
                                data-session-classe="{{ $classe }}"
                                data-session-subject="{{ $matiere }}"
                                data-session-prof="{{ $prof }}"
                                data-session-present="{{ $presents }}"
                                data-session-absent="{{ $absents }}"
                            >
                                <span class="session-button__top">
                                    <span class="session-button__number">Séance {{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="session-button__status" aria-hidden="true"></span>
                                </span>
                                <span class="session-button__subject">{{ $matiere }}</span>
                                <span class="session-button__meta">
                                    <span class="session-button__classe">Classe {{ $classe }}</span>
                                    <span class="session-button__date">{{ $date->format('d/m/Y') }} · {{ $isEmpty ? 'Libre' : $hours[0].' – '.$hours[1] }}</span>
                                </span>
                            </button>
                        @endfor
                    </div>
                </div>

                <div class="doc-overlay" id="session-view-overlay" aria-hidden="true">
                    <div class="doc-modal" role="dialog" aria-modal="true" aria-labelledby="session-view-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="session-view-title">Détail de la Séance</h3>
                                <p class="doc-modal__subtitle" id="session-view-subtitle"></p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="session-view-close">Fermer</button>
                        </div>
                        <div class="doc-view-grid" id="session-view-body"></div>
                        <div class="doc-modal__actions">
                            <button type="button" class="btn btn--primary" id="session-view-ok">Fermer</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-centre' ? 'is-visible' : '' }}" id="panel-fiche-centre" data-panel="fiche-centre">
                @php
                    $showCentreSheet = $centre
                        && request('mode') !== 'edit'
                        && ! $errors->any();
                @endphp

                <div class="centre-editor" id="centre-editor" @if ($showCentreSheet) hidden @endif>
                    <div class="form-window">
                    <div class="form-window__head">
                        <h2 class="form-window__title">Fiche Centre</h2>
                        <p class="form-window__desc">Saisissez les informations gÃ©nÃ©rales du centre L'HORIZON.</p>
                    </div>

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
                                        JPG, PNG â€” max 2 Mo
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
                                    <label for="nom_gerant">Nom GÃ©rant</label>
                                    <input type="text" id="nom_gerant" name="nom_gerant" value="{{ old('nom_gerant', $centre->nom_gerant ?? '') }}" placeholder="Nom du gÃ©rant">
                                </div>
                                <div class="form-field">
                                    <label for="contact">Contact</label>
                                    <input type="text" id="contact" name="contact" value="{{ old('contact', $centre->contact ?? '') }}" placeholder="TÃ©lÃ©phone ou e-mail">
                                </div>
                                <div class="form-field">
                                    <label for="ville">Ville</label>
                                    <input type="text" id="ville" name="ville" value="{{ old('ville', $centre->ville ?? '') }}" placeholder="Ville">
                                </div>
                                <div class="form-field form-field--full">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $centre->adresse ?? '') }}" placeholder="Adresse complÃ¨te">
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
                </div>

                <div class="centre-sheet-wrap" id="centre-sheet-wrap" @if (! $showCentreSheet) hidden @endif>
                    @if ($centre)
                        <article class="centre-sheet" id="centre-sheet">
                            <header class="centre-sheet__header">
                                <div class="centre-sheet__identity">
                                    <div class="centre-sheet__photo">
                                        @if ($centre->photo)
                                            <img src="{{ asset('storage/'.$centre->photo) }}" alt="Photo du centre">
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                <path d="M3 21h18"/><path d="M5 21V8l7-4 7 4v13"/><path d="M9 21v-6h6v6"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="centre-sheet__eyebrow">Fiche Officielle Du Centre</p>
                                        <h2 class="centre-sheet__name">{{ $centre->nom_centre }}</h2>
                                        <p class="centre-sheet__city">{{ $centre->ville ?: 'Ville Non RenseignÃ©e' }}</p>
                                    </div>
                                </div>
                                <div class="centre-sheet__stamp">Fiche ValidÃ©e</div>
                            </header>

                            <div class="centre-sheet__details">
                                <div class="centre-sheet__field">
                                    <span class="centre-sheet__label">Nom Du GÃ©rant</span>
                                    <div class="centre-sheet__value">{{ $centre->nom_gerant ?: 'Non RenseignÃ©' }}</div>
                                </div>
                                <div class="centre-sheet__field">
                                    <span class="centre-sheet__label">Contact</span>
                                    <div class="centre-sheet__value">{{ $centre->contact ?: 'Non RenseignÃ©' }}</div>
                                </div>
                                <div class="centre-sheet__field">
                                    <span class="centre-sheet__label">Ville</span>
                                    <div class="centre-sheet__value">{{ $centre->ville ?: 'Non RenseignÃ©e' }}</div>
                                </div>
                                <div class="centre-sheet__field">
                                    <span class="centre-sheet__label">Date De Mise Ã€ Jour</span>
                                    <div class="centre-sheet__value">{{ $centre->updated_at?->format('d/m/Y Ã  H:i') }}</div>
                                </div>
                                <div class="centre-sheet__field centre-sheet__field--full">
                                    <span class="centre-sheet__label">Adresse</span>
                                    <div class="centre-sheet__value">{{ $centre->adresse ?: 'Non RenseignÃ©e' }}</div>
                                </div>
                                <div class="centre-sheet__field centre-sheet__field--full">
                                    <span class="centre-sheet__label">Description</span>
                                    <div class="centre-sheet__value centre-sheet__description">{{ $centre->description ?: 'Aucune Description' }}</div>
                                </div>
                            </div>

                            <footer class="centre-sheet__footer">
                                <span>Centre L'Horizon â€” A2S</span>
                                <span>Document Administratif</span>
                            </footer>
                        </article>

                        <div class="centre-sheet-actions">
                            <button type="button" class="btn btn--primary" id="centre-print">
                                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M6 9V3h12v6"/><rect x="4" y="9" width="16" height="8" rx="2"/><path d="M7 14h10v7H7z"/>
                                </svg>
                                Imprimer
                            </button>
                            <button type="button" class="btn btn--secondary" id="centre-edit">
                                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M4 20h4l11-11-4-4L4 16v4z"/><path d="M13.5 6.5l4 4"/>
                                </svg>
                                Modifier
                            </button>
                            <button type="button" class="btn btn--danger" id="centre-close">
                                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M6 6l12 12M18 6L6 18"/>
                                </svg>
                                Fermer
                            </button>
                        </div>
                    @endif
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'documents-administratifs' ? 'is-visible' : '' }}" id="panel-documents-administratifs" data-panel="documents-administratifs">
                <div class="form-window">
                    <div class="form-window__head">
                        <h2 class="form-window__title">Documents Administratifs</h2>
                    </div>

                    @if ($errors->any() && ($activeSection ?? '') === 'documents-administratifs')
                        <div class="form-alert form-alert--error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="doc-sticky">
                        <div class="doc-cards" id="doc-cards">
                            @php
                                $docIcons = [
                                    'attestation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M8 3h8v4H8z"/><path d="M7 7h10v14H7z"/><path d="M10 11h4M10 14h4M10 17h3"/></svg>',
                                    'diplomes' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 3 2 8l10 5 10-5-10-5Z"/><path d="M6 10.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-5.5"/></svg>',
                                    'certificats' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="10" r="6"/><path d="m9.5 10 1.7 1.7 3.3-3.4"/><path d="M8.5 15.5 7 21l5-2 5 2-1.5-5.5"/></svg>',
                                    'releve-notes' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/></svg>',
                                    'etudiant-stagiaire' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 19c1.8-3.2 4-4.8 6.5-4.8S16.7 15.8 18.5 19"/></svg>',
                                ];
                            @endphp
                            @foreach ($documentTypes as $typeKey => $typeLabel)
                                @php $typeCount = $documents->where('type', $typeKey)->count(); @endphp
                                <button type="button" class="doc-card" data-type="{{ $typeKey }}" data-label="{{ $typeLabel }}">
                                    <span class="doc-card__icon">{!! $docIcons[$typeKey] ?? $docIcons['attestation'] !!}</span>
                                    <span class="doc-card__title">{{ $typeLabel }}</span>
                                    <span class="doc-card__count">{{ $typeCount }} document(s)</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="doc-toolbar">
                            <div class="form-field">
                                <label for="doc-filter-mois">Mois</label>
                                <input type="month" id="doc-filter-mois" value="">
                            </div>
                            <div class="form-field">
                                <label for="doc-filter-type">Type Doc</label>
                                <select id="doc-filter-type">
                                    <option value="">Tous</option>
                                    @foreach ($documentTypes as $typeKey => $typeLabel)
                                        <option value="{{ $typeKey }}">{{ $typeLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="doc-filter-statut">Statut</label>
                                <select id="doc-filter-statut">
                                    <option value="">Tous</option>
                                    @foreach ($documentStatuts as $statutKey => $statutLabel)
                                        <option value="{{ $statutKey }}">{{ $statutLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="doc-filter-search">ID / Bénéficiaire</label>
                                <input type="search" id="doc-filter-search" placeholder="Rechercher…">
                            </div>
                            <button type="button" class="btn btn--primary" id="doc-add-open">Ajouter</button>
                        </div>
                    </div>

                    <div class="doc-panel-scroll">
                        <div class="doc-table-wrap">
                            <table class="doc-table" id="doc-main-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type Doc</th>
                                        <th>ID</th>
                                        <th>Bénéficiaire</th>
                                        <th>Famille</th>
                                        <th>Catégorie</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="doc-table-body">
                                    @forelse ($documents as $document)
                                        <tr
                                            class="doc-row"
                                            data-doc-id="{{ $document->id }}"
                                            data-doc-type="{{ $document->type }}"
                                            data-doc-statut="{{ $document->statut }}"
                                            data-doc-month="{{ optional($document->date_document)->format('Y-m') }}"
                                            data-doc-search="{{ \Illuminate\Support\Str::upper(trim(($document->id_beneficiaire ?? '').' '.($document->beneficiaire ?? '').' '.($document->reference ?? ''))) }}"
                                        >
                                            <td>{{ optional($document->date_document)->format('d/m/Y') ?: '—' }}</td>
                                            <td>{{ $document->type_label }}</td>
                                            <td>{{ $document->id_beneficiaire ?: '—' }}</td>
                                            <td>{{ $document->beneficiaire ?: '—' }}</td>
                                            <td>{{ $document->famille ?: '—' }}</td>
                                            <td>{{ $document->categorie ?: '—' }}</td>
                                            <td>
                                                <span class="doc-status doc-status--{{ $document->statut }}">{{ $document->statut_label }}</span>
                                            </td>
                                            <td>
                                                <div class="doc-actions">
                                                    <button type="button" class="doc-action" data-doc-view="{{ $document->id }}">Voir</button>
                                                    <button type="button" class="doc-action" data-doc-edit="{{ $document->id }}">Modifier</button>
                                                    <button type="button" class="doc-action doc-action--danger" data-doc-delete="{{ $document->id }}">Supprimer</button>
                                                    <a class="doc-action" href="{{ route('admin.documents.pdf', $document) }}" target="_blank" rel="noopener">PDF</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="doc-empty-row">
                                            <td colspan="8" class="doc-empty">Aucun document administratif enregistré.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="doc-overlay" id="doc-form-overlay" aria-hidden="true">
                    <div class="doc-modal doc-modal--form" role="dialog" aria-modal="true" aria-labelledby="doc-form-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="doc-form-title">Nouveau document</h3>
                                <p class="doc-modal__subtitle" id="doc-form-subtitle">Saisie</p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="doc-form-close">Fermer</button>
                        </div>

                        <form method="POST" action="{{ route('admin.documents.store') }}" class="form-fields" id="doc-admin-form" novalidate>
                            @csrf
                            <input type="hidden" name="_method" id="doc-form-method" value="POST">

                            <div class="form-field">
                                <label for="doc_type">Type de document</label>
                                <select id="doc_type" name="type" required>
                                    @foreach ($documentTypes as $typeKey => $typeLabel)
                                        <option value="{{ $typeKey }}">{{ $typeLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="doc_date_document">Date</label>
                                <input id="doc_date_document" type="date" name="date_document" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="form-field">
                                <label for="doc_reference">Référence</label>
                                <input id="doc_reference" type="text" name="reference_display" readonly value="">
                            </div>
                            <div class="form-field">
                                <label for="doc_titre">Titre</label>
                                <input id="doc_titre" type="text" name="titre" required maxlength="255" placeholder="Titre du document">
                            </div>
                            <div class="form-field">
                                <label for="doc_id_beneficiaire">ID Bénéficiaire</label>
                                <input id="doc_id_beneficiaire" type="text" name="id_beneficiaire" maxlength="255" placeholder="Ex. BEN-001">
                            </div>
                            <div class="form-field">
                                <label for="doc_beneficiaire">Bénéficiaire</label>
                                <input id="doc_beneficiaire" type="text" name="beneficiaire" required maxlength="255" placeholder="Nom complet">
                            </div>
                            <div class="form-field">
                                <label for="doc_famille">Famille</label>
                                <input id="doc_famille" type="text" name="famille" maxlength="255" placeholder="Nom de famille">
                            </div>
                            <div class="form-field">
                                <label for="doc_categorie">Catégorie</label>
                                <input id="doc_categorie" type="text" name="categorie" maxlength="255" placeholder="Ex. Formation, Stage…">
                            </div>
                            <div class="form-field">
                                <label for="doc_statut">Statut</label>
                                <select id="doc_statut" name="statut" required>
                                    @foreach ($documentStatuts as $statutKey => $statutLabel)
                                        <option value="{{ $statutKey }}" @selected($statutKey === 'non_livre')>{{ $statutLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field form-field--full">
                                <label for="doc_remarque">Remarque</label>
                                <textarea id="doc_remarque" name="remarque" rows="4" maxlength="5000" placeholder="Informations complémentaires…"></textarea>
                            </div>

                            <div class="doc-modal__actions form-field--full">
                                <button type="button" class="btn btn--ghost" id="doc-form-cancel">Annuler</button>
                                <button type="submit" class="btn btn--primary" id="doc-form-submit">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="doc-overlay" id="doc-view-overlay" aria-hidden="true">
                    <div class="doc-modal" role="dialog" aria-modal="true" aria-labelledby="doc-view-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="doc-view-title">Détail document</h3>
                                <p class="doc-modal__subtitle" id="doc-view-subtitle"></p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="doc-view-close">Fermer</button>
                        </div>
                        <div class="doc-view-grid" id="doc-view-body"></div>
                        <div class="doc-modal__actions">
                            <a class="btn btn--ghost" id="doc-view-pdf" href="#" target="_blank" rel="noopener">PDF</a>
                            <button type="button" class="btn btn--primary" id="doc-view-edit">Modifier</button>
                        </div>
                    </div>
                </div>

                <form method="POST" id="doc-delete-form" hidden>
                    @csrf
                    @method('DELETE')
                </form>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'parametres-financiers' ? 'is-visible' : '' }}" id="panel-parametres-financiers" data-panel="parametres-financiers">
                <div class="form-window">
                    <div class="form-window__head frais-head">
                        <div>
                            <h2 class="form-window__title">Paramètres Financiers</h2>
                        </div>
                        <button type="button" class="btn btn--secondary" id="frais-print">
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M6 9V3h12v6"/><rect x="4" y="9" width="16" height="8" rx="2"/><path d="M7 14h10v7H7z"/>
                            </svg>
                            Imprimer
                        </button>
                    </div>

                    @if ($errors->any() && ($activeSection ?? '') === 'parametres-financiers')
                        <div class="form-alert form-alert--error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="doc-sticky">
                        <div class="doc-cards frais-cards" id="frais-cards">
                            @php
                                $fraisIcons = [
                                    'frais-formation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 2 8l10 5 10-5-10-5Z"/><path d="M6 10.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-5.5"/></svg>',
                                    'frais-profs' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 19c1.8-3.2 4-4.8 6.5-4.8S16.7 15.8 18.5 19"/></svg>',
                                    'frais-personnels' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 11a3 3 0 10-6 0"/><path d="M9 19c0-2.5 1.8-4.5 4-4.5s4 2 4 4.5"/><circle cx="8" cy="9" r="2.2"/><path d="M4.5 19c.9-2 2.3-3.2 4-3.5"/></svg>',
                                    'frais-charges' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16v12H4z"/><path d="M8 7V5h8v2"/><path d="M8 12h8M8 16h5"/></svg>',
                                    'frais-salaires' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/><path d="M7 15h2"/></svg>',
                                ];
                            @endphp
                            @foreach ($fraisCategories as $catKey => $catLabel)
                                @php $catCount = $fraisList->where('categorie', $catKey)->count(); @endphp
                                <button type="button" class="doc-card" data-frais-type="{{ $catKey }}" data-label="{{ $catLabel }}">
                                    <span class="doc-card__icon">{!! $fraisIcons[$catKey] !!}</span>
                                    <span class="doc-card__title">{{ $catLabel }}</span>
                                    <span class="doc-card__count">{{ $catCount }} ligne(s)</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="doc-panel-scroll" id="frais-print-area">
                        <div class="doc-table-wrap">
                            <table class="doc-table" id="frais-main-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Réf</th>
                                        <th>Désignation</th>
                                        <th>Bénéficiaire</th>
                                        <th>Type</th>
                                        <th>Montant</th>
                                        <th>Solde</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="frais-table-body">
                                    @forelse ($fraisList as $frais)
                                        <tr
                                            class="frais-row"
                                            data-frais-id="{{ $frais->id }}"
                                            data-frais-cat="{{ $frais->categorie }}"
                                        >
                                            <td>{{ optional($frais->date_frais)->format('d/m/Y') ?: '—' }}</td>
                                            <td>{{ $frais->reference ?: '—' }}</td>
                                            <td>{{ $frais->designation }}</td>
                                            <td>{{ $frais->beneficiaire ?: '—' }}</td>
                                            <td>{{ $frais->type_frais ?: '—' }}</td>
                                            <td>{{ number_format((float) $frais->montant, 2, ',', ' ') }}</td>
                                            <td>{{ number_format((float) $frais->solde, 2, ',', ' ') }}</td>
                                            <td>
                                                <div class="doc-actions">
                                                    <button type="button" class="doc-action doc-action--icon" data-frais-view="{{ $frais->id }}" title="Voir" aria-label="Voir">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </button>
                                                    <button type="button" class="doc-action doc-action--icon" data-frais-edit="{{ $frais->id }}" title="Modifier" aria-label="Modifier">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20h4l11-11-4-4L4 16v4z"/><path d="M13.5 6.5l4 4"/></svg>
                                                    </button>
                                                    <button type="button" class="doc-action doc-action--icon doc-action--danger" data-frais-delete="{{ $frais->id }}" title="Supprimer" aria-label="Supprimer">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M9 7V5h6v2"/><path d="M7 7l1 13h8l1-13"/></svg>
                                                    </button>
                                                    <a class="doc-action doc-action--icon" href="{{ route('admin.frais.pdf', $frais) }}" target="_blank" rel="noopener" title="PDF" aria-label="PDF">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/></svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="frais-empty-row">
                                            <td colspan="8" class="doc-empty">Aucun frais enregistré. Cliquez sur une carte pour saisir.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="doc-overlay" id="frais-form-overlay" aria-hidden="true">
                    <div class="doc-modal doc-modal--form" role="dialog" aria-modal="true" aria-labelledby="frais-form-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="frais-form-title">Nouveau frais</h3>
                                <p class="doc-modal__subtitle" id="frais-form-subtitle">Saisie</p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="frais-form-close">Fermer</button>
                        </div>

                        <form method="POST" action="{{ route('admin.frais.store') }}" class="form-fields" id="frais-admin-form" novalidate>
                            @csrf
                            <input type="hidden" name="_method" id="frais-form-method" value="POST">
                            <input type="hidden" name="categorie" id="frais_categorie" value="">

                            <div class="form-field">
                                <label for="frais_date">Date</label>
                                <input id="frais_date" type="date" name="date_frais" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="form-field">
                                <label for="frais_reference">Référence</label>
                                <input id="frais_reference" type="text" readonly value="">
                            </div>
                            <div class="form-field form-field--full">
                                <label for="frais_designation">Désignation</label>
                                <input id="frais_designation" type="text" name="designation" required maxlength="255" placeholder="Désignation">
                            </div>
                            <div class="form-field">
                                <label for="frais_beneficiaire">Bénéficiaire</label>
                                <input id="frais_beneficiaire" type="text" name="beneficiaire" maxlength="255" placeholder="Nom du bénéficiaire">
                            </div>
                            <div class="form-field">
                                <label for="frais_type">Type</label>
                                <input id="frais_type" type="text" name="type_frais" maxlength="120" placeholder="Ex. Mensuel, Annuel…">
                            </div>
                            <div class="form-field">
                                <label for="frais_montant">Montant</label>
                                <input id="frais_montant" type="number" name="montant" step="0.01" min="0" required placeholder="0.00">
                            </div>
                            <div class="form-field">
                                <label for="frais_solde">Solde</label>
                                <input id="frais_solde" type="number" name="solde" step="0.01" value="0" placeholder="0.00">
                            </div>
                            <div class="form-field form-field--full">
                                <label for="frais_remarque">Remarque</label>
                                <textarea id="frais_remarque" name="remarque" rows="3" maxlength="5000" placeholder="Informations complémentaires…"></textarea>
                            </div>

                            <div class="doc-modal__actions form-field--full">
                                <button type="button" class="btn btn--ghost" id="frais-form-cancel">Fermer</button>
                                <button type="submit" class="btn btn--primary" id="frais-form-submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="doc-overlay" id="frais-view-overlay" aria-hidden="true">
                    <div class="doc-modal" role="dialog" aria-modal="true" aria-labelledby="frais-view-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="frais-view-title">Détail frais</h3>
                                <p class="doc-modal__subtitle" id="frais-view-subtitle"></p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="frais-view-close">Fermer</button>
                        </div>
                        <div class="doc-view-grid" id="frais-view-body"></div>
                        <div class="doc-modal__actions">
                            <a class="btn btn--ghost" id="frais-view-pdf" href="#" target="_blank" rel="noopener">PDF</a>
                            <button type="button" class="btn btn--primary" id="frais-view-edit">Modifier</button>
                        </div>
                    </div>
                </div>

                <form method="POST" id="frais-delete-form" hidden>
                    @csrf
                    @method('DELETE')
                </form>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'filieres-specialites' ? 'is-visible' : '' }}" id="panel-filieres-specialites" data-panel="filieres-specialites">
                <div class="panel-placeholder">
                    <h2 class="panel__title">FiliÃ¨res &amp; SpÃ©cialitÃ©s</h2>
                    <p>GÃ©rez les filiÃ¨res et spÃ©cialitÃ©s proposÃ©es par le centre.</p>
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
                            <label for="paiement-year">AnnÃ©e</label>
                            <select id="paiement-year" aria-label="SÃ©lectionner l'annÃ©e">
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-panel__canvas-wrap">
                        <canvas id="paiement-chart" aria-label="Diagramme Montant PayÃ©, en Attente et en Retard"></canvas>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'frais-formation' ? 'is-visible' : '' }}" id="panel-frais-formation" data-panel="frais-formation">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Frais de Formation</h2>
                    <p>GÃ©rez les frais de formation, tarifs et modalitÃ©s de paiement.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'tresorerie' ? 'is-visible' : '' }}" id="panel-tresorerie" data-panel="tresorerie">
                <div class="panel-placeholder">
                    <h2 class="panel__title">TrÃ©sorerie</h2>
                    <p>Suivez les encaissements, dÃ©caissements et la caisse du centre.</p>
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
                    <p>GÃ©rez les relances des paiements en attente ou en retard.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'echeancier' ? 'is-visible' : '' }}" id="panel-echeancier" data-panel="echeancier">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Ã‰chÃ©ancier</h2>
                    <p>Planifiez et suivez les Ã©chÃ©ances de paiement des Ã©lÃ¨ves.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'profs' ? 'is-visible' : '' }}" id="panel-profs" data-panel="profs">
                <div class="analytics-sticky">
                    <h3 class="stats__title">Gestion des Professeurs</h3>
                    <div class="prof-action-cards">
                        <button type="button" class="prof-action-card" data-prof-target="fiche-prof">
                            <span class="prof-action-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.2"/><path d="M5.5 20c1.7-3.5 3.9-5.2 6.5-5.2s4.8 1.7 6.5 5.2"/></svg>
                            </span>
                            <span class="prof-action-card__label">Fiche Prof</span>
                        </button>
                        <button type="button" class="prof-action-card" data-prof-target="matieres">
                            <span class="prof-action-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 5.5A3.5 3.5 0 0 1 7.5 2H20v17H7.5A3.5 3.5 0 0 0 4 22z"/><path d="M4 5.5V22M9 7h7M9 11h7"/></svg>
                            </span>
                            <span class="prof-action-card__label">Matière</span>
                        </button>
                        <button type="button" class="prof-action-card" data-prof-target="fiche-seances">
                            <span class="prof-action-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 14h3M8 17h6"/></svg>
                            </span>
                            <span class="prof-action-card__label">Fiche des Séances</span>
                        </button>
                        <button type="button" class="prof-action-card" data-prof-target="fiche-analytique-profs">
                            <span class="prof-action-card__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/><path d="m4 8 6-5 6 7 5-5"/></svg>
                            </span>
                            <span class="prof-action-card__label">Fiche Analytique</span>
                        </button>
                    </div>
                </div>

                <div class="chart-panel" id="profs-analytics">
                    <div class="chart-panel__head">
                        <h3 class="chart-panel__title">Matières Actives, Matières Faibles &amp; Revenus</h3>
                        <div class="chart-panel__filters">
                            <label for="profs-year">Année</label>
                            <select id="profs-year" aria-label="Sélectionner l'année">
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-panel__canvas-wrap">
                        <canvas id="profs-chart" aria-label="Diagramme des matières actives, matières faibles et revenus par mois et année"></canvas>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'matieres' ? 'is-visible' : '' }}" id="panel-matieres" data-panel="matieres">
                <div class="form-window">
                    <div class="form-window__head">
                        <div>
                            <h2 class="form-window__title">Matière</h2>
                        </div>
                        <div class="centre-sheet-actions">
                            <button type="button" class="btn btn--primary" id="matiere-add-open">Ajouter</button>
                            <button type="button" class="btn btn--secondary" id="matiere-validate">Valider</button>
                        </div>
                    </div>

                    @if ($errors->any() && ($activeSection ?? '') === 'matieres')
                        <div class="form-alert form-alert--error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="doc-panel-scroll">
                        <div class="matiere-groups" id="matiere-groups">
                            @forelse ($matiereCategories ?? [] as $categorie)
                                <section class="matiere-group" data-categorie-id="{{ $categorie->id }}">
                                    <h3 class="matiere-group__title">{{ $categorie->titre }}</h3>
                                    @if ($categorie->cartes->isEmpty())
                                        <p class="matiere-empty">Aucune carte pour ce titre.</p>
                                    @else
                                        <div class="matiere-cards">
                                            @foreach ($categorie->cartes as $carte)
                                                <button
                                                    type="button"
                                                    class="matiere-card"
                                                    data-carte-id="{{ $carte->id }}"
                                                    data-carte-nom="{{ $carte->nom }}"
                                                >
                                                    {{ $carte->nom }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </section>
                            @empty
                                <p class="matiere-empty">Aucune matière enregistrée. Cliquez sur Ajouter.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="doc-overlay" id="matiere-form-overlay" aria-hidden="true">
                    <div class="doc-modal doc-modal--form" role="dialog" aria-modal="true" aria-labelledby="matiere-form-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="matiere-form-title">Ajouter un titre</h3>
                                <p class="doc-modal__subtitle">Plusieurs cartes possibles</p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="matiere-form-close">Fermer</button>
                        </div>

                        <form method="POST" action="{{ route('admin.matieres.store') }}" class="form-fields" id="matiere-admin-form" novalidate>
                            @csrf

                            <div class="form-field form-field--full">
                                <label for="matiere_titre">Titre</label>
                                <input id="matiere_titre" type="text" name="titre" required maxlength="255" placeholder="Ex. Communication">
                            </div>

                            <div class="form-field form-field--full">
                                <label>Carte</label>
                                <div class="matiere-carte-rows" id="matiere-carte-rows">
                                    <div class="matiere-carte-row">
                                        <input type="text" name="cartes[]" required maxlength="255" placeholder="Nom de la carte">
                                        <button type="button" class="btn btn--ghost matiere-carte-add" title="Ajouter une carte">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="doc-modal__actions form-field--full">
                                <button type="button" class="btn btn--ghost" id="matiere-form-cancel">Fermer</button>
                                <button type="submit" class="btn btn--primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="matiere-sheet-overlay" id="matiere-sheet-overlay" aria-hidden="true">
                    <div class="matiere-sheet" role="dialog" aria-modal="true" aria-labelledby="matiere-sheet-title">
                        <div class="matiere-sheet__head">
                            <div>
                                <p class="matiere-sheet__eyebrow" id="matiere-sheet-titre"></p>
                                <h3 class="matiere-sheet__title" id="matiere-sheet-title"></h3>
                            </div>
                            <button type="button" class="matiere-sheet__close" id="matiere-sheet-close" aria-label="Fermer">×</button>
                        </div>
                        <div class="matiere-sheet__stats">
                            <div class="matiere-sheet__stat">
                                <span class="matiere-sheet__label">Nbre d'étudiants</span>
                                <span class="matiere-sheet__value" id="matiere-sheet-etudiants">0</span>
                            </div>
                            <div class="matiere-sheet__stat">
                                <span class="matiere-sheet__label">Nbre de profs</span>
                                <span class="matiere-sheet__value" id="matiere-sheet-profs">0</span>
                            </div>
                            <div class="matiere-sheet__stat">
                                <span class="matiere-sheet__label">Revenu mensuel</span>
                                <span class="matiere-sheet__value" id="matiere-sheet-revenu">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-seances' ? 'is-visible' : '' }}" id="panel-fiche-seances" data-panel="fiche-seances">
                <div class="form-window">
                    <div class="form-window__head">
                        <h2 class="form-window__title">Fiche des Séances</h2>
                        <p class="form-window__desc">Remplissez les informations d’une séance pour l’afficher sur le tableau de bord principal.</p>
                    </div>
                    <div class="form-fields">
                        <div class="form-field">
                            <label for="seance_numero">N° Séance</label>
                            <select id="seance_numero" name="seance_numero">
                                @for ($n = 1; $n <= 30; $n++)
                                    <option value="{{ $n }}">Séance {{ str_pad((string) $n, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="seance_statut">Statut</label>
                            <select id="seance_statut" name="seance_statut">
                                <option value="reelle">Séance Réelle</option>
                                <option value="vide">Séance Vide</option>
                                <option value="reportee">Séance Reportée</option>
                                <option value="individuelle">Séance Individuelle</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="seance_date">Date</label>
                            <input id="seance_date" type="date" name="seance_date" value="{{ now()->toDateString() }}">
                        </div>
                        <div class="form-field">
                            <label for="seance_debut">Heure Début</label>
                            <input id="seance_debut" type="time" name="seance_debut" value="08:00">
                        </div>
                        <div class="form-field">
                            <label for="seance_fin">Heure Fin</label>
                            <input id="seance_fin" type="time" name="seance_fin" value="09:30">
                        </div>
                        <div class="form-field">
                            <label for="seance_classe">N° de Classe</label>
                            <input id="seance_classe" type="text" name="seance_classe" placeholder="Ex. C01" maxlength="20">
                        </div>
                        <div class="form-field">
                            <label for="seance_matiere">Matière</label>
                            <input id="seance_matiere" type="text" name="seance_matiere" placeholder="Ex. Mathématiques">
                        </div>
                        <div class="form-field">
                            <label for="seance_prof">Prof</label>
                            <input id="seance_prof" type="text" name="seance_prof" placeholder="Nom du professeur">
                        </div>
                        <div class="form-field">
                            <label for="seance_presents">Élèves Présents</label>
                            <input id="seance_presents" type="number" name="seance_presents" min="0" value="0">
                        </div>
                        <div class="form-field">
                            <label for="seance_absents">Élèves Absents</label>
                            <input id="seance_absents" type="number" name="seance_absents" min="0" value="0">
                        </div>
                        <div class="doc-modal__actions form-field--full">
                            <button type="button" class="btn btn--primary" id="seance-fill-apply">Valider sur le tableau</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-analytique-profs' ? 'is-visible' : '' }}" id="panel-fiche-analytique-profs" data-panel="fiche-analytique-profs">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Fiche Analytique</h2>
                    <p>Consultez les indicateurs analytiques détaillés des professeurs.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-prof' ? 'is-visible' : '' }}" id="panel-fiche-prof" data-panel="fiche-prof">
                <div class="form-window">
                    <div class="form-window__head">
                        <div>
                            <h2 class="form-window__title">Fiche Prof</h2>
                        </div>
                        <div class="centre-sheet-actions">
                            <button type="button" class="btn btn--primary" id="prof-add-open">Ajouter</button>
                            <button type="button" class="btn btn--danger" id="prof-panel-close">Fermer</button>
                        </div>
                    </div>

                    @if ($errors->any() && ($activeSection ?? '') === 'fiche-prof')
                        <div class="form-alert form-alert--error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="doc-panel-scroll" id="prof-print-area">
                        <div class="doc-table-wrap">
                            <table class="doc-table" id="prof-main-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>ID</th>
                                        <th>Nom Complet</th>
                                        <th>Matière</th>
                                        <th>Statut</th>
                                        <th>Établissement</th>
                                        <th>Niveau</th>
                                        <th>Type</th>
                                        <th>Paiement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="prof-table-body">
                                    @forelse ($profsList ?? [] as $prof)
                                        <tr class="prof-row" data-prof-id="{{ $prof->id }}">
                                            <td>{{ optional($prof->date_prof)->format('d/m/Y') ?: '—' }}</td>
                                            <td>{{ $prof->reference }}</td>
                                            <td>{{ $prof->nom_complet }}</td>
                                            <td>{{ $prof->matiere }}</td>
                                            <td>{{ $prof->statut_label }}</td>
                                            <td>{{ $prof->etablissement ?: '—' }}</td>
                                            <td>{{ $prof->niveau_label }}</td>
                                            <td>{{ $prof->type_label }}</td>
                                            <td>{{ $prof->paiement_label }}</td>
                                            <td>
                                                <div class="doc-actions">
                                                    <button type="button" class="doc-action doc-action--icon" data-prof-view="{{ $prof->id }}" title="Voir" aria-label="Voir">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </button>
                                                    <button type="button" class="doc-action doc-action--icon" data-prof-edit="{{ $prof->id }}" title="Modifier" aria-label="Modifier">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20h4l11-11-4-4L4 16v4z"/><path d="M13.5 6.5l4 4"/></svg>
                                                    </button>
                                                    <button type="button" class="doc-action doc-action--icon doc-action--danger" data-prof-delete="{{ $prof->id }}" title="Supprimer" aria-label="Supprimer">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M9 7V5h6v2"/><path d="M7 7l1 13h8l1-13"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="prof-empty-row">
                                            <td colspan="10" class="doc-empty">Aucun professeur enregistré. Cliquez sur Ajouter pour saisir.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="doc-overlay" id="prof-form-overlay" aria-hidden="true">
                    <div class="doc-modal doc-modal--form" role="dialog" aria-modal="true" aria-labelledby="prof-form-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="prof-form-title">Nouveau professeur</h3>
                                <p class="doc-modal__subtitle" id="prof-form-subtitle">Saisie</p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="prof-form-close">Fermer</button>
                        </div>

                        <form method="POST" action="{{ route('admin.profs.store') }}" class="form-fields" id="prof-admin-form" novalidate>
                            @csrf
                            <input type="hidden" name="_method" id="prof-form-method" value="POST">

                            <div class="form-field">
                                <label for="prof_date">Date</label>
                                <input id="prof_date" type="date" name="date_prof" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="form-field">
                                <label for="prof_reference">ID</label>
                                <input id="prof_reference" type="text" readonly value="{{ $nextProfRef ?? 'PR-0001' }}">
                            </div>
                            <div class="form-field form-field--full">
                                <label for="prof_nom">Nom Complet</label>
                                <input id="prof_nom" type="text" name="nom_complet" required maxlength="255" placeholder="Nom complet">
                            </div>
                            <div class="form-field">
                                <label for="prof_matiere">Matière</label>
                                <input id="prof_matiere" type="text" name="matiere" required maxlength="255" placeholder="Matière">
                            </div>
                            <div class="form-field">
                                <label for="prof_statut">Statut</label>
                                <select id="prof_statut" name="statut" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($profStatuts ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="prof_etablissement">Établissement</label>
                                <input id="prof_etablissement" type="text" name="etablissement" maxlength="255" placeholder="Établissement">
                            </div>
                            <div class="form-field">
                                <label for="prof_niveau">Niveau</label>
                                <select id="prof_niveau" name="niveau" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($profNiveaux ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="prof_type">Type</label>
                                <select id="prof_type" name="type" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($profTypes ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="prof_paiement">Paiement</label>
                                <select id="prof_paiement" name="paiement" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($profPaiements ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="doc-modal__actions form-field--full">
                                <button type="button" class="btn btn--ghost" id="prof-form-cancel">Fermer</button>
                                <button type="submit" class="btn btn--primary" id="prof-form-submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="doc-overlay" id="prof-view-overlay" aria-hidden="true">
                    <div class="doc-modal" role="dialog" aria-modal="true" aria-labelledby="prof-view-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="prof-view-title">Détail professeur</h3>
                                <p class="doc-modal__subtitle" id="prof-view-subtitle"></p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="prof-view-close">Fermer</button>
                        </div>
                        <div class="doc-view-grid" id="prof-view-body"></div>
                        <div class="doc-modal__actions">
                            <a class="btn btn--ghost" id="prof-view-pdf" href="#" target="_blank" rel="noopener">PDF</a>
                            <button type="button" class="btn btn--primary" id="prof-view-edit">Modifier</button>
                        </div>
                    </div>
                </div>

                <form method="POST" id="prof-delete-form" hidden>
                    @csrf
                    @method('DELETE')
                </form>
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
                    <p>Affectez les professeurs aux matiÃ¨res et aux classes.</p>
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
                    <p>Consultez et exportez les rapports liÃ©s aux professeurs.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'etudiants' ? 'is-visible' : '' }}" id="panel-etudiants" data-panel="etudiants">
                <div class="form-window">
                    <div class="form-window__head etudiant-head">
                        <div>
                            <h2 class="form-window__title">Gestion Etudiant</h2>
                        </div>
                        <div class="centre-sheet-actions">
                            <button type="button" class="btn btn--primary" id="etudiant-add-open">Ajouter</button>
                            <button type="button" class="btn btn--danger" id="etudiant-panel-close">Fermer</button>
                        </div>
                    </div>

                    @if ($errors->any() && ($activeSection ?? '') === 'etudiants')
                        <div class="form-alert form-alert--error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="analytics-sticky etudiant-analytics">
                        <div class="stats stats--paiement stats--etudiants">
                            <article class="stat">
                                <div class="stat__label">Effectifs</div>
                                <div class="stat__value">{{ number_format((float) ($etudiantsStats['effectifs'] ?? 0), 0, ',', ' ') }}</div>
                            </article>
                            <article class="stat">
                                <div class="stat__label">Revenu</div>
                                <div class="stat__value">{{ number_format((float) ($etudiantsStats['revenu'] ?? 0), 2, ',', ' ') }}</div>
                            </article>
                            <article class="stat">
                                <div class="stat__label">Solde</div>
                                <div class="stat__value">{{ number_format((float) ($etudiantsStats['solde'] ?? 0), 2, ',', ' ') }}</div>
                            </article>
                        </div>
                    </div>

                    <div class="doc-panel-scroll">
                        <div class="doc-table-wrap">
                            <table class="doc-table" id="etudiant-main-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>ID/ET</th>
                                        <th>Nom Complet</th>
                                        <th>Niv/Sc</th>
                                        <th>Date/Insc</th>
                                        <th>Matière</th>
                                        <th>Type Paie</th>
                                        <th>Mode Paie</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="etudiant-table-body">
                                    @forelse ($etudiantsList ?? [] as $etudiant)
                                        <tr class="etudiant-row" data-etudiant-id="{{ $etudiant->id }}">
                                            <td>{{ optional($etudiant->date_etudiant)->format('d/m/Y') ?: '—' }}</td>
                                            <td>{{ $etudiant->reference }}</td>
                                            <td>{{ $etudiant->nom_complet }}</td>
                                            <td>{{ $etudiant->niveau_scolaire }}</td>
                                            <td>{{ optional($etudiant->date_inscription)->format('d/m/Y') ?: '—' }}</td>
                                            <td>{{ $etudiant->matiere }}</td>
                                            <td>{{ $etudiant->type_paie_label }}</td>
                                            <td>{{ $etudiant->mode_paie_label }}</td>
                                            <td>
                                                @if ($etudiant->photo)
                                                    <img class="etudiant-photo-thumb" src="{{ asset('storage/'.$etudiant->photo) }}" alt="Photo {{ $etudiant->nom_complet }}">
                                                @else
                                                    <span class="etudiant-photo-empty">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="doc-actions">
                                                    <button type="button" class="doc-action doc-action--icon" data-etudiant-view="{{ $etudiant->id }}" title="Voir" aria-label="Voir">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </button>
                                                    <button type="button" class="doc-action doc-action--icon" data-etudiant-edit="{{ $etudiant->id }}" title="Modifier" aria-label="Modifier">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20h4l11-11-4-4L4 16v4z"/><path d="M13.5 6.5l4 4"/></svg>
                                                    </button>
                                                    <button type="button" class="doc-action doc-action--icon doc-action--danger" data-etudiant-delete="{{ $etudiant->id }}" title="Supprimer" aria-label="Supprimer">
                                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M9 7V5h6v2"/><path d="M7 7l1 13h8l1-13"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="etudiant-empty-row">
                                            <td colspan="10" class="doc-empty">Aucun étudiant enregistré. Cliquez sur Ajouter pour saisir.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="doc-overlay" id="etudiant-form-overlay" aria-hidden="true">
                    <div class="doc-modal doc-modal--form" role="dialog" aria-modal="true" aria-labelledby="etudiant-form-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="etudiant-form-title">Nouveau étudiant</h3>
                                <p class="doc-modal__subtitle" id="etudiant-form-subtitle">Saisie</p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="etudiant-form-close">Fermer</button>
                        </div>

                        <form method="POST" action="{{ route('admin.etudiants.store') }}" class="form-fields" id="etudiant-admin-form" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="form-field form-field--full etudiant-photo-top">
                                <label>Photo</label>
                                <div class="form-photo etudiant-form-photo">
                                    <div class="form-photo__preview" id="etudiant-photo-preview">
                                        <img id="etudiant-photo-img" src="" alt="Aperçu photo">
                                        <div class="form-photo__placeholder">
                                            <strong>Photo étudiant</strong>
                                            JPG, PNG — max 5 Mo
                                        </div>
                                    </div>
                                    <label class="form-photo__btn" for="etudiant_photo">Importer Photo</label>
                                    <input id="etudiant_photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp,image/gif,.jpg,.jpeg,.png,.webp,.gif">
                                    <p class="etudiant-photo-hint" id="etudiant-photo-hint" hidden>Photo actuelle conservée si aucun nouveau fichier.</p>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="etudiant_date">Date</label>
                                <input id="etudiant_date" type="date" name="date_etudiant" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="form-field">
                                <label for="etudiant_reference">ID/ET</label>
                                <input id="etudiant_reference" type="text" readonly value="{{ $nextEtudiantRef ?? 'ID/ET-0001' }}">
                            </div>
                            <div class="form-field form-field--full">
                                <label for="etudiant_nom">Nom Complet</label>
                                <input id="etudiant_nom" type="text" name="nom_complet" required maxlength="255" placeholder="Nom complet">
                            </div>
                            <div class="form-field">
                                <label for="etudiant_niveau">Niv/Sc</label>
                                <input id="etudiant_niveau" type="text" name="niveau_scolaire" required maxlength="120" placeholder="Ex. 3ème, 1ère Bac…">
                            </div>
                            <div class="form-field">
                                <label for="etudiant_matiere">Matière</label>
                                <select id="etudiant_matiere" name="matiere" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($matiereOptions ?? [] as $matiereNom)
                                        <option value="{{ $matiereNom }}">{{ $matiereNom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="etudiant_type_paie">Type Paie</label>
                                <select id="etudiant_type_paie" name="type_paie" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($etudiantTypePaies ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="etudiant_mode_paie">Mode Paie</label>
                                <select id="etudiant_mode_paie" name="mode_paie" required>
                                    <option value="">— Choisir —</option>
                                    @foreach ($etudiantModePaies ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="doc-modal__actions form-field--full">
                                <button type="button" class="btn btn--ghost" id="etudiant-form-cancel">Fermer</button>
                                <button type="submit" class="btn btn--primary" id="etudiant-form-submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="doc-overlay" id="etudiant-view-overlay" aria-hidden="true">
                    <div class="doc-modal" role="dialog" aria-modal="true" aria-labelledby="etudiant-view-title">
                        <div class="doc-modal__head">
                            <div>
                                <h3 class="doc-modal__title" id="etudiant-view-title">Détail étudiant</h3>
                                <p class="doc-modal__subtitle" id="etudiant-view-subtitle"></p>
                            </div>
                            <button type="button" class="btn btn--ghost" id="etudiant-view-close">Fermer</button>
                        </div>
                        <div class="doc-view-grid" id="etudiant-view-body"></div>
                        <div class="doc-modal__actions">
                            <button type="button" class="btn btn--ghost" id="etudiant-view-print">Imprimer</button>
                            <button type="button" class="btn btn--primary" id="etudiant-view-edit">Modifier</button>
                        </div>
                    </div>
                </div>

                <form method="POST" id="etudiant-delete-form" hidden>
                    @csrf
                    @method('DELETE')
                </form>

                <div class="etudiant-print-sheet" id="etudiant-print-sheet" aria-hidden="true">
                    <img class="etudiant-print-sheet__photo" id="etudiant-print-photo" src="" alt="Photo">
                    <div id="etudiant-print-body"></div>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'fiche-eleve' ? 'is-visible' : '' }}" id="panel-fiche-eleve" data-panel="fiche-eleve">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Fiche Ã‰lÃ¨ve</h2>
                    <p>CrÃ©ez et consultez les dossiers individuels des Ã©lÃ¨ves.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'affectation-suivi' ? 'is-visible' : '' }}" id="panel-affectation-suivi" data-panel="affectation-suivi">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Affectation et Suivi PÃ©dagogiques</h2>
                    <p>Affectez les Ã©lÃ¨ves et suivez leur parcours pÃ©dagogique.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'discipline' ? 'is-visible' : '' }}" id="panel-discipline" data-panel="discipline">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Discipline</h2>
                    <p>GÃ©rez les incidents, absences et mesures disciplinaires.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'notes-evaluations' ? 'is-visible' : '' }}" id="panel-notes-evaluations" data-panel="notes-evaluations">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Notes &amp; Ã‰valuations</h2>
                    <p>Saisissez les notes et suivez les Ã©valuations des Ã©lÃ¨ves.</p>
                </div>
            </section>

            <section class="panel {{ ($activeSection ?? '') === 'rapports-etudiants' ? 'is-visible' : '' }}" id="panel-rapports-etudiants" data-panel="rapports-etudiants">
                <div class="panel-placeholder">
                    <h2 class="panel__title">Rapports</h2>
                    <p>Consultez et exportez les rapports liÃ©s aux Ã©tudiants.</p>
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
        const mainContent = document.querySelector('.main');
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
                'fiche-seances',
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
                'matieres',
                'fiche-analytique-profs',
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

        const moisLabels = ['Jan', 'FÃ©v', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'AoÃ»t', 'Sep', 'Oct', 'Nov', 'DÃ©c'];
        let paiementChart = null;
        let profsChart = null;
        let currentSection = initialSection;

        const profsData = {
            2025: {
                actives: [12, 13, 13, 14, 14, 15, 15, 15, 16, 16, 17, 17],
                faibles: [5, 5, 4, 5, 4, 4, 3, 4, 3, 3, 3, 2],
                revenus: [18200, 19500, 21400, 22800, 23600, 24900, 25700, 26300, 27800, 29100, 30500, 31800],
            },
            2026: {
                actives: [15, 16, 16, 17, 17, 18, 18, 0, 0, 0, 0, 0],
                faibles: [4, 4, 3, 4, 3, 3, 4, 0, 0, 0, 0, 0],
                revenus: [24800, 26100, 27500, 28900, 30200, 31600, 32900, 0, 0, 0, 0, 0],
            },
        };

        function findGroupKey(section) {
            return Object.keys(groupChildren).find((key) => groupChildren[key].includes(section)) || section;
        }

        function buildProfsChart(year) {
            const canvas = document.getElementById('profs-chart');
            if (!canvas || typeof Chart === 'undefined') return;

            const data = profsData[year] || profsData[2026];

            if (profsChart) {
                profsChart.destroy();
            }

            const gradientFill = canvas.getContext('2d').createLinearGradient(0, 0, 0, 320);
            gradientFill.addColorStop(0, 'rgba(107, 92, 224, 0.25)');
            gradientFill.addColorStop(1, 'rgba(107, 92, 224, 0.02)');

            profsChart = new Chart(canvas, {
                data: {
                    labels: moisLabels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Matières Actives',
                            data: data.actives,
                            backgroundColor: 'rgba(34, 170, 130, 0.72)',
                            borderColor: 'rgba(26, 122, 92, 0.95)',
                            borderWidth: 1.5,
                            borderRadius: 9,
                            hoverBackgroundColor: 'rgba(34, 170, 130, 0.95)',
                            order: 2,
                            yAxisID: 'y',
                        },
                        {
                            type: 'bar',
                            label: 'Matières Faibles',
                            data: data.faibles,
                            backgroundColor: 'rgba(224, 69, 90, 0.68)',
                            borderColor: 'rgba(184, 50, 69, 0.95)',
                            borderWidth: 1.5,
                            borderRadius: 9,
                            hoverBackgroundColor: 'rgba(224, 69, 90, 0.92)',
                            order: 3,
                            yAxisID: 'y',
                        },
                        {
                            type: 'line',
                            label: 'Revenus',
                            data: data.revenus,
                            borderColor: 'rgba(107, 92, 224, 0.95)',
                            backgroundColor: gradientFill,
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: 'rgba(107, 92, 224, 1)',
                            pointBorderWidth: 2,
                            order: 1,
                            yAxisID: 'yRevenue',
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
                                font: { family: 'Poppins', size: 12, weight: '600' },
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
                                    if (ctx.dataset.label === 'Revenus') {
                                        return ` Revenus: ${value.toLocaleString('fr-FR')} DA`;
                                    }
                                    return ` ${ctx.dataset.label}: ${value}`;
                                },
                                footer(items) {
                                    const totalActives = Number(items.find((i) => i.dataset.label === 'Matières Actives')?.raw || 0);
                                    const totalFaibles = Number(items.find((i) => i.dataset.label === 'Matières Faibles')?.raw || 0);
                                    if (!totalActives) return '';
                                    const ratio = ((totalFaibles / totalActives) * 100).toFixed(1);
                                    return `Ratio matières faibles : ${ratio}%`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(20, 90, 140, 0.08)' },
                            ticks: { color: '#5d7f99', font: { family: 'Poppins', size: 11 } },
                        },
                        y: {
                            beginAtZero: true,
                            suggestedMax: 40,
                            grid: { color: 'rgba(20, 90, 140, 0.1)' },
                            title: {
                                display: true,
                                text: 'Nombre de matières',
                                color: '#5d7f99',
                                font: { family: 'Poppins', size: 11, weight: '600' },
                            },
                            ticks: {
                                color: '#5d7f99',
                                font: { family: 'Poppins', size: 11 },
                                precision: 0,
                                callback(value) {
                                    return Number(value).toLocaleString('fr-FR');
                                },
                            },
                        },
                        yRevenue: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: {
                                display: true,
                                text: 'Revenus (DA)',
                                color: '#6b5ce0',
                                font: { family: 'Poppins', size: 11, weight: '600' },
                            },
                            ticks: {
                                color: '#6b5ce0',
                                font: { family: 'Poppins', size: 11 },
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
                            label: 'Montant PayÃ©',
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
                                font: { family: 'Poppins', size: 12, weight: '600' },
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
                            ticks: { color: '#5d7f99', font: { family: 'Poppins', size: 11 } },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(20, 90, 140, 0.1)' },
                            ticks: {
                                color: '#5d7f99',
                                font: { family: 'Poppins', size: 11 },
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

        function showSection(section, { openGroup = false } = {}) {
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

            mainContent?.classList.toggle('is-dashboard', section === 'administration');
            document.getElementById('sidebar-home-btn')?.classList.toggle('is-active', section === 'administration');

            sidebar.classList.remove('is-open');

            if (section === 'paiement') {
                refreshPaiementChart();
            }

            if (section === 'profs') {
                refreshProfsChart();
            }
        }

        document.getElementById('sidebar-home-btn')?.addEventListener('click', () => {
            closeAllGroups();
            showSection('administration', { openGroup: false });
            window.history.replaceState({}, '', @json(route('admin.dashboard', ['section' => 'administration'])));
        });

        menuToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('is-open');
        });

        groupToggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const section = toggle.dataset.section;
                const group = toggle.closest('[data-nav-group]');
                const isOpen = group?.classList.contains('is-open');
                const hasSub = Boolean(group?.querySelector('.nav-sub'));

                if (hasSub) {
                    if (isOpen) {
                        setGroupOpen(group, false);
                        return;
                    }

                    closeAllGroups();
                    setGroupOpen(group, true);
                    showSection(section, { openGroup: false });
                    return;
                }

                closeAllGroups();
                showSection(section, { openGroup: false });
            });
        });

        navSubItems.forEach((item) => {
            item.addEventListener('click', (event) => {
                event.stopPropagation();
                showSection(item.dataset.section, { openGroup: false });
            });
        });

        document.querySelectorAll('[data-prof-target]').forEach((card) => {
            card.addEventListener('click', () => {
                showSection(card.dataset.profTarget, { openGroup: false });
            });
        });

        const sessionViewOverlay = document.getElementById('session-view-overlay');
        const sessionsWindow = document.getElementById('sessions-window');
        const sessionsToggle = document.getElementById('sessions-toggle');
        const sessionsToggleLabel = document.getElementById('sessions-toggle-label');

        function setSessionsVisible(visible) {
            sessionsWindow?.classList.toggle('is-collapsed', !visible);
            sessionsToggle?.setAttribute('aria-expanded', visible ? 'true' : 'false');
            if (sessionsToggleLabel) {
                sessionsToggleLabel.textContent = visible ? 'Masquer' : 'Afficher';
            }
            const icon = sessionsToggle?.querySelector('svg');
            if (icon) {
                icon.innerHTML = visible
                    ? '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>'
                    : '<path d="M3 3l18 18"/><path d="M10.6 10.6a3 3 0 004.2 4.2"/><path d="M9.9 5.1A10.4 10.4 0 0112 5c6.5 0 10 7 10 7a17.7 17.7 0 01-3.2 4.4"/><path d="M6.1 6.1C3.7 7.9 2 12 2 12s3.5 7 10 7c1.4 0 2.7-.3 3.9-.8"/>';
            }
        }

        sessionsToggle?.addEventListener('click', () => {
            const visible = sessionsToggle.getAttribute('aria-expanded') !== 'true';
            setSessionsVisible(visible);
        });

        function closeSessionView() {
            if (!sessionViewOverlay) return;
            sessionViewOverlay.classList.remove('is-open');
            sessionViewOverlay.setAttribute('aria-hidden', 'true');
        }

        document.getElementById('sessions-grid')?.addEventListener('click', (event) => {
            const sessionButton = event.target.closest('.session-button');
            if (!sessionButton || !sessionViewOverlay) return;

            const data = sessionButton.dataset;
            const subtitle = document.getElementById('session-view-subtitle');
            const body = document.getElementById('session-view-body');

            if (subtitle) {
                subtitle.textContent = `Séance ${data.sessionNumber} · ${data.sessionStatus}`;
            }

            if (body) {
                const fields = [
                    ['Date', data.sessionDate],
                    ['N° de Classe', data.sessionClasse],
                    ['Heure Début', data.sessionStart],
                    ['Heure Fin', data.sessionEnd],
                    ['Matière', data.sessionSubject],
                    ['Prof', data.sessionProf],
                    ['Élèves Présents', data.sessionPresent],
                    ['Élèves Absents', data.sessionAbsent],
                    ['Statut', data.sessionStatus],
                ];

                body.innerHTML = fields.map(([label, value]) => `
                    <div class="form-field">
                        <label>${label}</label>
                        <div class="doc-view-value">${value || '—'}</div>
                    </div>
                `).join('');
            }

            sessionViewOverlay.classList.add('is-open');
            sessionViewOverlay.setAttribute('aria-hidden', 'false');
        });

        document.getElementById('session-view-close')?.addEventListener('click', closeSessionView);
        document.getElementById('session-view-ok')?.addEventListener('click', closeSessionView);
        sessionViewOverlay?.addEventListener('click', (event) => {
            if (event.target === sessionViewOverlay) closeSessionView();
        });

        const seanceStatusLabels = {
            reelle: 'Séance Réelle',
            vide: 'Séance Vide',
            reportee: 'Séance Reportée',
            individuelle: 'Séance Individuelle',
        };

        function formatSeanceDate(isoDate) {
            if (!isoDate) return '—';
            const [y, m, d] = isoDate.split('-');
            return `${d}/${m}/${y}`;
        }

        function applySessionsCalendarFilters() {
            const day = document.getElementById('sessions-filter-day')?.value || '';
            const month = document.getElementById('sessions-filter-month')?.value || '';

            document.querySelectorAll('#sessions-grid .session-button').forEach((button) => {
                const iso = button.dataset.sessionIso || '';
                const buttonMonth = button.dataset.sessionMonth || (iso ? iso.slice(0, 7) : '');
                const matchDay = !day || iso === day;
                const matchMonth = !month || buttonMonth === month;
                button.classList.toggle('is-filtered-out', !(matchDay && matchMonth));
            });
        }

        document.getElementById('sessions-filter-day')?.addEventListener('change', () => {
            const day = document.getElementById('sessions-filter-day')?.value || '';
            const monthInput = document.getElementById('sessions-filter-month');
            if (day && monthInput && !monthInput.value) {
                monthInput.value = day.slice(0, 7);
            }
            applySessionsCalendarFilters();
        });

        document.getElementById('sessions-filter-month')?.addEventListener('change', applySessionsCalendarFilters);

        document.getElementById('sessions-filter-day-reset')?.addEventListener('click', () => {
            const dayInput = document.getElementById('sessions-filter-day');
            if (dayInput) dayInput.value = '';
            applySessionsCalendarFilters();
        });

        document.getElementById('sessions-filter-month-reset')?.addEventListener('click', () => {
            const monthInput = document.getElementById('sessions-filter-month');
            const dayInput = document.getElementById('sessions-filter-day');
            if (monthInput) monthInput.value = '';
            if (dayInput) dayInput.value = '';
            applySessionsCalendarFilters();
        });

        document.getElementById('seance-fill-apply')?.addEventListener('click', () => {
            const number = document.getElementById('seance_numero')?.value || '1';
            const statusKey = document.getElementById('seance_statut')?.value || 'vide';
            const dateIso = document.getElementById('seance_date')?.value || '';
            const start = document.getElementById('seance_debut')?.value || '—';
            const end = document.getElementById('seance_fin')?.value || '—';
            const classe = (document.getElementById('seance_classe')?.value || '').trim().toUpperCase() || (statusKey === 'vide' ? '—' : 'C00');
            const subject = (document.getElementById('seance_matiere')?.value || '').trim() || (statusKey === 'vide' ? 'À Programmer' : 'Sans Matière');
            const prof = (document.getElementById('seance_prof')?.value || '').trim() || (statusKey === 'vide' ? 'Non Affecté' : 'Sans Prof');
            const presents = document.getElementById('seance_presents')?.value || '0';
            const absents = document.getElementById('seance_absents')?.value || '0';
            const padded = String(number).padStart(2, '0');
            const button = document.querySelector(`#sessions-grid .session-button[data-session-number="${padded}"]`);
            if (!button) return;

            button.className = `session-button session-button--${statusKey}`;
            button.dataset.sessionStatus = seanceStatusLabels[statusKey] || statusKey;
            button.dataset.sessionDate = formatSeanceDate(dateIso);
            button.dataset.sessionIso = dateIso;
            button.dataset.sessionMonth = dateIso ? dateIso.slice(0, 7) : '';
            button.dataset.sessionStart = statusKey === 'vide' ? '—' : start;
            button.dataset.sessionEnd = statusKey === 'vide' ? '—' : end;
            button.dataset.sessionClasse = classe;
            button.dataset.sessionSubject = subject.toUpperCase();
            button.dataset.sessionProf = prof.toUpperCase();
            button.dataset.sessionPresent = presents;
            button.dataset.sessionAbsent = absents;

            const subjectEl = button.querySelector('.session-button__subject');
            const classeEl = button.querySelector('.session-button__classe');
            const dateEl = button.querySelector('.session-button__date');
            if (subjectEl) subjectEl.textContent = subject.toUpperCase();
            if (classeEl) classeEl.textContent = `Classe ${classe}`;
            if (dateEl) {
                dateEl.textContent = statusKey === 'vide'
                    ? `${formatSeanceDate(dateIso)} · Libre`
                    : `${formatSeanceDate(dateIso)} · ${start} – ${end}`;
            }

            applySessionsCalendarFilters();
            showSection('administration', { openGroup: false });
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

        const centreEditor = document.getElementById('centre-editor');
        const centreSheetWrap = document.getElementById('centre-sheet-wrap');

        document.getElementById('centre-print')?.addEventListener('click', () => {
            window.print();
        });

        document.getElementById('centre-edit')?.addEventListener('click', () => {
            if (centreSheetWrap) centreSheetWrap.hidden = true;
            if (centreEditor) centreEditor.hidden = false;
            centreEditor?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        document.getElementById('centre-close')?.addEventListener('click', () => {
            if (centreSheetWrap) centreSheetWrap.hidden = true;
            showSection('administration', { openGroup: false });
            window.history.replaceState({}, '', @json(route('admin.dashboard')));
        });

        const docFormOverlay = document.getElementById('doc-form-overlay');
        const docViewOverlay = document.getElementById('doc-view-overlay');
        const docAdminForm = document.getElementById('doc-admin-form');
        const docFormMethod = document.getElementById('doc-form-method');
        const docFormTitle = document.getElementById('doc-form-title');
        const docFormSubtitle = document.getElementById('doc-form-subtitle');
        const docReferenceInput = document.getElementById('doc_reference');
        const docTypeSelect = document.getElementById('doc_type');
        const docDeleteForm = document.getElementById('doc-delete-form');
        const nextDocumentRefs = @json($nextDocumentRefs ?? []);
        const documentTypes = @json($documentTypes ?? []);
        const documentStatuts = @json($documentStatuts ?? []);
        const documentsIndex = @json($documentsIndex ?? []);
        const docStoreUrl = @json(route('admin.documents.store'));
        let activeDocumentType = @json($activeDocType ?? null);
        let editingDocumentId = null;

        const filterMois = document.getElementById('doc-filter-mois');
        const filterType = document.getElementById('doc-filter-type');
        const filterStatut = document.getElementById('doc-filter-statut');
        const filterSearch = document.getElementById('doc-filter-search');

        function setOverlayOpen(overlay, open) {
            if (!overlay) return;
            overlay.classList.toggle('is-open', open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }

        function syncDocCardsActive() {
            document.querySelectorAll('.doc-card').forEach((card) => {
                card.classList.toggle('is-active', Boolean(activeDocumentType) && card.dataset.type === activeDocumentType);
            });
        }

        function applyDocFilters() {
            const month = (filterMois?.value || '').trim();
            const type = (filterType?.value || activeDocumentType || '').trim();
            const statut = (filterStatut?.value || '').trim();
            const search = (filterSearch?.value || '').trim().toUpperCase();
            let visible = 0;

            document.querySelectorAll('#doc-table-body tr.doc-row').forEach((row) => {
                const matchMonth = !month || row.dataset.docMonth === month;
                const matchType = !type || row.dataset.docType === type;
                const matchStatut = !statut || row.dataset.docStatut === statut;
                const matchSearch = !search || (row.dataset.docSearch || '').includes(search);
                const show = matchMonth && matchType && matchStatut && matchSearch;
                row.hidden = !show;
                if (show) visible += 1;
            });

            const emptyRow = document.getElementById('doc-empty-row');
            if (emptyRow) emptyRow.hidden = visible > 0;

            let noMatch = document.getElementById('doc-filter-empty');
            if (!noMatch) {
                noMatch = document.createElement('tr');
                noMatch.id = 'doc-filter-empty';
                noMatch.innerHTML = '<td colspan="8" class="doc-empty">Aucun document ne correspond aux filtres.</td>';
                document.getElementById('doc-table-body')?.appendChild(noMatch);
            }
            noMatch.hidden = visible > 0 || Boolean(emptyRow && !emptyRow.hidden);
        }

        function resetDocForm() {
            editingDocumentId = null;
            if (docAdminForm) docAdminForm.action = docStoreUrl;
            if (docFormMethod) docFormMethod.value = 'POST';
            if (docFormTitle) docFormTitle.textContent = 'Nouveau document';
            if (docTypeSelect) docTypeSelect.disabled = false;
            docAdminForm?.reset();
            const type = activeDocumentType || Object.keys(documentTypes)[0];
            if (docTypeSelect && type) docTypeSelect.value = type;
            if (docReferenceInput) docReferenceInput.value = nextDocumentRefs[type] || '';
            if (docFormSubtitle) docFormSubtitle.textContent = documentTypes[type] || 'Saisie';
            const dateInput = document.getElementById('doc_date_document');
            if (dateInput) dateInput.value = new Date().toISOString().slice(0, 10);
            const statutInput = document.getElementById('doc_statut');
            if (statutInput) statutInput.value = 'non_livre';
        }

        function openDocForm(type = null) {
            if (type) {
                activeDocumentType = type;
                if (filterType) filterType.value = type;
                syncDocCardsActive();
                applyDocFilters();
            }
            resetDocForm();
            setOverlayOpen(docFormOverlay, true);
            document.getElementById('doc_titre')?.focus();
        }

        function closeDocForm() {
            setOverlayOpen(docFormOverlay, false);
        }

        function fillDocForm(doc) {
            editingDocumentId = doc.id;
            if (docAdminForm) docAdminForm.action = doc.update_url;
            if (docFormMethod) docFormMethod.value = 'PUT';
            if (docFormTitle) docFormTitle.textContent = 'Modifier document';
            if (docFormSubtitle) docFormSubtitle.textContent = doc.type_label || '';
            if (docTypeSelect) {
                docTypeSelect.value = doc.type;
                docTypeSelect.disabled = true;
            }
            if (docReferenceInput) docReferenceInput.value = doc.reference || '';
            const map = {
                doc_titre: doc.titre || '',
                doc_beneficiaire: doc.beneficiaire || '',
                doc_id_beneficiaire: doc.id_beneficiaire || '',
                doc_famille: doc.famille || '',
                doc_categorie: doc.categorie || '',
                doc_statut: doc.statut || 'non_livre',
                doc_date_document: doc.date_document || '',
                doc_remarque: doc.remarque || '',
            };
            Object.entries(map).forEach(([id, value]) => {
                const el = document.getElementById(id);
                if (el) el.value = value;
            });
        }

        function openDocEdit(id) {
            const doc = documentsIndex[id];
            if (!doc) return;
            setOverlayOpen(docViewOverlay, false);
            fillDocForm(doc);
            setOverlayOpen(docFormOverlay, true);
            document.getElementById('doc_titre')?.focus();
        }

        function openDocView(id) {
            const doc = documentsIndex[id];
            if (!doc) return;
            const body = document.getElementById('doc-view-body');
            const subtitle = document.getElementById('doc-view-subtitle');
            const pdfLink = document.getElementById('doc-view-pdf');
            const editBtn = document.getElementById('doc-view-edit');
            if (subtitle) subtitle.textContent = doc.reference || doc.type_label || '';
            if (pdfLink) pdfLink.href = doc.pdf_url;
            if (editBtn) editBtn.onclick = () => openDocEdit(doc.id);
            if (body) {
                const fields = [
                    ['Date', doc.date_label || '—'],
                    ['Type Doc', doc.type_label || '—'],
                    ['Référence', doc.reference || '—'],
                    ['Titre', doc.titre || '—'],
                    ['ID Bénéficiaire', doc.id_beneficiaire || '—'],
                    ['Bénéficiaire', doc.beneficiaire || '—'],
                    ['Famille', doc.famille || '—'],
                    ['Catégorie', doc.categorie || '—'],
                    ['Statut', doc.statut_label || '—'],
                    ['Remarque', doc.remarque || '—'],
                ];
                body.innerHTML = fields.map(([label, value]) => `
                    <div class="form-field${label === 'Remarque' ? ' form-field--full' : ''}">
                        <label>${label}</label>
                        <div class="doc-view-value">${value}</div>
                    </div>
                `).join('');
            }
            setOverlayOpen(docViewOverlay, true);
        }

        function closeDocView() {
            setOverlayOpen(docViewOverlay, false);
        }

        function deleteDoc(id) {
            const doc = documentsIndex[id];
            if (!doc || !docDeleteForm) return;
            if (!window.confirm(`Supprimer le document ${doc.reference || doc.titre || ''} ?`)) return;
            docDeleteForm.action = doc.delete_url;
            docDeleteForm.submit();
        }

        document.querySelectorAll('.doc-card').forEach((card) => {
            card.addEventListener('click', () => {
                openDocForm(card.dataset.type);
            });
        });

        document.getElementById('doc-add-open')?.addEventListener('click', () => openDocForm(activeDocumentType));
        document.getElementById('doc-form-close')?.addEventListener('click', closeDocForm);
        document.getElementById('doc-form-cancel')?.addEventListener('click', closeDocForm);
        document.getElementById('doc-view-close')?.addEventListener('click', closeDocView);

        docFormOverlay?.addEventListener('click', (event) => {
            if (event.target === docFormOverlay) closeDocForm();
        });
        docViewOverlay?.addEventListener('click', (event) => {
            if (event.target === docViewOverlay) closeDocView();
        });

        docTypeSelect?.addEventListener('change', () => {
            if (editingDocumentId) return;
            const type = docTypeSelect.value;
            if (docReferenceInput) docReferenceInput.value = nextDocumentRefs[type] || '';
            if (docFormSubtitle) docFormSubtitle.textContent = documentTypes[type] || 'Saisie';
        });

        [filterMois, filterType, filterStatut, filterSearch].forEach((el) => {
            el?.addEventListener('input', applyDocFilters);
            el?.addEventListener('change', () => {
                if (el === filterType) {
                    activeDocumentType = filterType.value || null;
                    syncDocCardsActive();
                }
                applyDocFilters();
            });
        });

        document.getElementById('doc-table-body')?.addEventListener('click', (event) => {
            const viewBtn = event.target.closest('[data-doc-view]');
            const editBtn = event.target.closest('[data-doc-edit]');
            const deleteBtn = event.target.closest('[data-doc-delete]');
            if (viewBtn) openDocView(viewBtn.dataset.docView);
            if (editBtn) openDocEdit(editBtn.dataset.docEdit);
            if (deleteBtn) deleteDoc(deleteBtn.dataset.docDelete);
        });

        docAdminForm?.addEventListener('submit', () => {
            if (docTypeSelect) docTypeSelect.disabled = false;
        });

        if (activeDocumentType) {
            if (filterType) filterType.value = activeDocumentType;
            syncDocCardsActive();
        }
        applyDocFilters();

        const fraisFormOverlay = document.getElementById('frais-form-overlay');
        const fraisViewOverlay = document.getElementById('frais-view-overlay');
        const fraisAdminForm = document.getElementById('frais-admin-form');
        const fraisFormMethod = document.getElementById('frais-form-method');
        const fraisFormTitle = document.getElementById('frais-form-title');
        const fraisFormSubtitle = document.getElementById('frais-form-subtitle');
        const fraisCategorieInput = document.getElementById('frais_categorie');
        const fraisReferenceInput = document.getElementById('frais_reference');
        const fraisDeleteForm = document.getElementById('frais-delete-form');
        const nextFraisRefs = @json($nextFraisRefs ?? []);
        const fraisCategories = @json($fraisCategories ?? []);
        const fraisIndex = @json($fraisIndex ?? []);
        const fraisStoreUrl = @json(route('admin.frais.store'));
        let activeFraisType = @json($activeFraisType ?? null);
        let editingFraisId = null;

        function setFraisOverlayOpen(overlay, open) {
            if (!overlay) return;
            overlay.classList.toggle('is-open', open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }

        function syncFraisCardsActive() {
            document.querySelectorAll('#frais-cards .doc-card').forEach((card) => {
                card.classList.toggle('is-active', Boolean(activeFraisType) && card.dataset.fraisType === activeFraisType);
            });
        }

        function applyFraisFilters() {
            let visible = 0;
            document.querySelectorAll('#frais-table-body tr.frais-row').forEach((row) => {
                const show = !activeFraisType || row.dataset.fraisCat === activeFraisType;
                row.hidden = !show;
                if (show) visible += 1;
            });
            const emptyRow = document.getElementById('frais-empty-row');
            if (emptyRow) emptyRow.hidden = visible > 0;
        }

        function resetFraisForm() {
            editingFraisId = null;
            if (fraisAdminForm) fraisAdminForm.action = fraisStoreUrl;
            if (fraisFormMethod) fraisFormMethod.value = 'POST';
            if (fraisFormTitle) fraisFormTitle.textContent = 'Nouveau frais';
            fraisAdminForm?.reset();
            const type = activeFraisType || Object.keys(fraisCategories)[0];
            if (fraisCategorieInput) fraisCategorieInput.value = type || '';
            if (fraisReferenceInput) fraisReferenceInput.value = nextFraisRefs[type] || '';
            if (fraisFormSubtitle) fraisFormSubtitle.textContent = fraisCategories[type] || 'Saisie';
            const dateInput = document.getElementById('frais_date');
            if (dateInput) dateInput.value = new Date().toISOString().slice(0, 10);
            const soldeInput = document.getElementById('frais_solde');
            if (soldeInput) soldeInput.value = '0';
        }

        function openFraisForm(type = null) {
            if (type) {
                activeFraisType = type;
                syncFraisCardsActive();
                applyFraisFilters();
            }
            resetFraisForm();
            setFraisOverlayOpen(fraisFormOverlay, true);
            document.getElementById('frais_designation')?.focus();
        }

        function closeFraisForm() {
            setFraisOverlayOpen(fraisFormOverlay, false);
        }

        function fillFraisForm(frais) {
            editingFraisId = frais.id;
            if (fraisAdminForm) fraisAdminForm.action = frais.update_url;
            if (fraisFormMethod) fraisFormMethod.value = 'PUT';
            if (fraisFormTitle) fraisFormTitle.textContent = 'Modifier frais';
            if (fraisFormSubtitle) fraisFormSubtitle.textContent = frais.categorie_label || '';
            if (fraisCategorieInput) fraisCategorieInput.value = frais.categorie;
            if (fraisReferenceInput) fraisReferenceInput.value = frais.reference || '';
            const map = {
                frais_date: frais.date_frais || '',
                frais_designation: frais.designation || '',
                frais_beneficiaire: frais.beneficiaire || '',
                frais_type: frais.type_frais || '',
                frais_montant: frais.montant ?? '',
                frais_solde: frais.solde ?? 0,
                frais_remarque: frais.remarque || '',
            };
            Object.entries(map).forEach(([id, value]) => {
                const el = document.getElementById(id);
                if (el) el.value = value;
            });
        }

        function openFraisEdit(id) {
            const frais = fraisIndex[id];
            if (!frais) return;
            setFraisOverlayOpen(fraisViewOverlay, false);
            fillFraisForm(frais);
            setFraisOverlayOpen(fraisFormOverlay, true);
            document.getElementById('frais_designation')?.focus();
        }

        function openFraisView(id) {
            const frais = fraisIndex[id];
            if (!frais) return;
            const body = document.getElementById('frais-view-body');
            const subtitle = document.getElementById('frais-view-subtitle');
            const pdfLink = document.getElementById('frais-view-pdf');
            const editBtn = document.getElementById('frais-view-edit');
            if (subtitle) subtitle.textContent = frais.reference || frais.categorie_label || '';
            if (pdfLink) pdfLink.href = frais.pdf_url;
            if (editBtn) editBtn.onclick = () => openFraisEdit(frais.id);
            if (body) {
                const money = (n) => Number(n || 0).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                const fields = [
                    ['Date', frais.date_label || '—'],
                    ['Référence', frais.reference || '—'],
                    ['Catégorie', frais.categorie_label || '—'],
                    ['Désignation', frais.designation || '—'],
                    ['Bénéficiaire', frais.beneficiaire || '—'],
                    ['Type', frais.type_frais || '—'],
                    ['Montant', money(frais.montant)],
                    ['Solde', money(frais.solde)],
                    ['Remarque', frais.remarque || '—'],
                ];
                body.innerHTML = fields.map(([label, value]) => `
                    <div class="form-field${label === 'Remarque' || label === 'Désignation' ? ' form-field--full' : ''}">
                        <label>${label}</label>
                        <div class="doc-view-value">${value}</div>
                    </div>
                `).join('');
            }
            setFraisOverlayOpen(fraisViewOverlay, true);
        }

        function closeFraisView() {
            setFraisOverlayOpen(fraisViewOverlay, false);
        }

        function deleteFrais(id) {
            const frais = fraisIndex[id];
            if (!frais || !fraisDeleteForm) return;
            if (!window.confirm(`Supprimer le frais ${frais.reference || frais.designation || ''} ?`)) return;
            fraisDeleteForm.action = frais.delete_url;
            fraisDeleteForm.submit();
        }

        document.querySelectorAll('#frais-cards .doc-card').forEach((card) => {
            card.addEventListener('click', () => {
                openFraisForm(card.dataset.fraisType);
            });
        });

        document.getElementById('frais-form-close')?.addEventListener('click', closeFraisForm);
        document.getElementById('frais-form-cancel')?.addEventListener('click', closeFraisForm);
        document.getElementById('frais-view-close')?.addEventListener('click', closeFraisView);

        fraisFormOverlay?.addEventListener('click', (event) => {
            if (event.target === fraisFormOverlay) closeFraisForm();
        });
        fraisViewOverlay?.addEventListener('click', (event) => {
            if (event.target === fraisViewOverlay) closeFraisView();
        });

        document.getElementById('frais-table-body')?.addEventListener('click', (event) => {
            const viewBtn = event.target.closest('[data-frais-view]');
            const editBtn = event.target.closest('[data-frais-edit]');
            const deleteBtn = event.target.closest('[data-frais-delete]');
            if (viewBtn) openFraisView(viewBtn.dataset.fraisView);
            if (editBtn) openFraisEdit(editBtn.dataset.fraisEdit);
            if (deleteBtn) deleteFrais(deleteBtn.dataset.fraisDelete);
        });

        document.getElementById('frais-print')?.addEventListener('click', () => {
            document.body.classList.add('printing-frais');
            window.print();
            setTimeout(() => document.body.classList.remove('printing-frais'), 400);
        });

        if (activeFraisType) {
            syncFraisCardsActive();
            applyFraisFilters();
        }

        const profFormOverlay = document.getElementById('prof-form-overlay');
        const profViewOverlay = document.getElementById('prof-view-overlay');
        const profAdminForm = document.getElementById('prof-admin-form');
        const profFormMethod = document.getElementById('prof-form-method');
        const profFormTitle = document.getElementById('prof-form-title');
        const profFormSubtitle = document.getElementById('prof-form-subtitle');
        const profReferenceInput = document.getElementById('prof_reference');
        const profDeleteForm = document.getElementById('prof-delete-form');
        const nextProfRef = @json($nextProfRef ?? 'PR-0001');
        const profsIndex = @json($profsIndex ?? []);
        const profStoreUrl = @json(route('admin.profs.store'));
        let editingProfId = null;

        function setProfOverlayOpen(overlay, open) {
            if (!overlay) return;
            overlay.classList.toggle('is-open', open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }

        function resetProfForm() {
            editingProfId = null;
            if (profAdminForm) profAdminForm.action = profStoreUrl;
            if (profFormMethod) profFormMethod.value = 'POST';
            if (profFormTitle) profFormTitle.textContent = 'Nouveau professeur';
            if (profFormSubtitle) profFormSubtitle.textContent = 'Saisie';
            profAdminForm?.reset();
            if (profReferenceInput) profReferenceInput.value = nextProfRef;
            const dateInput = document.getElementById('prof_date');
            if (dateInput) dateInput.value = new Date().toISOString().slice(0, 10);
        }

        function openProfForm() {
            resetProfForm();
            setProfOverlayOpen(profFormOverlay, true);
            document.getElementById('prof_nom')?.focus();
        }

        function closeProfForm() {
            setProfOverlayOpen(profFormOverlay, false);
        }

        function fillProfForm(prof) {
            editingProfId = prof.id;
            if (profAdminForm) profAdminForm.action = prof.update_url;
            if (profFormMethod) profFormMethod.value = 'PUT';
            if (profFormTitle) profFormTitle.textContent = 'Modifier professeur';
            if (profFormSubtitle) profFormSubtitle.textContent = prof.reference || '';
            if (profReferenceInput) profReferenceInput.value = prof.reference || '';
            const map = {
                prof_date: prof.date_prof || '',
                prof_nom: prof.nom_complet || '',
                prof_matiere: prof.matiere || '',
                prof_statut: prof.statut || '',
                prof_etablissement: prof.etablissement || '',
                prof_niveau: prof.niveau || '',
                prof_type: prof.type || '',
                prof_paiement: prof.paiement || '',
            };
            Object.entries(map).forEach(([id, value]) => {
                const el = document.getElementById(id);
                if (el) el.value = value;
            });
        }

        function openProfEdit(id) {
            const prof = profsIndex[id];
            if (!prof) return;
            setProfOverlayOpen(profViewOverlay, false);
            fillProfForm(prof);
            setProfOverlayOpen(profFormOverlay, true);
            document.getElementById('prof_nom')?.focus();
        }

        function openProfView(id) {
            const prof = profsIndex[id];
            if (!prof) return;
            const body = document.getElementById('prof-view-body');
            const subtitle = document.getElementById('prof-view-subtitle');
            const pdfLink = document.getElementById('prof-view-pdf');
            const editBtn = document.getElementById('prof-view-edit');
            if (subtitle) subtitle.textContent = prof.reference || '';
            if (pdfLink) pdfLink.href = prof.pdf_url;
            if (editBtn) editBtn.onclick = () => openProfEdit(prof.id);
            if (body) {
                const fields = [
                    ['Date', prof.date_label || '—'],
                    ['ID', prof.reference || '—'],
                    ['Nom Complet', prof.nom_complet || '—'],
                    ['Matière', prof.matiere || '—'],
                    ['Statut', prof.statut_label || '—'],
                    ['Établissement', prof.etablissement || '—'],
                    ['Niveau', prof.niveau_label || '—'],
                    ['Type', prof.type_label || '—'],
                    ['Paiement', prof.paiement_label || '—'],
                ];
                body.innerHTML = fields.map(([label, value]) => `
                    <div class="form-field${label === 'Nom Complet' ? ' form-field--full' : ''}">
                        <label>${label}</label>
                        <div class="doc-view-value">${value}</div>
                    </div>
                `).join('');
            }
            setProfOverlayOpen(profViewOverlay, true);
        }

        function closeProfView() {
            setProfOverlayOpen(profViewOverlay, false);
        }

        function deleteProf(id) {
            const prof = profsIndex[id];
            if (!prof || !profDeleteForm) return;
            if (!window.confirm(`Supprimer le professeur ${prof.reference || prof.nom_complet || ''} ?`)) return;
            profDeleteForm.action = prof.delete_url;
            profDeleteForm.submit();
        }

        document.getElementById('prof-add-open')?.addEventListener('click', openProfForm);
        document.getElementById('prof-form-close')?.addEventListener('click', closeProfForm);
        document.getElementById('prof-form-cancel')?.addEventListener('click', closeProfForm);
        document.getElementById('prof-view-close')?.addEventListener('click', closeProfView);
        document.getElementById('prof-panel-close')?.addEventListener('click', () => {
            showSection('profs', { openGroup: false });
        });

        profFormOverlay?.addEventListener('click', (event) => {
            if (event.target === profFormOverlay) closeProfForm();
        });
        profViewOverlay?.addEventListener('click', (event) => {
            if (event.target === profViewOverlay) closeProfView();
        });

        document.getElementById('prof-table-body')?.addEventListener('click', (event) => {
            const viewBtn = event.target.closest('[data-prof-view]');
            const editBtn = event.target.closest('[data-prof-edit]');
            const deleteBtn = event.target.closest('[data-prof-delete]');
            if (viewBtn) openProfView(viewBtn.dataset.profView);
            if (editBtn) openProfEdit(editBtn.dataset.profEdit);
            if (deleteBtn) deleteProf(deleteBtn.dataset.profDelete);
        });

        const matiereFormOverlay = document.getElementById('matiere-form-overlay');
        const matiereAdminForm = document.getElementById('matiere-admin-form');
        const matiereCarteRows = document.getElementById('matiere-carte-rows');

        function setMatiereOverlayOpen(open) {
            if (!matiereFormOverlay) return;
            matiereFormOverlay.classList.toggle('is-open', open);
            matiereFormOverlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }

        function createMatiereCarteRow(withRemove = true) {
            const row = document.createElement('div');
            row.className = 'matiere-carte-row';
            row.innerHTML = `
                <input type="text" name="cartes[]" maxlength="255" placeholder="Nom de la carte">
                <button type="button" class="btn btn--ghost ${withRemove ? 'matiere-carte-remove' : 'matiere-carte-add'}" title="${withRemove ? 'Retirer' : 'Ajouter une carte'}">${withRemove ? '−' : '+'}</button>
            `;
            return row;
        }

        function resetMatiereForm() {
            matiereAdminForm?.reset();
            if (!matiereCarteRows) return;
            matiereCarteRows.innerHTML = '';
            matiereCarteRows.appendChild(createMatiereCarteRow(false));
        }

        function openMatiereForm() {
            resetMatiereForm();
            setMatiereOverlayOpen(true);
            document.getElementById('matiere_titre')?.focus();
        }

        function closeMatiereForm() {
            setMatiereOverlayOpen(false);
        }

        document.getElementById('matiere-add-open')?.addEventListener('click', openMatiereForm);
        document.getElementById('matiere-form-close')?.addEventListener('click', closeMatiereForm);
        document.getElementById('matiere-form-cancel')?.addEventListener('click', closeMatiereForm);
        document.getElementById('matiere-validate')?.addEventListener('click', () => {
            showSection('profs', { openGroup: false });
        });

        matiereFormOverlay?.addEventListener('click', (event) => {
            if (event.target === matiereFormOverlay) closeMatiereForm();
        });

        matiereCarteRows?.addEventListener('click', (event) => {
            const addBtn = event.target.closest('.matiere-carte-add');
            const removeBtn = event.target.closest('.matiere-carte-remove');
            if (addBtn) {
                matiereCarteRows.appendChild(createMatiereCarteRow(true));
                const inputs = matiereCarteRows.querySelectorAll('input');
                inputs[inputs.length - 1]?.focus();
            }
            if (removeBtn) {
                removeBtn.closest('.matiere-carte-row')?.remove();
            }
        });

        const matieresIndex = @json($matieresIndex ?? []);
        const matiereSheetOverlay = document.getElementById('matiere-sheet-overlay');

        function setMatiereSheetOpen(open) {
            if (!matiereSheetOverlay) return;
            matiereSheetOverlay.classList.toggle('is-open', open);
            matiereSheetOverlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }

        function openMatiereSheet(id) {
            const data = matieresIndex[id];
            if (!data) return;
            document.querySelectorAll('.matiere-card').forEach((card) => {
                card.classList.toggle('is-active', card.dataset.carteId === String(id));
            });
            const titreEl = document.getElementById('matiere-sheet-titre');
            const titleEl = document.getElementById('matiere-sheet-title');
            const etuEl = document.getElementById('matiere-sheet-etudiants');
            const profsEl = document.getElementById('matiere-sheet-profs');
            const revenuEl = document.getElementById('matiere-sheet-revenu');
            if (titreEl) titreEl.textContent = data.titre || 'Matière';
            if (titleEl) titleEl.textContent = data.nom || '';
            if (etuEl) etuEl.textContent = Number(data.nb_etudiants || 0).toLocaleString('fr-FR');
            if (profsEl) profsEl.textContent = Number(data.nb_profs || 0).toLocaleString('fr-FR');
            if (revenuEl) {
                revenuEl.textContent = Number(data.revenu_mensuel || 0).toLocaleString('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }
            setMatiereSheetOpen(true);
        }

        function closeMatiereSheet() {
            setMatiereSheetOpen(false);
            document.querySelectorAll('.matiere-card.is-active').forEach((card) => card.classList.remove('is-active'));
        }

        document.getElementById('matiere-sheet-close')?.addEventListener('click', closeMatiereSheet);
        matiereSheetOverlay?.addEventListener('click', (event) => {
            if (event.target === matiereSheetOverlay) closeMatiereSheet();
        });

        document.getElementById('matiere-groups')?.addEventListener('click', (event) => {
            const card = event.target.closest('.matiere-card');
            if (!card) return;
            openMatiereSheet(card.dataset.carteId);
        });

        const etudiantFormOverlay = document.getElementById('etudiant-form-overlay');
        const etudiantViewOverlay = document.getElementById('etudiant-view-overlay');
        const etudiantAdminForm = document.getElementById('etudiant-admin-form');
        const etudiantFormTitle = document.getElementById('etudiant-form-title');
        const etudiantFormSubtitle = document.getElementById('etudiant-form-subtitle');
        const etudiantReferenceInput = document.getElementById('etudiant_reference');
        const etudiantDeleteForm = document.getElementById('etudiant-delete-form');
        const etudiantPhotoHint = document.getElementById('etudiant-photo-hint');
        const etudiantPhotoPreview = document.getElementById('etudiant-photo-preview');
        const etudiantPhotoImg = document.getElementById('etudiant-photo-img');
        const nextEtudiantRef = @json($nextEtudiantRef ?? 'ID/ET-0001');
        const etudiantsIndex = @json($etudiantsIndex ?? []);
        const etudiantStoreUrl = @json(route('admin.etudiants.store'));
        let editingEtudiantId = null;
        let viewingEtudiantId = null;

        function setEtudiantOverlayOpen(overlay, open) {
            if (!overlay) return;
            overlay.classList.toggle('is-open', open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
        }

        function setEtudiantPhotoPreview(url) {
            if (!etudiantPhotoPreview || !etudiantPhotoImg) return;
            if (url) {
                etudiantPhotoImg.src = url;
                etudiantPhotoPreview.classList.add('has-image');
            } else {
                etudiantPhotoImg.removeAttribute('src');
                etudiantPhotoPreview.classList.remove('has-image');
            }
        }

        function ensureEtudiantMatiereOption(value) {
            const select = document.getElementById('etudiant_matiere');
            if (!select || !value) return;
            const exists = Array.from(select.options).some((opt) => opt.value === value);
            if (!exists) {
                const opt = document.createElement('option');
                opt.value = value;
                opt.textContent = value;
                select.appendChild(opt);
            }
        }

        function resetEtudiantForm() {
            editingEtudiantId = null;
            if (etudiantAdminForm) etudiantAdminForm.action = etudiantStoreUrl;
            if (etudiantFormTitle) etudiantFormTitle.textContent = 'Nouveau étudiant';
            if (etudiantFormSubtitle) etudiantFormSubtitle.textContent = 'Saisie';
            etudiantAdminForm?.reset();
            if (etudiantReferenceInput) etudiantReferenceInput.value = nextEtudiantRef;
            const dateInput = document.getElementById('etudiant_date');
            if (dateInput) dateInput.value = new Date().toISOString().slice(0, 10);
            if (etudiantPhotoHint) etudiantPhotoHint.hidden = true;
            const photoInput = document.getElementById('etudiant_photo');
            if (photoInput) photoInput.value = '';
            setEtudiantPhotoPreview('');
        }

        function openEtudiantForm() {
            resetEtudiantForm();
            setEtudiantOverlayOpen(etudiantFormOverlay, true);
            document.getElementById('etudiant_nom')?.focus();
        }

        function closeEtudiantForm() {
            setEtudiantOverlayOpen(etudiantFormOverlay, false);
        }

        function fillEtudiantForm(etudiant) {
            editingEtudiantId = etudiant.id;
            if (etudiantAdminForm) etudiantAdminForm.action = etudiant.update_url;
            if (etudiantFormTitle) etudiantFormTitle.textContent = 'Modifier étudiant';
            if (etudiantFormSubtitle) etudiantFormSubtitle.textContent = etudiant.reference || '';
            if (etudiantReferenceInput) etudiantReferenceInput.value = etudiant.reference || '';
            ensureEtudiantMatiereOption(etudiant.matiere || '');
            const map = {
                etudiant_date: etudiant.date_etudiant || '',
                etudiant_nom: etudiant.nom_complet || '',
                etudiant_niveau: etudiant.niveau_scolaire || '',
                etudiant_matiere: etudiant.matiere || '',
                etudiant_type_paie: etudiant.type_paie || '',
                etudiant_mode_paie: etudiant.mode_paie || '',
            };
            Object.entries(map).forEach(([id, value]) => {
                const el = document.getElementById(id);
                if (el) el.value = value;
            });
            const photoInput = document.getElementById('etudiant_photo');
            if (photoInput) photoInput.value = '';
            if (etudiantPhotoHint) etudiantPhotoHint.hidden = !etudiant.photo_url;
            setEtudiantPhotoPreview(etudiant.photo_url || '');
        }

        function openEtudiantEdit(id) {
            const etudiant = etudiantsIndex[id];
            if (!etudiant) return;
            setEtudiantOverlayOpen(etudiantViewOverlay, false);
            fillEtudiantForm(etudiant);
            setEtudiantOverlayOpen(etudiantFormOverlay, true);
            document.getElementById('etudiant_nom')?.focus();
        }

        function openEtudiantView(id) {
            const etudiant = etudiantsIndex[id];
            if (!etudiant) return;
            viewingEtudiantId = etudiant.id;
            const body = document.getElementById('etudiant-view-body');
            const subtitle = document.getElementById('etudiant-view-subtitle');
            const editBtn = document.getElementById('etudiant-view-edit');
            if (subtitle) subtitle.textContent = etudiant.reference || '';
            if (editBtn) editBtn.onclick = () => openEtudiantEdit(etudiant.id);
            if (body) {
                const photoHtml = etudiant.photo_url
                    ? `<img class="etudiant-photo-thumb" src="${etudiant.photo_url}" alt="Photo" style="width:120px;height:120px;object-fit:cover;border-radius:12px;">`
                    : '—';
                const fields = [
                    ['Photo', photoHtml],
                    ['Date', etudiant.date_label || '—'],
                    ['ID/ET', etudiant.reference || '—'],
                    ['Nom Complet', etudiant.nom_complet || '—'],
                    ['Niv/Sc', etudiant.niveau_scolaire || '—'],
                    ['Date/Insc', etudiant.date_inscription_label || '—'],
                    ['Matière', etudiant.matiere || '—'],
                    ['Type Paie', etudiant.type_paie_label || '—'],
                    ['Mode Paie', etudiant.mode_paie_label || '—'],
                ];
                body.innerHTML = fields.map(([label, value]) => `
                    <div class="form-field${label === 'Nom Complet' || label === 'Photo' ? ' form-field--full' : ''}">
                        <label>${label}</label>
                        <div class="doc-view-value">${value}</div>
                    </div>
                `).join('');
            }
            setEtudiantOverlayOpen(etudiantViewOverlay, true);
        }

        function closeEtudiantView() {
            setEtudiantOverlayOpen(etudiantViewOverlay, false);
        }

        function deleteEtudiant(id) {
            const etudiant = etudiantsIndex[id];
            if (!etudiant || !etudiantDeleteForm) return;
            if (!window.confirm(`Supprimer l'étudiant ${etudiant.reference || etudiant.nom_complet || ''} ?`)) return;
            etudiantDeleteForm.action = etudiant.delete_url;
            etudiantDeleteForm.submit();
        }

        document.getElementById('etudiant_photo')?.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            setEtudiantPhotoPreview(url);
        });

        function compressEtudiantPhoto(file, maxSide = 1200, quality = 0.82) {
            return new Promise((resolve, reject) => {
                if (!file || !file.type.startsWith('image/')) {
                    resolve(file);
                    return;
                }
                const img = new Image();
                const objectUrl = URL.createObjectURL(file);
                img.onload = () => {
                    const scale = Math.min(1, maxSide / Math.max(img.width, img.height));
                    const width = Math.max(1, Math.round(img.width * scale));
                    const height = Math.max(1, Math.round(img.height * scale));
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    URL.revokeObjectURL(objectUrl);
                    canvas.toBlob((blob) => {
                        if (!blob) {
                            resolve(file);
                            return;
                        }
                        const name = (file.name || 'photo').replace(/\.\w+$/, '') + '.jpg';
                        resolve(new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() }));
                    }, 'image/jpeg', quality);
                };
                img.onerror = () => {
                    URL.revokeObjectURL(objectUrl);
                    reject(new Error('Impossible de lire la photo.'));
                };
                img.src = objectUrl;
            });
        }

        etudiantAdminForm?.addEventListener('submit', async (event) => {
            const photoInput = document.getElementById('etudiant_photo');
            const file = photoInput?.files?.[0];
            if (!file) return;

            event.preventDefault();
            try {
                const compressed = await compressEtudiantPhoto(file);
                const dt = new DataTransfer();
                dt.items.add(compressed);
                photoInput.files = dt.files;
                etudiantAdminForm.submit();
            } catch (error) {
                window.alert(error?.message || 'Échec de la préparation de la photo.');
            }
        });

        function printEtudiant(id) {
            const etudiant = etudiantsIndex[id];
            if (!etudiant) return;
            const sheet = document.getElementById('etudiant-print-sheet');
            const photo = document.getElementById('etudiant-print-photo');
            const body = document.getElementById('etudiant-print-body');
            if (photo) {
                if (etudiant.photo_url) {
                    photo.src = etudiant.photo_url;
                    photo.style.display = 'block';
                } else {
                    photo.removeAttribute('src');
                    photo.style.display = 'none';
                }
            }
            if (body) {
                body.innerHTML = `
                    <h2 style="margin:0 0 12px;text-transform:uppercase;">Fiche Étudiant</h2>
                    <p><strong>ID/ET :</strong> ${etudiant.reference || '—'}</p>
                    <p><strong>Nom Complet :</strong> ${etudiant.nom_complet || '—'}</p>
                    <p><strong>Date :</strong> ${etudiant.date_label || '—'}</p>
                    <p><strong>Date/Insc :</strong> ${etudiant.date_inscription_label || '—'}</p>
                    <p><strong>Niv/Sc :</strong> ${etudiant.niveau_scolaire || '—'}</p>
                    <p><strong>Matière :</strong> ${etudiant.matiere || '—'}</p>
                    <p><strong>Type Paie :</strong> ${etudiant.type_paie_label || '—'}</p>
                    <p><strong>Mode Paie :</strong> ${etudiant.mode_paie_label || '—'}</p>
                `;
            }
            if (sheet) sheet.setAttribute('aria-hidden', 'false');
            document.body.classList.add('printing-etudiant');
            window.print();
            setTimeout(() => {
                document.body.classList.remove('printing-etudiant');
                if (sheet) sheet.setAttribute('aria-hidden', 'true');
            }, 400);
        }

        document.getElementById('etudiant-view-print')?.addEventListener('click', () => {
            if (viewingEtudiantId) printEtudiant(viewingEtudiantId);
        });

        document.getElementById('etudiant-add-open')?.addEventListener('click', openEtudiantForm);
        document.getElementById('etudiant-form-close')?.addEventListener('click', closeEtudiantForm);
        document.getElementById('etudiant-form-cancel')?.addEventListener('click', closeEtudiantForm);
        document.getElementById('etudiant-view-close')?.addEventListener('click', closeEtudiantView);
        document.getElementById('etudiant-panel-close')?.addEventListener('click', () => {
            showSection('administration', { openGroup: false });
        });

        etudiantFormOverlay?.addEventListener('click', (event) => {
            if (event.target === etudiantFormOverlay) closeEtudiantForm();
        });
        etudiantViewOverlay?.addEventListener('click', (event) => {
            if (event.target === etudiantViewOverlay) closeEtudiantView();
        });

        document.getElementById('etudiant-table-body')?.addEventListener('click', (event) => {
            const viewBtn = event.target.closest('[data-etudiant-view]');
            const editBtn = event.target.closest('[data-etudiant-edit]');
            const deleteBtn = event.target.closest('[data-etudiant-delete]');
            if (viewBtn) openEtudiantView(viewBtn.dataset.etudiantView);
            if (editBtn) openEtudiantEdit(editBtn.dataset.etudiantEdit);
            if (deleteBtn) deleteEtudiant(deleteBtn.dataset.etudiantDelete);
        });

        showSection(initialSection, { openGroup: false });
        buildPaiementChart('2026');
        buildProfsChart('2026');
    </script>
</body>
</html>
