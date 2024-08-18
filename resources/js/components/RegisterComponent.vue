<template>
  <div class="register-container">
    <h1>Registrar</h1>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Nome</label>
        <input v-model="name" type="text" id="name" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" required>
      </div>

      <div class="form-group">
        <label for="password">Senha</label>
        <input v-model="password" type="password" id="password" required>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirme a Senha</label>
        <input v-model="password_confirmation" type="password" id="password_confirmation" required>
      </div>

      <div class="form-group">
        <button type="submit" class="btn">Registrar</button>
      </div>

      <div class="form-group">
        <button @click="goBack" type="button" class="btn btn-secondary">Voltar</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }
  },
  methods: {
    async register() {
      try {
        await axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        window.location.href = '/medidas'; // Redireciona após o registro bem-sucedido
      } catch (error) {
        console.error('Erro ao tentar registrar:', error);
      }
    },
    goBack() {
      window.location.href = '/login'; // Redireciona para a tela de login
    }
  }
}
</script>

<style scoped>
.register-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #f0f8f8;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #468c78;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-size: 14px;
  color: #468c78;
}

input {
  width: 100%;
  padding: 8px;
  border: 1px solid #dcdcdc;
  border-radius: 5px;
}

.btn {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  background-color: #468c78;
  color: white;
  cursor: pointer;
  text-align: center;
}

.btn:hover {
  background-color: #356f5a;
}

.btn-secondary {
  background-color: #7ea89b;
  margin-top: 10px;
}

.btn-secondary:hover {
  background-color: #5c8c79;
}
</style>
