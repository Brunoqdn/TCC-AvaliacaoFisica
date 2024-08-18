<template>
  <button @click="logout">Logout</button>
</template>

<script>
import axios from 'axios';

export default {
  methods: {
    async logout() {
      try {
        // Faz a requisição para deslogar o usuário
        await axios.post('/logout');

        // Após o logout, redireciona para a página de login
        window.location.href = '/login';
      } catch (error) {
        console.error('Erro ao tentar deslogar:', error);
      }
    }
  }
}
</script>
