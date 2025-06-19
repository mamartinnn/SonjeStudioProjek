<!-- Bootstrap Header -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .brand-text span {
    margin-right: 0.25rem;
    font-weight: 300;
    font-size: 1.5rem;
    letter-spacing: 0.05em;
  }
  .nav-link {
    font-size: 1 rem;
    font-weight: 400;
    letter-spacing: 0.03em;
    color: #333;
  }
  .nav-link  {
  position: relative;
  font-size: 0.875rem;
  font-weight: 400;
  letter-spacing: 0.03em;
  color: #333;
  text-decoration: none;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 1px;
  width: 0%;
  background-color: #000;
  transition: width 0.3s ease;
}

.nav-link:hover::after {
  width: 100%;
}


  
</style>

<header class="border-bottom py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <!-- Left: Brand -->
    <div class="brand-text d-flex align-items-center">
       <a class="nav-link" href="/">Sonje Studio </a>
    </div>

    <!-- Center: Navigation -->
    <ul class="nav d-none d-md-flex">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('products.search') }}">Search</a>
      </li>
    </ul>

    <!-- Right: Account and Cart -->
    <ul class="nav d-none d-md-flex">
       <li class="nav-item">
    @auth
      <a class="nav-link" href="{{ route('account.dashboard') }}">My Account</a>
    @else
      <a class="nav-link" href="{{ route('login') }}">Login / Register</a>
    @endauth
  </li>
    </ul>
  </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
