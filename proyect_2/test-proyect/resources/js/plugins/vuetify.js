import 'vuetify/styles'; // Importa los estilos de Vuetify
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'; // Importa los iconos

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi', // Configura el conjunto de iconos por defecto
  },
});

export default vuetify;