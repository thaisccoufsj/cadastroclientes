@extends('layouts.default')

@section('content')
@include('includes.alert')

<div class="page-content">
  <div class="card mt-2">
    <div class="card-header">
      Consulta de Clientes
    </div>
    <div class="card-body">
      <form id='customer-search-form' method="get" action="{{ route('list-customer') }}">
        @include('pages.customer-base-form')
        <button type="button" class="btn btn-secondary" data-clear-form-button>Limpar</button>
        <button type="button" class="btn btn-success" onclick="window.location='{{route('create-customer')}}'">Adicionar</button>
        <button type="submit" class="btn btn-primary">Buscar</button>
      </form>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header">
      Resultado da pesquisa
    </div>
    <div class="card-body">
        @if (count($customers) > 0)
            <table class="table table-striped table-hover table-bordered ">  

                <!-- Table Headings -->
                <thead class="thead-dark">
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data de Nascimento</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cidade</th>
                    <th scope="col" colspan="2">Ações</th>
                </thead>

                <!-- Table Body -->
                <tbody>

                @foreach($customers as $customer)
                  <?php $customer = (object) $customer; ?>
                    <tr>
                        <th scope="row">{{$customer->id}}</th>
                        <td>{{$customer->name}}</td>
                        <td>{{$customer->cpf}}</td>
                        <td>{{$customer->birthDate}}</td>
                        <td>{{$customer->gender}}</td>
                        <td>{{$customer->address}}</td>
                        <td>{{$customer->state}}</td>
                        <td>{{$customer->city}}</td>
                        <td>
                            <button type="button" class="btn btn-info" onclick="location.href='{{route('edit-customer', ['id' =>$customer->id])}}'">Editar</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="location.href='{{route('delete-customer', ['id' =>$customer->id])}}'">Excluir</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $paginator->appends(Request::except('page'))->render() !!}
            </div>
        @endif
    </div>
  </div>
</div>
@endsection