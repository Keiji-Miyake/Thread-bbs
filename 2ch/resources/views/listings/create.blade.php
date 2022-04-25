@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Create Listing<span class="float-right"><a href="{{ route('listings.index') }}" class="btn btn-secondary">Go Index</a></span></div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <form method="POST" action="{{ route('listings.store') }}">
            @csrf
            <div class="form-group">
              <label for="name">Enter your name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="address">Enter your address</label>
              <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" value="{{ old('address') }}">
            </div>
            <div class="form-group">
              <label for="website">Enter your website</label>
              <input type="text" class="form-control" name="website" id="website" placeholder="Enter website" value="{{ old('website') }}">
            </div>
            <div class="form-group">
              <label for="email">Enter your email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
              <label for="phone">Enter your phone</label>
              <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
              <label for="bio">Enter your bio</label>
              <input type="text" class="form-control" name="bio" id="bio" placeholder="Enter bio" value="{{ old('bio') }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
