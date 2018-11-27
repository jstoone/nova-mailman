<template>
    <card class="w-2/3" style="height: 650px;">
        <iframe v-if="message" :src="message.link" class="w-full h-full">
        </iframe>
        <heading v-else class="mt-6 text-center">Select an email</heading>
    </card>
</template>

<script>
export default {
    props: {
        message: null,
    },

    methods: {},
};
</script>
