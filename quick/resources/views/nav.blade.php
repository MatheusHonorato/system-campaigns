<nav class="col-md-2 d-none d-md-block bg-dark sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('clinics.index') }}" 
                
                @if(explode('/', Request::url())[3] == 'clinicas')
                    class="nav-link active"
                @else
                    class="nav-link"
                @endif
                
                >
                    <i class="fa fa-home fa-2x" aria-hidden="true"></i>     
                        Clínicas                       
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('campaigns.index') }}"
                
                @if(explode('/', Request::url())[3] == 'campanhas')
                    class="nav-link active"
                @else
                    class="nav-link"
                @endif

                >
                    <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
                        Campanhas
                </a>
            </li>
            @if(Auth::user()->type_user == 0)
            <li class="nav-item">
                <a  href="" class="nav-link" data-toggle="modal" data-target="#modallogo">
                    <i class="fa fa-eyedropper fa-2x" aria-hidden="true"></i>
                        Logo
                </a>
            </li>
            @endif
            @if(Auth::user()->type_user == 2)
            <li class="nav-item">
                <a href="" class="nav-link" data-toggle="modal" data-target="#modalalert" onclick="getPosts()">
                    <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                        Observações
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="" class="nav-link" data-toggle="modal" data-target="#modaldownload" onclick="getPostsAndAlertCampaign()">
                    <i class="fa fa-download fa-2x" aria-hidden="true"></i>
                        Download
                </a>
            </li>
        </ul>
    </div>
</nav>