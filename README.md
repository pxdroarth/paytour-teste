# Envio de Currículos — Paytour (Teste Dev Full Stack)

Projeto desenvolvido para o processo seletivo da **Paytour**.  
Objetivo: criar um **formulário de envio de currículos** com validação, upload seguro, persistência em banco, registro de IP/data-hora e envio de e-mail.

---

##  Tecnologias
- **Laravel 10+**
- **MySQL** (via XAMPP)
- **CSS puro** (sem Tailwind/Bootstrap)
- **Composer** para dependências
- **Mailer: log** (e-mails são gravados em `storage/logs/laravel.log`)

---

##  Estrutura
- `app/Models/Candidatura.php` — model  
- `app/Http/Controllers/CandidaturaController.php` — controller  
- `app/Http/Requests/StoreCandidaturaRequest.php` — validações  
- `app/Mail/CandidaturaRecebida.php` — mailable  
- `database/migrations/*create_candidaturas_table.php` — tabela  
- `resources/views/candidaturas/create.blade.php` — formulário  
- `resources/views/emails/candidatura.blade.php` — e-mail  
- `public/app.css` — estilos  
- `tests/Feature/CandidaturaTest.php` — testes automatizados  

---

##  Requisitos atendidos
- Campos: nome, e-mail, telefone, cargo desejado, escolaridade, observações (opcional), arquivo, data/hora de envio.  
- Validações completas.  
- Upload seguro (.pdf, .doc, .docx até 1 MB).  
- Armazenamento privado (`storage/app/private/curriculos`).  
- Registro de IP + `enviado_em`.  
- E-mail com dados do formulário (via `log`).  
- Testes automatizados cobrindo fluxo e regras.  

---

##  Como rodar

### 1. Clonar e instalar dependências

git clone https://github.com/pxdroarth/paytour-teste.git
cd paytour-teste
composer install
cp .env.example .env
php artisan key:generate
### 2.  Criar banco de dados
CREATE DATABASE paytour CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


Atualize o .env com suas credenciais MySQL.

### 3. Rodar migrations
php artisan migrate

### 4. Subir servidor
php artisan serve


Acesse: http://127.0.0.1:8000/candidaturas

###  Uploads e Armazenamento

Os currículos são armazenados em: storage/app/private/curriculos

O disk local foi configurado em config/filesystems.php para apontar para storage/app/private, garantindo que os arquivos não fiquem públicos (public/storage).

Para entregar arquivos, pode-se usar uma rota controlada:

Storage::disk('local')->download($candidatura->arquivo_path);

###  Testes

php artisan test -v

# Cobre:

Renderização do formulário

Envio válido (DB + upload + e-mail)

Observações opcional

Extensão inválida rejeitada

Arquivo maior que 1MB rejeitado

Campos obrigatórios vazios
```bash