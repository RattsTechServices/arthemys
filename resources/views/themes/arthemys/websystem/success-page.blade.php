<div class="container" style="width: 420px; height: 70%; top: 30%; position: relative;">
    <div class='row'>
        <div class='col-md-4 mx-auto text-center'>

        </div>
        <div class='col-md-12'>
            <div class='card bg-transparent shadow-lg rounded-4'>
                <div class='card-title row'>
                    <div class="col-12 text-center">
                        <i class='ki-duotone ki-check-circle text-success' style='font-size: 100px;'>
                            <span class='path1'></span>
                            <span class='path2'></span>
                        </i>
                    </div>
                    <div class="col-12 text-center" style="font-size: 40px;">
                        Sucesso
                    </div>
                </div>
                <div class='card-body fs-4 text-center'>
                    @if ($callback)
                        <div class="col">
                            Seu cadastro foi efetuado e agora aguarda aprovação. Clique
                            em prosseguir para continuar em {{ $title }}
                        </div>
                        <a href="{{$callback}}" class="btn btn-primary" style="margin-top: 30px;">
                            Prosseguir
                        </a>
                    @else
                        <div class="col">
                            Seu cadastro foi efetuado e agora aguarda aprovação. 
                            Retorne para <b class="text-success">{{ $title }}</b> e continue seu processo de autenticação
                        </div>
                        <a href="/" class="btn btn-primary" style="margin-top: 30px;">
                            Inicio
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
