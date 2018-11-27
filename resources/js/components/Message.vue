<template>
    <div class="border-b border-primary-10% cursor-pointer"
         @click="select(message)"
    >
        <div class="p-4 border-l-2 border-transparent hover:border-primary">
            <p class="flex justify-between">
                <span class="">{{ message.recipient }}</span>
                <span class="text-80 text-xs">{{ message.sent_at }}</span>
            </p>

            <p class="font-bold">{{ message.subject }}</p>

            <div class="text-right">
                <button
                    title="Delete"
                    type="button"
                    class="appearance-none cursor-pointer text-70 hover:text-primary mr-3"
                    @click.prevent="remove"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" aria-labelledby="delete" role="presentation" class="fill-current">
                        <path fill-rule="nonzero" d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: null,
    },

    methods: {
        select() {
            Nova.$emit('mailman:select:message', this.message);
        },

        remove() {
            Nova.$emit('mailman:delete:message', this.message);
        },
    },
};
</script>
