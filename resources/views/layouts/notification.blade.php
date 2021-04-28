<aside id="notification-sidebar" class="notification-sidebar d-none d-sm-none d-md-block"><a class="notification-sidebar-close"><i class="ft-x font-medium-3"></i></a>
      <div class="side-nav notification-sidebar-content">
        <div class="row">
          <div class="col-12 mt-1">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a id="base-tab1" data-toggle="tab" aria-controls="base-tab1" href="#activity-tab" aria-expanded="true" class="nav-link active"><strong>Activiés</strong></a></li>
            </ul>
            <div class="tab-content">
              <div id="activity-tab" role="tabpanel" aria-expanded="true" aria-labelledby="base-tab1" class="tab-pane active">
                <div id="activity-timeline" class="col-12 timeline-left">
                  <h6 class="mt-1 mb-3 text-bold-400">Activités récentes</h6>
                  <div class="timeline">
                    <ul class="list-unstyled base-timeline activity-timeline ml-0">
                        @foreach (App\Models\History::where('user_id', Auth::user()->id)->orderBy('date', 'DESC')->paginate(7) as $act)
                                        <li class="">
                                            <div class="timeline-icon   @if ($act->type === 'Ajout') bg-success @elseif($act->type === 'Edition') bg-warning @else bg-danger @endif">
                                                @if ($act->type === 'Ajout')
                                                    <i class="icon-plus"></i>
                                                @elseif($act->type === 'Edition')
                                                    <i class="ft-edit"></i>
                                                @else
                                                <i class="ft-trash-2"></i>
                                                @endif
                                            </div>
                                            <div class="base-timeline-info">
                                            <a href="#" class="text-uppercase  @if ($act->type === 'Ajout') text-success @elseif($act->type === 'Edition') text-warning @else text-danger @endif">{{$act->description}}</a>
                                            </div>
                                            <small class="text-muted">
                                                                {{$act->date}}
                                            </small>
                                        </li>
                                        @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </aside>
