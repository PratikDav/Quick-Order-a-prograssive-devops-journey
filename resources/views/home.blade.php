@extends('layouts.app')

@section('title', __('ui.nav.products'))

@section('content')
    <div class="intro">
        <div><h1>{{ __('ui.home.title') }}</h1><p>{{ __('ui.home.subtitle') }}</p></div>
        @guest<a class="button secondary" href="{{ route('register') }}">{{ __('ui.home.join_seller') }}</a>@endguest
    </div>

    @if ($products->isEmpty())
        <div class="empty">{{ __('ui.home.empty') }}</div>
    @else
        <div class="product-grid">
            @foreach ($products as $product)
                <article class="product">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description ?: __('ui.home.details_fallback') }}</p>
                    <div class="seller">{{ __('ui.home.seller', ['name' => $product->seller->name]) }}</div>
                    <div class="price-row"><span class="price">৳{{ number_format($product->price, 2) }}</span><span class="stock">{{ __('ui.home.stock', ['count' => $product->stock]) }}</span></div>
                    <div style="margin-top:13px">
                        @auth
                            @if (auth()->user()->role === 'buyer')<a class="button" href="{{ route('orders.create', $product) }}">{{ __('ui.home.order') }}</a>@else<span class="muted">{{ __('ui.home.buyer_only') }}</span>@endif
                        @else
                            <a class="button" href="{{ route('orders.create', $product) }}">{{ __('ui.home.login_to_order') }}</a>
                        @endauth
                    </div>
                </article>
            @endforeach
        </div>
        <div class="pagination">{{ $products->links() }}</div>
    @endif
@endsection