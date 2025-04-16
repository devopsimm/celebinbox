@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }}>
        {{ $status }}
    </div>
@endif
