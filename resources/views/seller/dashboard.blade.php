@extends('layouts.app')

@section('title', __('ui.seller.title'))

@section('content')
    <div class="intro"><div><h1>{{ __('ui.seller.title') }}</h1><p>{{ __('ui.seller.subtitle') }}</p></div></div>
    <div class="split">
        <section class="panel">
            <h2>{{ __('ui.seller.add_product') }}</h2>
            <form method="POST" action="{{ route('seller.products.store') }}">@csrf
                <div class="field"><label for="name">{{ __('ui.seller.product_name') }}</label><input id="name" name="name" value="{{ old('name') }}" required>@error('name')<div class="field-error">{{ $message }}</div>@enderror</div>
                <div class="field"><label for="description">{{ __('ui.seller.description') }}</label><textarea id="description" name="description">{{ old('description') }}</textarea>@error('description')<div class="field-error">{{ $message }}</div>@enderror</div>
                <div class="field"><label for="price">{{ __('ui.seller.price') }}</label><input id="price" name="price" type="number" min="0.01" step="0.01" value="{{ old('price') }}" required>@error('price')<div class="field-error">{{ $message }}</div>@enderror</div>
                <div class="field"><label for="stock">{{ __('ui.seller.stock') }}</label><input id="stock" name="stock" type="number" min="0" value="{{ old('stock', 1) }}" required>@error('stock')<div class="field-error">{{ $message }}</div>@enderror</div>
                <button class="button" type="submit">{{ __('ui.seller.save_product') }}</button>
            </form>
        </section>
        <section class="panel">
            <h2>{{ __('ui.seller.my_products', ['count' => $products->count()]) }}</h2>
            @if ($products->isEmpty())<div class="empty">{{ __('ui.seller.empty_products') }}</div>
            @else<div class="table-wrap"><table><thead><tr><th>{{ __('ui.seller.product') }}</th><th>{{ __('ui.seller.price') }}</th><th>{{ __('ui.seller.stock') }}</th></tr></thead><tbody>
                @foreach ($products as $product)<tr><td>{{ $product->name }}</td><td>৳{{ number_format($product->price, 2) }}</td><td>{{ $product->stock }}</td></tr>@endforeach
            </tbody></table></div>@endif
        </section>
    </div>
    <section class="panel" style="margin-top:22px">
        <h2>{{ __('ui.seller.orders', ['count' => $orders->count()]) }}</h2>
        @if ($orders->isEmpty())<div class="empty">{{ __('ui.seller.empty_orders') }}</div>
        @else<div class="table-wrap"><table><thead><tr><th>{{ __('ui.seller.order') }}</th><th>{{ __('ui.seller.product') }}</th><th>{{ __('ui.seller.buyer') }}</th><th>{{ __('ui.seller.quantity') }}</th><th>{{ __('ui.seller.total') }}</th><th>{{ __('ui.seller.date') }}</th></tr></thead><tbody>
            @foreach ($orders as $order)<tr><td>#{{ $order->id }}</td><td>{{ $order->product->name }}</td><td>{{ $order->buyer->name }}</td><td>{{ $order->quantity }}</td><td>৳{{ number_format($order->total, 2) }}</td><td>{{ $order->created_at->format('d/m/Y') }}</td></tr>@endforeach
        </tbody></table></div>@endif
    </section>
@endsection