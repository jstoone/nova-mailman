<template>
    <card class="w-1/3 mr-2">
        <message v-for="message in messages" :key="message.id"
                 :message="message"
                 @click="$emit('update:currentMessage', message)"
        />
    </card>
</template>

<script>
import Message from './Message';

export default {
    components: {
        Message,
    },

    props: {
        messages: [],
    },

    methods: {
        setCurrentMessage(message) {
            this.currentMessage = message;
        },

        formatTimestamp(timestamp) {
            return window.moment.unix(timestamp).calendar();
        },
    },
};
</script>
