@section('title', 'App API')
@extends('docs.master')
@section('content')
<div class="row realtime-items">
  <div class="col-md-3">
    <div class="list-group">
      @foreach ($lists as $item)
      <a href="{{ urlencode($item) }}" class="list-group-item list-group-item-success">{{ $item }}</a>
      @endforeach
    </div>
  </div>
  <div class="col-md-9">
    <div class="alert alert-info">
      <button type="button" class="close" aria-hidden="true"><i class="glyphicon glyphicon-user"></i></button>
      <h4>Your API key</h4>
      <textarea rows="1" class="form-control" onclick="this.focus();this.select()" readonly="readonly">{{$key}}</textarea>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading"><h5><span class="label label-info">GET</span> /api/v1/app/{{$name}}</h5></div>
        <table class="table">
          <thead>
            <tr>
              <th>Required</th>
              <th>Name</th>
              <th>Option</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Yes</td>
              <td>key</td>
              <td>[your api key]</td>
              <td>Your API key.</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>Yes</td>
              <td>user_id</td>
              <td>[User ID]</td>
              <td>User ID needed for lookup.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <center><a href="{{url('/api/v1/app/'.$name.'?key='.$key.'&user_id=PH9KrhJ2LO')}}" class="btn btn-info btn-block" target="_blank">Test it out.</a></center>
    </div>
</div>
</div>
@endsection