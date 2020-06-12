<template>
  <q-page>
    <div class="row">
      <div class="col">
        <q-item class="text-h3">Novo Portfólio</q-item>
      </div>
    </div>
    <q-list class="row column">
      <div class="q-pa-md">
        <q-form
          @submit="onSubmit"
          @reset="onReset"
          class="q-gutter-md"
        >
          <q-input
            filled
            v-model="name"
            label="Identificador"
            hint="Um nome para você identificar esse conjunto de clientes"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Este campo é obrigatório']"
          />

          <q-file
            label="Portifolio (somente csv)"
            :filter="checkFileType"
            @rejected="onRejected"
            filled
            v-model="file"
            accept=".csv"
            required
          />

          <q-toggle
            v-model="accept"
            label="Esses clientes podem ser enviados para outros usuários?"
          />

          <div>
            <q-btn
              label="Enviar"
              type="submit"
              color="primary"
            />
            <q-btn
              label="Cancelar"
              type="reset"
              color="primary"
              flat
              class="q-ml-sm"
            />
          </div>
        </q-form>
      </div>
    </q-list>
  </q-page>
</template>

<script>
export default {
  name: 'Portfolio',
  data() {
    return {
      name: null,
      age: null,
      accept: false,
      file: null,
    };
  },

  methods: {
    onSubmit() {
      const {
        name, age, accept, file,
      } = this;
      this.$axios.post('/api/portifolios', {
        name,
        age,
        accept,
        file,
      }).then(() => {
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Avisaremos por e-mail assim que os dados forem computados',
        });
      }).catch(() => {
        this.$q.notify({
          type: 'negative',
          message: 'Houve um erro no envio dos dados. Por favor tente novamente mais tarde!',
        });
      });
    },

    onReset() {
      this.name = null;
      this.age = null;
      this.accept = false;
      this.file = null;
    },

    checkFileType(files) {
      return files.filter((file) => file.type === 'application/vnd.ms-excel');
    },

    onRejected(rejectedEntries) {
      window.console.log(rejectedEntries);
      this.$q.notify({
        type: 'negative',
        message: `O arquivo ${rejectedEntries[0].file.name} não foi reconhecido como CSV!`,
      });
    },
  },
};
</script>
<style lang="scss">
.q-file {
  width: unset;
}
</style>
