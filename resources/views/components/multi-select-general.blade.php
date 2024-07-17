@props(['multiple' => true, 'options' => [], 'key' => null, 'placeholder' => 'Select an option','searchfields'=>['label','value']])

<div x-data="{
    multiple: @js($multiple),
    value: @entangle($attributes->wire('model')),
    options: @js($options),
    placeholder: @js($placeholder),
    searchfields:@js($searchfields),
    init() {
        this.$nextTick(() => {
            let choices = new Choices(this.$refs.select, {
                noChoicesText: @js($noChoicesText ?? 'Keine Optionen vorhanden'),
                removeItemButton: true,
                duplicateItemsAllowed:false,
                searchFields:this.searchfields??['label','value'],
                searchResultLimit:100,
            });

            let refreshChoices = () => {
                let selection = this.multiple ? this.value ?? [] : [this.value]

                choices.clearStore()
                choices.setChoices(this.options.map(({ value, label }) => ({
                    value,
                    label,
                    selected: selection.includes(value),
                })))
            }

            refreshChoices()

            this.$refs.select.addEventListener('change', () => {
                this.value = choices.getValue(true)
            })

            this.$watch('value', () => refreshChoices())
            this.$watch('options', () => refreshChoices())
        })
    },
    reset(newOptions) {
        this.options = newOptions.options
    }
}" {{ $attributes }} wire:ignore @newoptions{{ $key }}.window="reset(event.detail)"
     class="choices-outer border-none w-full bg-transparent">

    <select x-ref="select" :multiple="multiple" :placeholder="placeholder" class="w-full">
        <option disabled selected value="">{{ $placeholder }}</option>
        <option x-bind:value="null"></option>
    </select>
    <input type="hidden" name="{{ $attributes['name'] }}" x-bind:value="value" />
</div>
