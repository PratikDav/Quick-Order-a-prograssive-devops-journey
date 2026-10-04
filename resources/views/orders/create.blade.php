@extends('layouts.app')

@section('title', __('ui.orders.confirm_title'))

@section('content')
    <div class="form-wrap"><div class="form-card">
        <h1>{{ __('ui.orders.confirm_title') }}</h1>
        <p><strong>{{ $product->name }}</strong><br><span class="muted">{{ __('ui.orders.price', ['amount' => number_format($product->price, 2)]) }} · {{ __('ui.orders.stock', ['count' => $product->stock]) }}</span></p>
        @if ($errors->any())<div class="notice error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('orders.store', $product) }}">@csrf
            <div class="field"><label for="quantity">{{ __('ui.orders.quantity') }}</label><input id="quantity" name="quantity" type="number" min="1" max="{{ $product->stock }}" value="{{ old('quantity', 1) }}" required></div>
            <button class="button" type="submit">{{ __('ui.orders.confirm') }}</button>
            <a class="button secondary" href="{{ route('home') }}">{{ __('ui.orders.back') }}</a>
        </form>
    </div></div>
@endsection