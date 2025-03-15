@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;font-size: 22px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
            <img src="{{ secure_asset('images/logo300x300.png') }}" class="logo" width="45" height="45" alt="{{ config('app.name') }} logo">
            <br />
            <span class="title">{{ $slot }}</span>
        </a>
    </td>
</tr>
