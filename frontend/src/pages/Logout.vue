<template>
  <div></div>
</template>

<script>
export default {
  mounted() {
    this.$axios.defaults.headers.common.Authorization = '';
    this.$router.push('/');
  },
};
</script>
