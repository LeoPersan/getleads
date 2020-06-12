<template>
  <q-page>
    <div class="row">
      <div class="col">
        <q-item class="text-h3">Portfólios</q-item>
      </div>
    </div>
    <q-list class="row column">
      <q-item class="justify-end">
        <router-link to="/portifolios/new">
          <q-btn
            color="primary"
            label="Novo Portifólio"
          />
        </router-link>
      </q-item>
      <q-item
        v-for="portifolio in portifolios"
        :key="portifolio.id"
        clickable
        tag="a"
        :to="`/portifolios/${portifolio.id}`"
        class="shadow-1"
      >
        <q-item class="text-h5">{{portifolio.name}}</q-item>
      </q-item>
    </q-list>
  </q-page>
</template>

<script>
export default {
  name: 'Portfolio',
  data() {
    return {
      portifolios: [
        {
          id: 1,
          name: 'Teste',
        },
        {
          id: 2,
          name: 'Teste',
        },
      ],
    };
  },
};
</script>
