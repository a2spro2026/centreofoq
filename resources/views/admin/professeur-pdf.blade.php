<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF — {{ $professeur->reference }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #143a58;
            margin: 0;
            padding: 28px;
            text-transform: uppercase;
        }
        .sheet {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #9ec9e4;
            border-radius: 16px;
            padding: 28px;
        }
        .head {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 2px solid #d7ebf7;
            padding-bottom: 16px;
            margin-bottom: 18px;
        }
        h1 { margin: 0 0 8px; font-size: 26px; }
        .meta { color: #5d7f99; font-size: 13px; }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .field {
            background: #f3f9fd;
            border: 1px solid #d7ebf7;
            border-radius: 10px;
            padding: 12px;
        }
        .field.full { grid-column: 1 / -1; }
        .label {
            display: block;
            font-size: 11px;
            color: #1a7fc2;
            margin-bottom: 4px;
            letter-spacing: 0.08em;
        }
        .value { font-weight: 700; font-size: 14px; }
        .actions { margin-top: 22px; display: flex; gap: 10px; }
        button {
            text-transform: uppercase;
            border: 0;
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 700;
            cursor: pointer;
            background: #1a7fc2;
            color: #fff;
        }
        @media print {
            .actions { display: none; }
            body { padding: 0; }
            .sheet { border: 0; }
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="head">
            <div>
                <h1>Fiche Professeur</h1>
                <div class="meta">ID : {{ $professeur->reference }}</div>
            </div>
            <div class="meta">{{ $professeur->date_prof?->format('d/m/Y') }}</div>
        </div>

        <div class="grid">
            <div class="field full">
                <span class="label">Nom Complet</span>
                <div class="value">{{ $professeur->nom_complet }}</div>
            </div>
            <div class="field">
                <span class="label">Matière</span>
                <div class="value">{{ $professeur->matiere }}</div>
            </div>
            <div class="field">
                <span class="label">Statut</span>
                <div class="value">{{ $professeur->statut_label }}</div>
            </div>
            <div class="field">
                <span class="label">Établissement</span>
                <div class="value">{{ $professeur->etablissement ?: '—' }}</div>
            </div>
            <div class="field">
                <span class="label">Niveau</span>
                <div class="value">{{ $professeur->niveau_label }}</div>
            </div>
            <div class="field">
                <span class="label">Type</span>
                <div class="value">{{ $professeur->type_label }}</div>
            </div>
            <div class="field">
                <span class="label">Paiement</span>
                <div class="value">{{ $professeur->paiement_label }}</div>
            </div>
        </div>

        <div class="actions">
            <button type="button" onclick="window.print()">Imprimer</button>
        </div>
    </div>
</body>
</html>
