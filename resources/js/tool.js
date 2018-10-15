Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'nova-mailman',
            path: '/nova-mailman',
            component: require('./components/Tool'),
        },
    ])
})
