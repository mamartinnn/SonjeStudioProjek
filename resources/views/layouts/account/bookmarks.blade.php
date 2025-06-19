@extends('layouts.app')

@section('title', 'My Bookmarked Products')

@section('content')
<div class="container py-5">
  <h1 class="mb-4">My Bookmarked Products</h1>

  {{-- Flash Message --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @elseif (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      {{ session('info') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if($bookmarkedProducts->isEmpty())
    <p>You have no bookmarked products yet.</p>
  @else
    <div class="row">
      @foreach($bookmarkedProducts as $product)
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
              <h5 class="card-title">{{ $product->name }}</h5>
              <p class="card-text text-muted">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
              <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary">View Product</a>

              <form action="{{ route('bookmark.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger ms-2">Remove</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
