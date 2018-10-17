<template>
    <div>
        <heading class="mb-6">Mailman</heading>

        <div class="flex">
            <card class="w-1/3 mr-2">
                <div class="border-b border-primary-10% cursor-pointer" role="alert" v-for="message in messages" :key="message.timestamp">
                    <div class="p-4 border-l-2 border-transparent hover:border-primary" @click="setCurrentMessage(message)">
                        <p class="flex justify-between">
                            <span class="font-bold">{{ message.subject }}</span>
                            <span class="text-80 text-sm">{{ formatTimestamp(message.timestamp) }}</span>
                        </p>
                        <p>{{ message.to }}</p>
                    </div>
                </div>
            </card>
            <card class="w-2/3" style="height: 650px;">
                <iframe v-if="currentMessage" :src="currentMessage.content" class="w-full h-full">
                </iframe>
                <heading v-else class="mt-6 text-center">Select an email</heading>
            </card>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
            // 
        },

        data: () => ({
            loaded: false,
            currentMessage: null,
            messages: [
                {
                    to: "john@example.com",
                    subject: "Foo subject",
                    timestamp: 1539733755,
                    content: 'http://nova-demo.test'
                },
                {
                    to: "jane@example.com",
                    subject: "Bar subject",
                    timestamp: 1539733200,
                    content: 'http://import.dev-cobiro.test'
                },
                {
                    to: "mailman@example.com",
                    subject: "OMG subject",
                    timestamp: 1529733755,
                    content: 'http://api.dev-cobiro.test'
                },
            ]
        }),

        async created() {
            // await this.getMessages();

            // this.loaded = true;

            // this.startPolling();
        },

        methods: {
            getMessages() {
                //
            },

            setCurrentMessage(message) {
                this.currentMessage = message;
            },

            formatTimestamp(timestamp) {
                return window.moment.unix(timestamp).calendar();
            },

            startPolling() {
                const poller = window.setInterval(() => {
                    //
                }, 1000);

                this.$once('hook:beforeDestroy', () => {
                    window.clearInterval(poller);
                });
            }
        }
    }
</script>

<style>
    /* Scoped Styles */
</style>
