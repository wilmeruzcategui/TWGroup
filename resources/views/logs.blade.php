@foreach($logs as $log)
<tr>
    <td scope="col">{{$log->id}}</td>
    <td scope="col">{{$log->comment}}</td>
    <td scope="col">{{$log->created_at->format('d/m/Y')}}</td>
</tr>
@endforeach