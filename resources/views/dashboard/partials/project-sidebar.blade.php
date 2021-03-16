<ul class="navbar-nav ul--sidebar--overview">
  <li><a href="/project/{{$project_salt}}/overview/details">Overview</a></b></li>
  <li><a href="/projects/{{$project_salt}}/open/todo">To-do</a></li>
  <li><a href="/projects/{{$project_salt}}/stages">Stages</a></li>
  <li><a href="/projects/{{$project_salt}}/sharing">Sharing</a></li>
  <li><a href="/projects/{{$project_salt}}/attachments">Attachments</a></li>
  <li><a href="/projects/{{$project_salt}}/export">Exports</a></li>
  <li><a href="/project/{{$project_salt}}/overview/activity">Activity Log</a></li>
</ul>
<ul class="navbar-nav ul--sidebar--overview-2">
  <li><a href="/project/{{$project_salt}}/plans"><i class="fas fa-upload"></i> Upload Plans</a></li>
  <li><a><i class="fas fa-download"></i> Download Plans</a></li>
  <li><a onclick="open_global_archive_modal('{{$project_id}}','{{$project_name}}')" style="color: #D58512!important;"><i class="fas fa-archive"></i> Archeive Project</a></li>
</ul>


{{-- Archive Modal --}}
<div class="modal fade" id="global_archive_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{route('project.addtoarchive')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Archive Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <b>Project:</b>
          <p id="archive_project_name"></p>
          <b>Please choose a Reason:</b>
          <input type="hidden" name="id" id="archive_project_id">
          <select name="reason" class="form-control">
            @if($reasons->isEmpty())
              <option value="">Choose</option>
            @else
              @foreach($reasons as $reason)
                <option value="{{$reason->id}}" style="color:{{$reason->color}};">{{$reason->reason}}</option>
              @endforeach
            @endif
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>