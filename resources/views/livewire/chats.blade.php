@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')

    <div class="chat-application mt-2">
                <div class="content-overlay"></div>
                <div class="chat-sidebar float-left d-none d-sm-none d-md-block d-lg-block">
                  <div class="chat-sidebar-content">
                    <div class="chat-fixed-search p-2">
                      <form>
                        <div class="position-relative has-icon-left">
                          <input class="form-control" id="timesheetinput1" name="employeename" type="text">
                          <div class="form-control-position">
                            <i class="ft-user"></i>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div id="users-list" class="list-group position-relative">
                      <div class="users-list-padding">
                          @if ($clientMessagers)

                            @foreach ($clientMessagers as $msg)
                                <a wire:click.prevent="currentClient({{$msg->id}})" class="list-group-item @if($msg->id === $client->id) bg-success @endif bg-lighten-5 border-right-primary border-right-2">  <!-- (click)="SetActive($event, 'chat1')" -->
                                <span class="media">
                                    <span class="avatar avatar-md avatar-online mr-2">
                                    <img class="media-object d-flex mr-3 bg-primary rounded-circle" src="storage/images/client.png"
                                        alt="Generic placeholder image">
                                    <i></i>
                                    </span>
                                    <div class="media-body">
                                        <h6 class="list-group-item-heading">{{$msg->nom}}
                                        </h6>
                                    </div>
                                </span>
                                </a>
                            @endforeach

                          @else
                              Aucun message
                          @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="chat-name p-2 bg-white">
                  <div class="media">
                      <span class="chat-app-sidebar-toggle ft-align-justify font-large-1 mr-2 d-none d-block d-sm-block d-md-none"></span>
                      <img src="storage/images/client.png" width="37" class="rounded-circle mr-1" alt="avatar" />
                      <div class="media-body">
                        <span class="float-left">
                            @if ($client)
                                {{$client->nom}}
                          @else
                              Aucun
                          @endif
                        </span>
                        <i class="ft-more-vertical float-right mt-1"></i>
                      </div>
                  </div>
                </div>
                <section class="chat-app-window">
                  <div class="badge badge-dark mb-1">Historique des envois</div>
                  @if ($client)
                  <div class="chats">

                        @foreach ($client->messages as $item)
                            @if ($item->user_id === Auth::user()->id)
                                <div class="chat chat-left">
                                    <div class="chat-avatar">
                                        <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                                        <img src="storage/images/{{Auth::user()->avatar}}" class="width-50 rounded-circle" alt="avatar" />
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                        <p>{{$item->contenu}}</p>
                                        </div>
                                        <div class="chat-content">
                                        <p><a href="storage/fichiers/{{$item->fichier}}" target="_blank"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i> document</a></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="time">{{$item->created_at}}</p>
                            @endif
                        @endforeach

                    </div>
                      @endif
                </section>
                <section class="chat-app-form bg-blue-grey bg-lighten-5">
                  <form class="chat-app-input row" wire:submit.prevent="send" enctype="multipart/form-data">
                    <fieldset class="form-group position-relative has-icon-left col-lg-12  m-0">
                      <div class="form-control-position">
                        <i class="icon-emoticon-smile"></i>
                      </div>
                      <input type="text" class="form-control @error('form.contenu') is-invalid @enderror" id="iconLeft4" wire:model="form.contenu" placeholder="Entrer le message"
                      >
                      @error('form.contenu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </fieldset>
                    <fieldset class="form-group position-relative  col-lg-5 m-0 mt-2">
                      <input type="file" class="form-control @error('form.fichier') is-invalid @enderror" wire:model="form.fichier" id="iconLeft4"
                      >
                      @error('form.fichier')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </fieldset>
                    <fieldset class="form-group position-relative  col-lg-5 m-0 mt-2">
                        <select class="form-control @error('form.client_id') is-invalid @enderror" wire:model="form.client_id">
                            <option value="">Selectionner un client</option>
                            @foreach ($clients as $cli)
                                <option value="{{$cli->id}}">{{$cli->nom}}</option>
                            @endforeach
                        </select>
                        @error('form.client_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </fieldset>
                    <fieldset class="form-group position-relative has-icon-left col-lg-2 mt-2">
                      <button class="btn btn-info">
                        <i class="fa fa-paper-plane-o hidden-lg-up"></i> Envoyer</button>
                    </fieldset>
                  </form>
                </section>
              </div>
</div>


@section('js')
    <script>
        window.addEventListener('mailSent', event =>{
            toastr.success('Message envoyé avec succès!', 'Client', {positionClass: 'toast-top-right'});
        })
    </script>
@endsection
