<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean, Array],
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    class: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
    autofocus: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (props.autofocus) {
        input.value.focus();
    }
});

const classes = computed(() => {
    return [
        'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
        props.class,
    ].join(' ');
});

const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <select
        ref="input"
        :value="modelValue"
        @input="updateValue"
        :class="classes"
        :disabled="disabled"
        :required="required"
        :placeholder="placeholder"
    >
        <slot></slot>
    </select>
</template> 