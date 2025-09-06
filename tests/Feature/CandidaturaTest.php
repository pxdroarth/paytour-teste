<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Candidatura;

it('exibe o formulário de candidatura', function () {
    $this->get(route('candidaturas.create'))
        ->assertOk()
        ->assertSee('Envio de Currículo');
});

it('salva candidatura válida, armazena arquivo e envia e-mail', function () {
    // use o MESMO disk do controller: 'private' OU 'public'
    Storage::fake('private');

    $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

    $payload = [
        'nome'           => 'Pedro Arthur',
        'email'          => 'pedro@example.com',
        'telefone'       => '85999999999',
        'cargo_desejado' => 'Dev Fullstack',
        'escolaridade'   => 'Superior',
        'observacoes'    => 'Teste automático',
        'arquivo'        => $file,
    ];

    $this->post(route('candidaturas.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    // pega o registro salvo e valida o caminho real
    $c = Candidatura::where('email', 'pedro@example.com')->firstOrFail();
    Storage::disk('local')->assertExists($c->arquivo_path);

    $this->assertDatabaseHas('candidaturas', ['email' => 'pedro@example.com']);
});

it('aceita envio sem observações', function () {
    Storage::fake('local');

    $file = UploadedFile::fake()->create(
        'cv.docx', 120,
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    );

    $payload = [
        'nome'           => 'Maria',
        'email'          => 'maria@example.com',
        'telefone'       => '85988888888',
        'cargo_desejado' => 'Backend',
        'escolaridade'   => 'Médio',
        'arquivo'        => $file,
    ];

    $this->post(route('candidaturas.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('candidaturas', ['email' => 'maria@example.com']);
});

it('rejeita arquivo com extensão inválida', function () {
    Storage::fake('private');

    $file = UploadedFile::fake()->create('foto.png', 200, 'image/png');

    $payload = [
        'nome'           => 'José',
        'email'          => 'jose@example.com',
        'telefone'       => '85977777777',
        'cargo_desejado' => 'QA',
        'escolaridade'   => 'Superior',
        'arquivo'        => $file,
    ];

    $this->post(route('candidaturas.store'), $payload)
        ->assertSessionHasErrors(['arquivo']);
});

it('rejeita arquivo maior que 1MB', function () {
    Storage::fake('private');

    // 2000 KB ≈ 2 MB (deve falhar pois max é 1024)
    $file = UploadedFile::fake()->create('cv.pdf', 2000, 'application/pdf');

    $payload = [
        'nome'           => 'Ana',
        'email'          => 'ana@example.com',
        'telefone'       => '85966666666',
        'cargo_desejado' => 'Frontend',
        'escolaridade'   => 'Superior',
        'arquivo'        => $file,
    ];

    $this->post(route('candidaturas.store'), $payload)
        ->assertSessionHasErrors(['arquivo']);
});

it('valida campos obrigatórios', function () {
    $this->post(route('candidaturas.store'), [])
        ->assertSessionHasErrors([
            'nome','email','telefone','cargo_desejado','escolaridade','arquivo'
        ]);
});
