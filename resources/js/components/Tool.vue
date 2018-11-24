<template>
    <div>
        <div class="flex justify-between ml-auto">
            <heading class="mb-6">Mailman</heading>
            <button
                dusk="cancel-action-button"
                type="button"
                @click.prevent="getMessages"
                class="btn btn-default btn-primary text-center"
            >
                {{__('Refresh')}}
            </button>
        </div>

        <div class="flex">
            <card class="w-1/3 mr-2">
                <div class="border-b border-primary-10% cursor-pointer" role="alert" v-for="message in messages" :key="message.timestamp">
                    <div class="p-4 border-l-2 border-transparent hover:border-primary" @click="setCurrentMessage(message)">
                        <p class="flex justify-between">
                            <span class="font-bold">{{ message.subject }}</span>
                            <span class="text-80 text-sm">{{ formatTimestamp(message.sent_at) }}</span>
                        </p>
                        <p>{{ message.recipient }}</p>
                    </div>
                </div>
            </card>
            <card class="w-2/3" style="height: 650px;">
                <iframe v-if="currentMessage" :src="currentMessage.link" class="w-full h-full">
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
                content: 'http://nova-demo.test',
                recipient: 'john@example.com',
                sent_at: 1539733755,
                subject: 'Foo subject',
            },
        ],
    }),

    created() {
        this.getMessages();

        this.loaded = true;
    },

    methods: {
        getMessages() {
            Nova.request()
                .get('/nova-vendor/jstoone/nova-mailman/mail')
                .then(response => {
                    this.messages = response.data;
                });
        },

        setCurrentMessage(message) {
            this.currentMessage = message;
        },

        formatTimestamp(timestamp) {
            return window.moment.unix(timestamp).calendar();
        },
    },
};
</script>

<style>
/* Scoped Styles */
</style>
