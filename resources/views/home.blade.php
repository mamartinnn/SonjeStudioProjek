@extends('layouts.app')

@section('title', 'Home')

@section('content')

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


{{-- NEW ARRIVAL --}}
<section class="container text-center my-5">
  <h2 class="mb-4 text-uppercase fw-light small tracking-wide" style="letter-spacing: 2px; color: #333;">New Arrival</h2>

  <div class="d-flex flex-row flex-nowrap overflow-auto justify-content-center gap-4 px-2">
    @foreach($newArrivals as $product)
      <div class="flex-shrink-0 d-flex flex-column align-items-center text-center" style="max-width: 220px;">
        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark w-100">
          <div class="ratio ratio-3x4 overflow-hidden rounded" style="background-color: #f9f9f9;">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="w-100 h-100 object-fit-cover transition" alt="{{ $product->name }}">
          </div>
        </a>
        <div class="mt-2 px-1">
          <p class="mb-1 fw-normal small">{{ $product->name }}</p>
          <p class="text-muted mb-1 small">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
          <p class="text-muted small text-truncate-2" style="font-size: 0.8rem;">{{ $product->description }}</p>
        </div>
      </div>
    @endforeach
  </div>
</section>


{{-- BEST SELLERS --}}
<section class="container py-5">
  <h2 class="mb-4 text-uppercase fw-light small tracking-wide" style="letter-spacing: 2px; color: #333;">Best Sellers</h2>

  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
    @foreach($products as $product)
      <div class="col">
        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark d-block">
          <div class="ratio ratio-3x4 overflow-hidden rounded border" style="background-color: #f9f9f9;">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="w-100 h-100 object-fit-cover transition" alt="{{ $product->name }}">
          </div>
          <div class="mt-2 small text-start" style="min-height: 40px;">{{ $product->name }}</div>
          <div class="fw-semibold small text-start text-muted">IDR {{ number_format($product->price, 0, ',', '.') }}</div>
        </a>
      </div>
    @endforeach
  </div>
</section>

{{-- SHOP STUDIO NOW --}}
<section class="container py-5">
  <h2 class="mb-4 text-uppercase fw-light small tracking-wide" style="letter-spacing: 2px; color: #333;">Shop Sonje Now</h2>

  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
    @foreach($randomProducts as $product)
      <div class="col">
        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark d-block">
          <div class="ratio ratio-3x4 overflow-hidden rounded border" style="background-color: #f9f9f9;">
            <img src="{{ asset('storage/' . $product->image_url) }}" class="w-100 h-100 object-fit-cover transition" alt="{{ $product->name }}">
          </div>
          <div class="mt-2 small text-start" style="min-height: 40px;">
            {{ $product->name }}
          </div>
          <div class="fw-semibold small text-start">
            @if(isset($product->original_price) && $product->original_price > $product->price)
              <span class="text-muted text-decoration-line-through">IDR {{ number_format($product->original_price, 0, ',', '.') }}</span>
            @endif
            IDR {{ number_format($product->price, 0, ',', '.') }}
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>

<style>
  .ratio-3x4 {
    aspect-ratio: 3 / 4;
  }
  .object-fit-cover {
    object-fit: cover;
  }
  .tracking-wide {
    letter-spacing: 1.5px;
  }
  .transition {
    transition: transform 0.3s ease;
  }
  .transition:hover {
    transform: scale(1.02);
  }

  .text-truncate-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

</style>

@endsection
