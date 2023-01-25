<script setup>
    defineProps(['modelValue', 'phonePrefix']);
    defineEmits(['update:modelValue']);
</script>

<template>
    <v-text-field filled
                  v-mask="'### ### ###'"
                  :value="modelValue"
                  @input="$emit('update:modelValue', $event.target.value)"
                  type="tel"
                  ref="phoneInput">
        <template v-slot:prepend>
            {{phonePrefix}}
        </template>
    </v-text-field>
</template>
