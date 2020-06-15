<template>
  <q-page>
    <div class="row">
      <div class="col">
        <q-item class="text-h3">Portfólio: {{portfolio.name}}</q-item>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <q-item class="text-h5">
          {{serverPagination.rowsNumber}} itens encontrados /
          Percentual mínimo:
          <q-input
            v-model.number="match"
            type="number"
            class="number"
          />
        </q-item>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <q-item
          clickable
          @click="download"
        > Download em CSV</q-item>
      </div>
    </div>
    <q-list class="q-pa-md">
      <q-table
        title="Leads"
        dense
        :data="leads.data"
        :columns="leads.columns"
        row-key="name"
        :pagination.sync="serverPagination"
        @request="request"
        :loading="loading"
        :rows-per-page-options="[serverPagination.rowsPerPage]"
      />
    </q-list>
  </q-page>
</template>

<script>
import { exportFile } from 'quasar';

export default {
  name: 'Portfolio',
  data() {
    return {
      match: 50,
      portfolio: {},
      loading: false,
      leads: {
        data: [],
      },
      serverPagination: {
        page: 1,
        rowsPerPage: 15,
        rowsNumber: 0,
      },

    };
  },
  watch: {
    match() {
      this.request({
        pagination: this.serverPagination,
        filter: this.filter,
      });
    },
  },
  mounted() {
    this.request({
      pagination: this.serverPagination,
      filter: this.filter,
    });
  },
  methods: {
    request({ pagination }) {
      this.loading = true;
      this.$axios.get(`/portfolios/${this.$route.params.id}?page=${pagination.page}&match=${this.match}`)
        .then((result) => {
          this.portfolio = result.data.portfolio;
          this.leads.data = result.data.leads.data;
          pagination.rowsNumber = result.data.leads.total;
          pagination.page = result.data.leads.current_page;
          this.serverPagination = pagination;
          this.loading = false;
        });
    },
    download() {
      this.$axios.get(`/portfolios/${this.$route.params.id}?download&match=${this.match}`)
        .then((result) => {
          exportFile(
            'leads.csv',
            result.data,
            'text/csv',
          );
        });
    },
  },
};
</script>
<style lang="scss">
.q-field__control {
  margin: 0 10px;
  width: 50px;
  height: 20px;
}
</style>
