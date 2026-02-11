@props(['header' => false])

@if ($header)
    <th {{ $attributes->merge(['class' => 'px-6 py-4']) }}>
        {{ $slot }}
    </th>
@else
    <td {{ $attributes->merge(['class' => 'px-6 py-4']) }}>
        {{ $slot }}
    </td>
@endif
