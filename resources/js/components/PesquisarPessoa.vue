<template>
  <div class="container mt-5">
    <h1 class="text-center">Pesquisar Pessoa</h1>
    
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
    
    <div class="d-flex justify-content-center mt-4">
      <button @click="pesquisar" class="btn btn-primary mx-2">Pesquisar</button>
      <button @click="voltarParaMedidas" class="btn btn-secondary mx-2">Voltar para Medidas</button>
    </div>

    <div v-if="resultados.length" class="mt-5">
      <h2 class="text-center">Resultados:</h2>
      <ul class="list-group">
        <li v-for="resultado in resultados" :key="resultado.id" class="list-group-item">
          <p><strong>Nome:</strong> {{ resultado.nome }}</p>
          <p><strong>Idade:</strong> {{ resultado.idade }} anos</p>
          <p><strong>Sexo:</strong> {{ resultado.sexo }}</p>
          <p><strong>Peso:</strong> {{ resultado.peso }} kg</p>
          <p><strong>Altura:</strong> {{ resultado.altura }} cm</p>
          <p><strong>IMC:</strong> {{ resultado.imc }}</p>
          <p><strong>Flexibilidade:</strong> 
            <span :class="getClass(resultado.flexibilidadeAvaliacao)">
              {{ resultado.flexibilidade }} - {{ resultado.flexibilidadeAvaliacao }}
            </span>
          </p>
          <p><strong>Abdominais:</strong> 
            <span :class="getClass(resultado.abdominaisAvaliacao)">
              {{ resultado.abdominais }} - {{ resultado.abdominaisAvaliacao }}
            </span>
          </p>
          <p><strong>Corrida 6 minutos:</strong> 
            <span :class="getClass(resultado.corrida6minAvaliacao)">
              {{ resultado.corrida6min }} metros - {{ resultado.corrida6minAvaliacao }}
            </span>
          </p>
          <p><strong>Medicine Ball:</strong> 
            <span :class="getClass(resultado.medicineBallAvaliacao)">
              {{ resultado.medicineBall }} cm - {{ resultado.medicineBallAvaliacao }}
            </span>
          </p>
          <p><strong>Salto Horizontal:</strong> 
            <span :class="getClass(resultado.saltoHorizontalAvaliacao)">
              {{ resultado.saltoHorizontal }} cm - {{ resultado.saltoHorizontalAvaliacao }}
            </span>
          </p>
          <p><strong>Quadrado:</strong> 
            <span :class="getClass(resultado.quadradoAvaliacao)">
              {{ resultado.quadrado }} segundos e centésimos - {{ resultado.quadradoAvaliacao }}
            </span>
          </p>
          <p><strong>Corrida 20 metros:</strong> 
            <span :class="getClass(resultado.corrida20mAvaliacao)">
              {{ resultado.corrida20m }} segundos e centésimos - {{ resultado.corrida20mAvaliacao }}
            </span>
          </p><br>
        </li>
      </ul>
    </div>

    <div v-if="erro" class="alert alert-danger mt-3">
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
          // Manipulando os resultados para incluir o cálculo do IMC e avaliação
          this.resultados = response.data.map((pessoa) => {
            // Calcular IMC
            const alturaMetros = pessoa.altura / 100; // Convertendo altura de cm para metros
            pessoa.imc = (pessoa.peso / (alturaMetros * alturaMetros)).toFixed(2);

            // Avaliar os resultados para cada métrica
            pessoa.flexibilidadeAvaliacao = this.avaliarFlexibilidade(pessoa);
            pessoa.abdominaisAvaliacao = this.avaliarAbdominais(pessoa);
            pessoa.corrida6minAvaliacao = this.avaliarCorrida6Min(pessoa);
            pessoa.medicineBallAvaliacao = this.avaliarMedicineBall(pessoa);
            pessoa.saltoHorizontalAvaliacao = this.avaliarSaltoHorizontal(pessoa);
            pessoa.quadradoAvaliacao = this.avaliarQuadrado(pessoa);
            pessoa.corrida20mAvaliacao = this.avaliarCorrida20m(pessoa);

            return pessoa;
          });
        })
        .catch((error) => {
          this.erro = 'Erro ao pesquisar pessoa: ' + error.message;
          console.error('Erro ao pesquisar pessoa:', error);
        });
    },

    voltarParaMedidas() {
    window.location.href = '/medidas';
  },

    getClass(avaliacao) {
      switch (avaliacao) {
        case 'Fraco':
          return 'fraco';
        case 'Razoável':
          return 'razoavel';
        case 'Bom':
          return 'bom';
        case 'Muito Bom':
          return 'muito-bom';
        case 'Excelência':
          return 'excelencia';
        default:
          return '';
      }
    },

    avaliarAbdominais(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const abdominais = pessoa.abdominais;

    if (sexo === 'M') {
      if (idade <= 6) {
        if (abdominais < 18) return 'Fraco';
        if (abdominais < 23) return 'Razoável';
        if (abdominais < 28) return 'Bom';
        if (abdominais < 39) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 7) {
        if (abdominais < 20) return 'Fraco';
        if (abdominais < 26) return 'Razoável';
        if (abdominais < 31) return 'Bom';
        if (abdominais < 43) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 8) {
        if (abdominais < 23) return 'Fraco';
        if (abdominais < 28) return 'Razoável';
        if (abdominais < 34) return 'Bom';
        if (abdominais < 46) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 9) {
        if (abdominais < 25) return 'Fraco';
        if (abdominais < 30) return 'Razoável';
        if (abdominais < 36) return 'Bom';
        if (abdominais < 48) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 10) {
        if (abdominais < 26) return 'Fraco';
        if (abdominais < 32) return 'Razoável';
        if (abdominais < 37) return 'Bom';
        if (abdominais < 49) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 11) {
        if (abdominais < 27) return 'Fraco';
        if (abdominais < 33) return 'Razoável';
        if (abdominais < 39) return 'Bom';
        if (abdominais < 50) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 12) {
        if (abdominais < 29) return 'Fraco';
        if (abdominais < 35) return 'Razoável';
        if (abdominais < 40) return 'Bom';
        if (abdominais < 52) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 13) {
        if (abdominais < 30) return 'Fraco';
        if (abdominais < 36) return 'Razoável';
        if (abdominais < 42) return 'Bom';
        if (abdominais < 54) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 14) {
        if (abdominais < 32) return 'Fraco';
        if (abdominais < 38) return 'Razoável';
        if (abdominais < 44) return 'Bom';
        if (abdominais < 57) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 15) {
        if (abdominais < 34) return 'Fraco';
        if (abdominais < 40) return 'Razoável';
        if (abdominais < 47) return 'Bom';
        if (abdominais < 60) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 16) {
        if (abdominais < 35) return 'Fraco';
        if (abdominais < 42) return 'Razoável';
        if (abdominais < 48) return 'Bom';
        if (abdominais < 62) return 'Muito Bom';
        return 'Excelência';
      } else if (idade >= 17) {
        if (abdominais < 36) return 'Fraco';
        if (abdominais < 43) return 'Razoável';
        if (abdominais < 49) return 'Bom';
        if (abdominais < 63) return 'Muito Bom';
        return 'Excelência';
      }
    } if (sexo === 'F') {
      if (idade <= 6) {
        if (abdominais < 17) return 'Fraco';
        if (abdominais < 22) return 'Razoável';
        if (abdominais < 27) return 'Bom';
        if (abdominais < 37) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 7) {
        if (abdominais < 19) return 'Fraco';
        if (abdominais < 24) return 'Razoável';
        if (abdominais < 30) return 'Bom';
        if (abdominais < 40) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 8) {
        if (abdominais < 20) return 'Fraco';
        if (abdominais < 26) return 'Razoável';
        if (abdominais < 32) return 'Bom';
        if (abdominais < 43) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 9) {
        if (abdominais < 21) return 'Fraco';
        if (abdominais < 27) return 'Razoável';
        if (abdominais < 33) return 'Bom';
        if (abdominais < 45) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 10) {
        if (abdominais < 22) return 'Fraco';
        if (abdominais < 28) return 'Razoável';
        if (abdominais < 34) return 'Bom';
        if (abdominais < 45) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 11) {
        if (abdominais < 23) return 'Fraco';
        if (abdominais < 29) return 'Razoável';
        if (abdominais < 34) return 'Bom';
        if (abdominais < 46) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 12) {
        if (abdominais < 23) return 'Fraco';
        if (abdominais < 29) return 'Razoável';
        if (abdominais < 35) return 'Bom';
        if (abdominais < 46) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 13) {
        if (abdominais < 24) return 'Fraco';
        if (abdominais < 30) return 'Razoável';
        if (abdominais < 36) return 'Bom';
        if (abdominais < 48) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 14) {
        if (abdominais < 24) return 'Fraco';
        if (abdominais < 30) return 'Razoável';
        if (abdominais < 36) return 'Bom';
        if (abdominais < 49) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 15) {
        if (abdominais < 24) return 'Fraco';
        if (abdominais < 30) return 'Razoável';
        if (abdominais < 36) return 'Bom';
        if (abdominais < 49) return 'Muito Bom';
        return 'Excelência';
      } else if (idade === 16) {
        if (abdominais < 23) return 'Fraco';
        if (abdominais < 30) return 'Razoável';
        if (abdominais < 36) return 'Bom';
        if (abdominais < 49) return 'Muito Bom';
        return 'Excelência';
      } else if (idade >= 17) {
        if (abdominais < 23) return 'Fraco';
        if (abdominais < 30) return 'Razoável';
        if (abdominais < 36) return 'Bom';
        if (abdominais < 48) return 'Muito Bom';
        return 'Excelência';
      }
      }
      return 'N/A';
    },

    avaliarCorrida6Min(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const corrida6min = pessoa.corrida6min;

    if (sexo === 'M') {
        if (idade === 6) {
            if (corrida6min < 730) return 'Fraco';
            if (corrida6min < 826) return 'Razoável';
            if (corrida6min < 957) return 'Bom';
            if (corrida6min < 1317) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (corrida6min < 752) return 'Fraco';
            if (corrida6min < 852) return 'Razoável';
            if (corrida6min < 975) return 'Bom';
            if (corrida6min < 1303) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (corrida6min < 774) return 'Fraco';
            if (corrida6min < 874) return 'Razoável';
            if (corrida6min < 995) return 'Bom';
            if (corrida6min < 1301) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (corrida6min < 797) return 'Fraco';
            if (corrida6min < 895) return 'Razoável';
            if (corrida6min < 1018) return 'Bom';
            if (corrida6min < 1310) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (corrida6min < 817) return 'Fraco';
            if (corrida6min < 917) return 'Razoável';
            if (corrida6min < 1040) return 'Bom';
            if (corrida6min < 1323) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (corrida6min < 837) return 'Fraco';
            if (corrida6min < 939) return 'Razoável';
            if (corrida6min < 1062) return 'Bom';
            if (corrida6min < 1339) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (corrida6min < 860) return 'Fraco';
            if (corrida6min < 965) return 'Razoável';
            if (corrida6min < 1090) return 'Bom';
            if (corrida6min < 1367) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (corrida6min < 895) return 'Fraco';
            if (corrida6min < 1005) return 'Razoável';
            if (corrida6min < 1136) return 'Bom';
            if (corrida6min < 1422) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (corrida6min < 939) return 'Fraco';
            if (corrida6min < 1058) return 'Razoável';
            if (corrida6min < 1197) return 'Bom';
            if (corrida6min < 1499) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (corrida6min < 986) return 'Fraco';
            if (corrida6min < 1113) return 'Razoável';
            if (corrida6min < 1262) return 'Bom';
            if (corrida6min < 1585) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (corrida6min < 1015) return 'Fraco';
            if (corrida6min < 1149) return 'Razoável';
            if (corrida6min < 1306) return 'Bom';
            if (corrida6min < 1644) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (corrida6min < 1038) return 'Fraco';
            if (corrida6min < 1177) return 'Razoável';
            if (corrida6min < 1341) return 'Bom';
            if (corrida6min < 1692) return 'Muito Bom';
            return 'Excelência';
        }
    } else if (sexo === 'F') {
        if (idade === 6) {
            if (corrida6min < 672) return 'Fraco';
            if (corrida6min < 768) return 'Razoável';
            if (corrida6min < 901) return 'Bom';
            if (corrida6min < 1277) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (corrida6min < 691) return 'Fraco';
            if (corrida6min < 780) return 'Razoável';
            if (corrida6min < 892) return 'Bom';
            if (corrida6min < 1159) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (corrida6min < 707) return 'Fraco';
            if (corrida6min < 792) return 'Razoável';
            if (corrida6min < 896) return 'Bom';
            if (corrida6min < 1132) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (corrida6min < 720) return 'Fraco';
            if (corrida6min < 806) return 'Razoável';
            if (corrida6min < 911) return 'Bom';
            if (corrida6min < 1149) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (corrida6min < 729) return 'Fraco';
            if (corrida6min < 819) return 'Razoável';
            if (corrida6min < 932) return 'Bom';
            if (corrida6min < 1200) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (corrida6min < 736) return 'Fraco';
            if (corrida6min < 832) return 'Razoável';
            if (corrida6min < 954) return 'Bom';
            if (corrida6min < 1251) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (corrida6min < 743) return 'Fraco';
            if (corrida6min < 836) return 'Razoável';
            if (corrida6min < 948) return 'Bom';
            if (corrida6min < 1192) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (corrida6min < 749) return 'Fraco';
            if (corrida6min < 840) return 'Razoável';
            if (corrida6min < 948) return 'Bom';
            if (corrida6min < 1179) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (corrida6min < 751) return 'Fraco';
            if (corrida6min < 848) return 'Razoável';
            if (corrida6min < 970) return 'Bom';
            if (corrida6min < 1257) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (corrida6min < 748) return 'Fraco';
            if (corrida6min < 859) return 'Razoável';
            if (corrida6min < 1006) return 'Bom';
            if (corrida6min < 1391) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (corrida6min < 746) return 'Fraco';
            if (corrida6min < 866) return 'Razoável';
            if (corrida6min < 1022) return 'Bom';
            if (corrida6min < 1402) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (corrida6min < 744) return 'Fraco';
            if (corrida6min < 871) return 'Razoável';
            if (corrida6min < 1028) return 'Bom';
            if (corrida6min < 1390) return 'Muito Bom';
            return 'Excelência';
          }
      }
      return 'N/A';
    },

