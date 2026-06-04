# Devfolio

Gerador de currículos para desenvolvedores. Preencha seus dados e veja o
currículo sendo montado em tempo real, escolha um tema, salve e compartilhe
por link ou exporte em PDF.

## Funcionalidades

- **Contas de usuário** (Laravel Breeze) — cada pessoa tem seus próprios currículos; o link público continua aberto.
- **Builder com prévia ao vivo** (Alpine.js) — o currículo é montado enquanto você digita.
- **Seções completas** — dados pessoais, resumo, experiência, formação, habilidades, projetos e idiomas (todos repetíveis).
- **10 modelos** — 5 sem foto (moderno, clássico, compacto, minimalista, técnico) e 5 com foto (sidebar, banner, elegante, cartão, corporativo).
- **Upload de foto de perfil** para os modelos que a usam.
- **Modo escuro** persistido no navegador.
- **Persistência em MySQL** com link público compartilhável (`/r/{slug}`).
- **Export em PDF / impressão** com layout A4 dedicado.

## Stack

| Componente        | Versão                                            |
| ----------------- | ------------------------------------------------- |
| Laravel Framework | 12.x (constraint `^12.0`)                         |
| PHP               | 8.3 (`^8.3`) — imagem base `php:8.3-fpm-bookworm` |
| MySQL             | 8.4                                               |
| Composer          | 2.9                                               |
| Node.js           | 20.x                                              |
| Vite              | 6.x                                               |

Todo o ambiente roda em containers Docker — não é necessário instalar PHP,
MySQL ou Composer no host.

## Como rodar

Pré-requisitos: Docker e Docker Compose.

```bash
# 1. Configurar o ambiente
cp .env.example .env

# 2. Subir a imagem da aplicação (PHP 8.3 + Composer 2.9)
UID=$(id -u) GID=$(id -g) docker compose build app

# 3. Instalar dependências PHP
docker compose run --rm app composer install

# 4. Subir a stack (app + nginx + mysql)
docker compose up -d

# 5. Gerar a APP_KEY e rodar as migrations
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate

# 6. Instalar e compilar os assets (Node 20 / Vite)
docker compose run --rm node npm install
docker compose run --rm node npm run build
```

A aplicação fica disponível em **http://localhost:8000**.

### Rotas

| Rota                   | Acesso  | Descrição                            |
| ---------------------- | ------- | ------------------------------------ |
| `/`                    | público | Landing page                         |
| `/login`, `/register`  | público | Autenticação (Laravel Breeze)        |
| `/builder`             | logado  | Criar um currículo                   |
| `/builder/{slug}`      | dono    | Editar um currículo                  |
| `/resumes`             | logado  | Seus currículos                      |
| `/profile`             | logado  | Perfil do usuário                    |
| `/r/{slug}`            | público | Página pública (link compartilhável) |
| `/r/{slug}/print`      | público | Versão para impressão / PDF          |
| `/up`                  | público | Health check                         |

Há um currículo de exemplo semeado em `/r/exemplo1` (rode `php artisan db:seed`).

### Stack de frontend

Blade + **Tailwind CSS 3** (dark mode via classe) + **Alpine.js 3**, compilado
com Vite. O documento do currículo usa CSS próprio (`.cv`) para garantir
fidelidade na tela, na impressão e no PDF.

### Desenvolvimento de assets (hot reload)

```bash
docker compose run --rm --service-ports node npm run dev
```

### Testes

```bash
docker compose exec app php artisan test
```

## Portas

| Serviço | Host    | Container |
| ------- | ------- | --------- |
| nginx   | `8000`  | `80`      |
| MySQL   | `33060` | `3306`    |
| Vite    | `5173`  | `5173`    |

As portas do host podem ser ajustadas via `.env` (`APP_PORT`, `FORWARD_DB_PORT`,
`VITE_PORT`).
