# Organização e publicação — Leiturinha

## O que foi reorganizado

| Antes | Agora |
|---|---|
| `style.css` | `assets/css/style.css` |
| `script.js` | `assets/js/script.js` |
| `leiturinha.sql` | `database/leiturinha.sql` |
| `db.php` com dados de produção | `config/database.php` (seguro) + `config/database.example.php` |
| `index.html`, `login.html`, `produto1.html` a `produto6.html` | `legacy/` |
| Ausência de README e gitignore | `README.md` e `.gitignore` |

Links relativos para CSS, JavaScript e favoritos foram atualizados. `index.php` agora carrega o JavaScript da busca. O código de favoritos vindo do MySQL não é mais substituído pelos favoritos do protótipo antigo guardados em `localStorage`.

## Passos antes de publicar

1. **Troque a senha** do MySQL usada na versão antiga: a credencial apareceu no arquivo `db.php` enviado. Se já houve commits públicos com ela, trate-a como comprometida.
2. Confirme o funcionamento do sistema no ambiente local usando `config/database.local.php` (esse arquivo é ignorado pelo Git).
3. Faça backup do banco atual; o script SQL fornecido é para banco de testes e contém `DROP TABLE`.
4. Se o repositório já tinha arquivos na raiz, remova os antigos (`db.php`, `style.css`, `script.js`, `index.html`, `produto1.html` a `produto6.html`, `login.html`, `leiturinha.sql`) e envie a nova estrutura. Não deixe duas versões ativas.
5. Confirme quais contribuições pertencem aos demais membros e atribua os créditos apropriados.

## Publicação via Git (repositório já existente)

Faça primeiro um backup do projeto local. Na pasta do clone do repositório:

```bash
git status
# Copie o conteúdo da pasta Site-Leiturinha-organizado para dentro deste clone,
# substituindo a versão antiga e removendo os arquivos que foram movidos.
git add -A
git diff --cached --stat
git commit -m "docs: organiza estrutura e documentacao do Leiturinha"
git push origin main
```

**Importante:** o nome da branch principal pode ser `main` ou outro. Verifique em `git branch --show-current` e altere o comando conforme a branch real.

## Sobre atualização do servidor

A estrutura de pastas mudou. Subir apenas o README no GitHub não atualiza automaticamente a hospedagem. Atualize os caminhos dos arquivos no servidor e **mantenha** uma configuração de banco própria em `config/database.local.php` no servidor. Teste em ambiente local/homologação antes de substituir o site publicado.
