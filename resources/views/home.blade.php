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
                            <tr>
                            <th scope="row">{{ $task->id }} </th>
                            <td> {{ $task->description }} </td>
                            <td> {{ $task->date->format('d-m-Y') }} </td>
                            <td> 
                                @if($task->user_id === \Auth::user()->id)
                                <button type="button" class="btn btn-secondary btn-sm">View</button>
                                @endif
                                <button type="button" class="btn btn-secondary btn-sm">Edit</button>
                                <button type="button" class="btn btn-secondary btn-sm">Delete</button>
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

<!-- Modal -->
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
</script>
@endsection
