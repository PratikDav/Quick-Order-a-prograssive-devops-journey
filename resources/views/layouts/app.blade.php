<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'QuickOrder') | QuickOrder</title>
    <meta name="language" content="{{ app()->getLocale() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{font-family:'Hind Siliguri',sans-serif;color:#24312d;background:#f5f7f4;font-synthesis:none;text-rendering:optimizeLegibility;--green:#176b4b;--dark:#154a37;--line:#dfe7e1;--muted:#718078}*{box-sizing:border-box}body{margin:0}a{color:inherit;text-decoration:none}button,input,textarea,select{font:inherit}.topbar{background:#fff;border-bottom:1px solid var(--line)}.nav{max-width:1100px;min-height:68px;margin:auto;padding:0 22px;display:flex;align-items:center;justify-content:space-between;gap:18px}.brand{font-size:23px;font-weight:700;color:var(--dark)}.nav-links{display:flex;align-items:center;gap:18px;color:#52615a}.nav-links form{margin:0}.nav-links a:hover,.nav-links a[aria-current="page"]{color:var(--green)}.nav-links a[aria-current="page"]{font-weight:700}.container{width:min(1100px,calc(100% - 40px));margin:0 auto}.page{padding:34px 0 58px}.intro{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:24px}.intro h1{font-size:30px;line-height:1.2;margin:0 0 6px;color:#1c352a}.intro p{margin:0;color:var(--muted)}.section-title{font-size:20px;margin:0 0 14px;color:#1c352a}.product-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.product{background:#fff;border:1px solid var(--line);border-radius:7px;padding:18px;display:flex;flex-direction:column;min-height:205px}.product h2{font-size:19px;margin:0 0 5px}.product p{margin:4px 0;color:#607068;line-height:1.55}.product .seller{font-size:13px;color:var(--muted);margin-top:auto;padding-top:14px}.price-row{display:flex;align-items:center;justify-content:space-between;margin-top:10px}.price{font-size:20px;font-weight:700;color:var(--green)}.stock{font-size:13px;color:var(--muted)}.button{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:5px;background:var(--green);color:#fff;padding:9px 15px;font-weight:600;cursor:pointer}.button:hover{background:var(--dark)}.button.secondary{background:#edf4ef;color:var(--dark)}.button.small{padding:7px 12px}.form-card,.panel{background:#fff;border:1px solid var(--line);border-radius:7px;padding:22px}.form-wrap{max-width:500px;margin:0 auto}.form-wrap h1{margin:0 0 18px;font-size:25px}.field{margin-bottom:15px}.field label{display:block;font-weight:600;margin-bottom:5px}.field input,.field textarea,.field select{display:block;width:100%;border:1px solid #cbd7ce;border-radius:5px;padding:10px 12px;background:#fff;color:#24312d}.field textarea{min-height:90px;resize:vertical}.field input:focus,.field textarea:focus,.field select:focus{outline:2px solid #8dbda4;border-color:var(--green)}.field-error{font-size:13px;color:#a83232;margin-top:4px}.notice{padding:11px 14px;border-radius:5px;margin-bottom:18px;background:#e8f4ec;color:#205a3f}.notice.error{background:#fff0ed;color:#a83232}.split{display:grid;grid-template-columns: minmax(260px, .8fr) minmax(0,1.5fr);gap:22px;align-items:start}.panel h2{font-size:19px;margin:0 0 15px}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:540px}th,td{text-align:left;padding:11px 12px;border-bottom:1px solid var(--line);vertical-align:top}th{font-size:14px;color:#58675f;background:#f7f9f7}td{font-size:15px}.empty{background:#fff;border:1px dashed #cbd7ce;border-radius:7px;padding:28px;text-align:center;color:var(--muted)}.pagination{margin-top:20px}.pagination nav{display:flex;justify-content:space-between}.pagination svg{width:16px}.muted{color:var(--muted)}.auth-foot{margin-top:14px;color:var(--muted);text-align:center}.auth-foot a{color:var(--green);font-weight:600}.inline{display:inline}.footer{border-top:1px solid var(--line);color:var(--muted);padding:18px 0;font-size:14px}@media(max-width:800px){.product-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.split{grid-template-columns:1fr}}@media(max-width:560px){.nav{padding:0 16px;align-items:flex-start;padding-top:12px;padding-bottom:12px}.nav-links{gap:10px;flex-wrap:wrap;justify-content:flex-end;font-size:14px}.brand{font-size:21px}.container{width:calc(100% - 28px)}.page{padding-top:25px}.intro{align-items:flex-start;flex-direction:column}.intro h1{font-size:26px}.product-grid{grid-template-columns:1fr}.form-card,.panel{padding:17px}}
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="nav">
            <a class="brand" href="{{ route('home') }}">QuickOrder</a>
            <div class="nav-links">
                <a href="{{ route('home') }}">{{ __('ui.nav.products') }}</a>
                <a lang="bn" href="{{ route('language.switch', 'bn') }}" @if (app()->getLocale() === 'bn') aria-current="page" @endif>বাংলা</a>
                <a lang="en" href="{{ route('language.switch', 'en') }}" @if (app()->getLocale() === 'en') aria-current="page" @endif>English</a>
                @auth
                    @if (auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}">{{ __('ui.nav.seller_panel') }}</a>
                    @else
                        <a href="{{ route('buyer.orders') }}">{{ __('ui.nav.my_orders') }}</a>
                    @endif
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="button secondary small" type="submit">{{ __('ui.nav.logout') }}</button></form>
                @else
                    <a href="{{ route('login') }}">{{ __('ui.nav.login') }}</a>
                    <a class="button small" href="{{ route('register') }}">{{ __('ui.nav.create_account') }}</a>
                @endauth
            </div>
        </nav>
    </header>
    <main class="container page">
        @if (session('success'))<div class="notice">{{ session('success') }}</div>@endif
        @if (session('error'))<div class="notice error">{{ session('error') }}</div>@endif
        @yield('content')
    </main>
    <footer class="footer"><div class="container">QuickOrder · {{ __('ui.footer') }}</div></footer>
</body>
</html>