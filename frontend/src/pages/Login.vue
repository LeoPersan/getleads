<template>
  <q-page class="q-pa-md flex column justify-center">
    <h2 class="text-center">Login</h2>
    <div class="row justify-center">
      <q-form class="col-4 q-gutter-md">

        <q-input
          filled
          v-model="email"
          label="E-mail"
          required
          :rules="[rulesEmail]"
        />

        <q-input
          v-model="password"
          filled
          :type="isPwd ? 'password' : 'text'"
          label="Senha"
        >
          <template v-slot:append>
            <q-icon
              :name="isPwd ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="isPwd = !isPwd"
            />
          </template>
        </q-input>

        <div>
          <q-btn
            label="Login"
            color="primary"
            @click="login"
          />
          <q-btn
            label="Registrar"
            color="deep-purple"
            class="float-right"
            @click="register"
          />
        </div>
      </q-form>
    </div>
  </q-page>
</template>

<script>
export default {
  name: 'PageIndex',
  data() {
    return {
      password: '',
      email: '',
      isPwd: true,
      rulesEmail: (val) => (!!val.match(/[^@]+@([^@.]+\.)+[^@.]+/)) || 'Digite um e-mail válido!',
    };
  },

  methods: {
    login() {
      const {
        password, email,
      } = this;
      if (this.rulesEmail(email) !== true) return;
      this.$axios.post('/login', {
        password, email,
      }).then((result) => {
        this.$axios.defaults.headers.common.Authorization = `Bearer ${result.data.access_token}`;
        this.$router.push('/');
      }).catch(() => {
        this.$q.notify({
          type: 'negative',
          message: 'Login ou senha inválidos!',
        });
      });
    },

    register() {
      const {
        password, email,
      } = this;
      if (this.rulesEmail(email) !== true) return;
      this.$axios.post('/users', {
        password, email, password_confirmation: password,
      }).then(() => {
        this.login();
      }).catch(() => {
        this.$q.notify({
          type: 'negative',
          message: 'Não foi possível registrar!',
        });
      });
    },
  },
};
</script>
<style>
.logo-full {
  max-width: 400px;
}
</style>
