Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'pending-opportunity-attribute',
      path: '/pending-opportunity-attribute',
      component: require('./components/Tool'),
    },
  ])
})
