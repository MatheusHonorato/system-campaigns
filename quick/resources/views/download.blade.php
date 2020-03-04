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
                        <input type="hidden" id="type_campaign" name="type_campaign" value="0">
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
                            <select id="select_posts" class="form-control" name="campaign">
                                @foreach($campaigns_option as $campaign)
                                    <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                @endforeach
                            </select>   
                        </div>

                        <div class="form-group text-center">
                            <button id="btnCollapseEdit" onclick="getPosts()" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseEdit" aria-expanded="false">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                            </button>
                        </div>

                        <div class="collapse" id="collapseEdit">
                                <table id="table-select-posts" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Imagem</th>
                                            <th scope="col" class="text-center">Baixar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_posts">
                                       
                                    </tbody>
                                </table>
                            </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Baixar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    var destiny_posts = document.getElementById('body_posts');
    var click_posts = document.getElementById('select_posts');
    var type_campaign = document.getElementById('type_campaign');

    function populateHeader(jsonObj) {
        
        result = jsonObj.response;
        while (destiny_posts.firstChild) {
            destiny_posts.removeChild(destiny_posts.firstChild);
        }
        for (i = 0; i < result.length; i = i + 1) {
            var img = document.createElement("img");
            img.src = "{{ route('welcome') }}/storage/"+result[i].image;
            img.width = 100;
            var td = document.createElement("td");
            td.appendChild(img);
            var tdd = document.createElement("td");
            tdd.className = "text-center";
            var input = document.createElement("input");
            input.name = result[i].id;
            input.type = "checkbox";
            input.checked = "checked";
            tdd.appendChild(input);
            var tr = document.createElement("tr");
            tr.appendChild(td);
            tr.appendChild(tdd);
            destiny_posts.appendChild(tr);
        }
        
    }
    function getPosts() {
        destiny_posts.disabled = false;
        type_campaign.value = 1;
        var campaign_id = click_posts.value;
        var url = "{{ route('welcome') }}/posts_filter/"+campaign_id;
        var requestURL = url;
        var request = new XMLHttpRequest();
        request.open('GET', requestURL, true);
        request.responseType = 'json';
        request.send();
        
        request.onload = function() {
            var posts = request;
            populateHeader(posts);
        }
    };
</script>