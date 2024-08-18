<template>
  <div>
    <form @submit.prevent="submitForm">
      <div v-for="(value, key) in formData" :key="key" class="form-group">
        <label :for="key">{{ labels[key] }}</label>
        <input 
          v-if="key !== 'sexo'" 
          :type="inputType(key)" 
          class="form-control" 
          v-model="formData[key]" 
          :id="key"
        >
        <select v-if="key === 'sexo'" class="form-control" v-model="formData[key]" id="sexo">
          <option value="M">Masculino</option>
          <option value="F">Feminino</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
      <button type="button" @click="goToPesquisa" class="btn btn-secondary">Ir para Pesquisa</button>
      <logout-button></logout-button>
    </form>

    <div v-if="successMessage" class="alert alert-success mt-3">
      {{ successMessage }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        nome: '',
        idade: '',
        sexo: 'M',
        peso: '',
        altura: '',
        flexibilidade: '',
        abdominais: '',
        corrida6min: '', // Nome ajustado para o backend
        medicineBall: '',
        saltoHorizontal: '',
        quadrado: '',
        corrida20m: '' // Nome ajustado para o backend
      },
      successMessage: '',
      labels: {
        nome: 'Nome:',
        idade: 'Idade:',
        sexo: 'Sexo:',
        peso: 'Peso (kg):',
        altura: 'Altura (cm):',
        flexibilidade: 'Flexibilidade (metros):',
        abdominais: 'Abdominais:',
        corrida6min: 'Corrida 6 minutos (metros):', // Nome ajustado para o backend
        medicineBall: 'Medicine Ball (cm):',
        saltoHorizontal: 'Salto Horizontal (cm):',
        quadrado: 'Quadrado (segundos e centésimos):',
        corrida20m: 'Corrida 20 metros (segundos e centésimos):' // Nome ajustado para o backend
      }
    };
  },
  methods: {
    async submitForm() {
      try {
        await axios.post('/medidas', this.formData);
        this.successMessage = 'Medida inserida com sucesso!';
        this.clearForm();
      } catch (error) {
        console.error('Erro ao enviar os dados:', error);
      }
    },
    clearForm() {
      this.formData = {
        nome: '',
        idade: '',
        sexo: 'M',
        peso: '',
        altura: '',
        flexibilidade: '',
        abdominais: '',
        corrida6min: '', // Nome ajustado para o backend
        medicineBall: '',
        saltoHorizontal: '',
        quadrado: '',
        corrida20m: ''  // Nome ajustado para o backend
      };
    },
    goToPesquisa() {
      window.location.href = '/pesquisar';
    },
    inputType(key) {
      return ['idade', 'abdominais', 'peso', 'altura', 'flexibilidade', 'corrida6min', 'medicineBall', 'saltoHorizontal', 'quadrado', 'corrida20m'].includes(key) ? 'number' : 'text';

    }
  }
};
</script>

<style scoped>
.form-group {
  margin-bottom: 1rem;
}
</style>
