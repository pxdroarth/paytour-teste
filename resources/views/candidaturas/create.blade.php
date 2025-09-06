@extends('layouts.app')
@section('title', 'Envio de Currículo')

@section('content')
  <main id="form_container">
    <header id="form_header">
      <h1 id="form_title">Envio de currículos</h1>
    </header>

    {{-- FLASH MESSAGES (sucesso / erro geral) --}}
    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert error">{{ session('error') }}</div>
    @endif

    {{-- (Opcional) Sumário de validação --}}
    @if ($errors->any())
      <div class="alert error">
        <strong>Corrija os campos abaixo:</strong>
        <ul style="margin:6px 0 0 18px;">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <p>Preencha os campos obrigatórios e anexe seu currículo (.pdf, .doc, .docx • máx 1MB).</p>

    <form id="form" method="POST" action="{{ route('candidaturas.store') }}" enctype="multipart/form-data">
      @csrf

      <section id="input_container">
        {{-- Nome (linha inteira) --}}
        <div class="input-box span-2">
          <label class="form-label" for="nome">Nome *</label>
          <div class="input-field">
            <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" required>
          </div>
          @error('nome') <small class="text-error">{{ $message }}</small> @enderror
        </div>

        {{-- E-mail + Telefone (lado a lado) --}}
        <div class="input-box">
          <label class="form-label" for="email">E-mail *</label>
          <div class="input-field">
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          </div>
          @error('email') <small class="text-error">{{ $message }}</small> @enderror
        </div>

        <div class="input-box">
          <label class="form-label" for="telefone">Telefone *</label>
          <div class="input-field">
            <input id="telefone" name="telefone" class="form-control" value="{{ old('telefone') }}" required>
          </div>
          @error('telefone') <small class="text-error">{{ $message }}</small> @enderror
        </div>

        {{-- Cargo + Escolaridade (lado a lado) --}}
        <div class="input-box">
          <label class="form-label" for="cargo_desejado">Cargo Desejado *</label>
          <div class="input-field">
            <input id="cargo_desejado" name="cargo_desejado" class="form-control" value="{{ old('cargo_desejado') }}" required>
          </div>
          @error('cargo_desejado') <small class="text-error">{{ $message }}</small> @enderror
        </div>

        <div class="input-box">
          <label class="form-label" for="escolaridade">Escolaridade *</label>
          <div class="input-field">
            <select id="escolaridade" name="escolaridade" class="form-control" required>
              <option value="">Selecione...</option>
              <option {{ old('escolaridade')=='Médio'?'selected':'' }}>Médio</option>
              <option {{ old('escolaridade')=='Técnico'?'selected':'' }}>Técnico</option>
              <option {{ old('escolaridade')=='Superior'?'selected':'' }}>Superior</option>
            </select>
          </div>
          @error('escolaridade') <small class="text-error">{{ $message }}</small> @enderror
        </div>

        {{-- Observações (linha inteira) --}}
        <div class="input-box span-2">
          <label class="form-label" for="observacoes">Observações (opcional)</label>
          <div class="input-field">
            <textarea id="observacoes" name="observacoes" class="form-control" rows="4">{{ old('observacoes') }}</textarea>
          </div>
        </div>

        {{-- Arquivo (linha inteira) --}}
        <div class="input-box span-2">
          <label class="form-label" for="arquivo">Currículo (.pdf, .doc, .docx | máx 1MB) *</label>
          <div class="input-field">
            <input id="arquivo" type="file" name="arquivo" class="form-control" accept=".pdf,.doc,.docx" required>
          </div>
          @error('arquivo') <small class="text-error">{{ $message }}</small> @enderror
        </div>
      </section>

      {{-- barra inferior, botão full width como no exemplo --}}
      <div id="form_actions">
        <button class="btn-default" type="submit">Enviar candidatura</button>
      </div>
    </form>
  </main>
@endsection
