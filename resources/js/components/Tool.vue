<template>
    <div>
        <div class="flex justify-between ml-auto">
            <heading class="mb-6">Mailman</heading>
            <button
                type="button"
                @click.prevent="getMessages"
                class="btn btn-default btn-primary text-center"
            >
                {{__('Refresh')}}
            </button>
        </div>

        <div class="flex">
            <inbox :messages="messages" />
            <preview :message="currentMessage" />
        </div>
    </div>
</template>

<script>
import Inbox from './Inbox.vue';
import Preview from './Preview.vue';

export default {
    components: {
        Inbox,
        Preview,
    },

    data() {
        return {
            currentMessage: null,
            messages: [],
        };
    },

    created() {
        this.getMessages();

        this.registerListeners();
    },

    methods: {
        registerListeners() {
            Nova.$on('mailman:select:message', this.selectMessage);
            Nova.$on('mailman:delete:message', this.deleteMessage);
        },

        getMessages() {
            Nova.request()
                .get('/nova-vendor/jstoone/nova-mailman/mail')
                .then(response => {
                    this.messages = response.data;
                });
        },

        selectMessage(message) {
            this.currentMessage = message;
        },

        deleteMessage(message) {
            Nova.request()
                .delete('/nova-vendor/jstoone/nova-mailman/mail/' + message.id)
                .then(() => {
                    // Filter away the removed item
                    this.messages = this.messages.filter(item => {
                        return item.id !== message.id;
                    });

                    this.currentMessage = null;
                });
        },
    },
};
</script>
