<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devfolio — Gerador de Currículos</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f5f5f7;
            color: #1d1d1f;
            line-height: 1.5;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        .pane {
            padding: 2.5rem;
            overflow-y: auto;
        }

        .pane--form {
            background: #ffffff;
            border-right: 1px solid #e5e5ea;
        }

        .pane--preview {
            background: #f5f5f7;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .subtitle {
            color: #6e6e73;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .field {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: #1d1d1f;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: 1px solid #d2d2d7;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            background: #fff;
            transition: border-color 0.15s;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #0071e3;
        }

        textarea {
            resize: vertical;
            min-height: 140px;
        }

        .resume {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            min-height: 100%;
        }

        .resume__name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1d1d1f;
        }

        .resume__section-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6e6e73;
            margin-bottom: 0.5rem;
            padding-bottom: 0.4rem;
            border-bottom: 1px solid #e5e5ea;
        }

        .resume__summary {
            font-size: 0.95rem;
            white-space: pre-wrap;
            color: #1d1d1f;
        }

        .placeholder {
            color: #a1a1a6;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .pane--form {
                border-right: none;
                border-bottom: 1px solid #e5e5ea;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="pane pane--form">
            <h1>Devfolio</h1>
            <p class="subtitle">Gerador de currículos para desenvolvedores</p>

            <form id="resume-form" autocomplete="off">
                <div class="field">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" placeholder="Seu nome completo">
                </div>

                <div class="field">
                    <label for="summary">Resumo profissional</label>
                    <textarea id="summary" name="summary" placeholder="Fale brevemente sobre sua experiência, stack e objetivos."></textarea>
                </div>
            </form>
        </section>

        <section class="pane pane--preview">
            <article class="resume" aria-live="polite">
                <h2 class="resume__name" id="preview-name">
                    <span class="placeholder">Seu nome aparecerá aqui</span>
                </h2>

                <h3 class="resume__section-title">Resumo profissional</h3>
                <p class="resume__summary" id="preview-summary">
                    <span class="placeholder">Seu resumo profissional aparecerá aqui.</span>
                </p>
            </article>
        </section>
    </div>

    <script>
        (function () {
            const nameInput = document.getElementById('name');
            const summaryInput = document.getElementById('summary');
            const namePreview = document.getElementById('preview-name');
            const summaryPreview = document.getElementById('preview-summary');

            const namePlaceholder = '<span class="placeholder">Seu nome aparecerá aqui</span>';
            const summaryPlaceholder = '<span class="placeholder">Seu resumo profissional aparecerá aqui.</span>';

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function updateName() {
                const value = nameInput.value.trim();
                namePreview.innerHTML = value ? escapeHtml(value) : namePlaceholder;
            }

            function updateSummary() {
                const value = summaryInput.value.trim();
                summaryPreview.innerHTML = value ? escapeHtml(value) : summaryPlaceholder;
            }

            nameInput.addEventListener('input', updateName);
            summaryInput.addEventListener('input', updateSummary);
        })();
    </script>
</body>
</html>
