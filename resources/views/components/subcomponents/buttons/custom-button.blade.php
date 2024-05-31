<a href="{{ $hrefTag }}"
    class="inline-flex items-center px-6 lg:px-12 py-3 mx-2 {{ $bold == 'true' ? 'font-bold' : '' }} {{ $textSize }}
    text-center text-white {{ $rounded ? 'rounded-full' : '' }}  lg:px-5 focus:ring-4 focus:outline-none
    {{ $color == 'primary' ? 'bg-primary hover:bg-primary-800' : 'bg-secondary hover:bg-secondary-800' }} "
    target="_blank">
    {{ $text }}

    @if ($hasArrow == 'true')
        <span aria-hidden="true">
            &nbsp;→
        </span>
    @endif
</a>
