import { createApp } from 'vue';
import App from './components/App.vue';
import UserForm from './components/UserForm.vue';
import UserList from './components/UserList.vue';
import vuetify from './plugins/vuetify'; // Importa la configuración de Vuetify

const components = {
    UserForm,
    UserList, // Añade otros componentes aquí
    
};

const appElement = document.getElementById('app');

if (appElement) {
    const componentName = appElement.dataset.vueComponent; // Lee el nombre del data-attribute
    if (componentName && components[componentName]) {
        const app = createApp(components[componentName]).mount(appElement);
        app.use(vuetify); // Usa Vuetify en la aplicación
        app.mount(appElement);
    } else if (componentName) {
        console.warn(`Componente Vue "${componentName}" no encontrado o no registrado en app.js.`);
    } else {
        // Opcional: montar un componente por defecto si no se especifica ninguno
        // console.warn('No se especificó data-vue-component en el elemento #app.');
        // createApp(UserForm).mount(appElement); // Por ejemplo, UserForm como fallback
    }
}