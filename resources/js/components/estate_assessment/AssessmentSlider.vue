<template>
    <div>
      <h1>{{ title }}</h1>
      <p>{{ description }}</p>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        title: 'Hallo, Welt!',
        description: 'Willkommen zu meiner Vue.js-Komponente!',
      };
    },
  };
  </script>
