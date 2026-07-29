<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF — {{ $frais->reference }}</title>
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
                <h1>{{ $categorieLabel }}</h1>
                <div class="meta">Réf : {{ $frais->reference }}</div>
            </div>
            <div class="meta">{{ $frais->date_frais?->format('d/m/Y') }}</div>
        </div>

        <div class="grid">
            <div class="field">
                <span class="label">Date</span>
                <div class="value">{{ $frais->date_frais?->format('d/m/Y') ?: '—' }}</div>
            </div>
            <div class="field">
                <span class="label">Référence</span>
                <div class="value">{{ $frais->reference ?: '—' }}</div>
            </div>
            <div class="field full">
                <span class="label">Désignation</span>
                <div class="value">{{ $frais->designation }}</div>
            </div>
            <div class="field">
                <span class="label">Bénéficiaire</span>
                <div class="value">{{ $frais->beneficiaire ?: '—' }}</div>
            </div>
            <div class="field">
                <span class="label">Type</span>
                <div class="value">{{ $frais->type_frais ?: '—' }}</div>
            </div>
            <div class="field">
                <span class="label">Montant</span>
                <div class="value">{{ number_format((float) $frais->montant, 2, ',', ' ') }}</div>
            </div>
            <div class="field">
                <span class="label">Solde</span>
                <div class="value">{{ number_format((float) $frais->solde, 2, ',', ' ') }}</div>
            </div>
            <div class="field full">
                <span class="label">Remarque</span>
                <div class="value">{{ $frais->remarque ?: '—' }}</div>
            </div>
        </div>

        <div class="actions">
            <button type="button" onclick="window.print()">Imprimer / PDF</button>
            <button type="button" onclick="window.close()" style="background:#b83245">Fermer</button>
        </div>
    </div>
    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 250));</script>
</body>
</html>
