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
          {{ resultado.nome }} - {{ resultado.idade }} anos<br>
          Flexibilidade: {{ resultado.flexibilidade }}<br>
          Abdominais: {{ resultado.abdominais }}<br>
          Corrida 6 minutos: {{ resultado.corrida6min }}<br>
          Medicine Ball: {{ resultado.medicineBall }}<br>
          Salto Horizontal: {{ resultado.saltoHorizontal }}<br>
          Quadrado: {{ resultado.quadrado }}<br>
          Corrida 20 metros: {{ resultado.corrida20m }}<br><br>
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
</style>
