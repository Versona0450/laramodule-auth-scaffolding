<script setup>
import { Link } from "@inertiajs/vue3";
import { defineComponent, ref } from "vue";

defineProps({
    logo: String,
    user: Object,
});
</script>

<template>
    <head>
        <title>Auth</title>
    </head>

    <div class="min-h-screen flex items-center justify-center">
        WELCOME {{ user.name }}
    </div>
</template>
