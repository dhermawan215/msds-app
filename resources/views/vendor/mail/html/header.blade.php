@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://digsys.zekindo.co.id/zekindo-apps/public/img/logo-zekindo-comp.png" class="logo"
                    alt="Laravel Logo" width="100%" height="100px">
            @else
                {{-- {{ $slot }} --}}
                <img src="https://digsys.zekindo.co.id/zekindo-apps/public/img/logo-zekindo-comp.png" class="logo"
                    alt="Laravel Logo" width="100%" height="100px">
            @endif
        </a>
    </td>
</tr>
