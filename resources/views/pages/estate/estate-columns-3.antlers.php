<div class="hidden mt-4 space-y-10 lg:grid lg:grid-cols-3 lg:gap-6 lg:mt-6 lg:space-y-0 lg:space-x-2">
    {{ estates sort="geaendert_am" limit="3"}}
    {{partial:pages/estate/estate-columns-item}}
    {{/estates}}
</div>

<div class="hidden mt-4 space-y-10 md:grid lg:hidden md:grid-cols-2 md:gap-6 md:mt-6 md:space-y-0 md:space-x-2">
    {{ estates sort="geaendert_am" limit="2"}}
    {{partial:pages/estate/estate-columns-item}}
    {{/estates}}
</div>

<div class="grid grid-cols-1 mt-4 space-y-10 md:hidden">
    {{ estates sort="geaendert_am" limit="1"}}
    {{partial:pages/estate/estate-columns-item}}
    {{/estates}}
</div>