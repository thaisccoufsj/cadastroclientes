@extends('layouts.default')

@section('content')
@include('includes.alert')

<div class="page-content">
  <div class="card"  >
    <div class="card-header">
      Cadastro de clientes
    </div>
    <div class="card-body">
      <form method="post" action="{{ route('save-customer') }}">
        @include('pages.customer-base-form')
        <button type="button" class="btn btn-secondary" onclick="location.href = '{{ route('list-customer') }}'">Voltar para Listagem</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </form>
    </div>
  </div>
</div>
@endsection