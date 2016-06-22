@section('title', 'NASA')
@extends('docs.master')
@section('content')
<div class="row realtime-items">
  <div class="col-md-3">
    Note: Make sure to include a `tb` ID.
  </div>
  <div class="col-md-9">
    <div class="alert alert-info">
      <button type="button" class="close" aria-hidden="true"><i class="glyphicon glyphicon-user"></i></button>
      <h4>Your API key</h4>
      <textarea rows="1" class="form-control" onclick="this.focus();this.select()" readonly="readonly">{{$key}}</textarea>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading"><h5><span class="label label-info">GET</span> /api/v1/homewood/</h5></div>
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
              <td>tb</td>
              <td>[1-4]</td>
              <td>Buoy ID.</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>No</td>
              <td>limit</td>
              <td>[integer]</td>
              <td>Default: 100.</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>Yes</td>
              <td>start</td>
              <td>yyyy-mm-dd</td>
              <td>Start date for data.</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>No</td>
              <td>end</td>
              <td>yyyy-mm-dd</td>
              <td>End date for data.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <center><a href="{{url('/api/v1/nasa/?key='.$key.'&start=2016-04-29&limit=10&tb=1')}}" class="btn btn-info btn-block" target="_blank">Test it out.</a></center>
    </div>
</div>
</div>
@endsection