avaliarFlexibilidade(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const flexibilidade = pessoa.flexibilidade;

    // Avaliação para masculino
    if (sexo === 'M') {
        if (idade === 6) {
            if (flexibilidade < 34.3) return 'Fraco';
            if (flexibilidade < 41.3) return 'Razoável';
            if (flexibilidade < 50.4) return 'Bom';
            if (flexibilidade < 74.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (flexibilidade < 33.3) return 'Fraco';
            if (flexibilidade < 39.7) return 'Razoável';
            if (flexibilidade < 48.0) return 'Bom';
            if (flexibilidade < 68.5) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (flexibilidade < 32.3) return 'Fraco';
            if (flexibilidade < 38.4) return 'Razoável';
            if (flexibilidade < 46.0) return 'Bom';
            if (flexibilidade < 64.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (flexibilidade < 31.3) return 'Fraco';
            if (flexibilidade < 37.2) return 'Razoável';
            if (flexibilidade < 44.6) return 'Bom';
            if (flexibilidade < 61.5) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (flexibilidade < 30.4) return 'Fraco';
            if (flexibilidade < 36.5) return 'Razoável';
            if (flexibilidade < 43.9) return 'Bom';
            if (flexibilidade < 60.8) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (flexibilidade < 29.8) return 'Fraco';
            if (flexibilidade < 35.7) return 'Razoável';
            if (flexibilidade < 43.0) return 'Bom';
            if (flexibilidade < 59.3) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (flexibilidade < 29.4) return 'Fraco';
            if (flexibilidade < 35.2) return 'Razoável';
            if (flexibilidade < 42.2) return 'Bom';
            if (flexibilidade < 57.9) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (flexibilidade < 29.1) return 'Fraco';
            if (flexibilidade < 35.3) return 'Razoável';
            if (flexibilidade < 42.9) return 'Bom';
            if (flexibilidade < 60.6) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (flexibilidade < 28.7) return 'Fraco';
            if (flexibilidade < 35.7) return 'Razoável';
            if (flexibilidade < 44.8) return 'Bom';
            if (flexibilidade < 67.2) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (flexibilidade < 28.4) return 'Fraco';
            if (flexibilidade < 36.4) return 'Razoável';
            if (flexibilidade < 47.0) return 'Bom';
            if (flexibilidade < 73.8) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (flexibilidade < 28.4) return 'Fraco';
            if (flexibilidade < 36.8) return 'Razoável';
            if (flexibilidade < 48.1) return 'Bom';
            if (flexibilidade < 76.6) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (flexibilidade < 28.7) return 'Fraco';
            if (flexibilidade < 36.9) return 'Razoável';
            if (flexibilidade < 48.0) return 'Bom';
            if (flexibilidade < 76.2) return 'Muito Bom';
            return 'Excelência';
        }
    }

    // Avaliação para feminino
    if (sexo === 'F') {
        if (idade === 6) {
            if (flexibilidade < 37.0) return 'Fraco';
            if (flexibilidade < 43.9) return 'Razoável';
            if (flexibilidade < 52.6) return 'Bom';
            if (flexibilidade < 73.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (flexibilidade < 35.3) return 'Fraco';
            if (flexibilidade < 41.9) return 'Razoável';
            if (flexibilidade < 50.0) return 'Bom';
            if (flexibilidade < 69.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (flexibilidade < 33.3) return 'Fraco';
            if (flexibilidade < 40.1) return 'Razoável';
            if (flexibilidade < 47.9) return 'Bom';
            if (flexibilidade < 65.7) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (flexibilidade < 32.4) return 'Fraco';
            if (flexibilidade < 38.7) return 'Razoável';
            if (flexibilidade < 46.3) return 'Bom';
            if (flexibilidade < 63.6) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (flexibilidade < 31.3) return 'Fraco';
            if (flexibilidade < 37.6) return 'Razoável';
            if (flexibilidade < 45.4) return 'Bom';
            if (flexibilidade < 62.6) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (flexibilidade < 30.6) return 'Fraco';
            if (flexibilidade < 36.8) return 'Razoável';
            if (flexibilidade < 44.3) return 'Bom';
            if (flexibilidade < 61.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (flexibilidade < 30.4) return 'Fraco';
            if (flexibilidade < 36.4) return 'Razoável';
            if (flexibilidade < 43.7) return 'Bom';
            if (flexibilidade < 60.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (flexibilidade < 30.3) return 'Fraco';
            if (flexibilidade < 36.7) return 'Razoável';
            if (flexibilidade < 44.6) return 'Bom';
            if (flexibilidade < 62.9) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (flexibilidade < 30.1) return 'Fraco';
            if (flexibilidade < 37.3) return 'Razoável';
            if (flexibilidade < 46.6) return 'Bom';
            if (flexibilidade < 69.5) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (flexibilidade < 29.6) return 'Fraco';
            if (flexibilidade < 37.9) return 'Razoável';
            if (flexibilidade < 48.9) return 'Bom';
            if (flexibilidade < 77.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (flexibilidade < 29.2) return 'Fraco';
            if (flexibilidade < 37.9) return 'Razoável';
            if (flexibilidade < 49.6) return 'Bom';
            if (flexibilidade < 80.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (flexibilidade < 28.9) return 'Fraco';
            if (flexibilidade < 37.5) return 'Razoável';
            if (flexibilidade < 49.0) return 'Bom';
            if (flexibilidade < 79.0) return 'Muito Bom';
            return 'Excelência';
          }
      }
      return 'N/A';
    },

avaliarMedicineBall(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const medicineBall = pessoa.medicineBall;

    if (sexo === 'M') {
        if (idade === 6) {
            if (medicineBall < 136.2) return 'Fraco';
            if (medicineBall < 155.0) return 'Razoável';
            if (medicineBall < 180.4) return 'Bom';
            if (medicineBall < 249.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (medicineBall < 154.9) return 'Fraco';
            if (medicineBall < 175.6) return 'Razoável';
            if (medicineBall < 201.4) return 'Bom';
            if (medicineBall < 261.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (medicineBall < 173.4) return 'Fraco';
            if (medicineBall < 195.9) return 'Razoável';
            if (medicineBall < 223.3) return 'Bom';
            if (medicineBall < 284.3) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (medicineBall < 192.2) return 'Fraco';
            if (medicineBall < 216.6) return 'Razoável';
            if (medicineBall < 247.0) return 'Bom';
            if (medicineBall < 315.3) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (medicineBall < 209.2) return 'Fraco';
            if (medicineBall < 235.7) return 'Razoável';
            if (medicineBall < 268.8) return 'Bom';
            if (medicineBall < 345.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (medicineBall < 230.1) return 'Fraco';
            if (medicineBall < 259.2) return 'Razoável';
            if (medicineBall < 295.1) return 'Bom';
            if (medicineBall < 376.8) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (medicineBall < 255.2) return 'Fraco';
            if (medicineBall < 287.7) return 'Razoável';
            if (medicineBall < 327.4) return 'Bom';
            if (medicineBall < 416.2) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (medicineBall < 295.6) return 'Fraco';
            if (medicineBall < 334.0) return 'Razoável';
            if (medicineBall < 380.0) return 'Bom';
            if (medicineBall < 479.7) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (medicineBall < 348.5) return 'Fraco';
            if (medicineBall < 394.0) return 'Razoável';
            if (medicineBall < 446.5) return 'Bom';
            if (medicineBall < 554.5) return 'Muito Bom';
            return 'Excelência';
        }else if (idade === 15) {
            if (medicineBall < 405.1) return 'Fraco';
            if (medicineBall < 456.1) return 'Razoável';
            if (medicineBall < 513.0) return 'Bom';
            if (medicineBall < 623.5) return 'Muito Bom';
            return 'Excelência';
        }else if (idade === 16) {
            if (medicineBall < 448.3) return 'Fraco';
            if (medicineBall < 501.6) return 'Razoável';
            if (medicineBall < 560.1) return 'Bom';
            if (medicineBall < 670.9) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (medicineBall < 486.8) return 'Fraco';
            if (medicineBall < 541.2) return 'Razoável';
            if (medicineBall < 600.2) return 'Bom';
            if (medicineBall < 710.4) return 'Muito Bom';
            return 'Excelência';
        }
    } else if (sexo === 'F') {
        if (idade === 6) {
            if (medicineBall < 129.7) return 'Fraco';
            if (medicineBall < 146.6) return 'Razoável';
            if (medicineBall < 167.4) return 'Bom';
            if (medicineBall < 214.8) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (medicineBall < 141.7) return 'Fraco';
            if (medicineBall < 159.9) return 'Razoável';
            if (medicineBall < 182.0) return 'Bom';
            if (medicineBall < 230.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (medicineBall < 156.6) return 'Fraco';
            if (medicineBall < 176.4) return 'Razoável';
            if (medicineBall < 200.3) return 'Bom';
            if (medicineBall < 252.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (medicineBall < 174.1) return 'Fraco';
            if (medicineBall < 195.8) return 'Razoável';
            if (medicineBall < 222.2) return 'Bom';
            if (medicineBall < 279.5) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (medicineBall < 191.9) return 'Fraco';
            if (medicineBall < 215.5) return 'Razoável';
            if (medicineBall < 244.3) return 'Bom';
            if (medicineBall < 308.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (medicineBall < 214.3) return 'Fraco';
            if (medicineBall < 240.2) return 'Razoável';
            if (medicineBall < 271.8) return 'Bom';
            if (medicineBall < 341.9) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (medicineBall < 236.8) return 'Fraco';
            if (medicineBall < 265.0) return 'Razoável';
            if (medicineBall < 298.9) return 'Bom';
            if (medicineBall < 372.2) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (medicineBall < 261.3) return 'Fraco';
            if (medicineBall < 292.1) return 'Razoável';
            if (medicineBall < 328.2) return 'Bom';
            if (medicineBall < 403.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (medicineBall < 283.5) return 'Fraco';
            if (medicineBall < 316.5) return 'Razoável';
            if (medicineBall < 354.4) return 'Bom';
            if (medicineBall < 431.7) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (medicineBall < 299.9) return 'Fraco';
            if (medicineBall < 334.1) return 'Razoável';
            if (medicineBall < 373.4) return 'Bom';
            if (medicineBall < 452.8) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (medicineBall < 309.7) return 'Fraco';
            if (medicineBall < 344.6) return 'Razoável';
            if (medicineBall < 385.0) return 'Bom';
            if (medicineBall < 468.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (medicineBall < 318.4) return 'Fraco';
            if (medicineBall < 353.7) return 'Razoável';
            if (medicineBall < 395.5) return 'Bom';
            if (medicineBall < 484.0) return 'Muito Bom';
            return 'Excelência';
        }
      }
      return 'N/A';
    },

    avaliarSaltoHorizontal(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const saltoHorizontal = pessoa.saltoHorizontal;

    if (sexo === 'M') {
        if (idade === 6) {
            if (saltoHorizontal < 100.1) return 'Fraco';
            if (saltoHorizontal <= 111.6) return 'Razoável';
            if (saltoHorizontal <= 125.7) return 'Bom';
            if (saltoHorizontal <= 158.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (saltoHorizontal < 107.5) return 'Fraco';
            if (saltoHorizontal <= 118.9) return 'Razoável';
            if (saltoHorizontal <= 132.9) return 'Bom';
            if (saltoHorizontal <= 164.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (saltoHorizontal < 114.7) return 'Fraco';
            if (saltoHorizontal <= 126.2) return 'Razoável';
            if (saltoHorizontal <= 140.1) return 'Bom';
            if (saltoHorizontal <= 170.6) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (saltoHorizontal < 122.2) return 'Fraco';
            if (saltoHorizontal <= 133.9) return 'Razoável';
            if (saltoHorizontal <= 147.8) return 'Bom';
            if (saltoHorizontal <= 178.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (saltoHorizontal < 129.6) return 'Fraco';
            if (saltoHorizontal <= 141.6) return 'Razoável';
            if (saltoHorizontal <= 155.7) return 'Bom';
            if (saltoHorizontal <= 185.9) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (saltoHorizontal < 136.6) return 'Fraco';
            if (saltoHorizontal <= 148.9) return 'Razoável';
            if (saltoHorizontal <= 163.7) return 'Bom';
            if (saltoHorizontal <= 193.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (saltoHorizontal < 143.4) return 'Fraco';
            if (saltoHorizontal <= 156.3) return 'Razoável';
            if (saltoHorizontal <= 171.3) return 'Bom';
            if (saltoHorizontal <= 201.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (saltoHorizontal < 150.3) return 'Fraco';
            if (saltoHorizontal <= 164.1) return 'Razoável';
            if (saltoHorizontal <= 179.1) return 'Bom';
            if (saltoHorizontal <= 213.9) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (saltoHorizontal < 156.2) return 'Fraco';
            if (saltoHorizontal <= 166.8) return 'Razoável';
            if (saltoHorizontal <= 191.4) return 'Bom';
            if (saltoHorizontal <= 230.0) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (saltoHorizontal < 163.8) return 'Fraco';
            if (saltoHorizontal <= 173.7) return 'Razoável';
            if (saltoHorizontal <= 204.4) return 'Bom';
            if (saltoHorizontal <= 245.5) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (saltoHorizontal < 175.3) return 'Fraco';
            if (saltoHorizontal <= 191.4) return 'Razoável';
            if (saltoHorizontal <= 209.5) return 'Bom';
            if (saltoHorizontal <= 255.2) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (saltoHorizontal < 188.5) return 'Fraco';
            if (saltoHorizontal <= 205.8) return 'Razoável';
            if (saltoHorizontal <= 225.5) return 'Bom';
            if (saltoHorizontal <= 262.6) return 'Muito Bom';
            return 'Excelência';
        }
    } else if (sexo === 'F') {
        if (idade === 6) {
            if (saltoHorizontal < 88.3) return 'Fraco';
            if (saltoHorizontal <= 99.2) return 'Razoável';
            if (saltoHorizontal <= 112.8) return 'Bom';
            if (saltoHorizontal <= 143.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (saltoHorizontal < 96.2) return 'Fraco';
            if (saltoHorizontal <= 107.3) return 'Razoável';
            if (saltoHorizontal <= 120.9) return 'Bom';
            if (saltoHorizontal <= 151.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (saltoHorizontal < 103.5) return 'Fraco';
            if (saltoHorizontal <= 114.6) return 'Razoável';
            if (saltoHorizontal <= 128.4) return 'Bom';
            if (saltoHorizontal <= 158.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (saltoHorizontal < 110.8) return 'Fraco';
            if (saltoHorizontal <= 122.1) return 'Razoável';
            if (saltoHorizontal <= 136.0) return 'Bom';
            if (saltoHorizontal <= 166.2) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (saltoHorizontal < 117.7) return 'Fraco';
            if (saltoHorizontal <= 127.9) return 'Razoável';
            if (saltoHorizontal <= 140.3) return 'Bom';
            if (saltoHorizontal <= 174.1) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (saltoHorizontal < 123.9) return 'Fraco';
            if (saltoHorizontal <= 135.8) return 'Razoável';
            if (saltoHorizontal <= 150.4) return 'Bom';
            if (saltoHorizontal <= 181.7) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (saltoHorizontal < 128.0) return 'Fraco';
            if (saltoHorizontal <= 140.3) return 'Razoável';
            if (saltoHorizontal <= 155.3) return 'Bom';
            if (saltoHorizontal <= 187.6) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (saltoHorizontal < 130.0) return 'Fraco';
            if (saltoHorizontal <= 144.0) return 'Razoável';
            if (saltoHorizontal <= 159.4) return 'Bom';
            if (saltoHorizontal <= 193.3) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (saltoHorizontal < 132.0) return 'Fraco';
            if (saltoHorizontal <= 145.5) return 'Razoável';
            if (saltoHorizontal <= 161.9) return 'Bom';
            if (saltoHorizontal <= 197.4) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (saltoHorizontal < 131.8) return 'Fraco';
            if (saltoHorizontal <= 146.4) return 'Razoável';
            if (saltoHorizontal <= 163.4) return 'Bom';
            if (saltoHorizontal <= 200.8) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (saltoHorizontal < 131.2) return 'Fraco';
            if (saltoHorizontal <= 146.3) return 'Razoável';
            if (saltoHorizontal <= 164.4) return 'Bom';
            if (saltoHorizontal <= 203.3) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (saltoHorizontal < 130.5) return 'Fraco';
            if (saltoHorizontal <= 146.3) return 'Razoável';
            if (saltoHorizontal <= 165.2) return 'Bom';
            if (saltoHorizontal <= 205.7) return 'Muito Bom';
            return 'Excelência';
        }
    }
    return 'N/A';
},


avaliarQuadrado(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const quadrado = pessoa.quadrado;

    if (sexo === 'M') {
        if (idade === 6) {
            if (quadrado > 8.07) return 'Fraco';
            if (quadrado > 7.61) return 'Razoável';
            if (quadrado > 7.11) return 'Bom';
            if (quadrado > 6.21) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (quadrado > 7.85) return 'Fraco';
            if (quadrado > 7.39) return 'Razoável';
            if (quadrado > 6.79) return 'Bom';
            if (quadrado > 6.02) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (quadrado > 7.65) return 'Fraco';
            if (quadrado > 7.20) return 'Razoável';
            if (quadrado > 6.61) return 'Bom';
            if (quadrado > 5.86) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (quadrado > 7.45) return 'Fraco';
            if (quadrado > 7.02) return 'Razoável';
            if (quadrado > 6.41) return 'Bom';
            if (quadrado > 5.68) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (quadrado > 7.25) return 'Fraco';
            if (quadrado > 6.82) return 'Razoável';
            if (quadrado > 6.21) return 'Bom';
            if (quadrado > 5.55) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (quadrado > 7.02) return 'Fraco';
            if (quadrado > 6.62) return 'Razoável';
            if (quadrado > 5.99) return 'Bom';
            if (quadrado > 5.22) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (quadrado > 6.82) return 'Fraco';
            if (quadrado > 6.42) return 'Razoável';
            if (quadrado > 5.61) return 'Bom';
            if (quadrado > 4.94) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (quadrado > 6.62) return 'Fraco';
            if (quadrado > 6.19) return 'Razoável';
            if (quadrado > 5.44) return 'Bom';
            if (quadrado > 4.73) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (quadrado > 6.42) return 'Fraco';
            if (quadrado > 5.99) return 'Razoável';
            if (quadrado > 5.28) return 'Bom';
            if (quadrado > 4.54) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (quadrado > 6.19) return 'Fraco';
            if (quadrado > 5.79) return 'Razoável';
            if (quadrado > 4.73) return 'Bom';
            if (quadrado > 4.47) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (quadrado > 5.99) return 'Fraco';
            if (quadrado > 5.59) return 'Razoável';
            if (quadrado > 4.60) return 'Bom';
            if (quadrado > 4.23) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (quadrado > 5.79) return 'Fraco';
            if (quadrado > 5.43) return 'Razoável';
            if (quadrado > 4.54) return 'Bom';
            if (quadrado > 4.11) return 'Muito Bom';
            return 'Excelência';
        }
    } else if (sexo === 'F') {
        if (idade === 6) {
            if (quadrado > 8.85) return 'Fraco';
            if (quadrado > 8.27) return 'Razoável';
            if (quadrado > 7.66) return 'Bom';
            if (quadrado > 6.21) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (quadrado > 8.47) return 'Fraco';
            if (quadrado > 7.93) return 'Razoável';
            if (quadrado > 7.36) return 'Bom';
            if (quadrado > 6.63) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (quadrado > 8.15) return 'Fraco';
            if (quadrado > 7.60) return 'Razoável';
            if (quadrado > 7.07) return 'Bom';
            if (quadrado > 5.98) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (quadrado > 7.85) return 'Fraco';
            if (quadrado > 7.37) return 'Razoável';
            if (quadrado > 6.87) return 'Bom';
            if (quadrado > 5.91) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (quadrado > 7.60) return 'Fraco';
            if (quadrado > 7.15) return 'Razoável';
            if (quadrado > 6.63) return 'Bom';
            if (quadrado > 5.67) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (quadrado > 7.39) return 'Fraco';
            if (quadrado > 6.97) return 'Razoável';
            if (quadrado > 6.42) return 'Bom';
            if (quadrado > 5.61) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (quadrado > 7.27) return 'Fraco';
            if (quadrado > 6.75) return 'Razoável';
            if (quadrado > 6.19) return 'Bom';
            if (quadrado > 5.45) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (quadrado > 7.15) return 'Fraco';
            if (quadrado > 6.63) return 'Razoável';
            if (quadrado > 6.05) return 'Bom';
            if (quadrado > 5.28) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (quadrado > 7.05) return 'Fraco';
            if (quadrado > 6.50) return 'Razoável';
            if (quadrado > 5.91) return 'Bom';
            if (quadrado > 5.13) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (quadrado > 6.92) return 'Fraco';
            if (quadrado > 6.42) return 'Razoável';
            if (quadrado > 5.83) return 'Bom';
            if (quadrado > 5.13) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (quadrado > 6.88) return 'Fraco';
            if (quadrado > 6.36) return 'Razoável';
            if (quadrado > 5.85) return 'Bom';
            if (quadrado > 5.02) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (quadrado > 6.88) return 'Fraco';
            if (quadrado > 6.36) return 'Razoável';
            if (quadrado > 5.85) return 'Bom';
            if (quadrado > 5.02) return 'Muito Bom';
            return 'Excelência';
        }
      }
      return 'N/A';
    },

avaliarCorrida20m(pessoa) {
    const idade = pessoa.idade;
    const sexo = pessoa.sexo;
    const corrida20m = pessoa.corrida20m;

    if (sexo === 'M') {
        if (idade === 6) {
            if (corrida20m > 4.94) return 'Fraco';
            if (corrida20m > 4.57) return 'Razoável';
            if (corrida20m > 4.22) return 'Bom';
            if (corrida20m > 3.62) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (corrida20m > 4.75) return 'Fraco';
            if (corrida20m > 4.40) return 'Razoável';
            if (corrida20m > 4.05) return 'Bom';
            if (corrida20m > 3.53) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (corrida20m > 4.59) return 'Fraco';
            if (corrida20m > 4.24) return 'Razoável';
            if (corrida20m > 3.97) return 'Bom';
            if (corrida20m > 3.38) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (corrida20m > 4.44) return 'Fraco';
            if (corrida20m > 4.09) return 'Razoável';
            if (corrida20m > 3.83) return 'Bom';
            if (corrida20m > 3.33) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (corrida20m > 4.30) return 'Fraco';
            if (corrida20m > 3.97) return 'Razoável';
            if (corrida20m > 3.70) return 'Bom';
            if (corrida20m > 3.15) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (corrida20m > 4.16) return 'Fraco';
            if (corrida20m > 3.83) return 'Razoável';
            if (corrida20m > 3.58) return 'Bom';
            if (corrida20m > 3.14) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (corrida20m > 4.04) return 'Fraco';
            if (corrida20m > 3.73) return 'Razoável';
            if (corrida20m > 3.55) return 'Bom';
            if (corrida20m > 3.14) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (corrida20m > 3.91) return 'Fraco';
            if (corrida20m > 3.63) return 'Razoável';
            if (corrida20m > 3.46) return 'Bom';
            if (corrida20m > 3.13) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (corrida20m > 3.78) return 'Fraco';
            if (corrida20m > 3.55) return 'Razoável';
            if (corrida20m > 3.35) return 'Bom';
            if (corrida20m > 3.10) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (corrida20m > 3.66) return 'Fraco';
            if (corrida20m > 3.43) return 'Razoável';
            if (corrida20m > 3.26) return 'Bom';
            if (corrida20m > 2.99) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (corrida20m > 3.53) return 'Fraco';
            if (corrida20m > 3.35) return 'Razoável';
            if (corrida20m > 3.19) return 'Bom';
            if (corrida20m > 2.96) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (corrida20m > 3.43) return 'Fraco';
            if (corrida20m > 3.25) return 'Razoável';
            if (corrida20m > 3.09) return 'Bom';
            if (corrida20m > 2.89) return 'Muito Bom';
            return 'Excelência';
        }
    } else if (sexo === 'F') {
        if (idade === 6) {
            if (corrida20m > 5.27) return 'Fraco';
            if (corrida20m > 4.91) return 'Razoável';
            if (corrida20m > 4.57) return 'Bom';
            if (corrida20m > 3.98) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 7) {
            if (corrida20m > 5.05) return 'Fraco';
            if (corrida20m > 4.70) return 'Razoável';
            if (corrida20m > 4.38) return 'Bom';
            if (corrida20m > 3.99) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 8) {
            if (corrida20m > 4.86) return 'Fraco';
            if (corrida20m > 4.52) return 'Razoável';
            if (corrida20m > 4.19) return 'Bom';
            if (corrida20m > 3.85) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 9) {
            if (corrida20m > 4.68) return 'Fraco';
            if (corrida20m > 4.35) return 'Razoável';
            if (corrida20m > 4.04) return 'Bom';
            if (corrida20m > 3.83) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 10) {
            if (corrida20m > 4.53) return 'Fraco';
            if (corrida20m > 4.21) return 'Razoável';
            if (corrida20m > 3.91) return 'Bom';
            if (corrida20m > 3.61) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 11) {
            if (corrida20m > 4.41) return 'Fraco';
            if (corrida20m > 4.10) return 'Razoável';
            if (corrida20m > 3.80) return 'Bom';
            if (corrida20m > 3.53) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 12) {
            if (corrida20m > 4.33) return 'Fraco';
            if (corrida20m > 4.01) return 'Razoável';
            if (corrida20m > 3.73) return 'Bom';
            if (corrida20m > 3.45) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 13) {
            if (corrida20m > 4.28) return 'Fraco';
            if (corrida20m > 3.96) return 'Razoável';
            if (corrida20m > 3.68) return 'Bom';
            if (corrida20m > 3.42) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 14) {
            if (corrida20m > 4.25) return 'Fraco';
            if (corrida20m > 3.92) return 'Razoável';
            if (corrida20m > 3.65) return 'Bom';
            if (corrida20m > 3.40) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 15) {
            if (corrida20m > 4.22) return 'Fraco';
            if (corrida20m > 3.89) return 'Razoável';
            if (corrida20m > 3.63) return 'Bom';
            if (corrida20m > 3.39) return 'Muito Bom';
            return 'Excelência';
        } else if (idade === 16) {
            if (corrida20m > 4.21) return 'Fraco';
            if (corrida20m > 3.87) return 'Razoável';
            if (corrida20m > 3.61) return 'Bom';
            if (corrida20m > 3.38) return 'Muito Bom';
            return 'Excelência';
        } else if (idade >= 17) {
            if (corrida20m > 4.19) return 'Fraco';
            if (corrida20m > 3.84) return 'Razoável';
            if (corrida20m > 3.58) return 'Bom';
            if (corrida20m > 3.35) return 'Muito Bom';
            return 'Excelência';
        }
      }
      return 'N/A';
    },

}}
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


.btn:hover {
  background-color: #0056b3;
}

.alert {
  margin-top: 20px;
}

.fraco {
  color: white;
  background-color: red;
}

.razoavel {
  color: black;
  background-color: yellow;
}

.bom {
  color: white;
  background-color: green;
}

.muito-bom {
  color: black;
  background-color: lightblue;
}

.excelencia {
  color: white;
  background-color: blue;
}
</style>
