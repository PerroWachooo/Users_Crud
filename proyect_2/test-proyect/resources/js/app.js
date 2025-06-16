import { createApp } from 'vue';
import App from './components/App.vue';
import UserForm from './components/UserForm.vue';
import UserList from './components/UserList.vue';
import 'vuetify/styles'; // Importa los estilos de Vuetify 3
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
  components,
  directives,
});

const componentsMap = {
    UserForm,
    UserList,
};

const appElement = document.getElementById('app');

if (appElement) {
    const componentName = appElement.dataset.vueComponent;
    if (componentName && componentsMap[componentName]) {
        const app = createApp(componentsMap[componentName]);
        app.use(vuetify);
        app.mount(appElement);
    } else if (componentName) {
        console.warn(`Componente Vue "${componentName}" no encontrado o no registrado en app.js.`);
    }
}