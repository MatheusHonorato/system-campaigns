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
                    <h1 class="h2">Clínicas</h1>
                    @if(Auth::user()->type_user == 0)
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nova</button>
                    @endif
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
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
                        @foreach($clinics as $clinic)
                        <tr>
                            <td id="clinic_name_{{ $clinic->id }}">{{ $clinic->name }}</td>
                            <td class="text-center">
                                <!-- Modal Edit --> 
                                <div class="modal fade text-left" id="modalEdit{{ $clinic->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cadastro</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('clinics.update',$clinic->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <label>Nome</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Nome" value="{{ $clinic->name }}" maxlength="50" required
                                                        
                                                        @if(Auth::user()->type_user != 0)
                                                            disabled
                                                        @endif

                                                        >
                                                        @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('clinic_record') ? 'has-error' : '' }}">
                                                        <label>Registro clínico</label>
                                                        <input type="text" class="form-control" name="clinic_record" placeholder="Registro clínico" value="{{ $clinic->clinic_record }}" maxlength="50" required
                                                        
                                                        @if(Auth::user()->type_user != 0)
                                                            disabled
                                                        @endif

                                                        >
                                                        @if ($errors->has('clinic_record'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('clinic_record') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('technical_manager') ? 'has-error' : '' }}">
                                                        <label>Responsável técnico</label>
                                                        <input type="text" class="form-control" name="technical_manager" placeholder="Responsável técnico" value="{{ $clinic->technical_manager }}" maxlength="50" required
                                                        
                                                        @if(Auth::user()->type_user != 0)
                                                            disabled
                                                        @endif

                                                        >
                                                        @if ($errors->has('technical_manager'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('technical_manager') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('professional_record') ? 'has-error' : '' }}">
                                                        <label>Registro profissional</label>
                                                        <input type="text" class="form-control" name="professional_record" placeholder="Registro profissional" value="{{ $clinic->professional_record }}" maxlength="50" required
                                                        
                                                        @if(Auth::user()->type_user != 0)
                                                            disabled
                                                        @endif

                                                        >
                                                        @if ($errors->has('professional_record'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('professional_record') }}</strong>
                                                        </span>
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
                                @if(Auth::user()->type_user == 0)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $clinic->id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
                                @else
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $clinic->id }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Visualizar</button>
                                @endif
                            </td>
                            @if(Auth::user()->type_user == 0)
                            <td class="text-center">
                                <form class="delete-cl" action="{{ route('clinics.destroy', $clinic->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Excluir</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $clinics->links() }}
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
            <form action="{{ route('clinics.store') }}" method="POST">
                @csrf
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome" value="" maxlength="50" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('clinic_record') ? 'has-error' : '' }}">
                    <label>Registro clínico</label>
                    <input type="text" class="form-control" name="clinic_record" placeholder="Registro clínico" value="" maxlength="50">
                    @if ($errors->has('clinic_record'))
                    <span class="help-block">
                        <strong>{{ $errors->first('clinic_record') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('technical_manager') ? 'has-error' : '' }}">
                    <label>Responsável técnico</label>
                    <input type="text" class="form-control" name="technical_manager" placeholder="Responsável técnico" value="" maxlength="50">
                    @if ($errors->has('technical_manager'))
                    <span class="help-block">
                        <strong>{{ $errors->first('technical_manager') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('professional_record') ? 'has-error' : '' }}">
                    <label>Registro profissional</label>
                    <input type="text" class="form-control" name="professional_record" placeholder="Registro profissional" value="" maxlength="50">
                    @if ($errors->has('professional_record'))
                    <span class="help-block">
                        <strong>{{ $errors->first('professional_record') }}</strong>
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
@endsection
