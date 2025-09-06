<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidaturaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nome'           => ['required','string','max:150'],
            'email'          => ['required','email','max:150'],
            'telefone'       => ['required','string','max:30'],
            'cargo_desejado' => ['required','string','max:120'],
            'escolaridade'   => ['required','string','in:Fundamental,Médio,Técnico,Superior,Pos,Outro'],
            'observacoes'    => ['nullable','string','max:2000'],
            'arquivo'        => ['required','file','mimes:doc,docx,pdf','max:1024'], // 1MB no maximo
        ];
    }

    public function messages(): array
    {
        return [
            'arquivo.mimes' => 'Envie apenas .doc, .docx ou .pdf.',
            'arquivo.max'   => 'O arquivo deve ter no máximo 1MB.',
        ];
    }
}
