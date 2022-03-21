@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Exam Dashboard') }}</div>

        <div class="card-body">

          {{ __('You are logged in exam dashboard!') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection