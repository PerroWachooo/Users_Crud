
<template>
  <div>
    <h1>Lista de Usuarios</h1>
    <div v-if="loading" class="loading">Cargando usuarios...</div>
    <div v-if="error" class="error-message">{{ error }}</div>
    <ul v-if="users.length > 0">
      <v-container>
        <v-data-table :items="users">
          <v-toolbar flat>
            <v-toolbar-title>
              <v-icon
              color="medium-emphasis"
              icon="mdi:account-group"
              size="x-small"
              start
              ></v-icon>
              Usuarios
            </v-toolbar-title>

            <v-btn text="Add User"></v-btn>

            <v-spacer></v-spacer>
          </v-toolbar>
        </v-data-table>
      </v-container>
    </ul>
    <div v-else-if="!loading && !error">
      No hay usuarios para mostrar.
    </div>
  </div>

</template>



<script>
import axios from 'axios';

export default {
  name: 'UserList',
  data() {
    return {
      users: [],
      loading: true,
      error: null,
    };
  },
  async mounted() {
    await this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      this.loading = true;
      this.error = null;
      try {
        // Asegúrate de que la URL '/users/list' coincida con la ruta definida en tu web.php
        // para el método getUsersJson del controlador.
        // Si usaste '/users/json' en web.php, cámbialo aquí.
        const response = await axios.get('/users/user-data');
        this.users = response.data;
        //Imprimimos la respuesta para depuración
        console.log('Usuarios obtenidos:', this.users);
      } catch (err) {
        console.error('Error fetching users:', err);
        this.error = 'Error al cargar la lista de usuarios. Por favor, inténtalo de nuevo más tarde.';
        if (err.response) {
            // El servidor respondió con un código de estado fuera del rango 2xx
            this.error += ` (Status: ${err.response.status})`;
        } else if (err.request) {
            // La solicitud se hizo pero no se recibió respuesta
            this.error = 'No se pudo conectar con el servidor para obtener los usuarios.';
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
.loading {
  color: #3498db;
  font-style: italic;
}
.error-message {
  color: #e74c3c;
  background-color: #fdd;
  border: 1px solid #e74c3c;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 15px;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  background-color: #f9f9f9;
  border: 1px solid #eee;
  padding: 10px;
  margin-bottom: 5px;
  border-radius: 4px;
}
li strong {
  color: #333;
}
li span {
  color: #777;
}
</style>