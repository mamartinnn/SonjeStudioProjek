@extends('layouts.app')

@section('title', 'Search Products')

@section('content')
<div class="container py-5">

  {{-- FILTER FORM --}}
  <form action="{{ route('products.search') }}" method="GET" class="row g-2 align-items-end mb-5">
    <div class="col-md-4">
      <input type="text" name="q" class="form-control shadow-sm rounded-3 border-light" placeholder="Search product name..." value="{{ request('q') }}">
    </div>
    <div class="col-md-2">
      <input type="number" name="min_price" class="form-control shadow-sm rounded-3 border-light" placeholder="Min Price" value="{{ request('min_price') }}">
    </div>
    <div class="col-md-2">
      <input type="number" name="max_price" class="form-control shadow-sm rounded-3 border-light" placeholder="Max Price" value="{{ request('max_price') }}">
    </div>
    <div class="col-md-3">
      <select name="category" class="form-select shadow-sm rounded-3 border-light">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-1">
      <button type="submit" class="btn btn-dark w-100 rounded-3">Search</button>
    </div>
  </form>

  {{-- PRODUCT GRID --}}
  @if($products->count())
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
      @foreach($products as $product)
        <div class="col">
          <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark d-block">
            <div class="ratio ratio-3x4 bg-light overflow-hidden rounded position-relative border">
              <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover transition">
            </div>
            <div class="mt-2 small">{{ $product->name }}</div>
            <div class="fw-semibold small text-muted">IDR {{ number_format($product->price, 0, ',', '.') }}</div>
          </a>
        </div>
      @endforeach
    </div>
  @else
    <div class="text-center text-muted py-5">
      <p class="mb-1" style="font-size: 1.1rem;">No products found.</p>
      <small>Try adjusting your filters or search keyword.</small>
    </div>
  @endif

  {{-- PAGINATION --}}
  <div class="mt-5">
    {{ $products->withQueryString()->links() }}
  </div>
</div>

<style>
  .ratio-3x4 {
    aspect-ratio: 3 / 4;
  }

  .object-fit-cover {
    object-fit: cover;
  }

  .transition {
    transition: transform 0.3s ease, opacity 0.3s ease;
  }

  .transition:hover {
    transform: scale(1.03);
    opacity: 0.9;
  }

  select.form-select,
  input.form-control {
    font-size: 0.9rem;
    background-color: #fff;
  }
</style>
@endsection
