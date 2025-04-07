<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'İçerik yazın...'
    },
    editorClass: {
        type: String,
        default: 'textarea textarea-bordered min-h-[200px] focus:textarea-primary w-full'
    }
});

const emit = defineEmits(['update:modelValue']);

const editorContent = ref(props.modelValue);
const editorRef = ref(null);

// Props değiştiğinde içeriği güncelle
watch(() => props.modelValue, (newVal) => {
    if (newVal !== editorContent.value) {
        editorContent.value = newVal;
    }
});

// İçerik değiştiğinde emit et
watch(editorContent, (newVal) => {
    emit('update:modelValue', newVal);
});

// Temel metin düzenleyicisi olarak kullanılıyor
// İleriki aşamalarda daha gelişmiş bir editör (TinyMCE, CKEditor gibi) eklenebilir
</script>

<template>
    <div class="text-editor">
        <textarea 
            ref="editorRef"
            :value="modelValue" 
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            :class="editorClass"
            rows="8"
        ></textarea>
    </div>
</template> 