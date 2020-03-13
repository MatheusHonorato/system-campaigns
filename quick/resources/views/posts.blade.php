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
                    <h1 class="h2 pt-2">Campanha: {{ $campaign->name }}</h1>
                    @if(Auth::user()->type_user == 0)
                        <button type="button" value="{{ $id }}" onclick="getCategories(this)" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Editar</button>
                    @endif
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Miniatura</th>
                            <th scope="col" class="text-center">Logo</th>
                            <th scope="col" class="text-center">Cor</th>
                            @if(Auth::user()->type_user == 0)
                                <th scope="col" class="text-center">Editar</th>
                            @else
                                <th scope="col" class="text-center">Visualizar</th>
                            @endif
                            @if(Auth::user()->type_user == 0)
                                <th scope="col" class="text-center">Excluir</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td id="post_name_{{ $post->id }}">
                            @if($post->image != '') 
                                <img src="{{ route('welcome') }}/storage/{{ $post->image }}" width="100px">
                            @else 
                                <img src="{{ route('welcome') }}/storage/images/default.png">
                            @endif
                            </td>
                            <td class="text-center">
                            @if($post->logo == 0) 
                                <img src="{{ route('welcome') }}/storage/{{ $logo_one }}" width="100px">
                            @else 
                                <img src="{{ route('welcome') }}/storage/{{ $logo_two }}" width="100px">
                            @endif
                            </td>
                            <td class="text-center">
                                <div style="background-color: {{ $post->color }}; cursor: auto;" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="{{ $post->color }}">
                                    {{ $post->color }}
                                </div>
                            </td>
                            @if(Auth::user()->type_user == 0)
                                <td class="text-center">
                                    <a href="" data-toggle="modal" data-target="#modalEdit{{ $post->id }}" class="btn btn-primary "><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</<a>
                                </td> 
                            @else
                                <td class="text-center">
                                    <a href="" data-toggle="modal" data-target="#modalEdit{{ $post->id }}" class="btn btn-primary "><i class="fa fa-sign-in" aria-hidden="true"></i> Visualizar</<a>
                                </td>  
                            @endif
                            @if(Auth::user()->type_user == 0)
                                <td class="text-center">
                                    <form class="delete-p" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Excluir</button>
                                    </form>
                                </td>
                            @endif
                        </tr>

                         <!-- Modal -->
                         <div class="modal fade text-left text-dark" id="modalEdit{{ $post->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            @if(Auth::user()->type_user == 0)
                                                <h5 class="modal-title" id="exampleModalLabel">Editar post</h5>
                                            @else
                                                <h5 class="modal-title" id="exampleModalLabel">Visualizar</h5>
                                            @endif
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <label>Id</label>
                                                    <input type="text" class="form-control" name="id" placeholder="Id" value="{{ $post->id }}" disabled>
                                                    @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback {{ $errors->has('campaign') ? 'has-error' : '' }}">
                                                    <label>Campanha</label>
                                                    <select class="form-control" name="campaign" 
                                                    
                                                    @if(Auth::user()->type_user != 0)
                                                        disabled
                                                    @endif

                                                    >
                                                    @foreach($campaigns as $camp)
                                                        @if($camp->id == $post->campaign_id)
                                                            <option value="{{ $camp->id }}" selected>{{ $camp->name }}</option>
                                                        @else
                                                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                    @if ($errors->has('campaigns'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('campaigns') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback {{ $errors->has('logo') ? 'has-error' : '' }}">
                                                    <label>Logo</label>
                                                    <select class="form-control" name="logo"
                                                    
                                                    @if(Auth::user()->type_user != 0)
                                                        disabled
                                                    @endif

                                                    >
                                                        <option value="0" @if($post->logo == '0') selected  @endif>Original</option>
                                                        <option value="1" @if($post->logo == '1') selected  @endif>Transparente</option>
                                                    </select>
                                                    @if ($errors->has('logo'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('logo') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback {{ $errors->has('color') ? 'has-error' : '' }}">
                                                    <label>Cor dos dados técnicos</label>
                                                    <input type="color" class="form-control" name="color" placeholder="Cor" value="{{ $post->color }}" maxlength="50"
                                                    
                                                    @if(Auth::user()->type_user != 0)
                                                        disabled
                                                    @endif

                                                    >
                                                    @if ($errors->has('color'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('color') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group text-center has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                                                    <label class="col-md-12 pl-0">Imagem</label>
                                                    @if($post->image != '') 
                                                        <img src="{{ route('welcome') }}/storage/{{ $post->image }}" width="200px">
                                                    @else 
                                                        <img src="{{ route('welcome') }}/storage/images/default.png">
                                                    @endif

                                                    @if(Auth::user()->type_user == 0)
                                                        <input class="mt-3" type="file" name="image" placeholder="Image">
                                                        @if ($errors->has('image'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('image') }}</strong>
                                                        </span>
                                                        @endif
                                                    @endif

                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            @if(Auth::user()->type_user == 0)
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
                                            @endif
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </main>
  

<!-- Modal Edit --> 
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar campanha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('campaigns.update', $id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ $campaign->name  }}" placeholder="Nome" maxlength="50" required>
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


