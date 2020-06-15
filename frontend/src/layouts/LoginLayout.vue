<template>
  <q-layout view="hHh Lpr fff">
    <q-header elevated>
      <q-toolbar>

        <q-toolbar-title>
          Get Leads
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: 'MainLayout',

  data() {
    return {
      essentialLinks: [
        {
          title: 'Home',
          icon: 'dashboard',
          to: '/',
        },
        {
          title: 'Portifólios',
          icon: 'contacts',
          to: '/portifolios',
        },
        {
          title: 'Logout',
          icon: 'power_settings_new',
          to: '/logout',
        },
      ],
    };
  },
};
</script>
