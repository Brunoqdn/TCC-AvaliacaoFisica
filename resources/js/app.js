import './bootstrap';
import { createApp } from 'vue';

// Importação dos componentes Vue
import FormularioMedida from './components/FormularioMedida.vue';
import LogoutButton from './components/LogoutButton.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import PesquisarPessoa from './components/PesquisarPessoa.vue';


// Criação do app Vue
const app = createApp({});

// Registro dos componentes Vue
app.component('formulario-medida', FormularioMedida);
app.component('logout-button', LogoutButton);
app.component('example-component', ExampleComponent);
app.component('login-component', LoginComponent);
app.component('register-component', RegisterComponent);
app.component('pesquisar-pessoa', PesquisarPessoa);
app.component('chart-component', ChartComponent);


// Montagem do app Vue no elemento com id "app"
app.mount('#app');

