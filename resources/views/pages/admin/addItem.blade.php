@extends('pages.admin.home')

@section('content')
<form>
    <div class="row">
      <div class="col">
        <input type="text" class="form-control" placeholder="First name">
      </div>
      <div class="col">
        <input type="text" class="form-control" placeholder="Last name">
      </div>
    </div>
  </form>
@endsection