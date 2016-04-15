@section('title', 'Realtime')
@extends('docs.master')
@section('content')
<div class="row realtime-items">
  <div class="col-md-3">
    <div class="list-group">
        @foreach ($lists as $item)
          <a href="historic/{{ urlencode($item) }}" class="list-group-item list-group-item-success">{{ $item }}</a>
        @endforeach
      </div>
  </div>
  <div class="col-md-9">
    

<div class="popover-example">
  <div class="popover right">
    <div class="arrow"></div>
    <h3 class="popover-title">Select an option</h3>
    <div class="popover-content">
      <p>Select one of the historic datasets from the left to view its API.</p>
    </div>
  </div>
</div>


  </div>
</div>
@endsection