<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    type: {
        type: String,
        default: 'text'
    },
    id: String,
    name: String,
    placeholder: String,
    required: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    autofocus: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="input input-bordered w-full focus:input-primary"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="type"
        :id="id"
        :name="name"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :autofocus="autofocus"
        ref="input"
    />
</template>
