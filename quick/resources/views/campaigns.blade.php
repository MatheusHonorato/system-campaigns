@extends('layouts.app')

@section('content')

@include('nav')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2">Campanhas</h1>
                    @if(Auth::user()->type_user == 0)
                        <button type="button" value="{{ $type_id }}"  onclick="getCategories(this)" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nova</button>
                    @endif
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-center">Acessar</th>
                            @if(Auth::user()->type_user == 0)
                                <th scope="col" class="text-center">Excluir</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($campaigns)) 
                            @foreach($campaigns as $campaign)
                            <tr>
                                <td id="campaign_name_{{ $campaign->id }}">{{ $campaign->name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('campaigns.show', $campaign->id) }}"  class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Acessar</a>
                                </td>
                                @if(Auth::user()->type_user == 0)
                                <td class="text-center">
                                    <form class="delete-c" action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Excluir</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if(isset($campaigns)) 
                    {{ $campaigns->links() }}
                @endif
            </div>
        </main>
    

<!-- Modal New --> 
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cadastro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome" maxlength="50" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label>Tipo</label>
                    <select class="form-control" id="type" name="type" onclick="getCategories(this)" required>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                    </select>
                    @if ($errors->has('type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
                <div id="body_categories" class="form-group has-feedback {{ $errors->has('campaigns') ? 'has-error' : '' }}">
                    @if ($errors->has('campaigns'))
                        <span class="help-block">
                            <strong>{{ $errors->first('campaigns') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('logo') ? 'has-error' : '' }}">
                    <label>Logo</label>
                    <select class="form-control" name="logo" required>
                        <option value="0">Original</option>
                        <option value="1">Transparente</option>
                    </select>
                    @if ($errors->has('logo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('logo') }}</strong>
                    </span>
                    @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('color') ? 'has-error' : '' }}">
                        <label>Cor dos dados técnicos</label>
                        <input type="color" class="form-control" name="color" placeholder="Cor" maxlength="50" required>
                        @if ($errors->has('color'))
                        <span class="help-block">
                            <strong>{{ $errors->first('color') }}</strong>
                        </span>
                        @endif
                    </div>
                <div class="form-group has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="col-md-12 pl-0">Imagem</label>
                    <input type="file" name="images[]" placeholder="Imagens" multiple required> 
                    @if ($errors->has('images'))
                        <span class="help-block">
                            <strong>{{ $errors->first('images') }}</strong>
                        </span>
                    @endif
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
            </form>
        </div>
    </div>
  </div>
</div>

<script>
    var destiny_categories = document.getElementById('body_categories');

    function populateHeaderCampaign(jsonObj) {
        
        result = jsonObj.response;
        
        if(destiny_categories) {
            while (destiny_categories.firstChild) {
                destiny_categories.removeChild(destiny_categories.firstChild);
            }
        }

        var label_campaign = document.createElement("label");
        label_campaign.textContent = "Categoria"; 
        destiny_categories.appendChild(label_campaign);

        var select = document.createElement("select");
        select.name = "category";
        select.className = "form-control";

        for (i = 0; i < result.length; i = i + 1) {
            
            var option = document.createElement("option");
            option.value = result[i].id;
            option.textContent = result[i].name;
            select.appendChild(option);
        }
        destiny_categories.appendChild(select);
        
    }
    
    function getCategories(id) {
        var url = "{{ route('welcome') }}/categories_filter/"+id.value;
        var requestURL = url;
        var request = new XMLHttpRequest();
        request.open('GET', requestURL, true);
        request.responseType = 'json';
        request.send();
        
        request.onload = function() {
            var categories = request;
            populateHeaderCampaign(categories);
        }
    };
        
</script>

@endsection



