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

        .stats--paiement {
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
            .stats--paiement { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (max-width: 1100px) {
            .stats,
            .stats--paiement { grid-template-columns: repeat(2, minmax(0, 1fr)); }
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
            .stats--paiement { grid-template-columns: 1fr; }
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

            <button type="button" class="nav-item is-active" data-section="administration">
                <span class="nav-item__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path d="M3 21h18"/><path d="M5 21V8l7-4 7 4v13"/><path d="M9 21v-6h6v6"/>
                    </svg>
                </span>
                <span class="nav-item__text">
                    <span class="nav-item__title">Administration</span>
                    <span class="nav-item__hint">Pilotage général</span>
                </span>
            </button>

            <button type="button" class="nav-item" data-section="paiement">
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
            </button>

            <button type="button" class="nav-item" data-section="profs">
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
            </button>

            <button type="button" class="nav-item" data-section="etudiants">
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
            </button>

            <button type="button" class="nav-item" data-section="classes">
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
            </button>

            <button type="button" class="nav-item" data-section="personnels">
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
            </button>

            <button type="button" class="nav-item" data-section="charges">
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
            </button>

            <button type="button" class="nav-item" data-section="configuration">
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
            </button>

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
            <section class="panel is-visible" id="panel-administration" data-panel="administration">
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

            <section class="panel" id="panel-paiement" data-panel="paiement">
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

            <section class="panel" id="panel-profs" data-panel="profs">
                <h2 class="panel__title">Gestion des profs</h2>
            </section>

            <section class="panel" id="panel-etudiants" data-panel="etudiants">
                <h2 class="panel__title">Gestion Etudiant</h2>
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
        const navItems = document.querySelectorAll('.nav-item');
        const panels = document.querySelectorAll('.panel');

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

        menuToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('is-open');
        });

        navItems.forEach((item) => {
            item.addEventListener('click', () => {
                const section = item.dataset.section;

                navItems.forEach((el) => el.classList.remove('is-active'));
                item.classList.add('is-active');

                panels.forEach((panel) => {
                    panel.classList.toggle('is-visible', panel.dataset.panel === section);
                });

                sidebar.classList.remove('is-open');

                if (section === 'paiement') {
                    refreshPaiementChart();
                }
            });
        });

        document.getElementById('paiement-year')?.addEventListener('change', (event) => {
            buildPaiementChart(event.target.value);
        });

        buildPaiementChart('2026');
    </script>
</body>
</html>
