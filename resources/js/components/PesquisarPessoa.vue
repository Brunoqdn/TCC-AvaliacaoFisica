<template>
  <div class="container">
    <h1>Pesquisar Pessoa</h1>
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input
        v-model="nome"
        type="text"
        id="nome"
        class="form-control"
        placeholder="Digite o nome"
      />
    </div>
    <button @click="pesquisar" class="btn btn-primary">Pesquisar</button>

    <div v-if="resultados.length">
      <h2>Resultados:</h2>
      <ul>
        <li v-for="resultado in resultados" :key="resultado.id">
          <p><strong>Nome:</strong> {{ resultado.nome }}</p>
          <p><strong>Idade:</strong> {{ resultado.idade }} anos</p>
          <p><strong>Peso:</strong> {{ resultado.peso }} kg</p>
          <p><strong>Altura:</strong> {{ resultado.altura }} cm</p>
          <p><strong>Flexibilidade:</strong> {{ resultado.flexibilidade }} metros</p>
          <p><strong>Abdominais:</strong> {{ resultado.abdominais }}</p>
          <p><strong>Corrida 6 Minutos:</strong> {{ resultado.corrida6min }} metros</p>
          <p><strong>Medicine Ball:</strong> {{ resultado.medicineBall }} cm</p>
          <p><strong>Salto Horizontal:</strong> {{ resultado.saltoHorizontal }} cm</p>
          <p><strong>Quadrado:</strong> {{ resultado.quadrado }} segundos</p>
          <p><strong>Corrida 20 Metros:</strong> {{ resultado.corrida20m }} segundos</p>
          <!-- Aqui você pode inserir a lógica para exibir a zona percentual -->
        </li>
      </ul>
    </div>
    <div v-if="erro" class="alert alert-danger">
      {{ erro }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      nome: '',
      resultados: [],
      erro: null,
    };
  },
  methods: {
    pesquisar() {
      this.erro = null;
      axios
        .get('/api/pesquisar', { params: { nome: this.nome } })
        .then((response) => {
          this.resultados = response.data;
        })
        .catch((error) => {
          this.erro = 'Erro ao pesquisar pessoa: ' + error.message;
          console.error('Erro ao pesquisar pessoa:', error);
        });
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f9f9f9;
}

h1 {
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
}

.form-control {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}

.btn {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: #0056b3;
}

.alert {
  margin-top: 20px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
}
</style>
