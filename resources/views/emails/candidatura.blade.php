<x-mail::message>
# Nova Candidatura

**Nome:** {{ $c->nome }}  
**E-mail:** {{ $c->email }}  
**Telefone:** {{ $c->telefone }}  
**Cargo:** {{ $c->cargo_desejado }}  
**Escolaridade:** {{ $c->escolaridade }}  
**IP:** {{ $c->ip }}  
**Enviado em:** {{ $c->enviado_em->format('d/m/Y H:i') }}  

@isset($c->observacoes)
**Observações:**  
{{ $c->observacoes }}
@endisset
</x-mail::message>
