<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaturaRequest;
use App\Mail\CandidaturaRecebida;
use App\Models\Candidatura;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CandidaturaController extends Controller
{
    public function create()
    {
        $opcoesEscolaridade = ['Fundamental','Médio','Técnico','Superior','Pos','Outro'];
        return view('candidaturas.create', compact('opcoesEscolaridade'));
    }

    public function store(CandidaturaRequest $request)
    {
        try {
            // Upload privado (config: 'local' -> storage/app/private)
            $path = $request->file('arquivo')->store('curriculos', 'local');

            // Persiste a candidatura
            $candidatura = Candidatura::create([
                'nome'           => $request->input('nome'),
                'email'          => $request->input('email'),
                'telefone'       => $request->input('telefone'),
                'cargo_desejado' => $request->input('cargo_desejado'),
                'escolaridade'   => $request->input('escolaridade'),
                'observacoes'    => $request->input('observacoes'),
                'arquivo_path'   => $path,
                'ip'             => $request->ip(),
                'enviado_em'     => now(),
            ]);

            // Envia e-mail (em dev, com MAIL_MAILER=log, vai para storage/logs/laravel.log)
            Mail::to('dev@paytour.com.br')->send(new CandidaturaRecebida($candidatura));

            return redirect()
                ->route('candidaturas.create')
                ->with('success', '✅ Candidatura enviada com sucesso!');
        } catch (\Throwable $e) {
            // Em caso de erro, loga e avisa o usuário
            Log::error('Erro ao processar candidatura', [
                'msg' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            // Opcional: se quiser apagar o arquivo salvo quando falhar algo depois
            // if (isset($path) && Storage::disk('local')->exists($path)) {
            //     Storage::disk('local')->delete($path);
            // }

            return back()->withInput()->with('error', '❌ Ocorreu um erro ao enviar sua candidatura. Tente novamente.');
        }
    }
}
