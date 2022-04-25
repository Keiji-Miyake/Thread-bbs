@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Listings<span class="float-right"><a href="{{ route('listings.create') }}"
              class="btn btn-secondary">Create listings</a></span></div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <h2>Your listings</h2>
          @if (count($listings))
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Company</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($listings as $listing)
                  <tr>
                    <td>{{ $listing->name }}</td>
                    <td>
                      <form class="float-right ml-2" action="{{ route('listings.destroy', $listing->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" name="button">Delete</button>
                      </form>
                      <a href="{{ route('listings.edit', $listing->id) }}" class="btn btn-info float-right">Edit</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <p>You don't have any listings yet!</p>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
