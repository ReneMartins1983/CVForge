# Deploy da demo no Render (grátis, SQLite)

A demo roda em um único container Docker com banco **SQLite** (sem MySQL gerenciado).
Os dados são recriados a cada deploy (incluindo o currículo de exemplo) — ideal para demonstração.

Arquivos usados:
- `Dockerfile.render` — imagem de produção (build dos assets + app PHP).
- `render/start.sh` — cria o SQLite, roda migrations + seed e sobe o servidor.
- `render.yaml` — blueprint que o Render lê para criar o serviço.

## Passo a passo

1. **Crie uma conta** em <https://render.com> e conecte sua conta do GitHub.

2. No painel: **New +  →  Blueprint** e selecione o repositório `ReneMartins1983/CVForge`.
   - O Render detecta o `render.yaml` e propõe o serviço web `cvforge` (plano Free).
   - *(Alternativa sem blueprint: New + → Web Service → Docker → escolha o repo →
     em "Dockerfile Path" informe `Dockerfile.render`.)*

3. **Defina as variáveis de ambiente** do serviço (aba *Environment*):
   - `APP_KEY` → cole a chave que você recebeu (formato `base64:...`).
   - `APP_URL` → deixe em branco no 1º deploy; depois preencha com a URL pública
     (ex.: `https://cvforge.onrender.com`) e faça *Manual Deploy → Clear build cache & deploy*.

4. **Deploy.** O primeiro build leva alguns minutos (instala dependências e compila os assets).

5. Acesse a URL gerada. Pontos de demonstração:
   - `/` — landing
   - `/modelos` — galeria dos 11 modelos (sem login)
   - `/r/exemplo1` — currículo de exemplo
   - `/register` — criar conta e montar um currículo

## Observações

- **Plano Free:** o serviço "dorme" após inatividade; o primeiro acesso depois disso
  leva ~30–50s para acordar (cold start). Normal para demo.
- **SQLite efêmero:** contas/currículos criados na demo somem em um novo deploy/restart.
  Para persistência real, use um banco gerenciado (ex.: Railway + MySQL) — a stack do
  projeto já suporta MySQL via `docker-compose.yml`.
- O servidor usa `php artisan serve` (suficiente para demo). Para produção de verdade,
  trocar por php-fpm + nginx ou FrankenPHP.
