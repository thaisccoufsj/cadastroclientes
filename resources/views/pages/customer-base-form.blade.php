@csrf
<div class="row">
    <div class="col-md-3 mb-3">
    <label for="name">Nome</label>
    <input type="text" class="form-control" name="name" placeholder="Nome" value="{{$customer->name ?? ''}}">
    </div>
    <div class="col-md-3 mb-3">
    <label for="cpf">CPF</label>
    <input type="text" class="form-control cpf" name="cpf" placeholder="123.456.789-10" value="{{$customer->cpf ?? ''}}">
    </div>
    <div class="col-md-3 mb-3">
    <label for="birthdate">Data de Nascimento</label>
    <input type="text" class="form-control date" name="birthdate" placeholder="dd/mm/aaaa" @if(isset($customer) && $customer->birthDate) value="{{$customer->birthDate->format('d/m/Y')}}" @endif>
    </div>
    <div class="col-md-3 mb-3">
    <label for="birthdate">Sexo</label>
    <div class="form-control">
        <input class="form-check-input" type="radio" name="gender" name="genderfemale" value="F" @if(isset($customer) && $customer->gender == 'F') checked @endif>
        <label class="form-check-label" for="genderfemale">Feminino</label>
        <input class="form-check-input" type="radio" name="gender" name="gendermale" value="M" @if(isset($customer) && $customer->gender == 'M') checked @endif>
        <label class="form-check-label" for="gendermale">Masculino</label>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
    <label for="address">Endereço</label>
    <input type="text" class="form-control" name="address" placeholder="Endereço" value="{{$customer->address ?? ''}}">
    </div>
    <div class="col-md-3 mb-3">
    <label for="address">Estado</label>
    <input type="text" class="form-control" name="state" placeholder="Estado" value="{{$customer->state ?? ''}}">
    </div>
    <div class="col-md-3 mb-3">
    <label for="address">Cidade</label>
    <input type="text" class="form-control" name="city" placeholder="Cidade" value="{{$customer->city ?? ''}}">
    </div>
</div>