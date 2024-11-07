@props([
    'type' => 'button',
    'color' => 'blue',
    'rounded' => 'md',
    'block' => false,
    'disabled' => false,
    'href' => null,
    'onclick' => null,
])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' =>
            'flex items-center justify-center px-4 h-10 text-sm font-medium text-white bg-' .
            $color .
            '-700 rounded-lg border border-' .
            $color .
            '-700 hover:bg-' .
            $color .
            '-800 focus:ring-4 focus:outline-none focus:ring-' .
            $color .
            '-300 dark:bg-' .
            $color .
            '-600 dark:hover:bg-' .
            $color .
            '-700 dark:focus:ring-' .
            $color .
            '-800' .
            ($block ? ' w-full' : '') .
            ' ' .
            ($rounded == 'full' ? 'rounded-full' : 'rounded-lg'),
        'disabled' => $disabled,
        'href' => $href,
        'onclick' => $onclick,
    ]) }}>
    {{ $slot }}
</button>
