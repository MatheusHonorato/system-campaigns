<!-- Modal Logo -->
<div class="modal fade" id="modaldownload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="modal-body">
                    <form action="{{ route('download') }}" method="GET">
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Clínica</label>
                            <select class="form-control" name="clinic">
                                @foreach($clinics_option as $clinic)
                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                @endforeach
                            </select>   
                        </div>
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Campanha</label>
                            <select class="form-control" name="campaign">
                                @foreach($campaigns_option as $campaign)
                                    <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                @endforeach
                            </select>   
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Baixar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>