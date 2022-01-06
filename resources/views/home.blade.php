@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            {{ __('Dashboard') }}
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">Create Task</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Description</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr @if($task->date < date('Y-m-d')) style="background: #f7b0b0;" @endif>
                            <th scope="row">{{ $task->id }} </th>
                            <td> {{ $task->description }} </td>
                            <td> {{ $task->date->format('d-m-Y') }} </td>
                            <td data-description="{{ $task->description }}" data-id="{{ $task->id }}" data-user="{{ $task->user_id }}" data-date="{{ $task->date->format('d/m/Y') }}">
                                @if($task->user_id === \Auth::user()->id)
                                <button type="button" class="btn btn-secondary btn-sm">View</button>
                                @endif
                                <button type="button" class="btn btn-secondary btn-sm edit">Edit</button>
                                <button type="button" class="btn btn-secondary btn-sm delete">Delete</button>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form id="createTaskForm" action="{{route('createtask')}}" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="taskdescription">Task Description</label>
            <textarea class="form-control" name= "taskdescription" id="taskdescription" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label" for="taskuser">Responsible user</label>
            <select class="form-select" name="taskuser" id="taskuser">
                <option value=""> Seleccione </option>
                @foreach($users as $user)
                    <option value={{ $user->id }}> {{ $user->name }} </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="taskdate">Date</label>
            <input type="text" class="form-control datepicker" name="taskdate" id="taskdate" value="{{ date('d/m/Y') }}">
        </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="createTask"> Create Task</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form id="editTaskForm" action="{{route('edittask')}}" method="post">
        @csrf
        <input type="hidden" name="id" id="taskide">
        <div class="mb-3">
            <label class="form-label" for="taskdescription">Task Description</label>
            <textarea class="form-control" name= "taskdescription" id="taskdescriptione" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label" for="taskuser">Responsible user</label>
            <select class="form-select" name="taskuser" id="taskusere">
                <option value=""> Seleccione </option>
                @foreach($users as $user)
                    <option value={{ $user->id }}> {{ $user->name }} </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="taskdate">Date</label>
            <input type="text" class="form-control datepicker" name="taskdate" id="taskdatee" value="{{ date('d/m/Y') }}">
        </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editTask"> Edit Task</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    var myModal = document.getElementById('createModal')
    var myInput = document.getElementById('taskdescription')
    myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
    });

    $(document).on('click', '#createTask', function(){
        var taskdescription = $('#taskdescription').val();
        var taskdate = $('#taskdate').val();
        var taskuser = $('#taskuser').val();

        if(!taskdescription){
            alert('Field task description is required');
            return false;
        }
        
        if(!taskuser){
            alert('Field Responsible user is required');
            return false;
        }

        if(!taskdate){
            alert('Field task date is required');
            return false;
        }

        $('#createTaskForm').submit();
    });

    $(document).on('click', '#editTask', function(){
        $('#editTaskForm').submit();
    });

    $(document).on('click', '.delete', function(){
        var td = $(this).closest('td');
        var id = $(td).data('id');
        var description = $(td).data('description');
        Swal.fire({
            title: 'Confirm delete ' + description,
            icon: 'question',
            iconHtml: '?',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '{{ route("deletetask") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success:function(data){
                        location.reload();
                    },
                    error: function(data){
                        Swal.fire('Task not deleted', '', 'error')
                    },
                });
            }
        });
    });

    $(document).on('click', '.edit', function(){
        var td = $(this).closest('td');
        var id = $(td).data('id');
        var description = $(td).data('description');
        var date = $(td).data('date');
        var user = $(td).data('user');
        $('#taskide').val(id);
        $('#taskdescriptione').val(description);
        $('#taskusere').val(user);
        $('#taskdatee').val(date);

        $("#editModal").modal('show');

    });

</script>
@endsection
