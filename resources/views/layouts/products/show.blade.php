@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">

  {{-- Flash Messages --}}
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
  @elseif (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row">
    <!-- Product Image -->
    <div class="col-md-6">
      <img src="{{ asset('storage/' . $product->image_url) }}" class="img-fluid" alt="{{ $product->name }}">
    </div>

    <!-- Product Details -->
    <div class="col-md-6">
      <h1 class="mb-3">{{ $product->name }}</h1>
      <p class="text-muted">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
      <p>{{ $product->description }}</p>

      <!-- Bookmark Button -->
      @auth
        <form action="{{ route('bookmark.store', $product) }}" method="POST">
          @csrf
          <button class="btn btn-dark mt-3">Add to Bookmarks</button>
        </form>
      @else
        <p><a href="{{ route('login') }}">Login</a> to bookmark this product.</p>
      @endauth

      <!-- External Links -->
      <div class="mt-4">
        @if($product->shopee_url)
          <a href="{{ route('product.shopee', $product) }}" class="btn btn-warning me-2" target="_blank">Beli di Shopee</a>
        @endif
        @if($product->tiktok_url)
          <a href="{{ route('product.tiktok', $product) }}" class="btn btn-info" target="_blank">Beli di TikTok Shop</a>
        @endif
      </div>

      <!-- Reviews Section -->
      <div class="mt-5">
        <h4>Customer Reviews</h4>

        <!-- Review Form -->
        @auth
          <form action="{{ route('review.store', $product) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
              <label for="comment" class="form-label">Your Review</label>
              <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
              <label for="rating" class="form-label">Rating (1–5)</label>
              <select name="rating" id="rating" class="form-control" required>
                @for ($i = 1; $i <= 5; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
          </form>
        @else
          <p><a href="{{ route('login') }}">Login</a> to leave a review.</p>
        @endauth

        <!-- Show Existing Reviews -->
        @forelse($product->reviews()->where('is_visible', true)->get() as $review)
          <div class="border p-3 mb-2 rounded">
            <strong>{{ $review->user->name }}</strong>  {{ $review->rating }}⭐<br>
            <p class="mb-0">{{ $review->comment }}</p>
            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
          </div>
        @empty
          <p>No reviews yet.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
