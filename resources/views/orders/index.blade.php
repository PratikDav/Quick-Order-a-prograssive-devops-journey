@extends('layouts.app')

@section('title', __('ui.orders.title'))

@section('content')
    <div class="intro"><div><h1>{{ __('ui.orders.title') }}</h1><p>{{ __('ui.orders.subtitle') }}</p></div><a class="button secondary" href="{{ route('home') }}">{{ __('ui.orders.view_products') }}</a></div>
    @if ($orders->isEmpty())<div class="empty">{{ __('ui.orders.empty') }}</div>
    @else<div class="panel table-wrap"><table><thead><tr><th>{{ __('ui.seller.order') }}</th><th>{{ __('ui.seller.product') }}</th><th>{{ __('ui.orders.seller') }}</th><th>{{ __('ui.seller.quantity') }}</th><th>{{ __('ui.seller.total') }}</th><th>{{ __('ui.orders.status') }}</th></tr></thead><tbody>
        @foreach ($orders as $order)<tr><td>#{{ $order->id }}</td><td>{{ $order->product->name }}</td><td>{{ $order->product->seller->name }}</td><td>{{ $order->quantity }}</td><td>৳{{ number_format($order->total, 2) }}</td><td>{{ __('ui.status.' . ($order->status === 'নতুন' ? 'new' : $order->status)) }}</td></tr>@endforeach
    </tbody></table></div>@endif
@endsection