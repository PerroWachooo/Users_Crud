<template>
  <div>
    <h1>Lista de Usuarios</h1>
    <div v-if="loading" class="loading">Cargando usuarios...</div>
    <div v-if="error" class="error-message">{{ error }}</div>
    
    <v-container v-if="users.length > 0">
      <v-data-table :headers="headers" :items="users">
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>
              <v-icon icon="mdi-account-group"></v-icon>
              Usuarios
            </v-toolbar-title>

            <v-btn text="Add User" href="/users/create"></v-btn>
            <v-spacer></v-spacer>
          </v-toolbar>
        </template>

        <template v-slot:item.actions="{ item }">
          <v-icon
            size="small"
            class="me-2"
            @click="editUser(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            size="small"
            @click="deleteUser(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-container>

    <div v-else-if="!loading && !error">
      No hay usuarios para mostrar.
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'; // Importar ref y onMounted de Vue 3
import axios from 'axios'; // Importar axios

// Estado reactivo
const users = ref([]);
const loading = ref(true);
const error = ref(null);
const headers = ref([
  { title: 'ID', align: 'start', key: 'id' },
  { title: 'Nombre', key: 'name' },
  { title: 'Email', key: 'email' },
  { title: 'Creado', key: 'created_at', sortable: false },
  { title: 'Acciones', key: 'actions', sortable: false, align: 'end' },
]);

// Función para obtener usuarios
const fetchUsers = async () => {
  loading.value = true;
  error.value = null;
  try {
    const response = await axios.get('/users/user-data');
    users.value = response.data;
    console.log('Usuarios obtenidos:', users.value);
  } catch (err) {
    console.error('Error fetching users:', err);
    error.value = 'Error al cargar la lista de usuarios. Por favor, inténtalo de nuevo más tarde.';
    if (err.response) {
      error.value += ` (Status: ${err.response.status})`;
    } else if (err.request) {
      error.value = 'No se pudo conectar con el servidor para obtener los usuarios.';
    }
  } finally {
    loading.value = false;
  }
};

// Función para eliminar un usuario
const deleteUser = async (user) => {
  if (!confirm(`¿Estás seguro que quieres eliminar a ${user.name}?`)) return;
  try {
    const response = await axios.delete(`/users/${user.id}`);
    console.log('Usuario eliminado:', response.data);
    fetchUsers(); // Refresca la lista de usuarios después de eliminar
  } catch (err) {
    console.error('Error deleting user:', err);
    error.value = 'Error al eliminar el usuario. Por favor, inténtalo de nuevo más tarde.';
  }
};

// Cargar los usuarios cuando el componente se monte
onMounted(() => {
  fetchUsers();
});
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
