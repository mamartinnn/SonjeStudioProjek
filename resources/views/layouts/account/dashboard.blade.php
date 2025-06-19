@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="container my-5">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
      <ul class="list-unstyled">
        <a href="{{ route('bookmarks.index') }}">Bookmarks</a>
        <li><a  href="{{ route('profile.edit') }}" class="d-block mb-2">account details</a></li>
        
        
        
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link p-0" type="submit">log out</button>
          </form>
        </li>
      </ul>
    </div>

    <!-- Content -->
    <div class="col-md-9">
      <p>hello <strong>{{ auth()->user()->name }}</strong> (not {{ auth()->user()->name }}?) <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link p-0" type="submit">log out</button>
          </form>
      <p>from your account dashboard you can view your
        <a href="{{ route('bookmarks.index') }}">bookmarks</a>,and
        <a href="{{ route('profile.edit') }}">edit your password and account details</a>.
      </p>
    </div>
  </div>
</div>
@endsection
