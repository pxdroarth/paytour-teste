
#  notas.md

```markdown
# Notas do Projeto — Envio de Currículos (Paytour)

##  Objetivo
Criar um formulário de envio de currículos seguro, validado e persistido em banco. Mostrar não só o funcionamento, mas também boas práticas.

---

##  Decisões Técnicas

### 1. CSS puro
- **Motivo:** o escopo é pequeno; não faz sentido adicionar build de Tailwind.  
- **Efeito:** estilo simples, leve e responsivo.

### 2. Armazenamento privado
- **Motivo:** currículos têm dados pessoais → não podem estar em `public`.  
- **Implementação:** `config/filesystems.php` configurado para que o disk `local` aponte para `storage/app/private`.  
- **Efeito:** arquivos ficam inacessíveis por URL direta, só via rota protegida.

### 3. Mailer = log
- **Motivo:** evitar dependência de SMTP pago.  
- **Implementação:** `MAIL_MAILER=log`.  
- **Efeito:** e-mails são gravados em `storage/logs/laravel.log`. Avaliador pode abrir e ver o conteúdo.

### 4. Testes automatizados
- **Cobertura:** envio válido, campos obrigatórios, limite de tamanho, tipos de arquivo.  
- **Benefício:** prova de que fluxo funciona e validações estão corretas.

### 5. Validações fortes
- **Implementação:** `FormRequest` com `mimetypes`, `max:1024`, `in:Médio,Técnico,Superior`.  
- **Efeito:** garante integridade dos dados.

---

##  Lições
- Focar no essencial (formulário → validação → persistência → notificação) é mais valioso que enfeitar com stack pesada.  
- Documentação clara (README + notas) ajuda o avaliador a rodar rápido e entender decisões.

---

##  Próximos passos (se fosse evoluir)
- Painel administrativo para visualizar candidaturas.  
- Autenticação para downloads.  
- Filas para envio de e-mail em background.  
- Máscara de telefone, validação de CPF.  
- Deploy em Docker.

---

##  Conclusão
O projeto cumpre os requisitos com simplicidade e clareza, priorizando:
- **Segurança**: uploads privados.  
- **Qualidade técnica**: validações, testes.  
- **Profissionalismo**: documentação e justificativas.
