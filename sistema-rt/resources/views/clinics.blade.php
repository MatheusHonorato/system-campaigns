@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('clinics.index') }}">
                            <span data-feather="home"></span>
                            Clínicas <span class="sr-only"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('campaigns.index') }}">
                            <span data-feather="bar-chart-2"></span>
                        Campanhas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">
                            <span data-feather="shopping-cart"></span>
                            Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="download-cart"></span>
                            Download
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="col-md-11">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2">Clínicas</h1>
                    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal">Novo</button>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">R.C</th>
                            <th scope="col">R.T</th>
                            <th scope="col">R.P</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clinics as $clinic)
                        <tr>
                            <td id="clinic_name_{{ $clinic->id }}">{{ $clinic->name }}</td>
                            <td id="clinic_clinic_record_{{ $clinic->id }}">{{ $clinic->clinic_record }}</td>
                            <td id="technical_manager_{{ $clinic->id }}">{{ $clinic->technical_manager }}</td>
                            <td id="professional_record_{{ $clinic->id }}">{{ $clinic->professional_record }}</td>
                            <td>
                                <!-- Modal Edit --> 
                                <div class="modal fade" id="modalEdit{{ $clinic->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                        <input type="text" class="form-control" name="name" placeholder="Nome" value="{{ $clinic->name }}" minlength="10" maxlength="50" required>
                                                        @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('clinic_record') ? 'has-error' : '' }}">
                                                        <label>Registro clínico</label>
                                                        <input type="text" class="form-control" name="clinic_record" placeholder="Registro clínico" value="{{ $clinic->clinic_record }}" minlength="10" maxlength="50" required>
                                                        @if ($errors->has('clinic_record'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('clinic_record') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('technical_manager') ? 'has-error' : '' }}">
                                                        <label>Responsável técnico</label>
                                                        <input type="text" class="form-control" name="technical_manager" placeholder="Responsável técnico" value="{{ $clinic->technical_manager }}" minlength="10" maxlength="50" required>
                                                        @if ($errors->has('technical_manager'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('technical_manager') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('professional_record') ? 'has-error' : '' }}">
                                                        <label>Registro profissional</label>
                                                        <input type="text" class="form-control" name="professional_record" placeholder="Registro profissional" value="{{ $clinic->professional_record }}" minlength="10" maxlength="50" required>
                                                        @if ($errors->has('professional_record'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('professional_record') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalEdit{{ $clinic->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ route('clinics.destroy', $clinic->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $clinics->links() }}
            </div>
        </main>
    </div>
</div>

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
                    <input type="text" class="form-control" name="name" placeholder="Nome" value="" minlength="10" maxlength="50" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('clinic_record') ? 'has-error' : '' }}">
                    <label>Registro clínico</label>
                    <input type="text" class="form-control" name="clinic_record" placeholder="Registro clínico" value="" minlength="10" maxlength="50" required>
                    @if ($errors->has('clinic_record'))
                    <span class="help-block">
                        <strong>{{ $errors->first('clinic_record') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('technical_manager') ? 'has-error' : '' }}">
                    <label>Responsável técnico</label>
                    <input type="text" class="form-control" name="technical_manager" placeholder="Responsável técnico" value="" minlength="10" maxlength="50" required>
                    @if ($errors->has('technical_manager'))
                    <span class="help-block">
                        <strong>{{ $errors->first('technical_manager') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('professional_record') ? 'has-error' : '' }}">
                    <label>Registro profissional</label>
                    <input type="text" class="form-control" name="professional_record" placeholder="Registro profissional" value="" minlength="10" maxlength="50" required>
                    @if ($errors->has('professional_record'))
                    <span class="help-block">
                        <strong>{{ $errors->first('professional_record') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
  </div>
</div>

@endsection
