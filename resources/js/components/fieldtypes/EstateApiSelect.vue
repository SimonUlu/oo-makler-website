<template>
    <div>
        <select v-model.lazy="value" @change="updateDebounced">
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
            >
                {{ option.text }}
            </option>
        </select>
    </div>
</template>

<script>
import { Fieldtype } from "@statamic/vue";

export default {
    mixins: [Fieldtype],

    data() {
        return {
            options: [
                // Here, you can add options to display in the select field
                { value: "option1", text: "Option 1" },
                { value: "option2", text: "Option 2" },
            ],
        };
    },
};
</script>
