<!-- <template>
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
</template> -->

<template>
  <div>
    <Navbar />
    <div class="background">
      <div class="card">
      <div>
        <h1 class="headLine">Lista de Usuarios</h1>
      </div>
      <div v-if="loading" class="loading">Cargando usuarios...</div>
      <div v-if="error" class="error-message">{{ error }}</div>
      <table id="userTable">
        <thead>
          <tr>
            <th v-for="header in headers" :key="header.key" :align="header.align">
              {{ header.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td> {{ user.name }}</td>
            <td> {{ user.email }}</td>
            <td> {{ formatDate(user.created_at) }}</td>
            <td class="accions-cell"> 
              <button @click="deleteUser(user)" class="delete-btn">
                <i class="material-icons">delete</i>
              </button>
            </td>

            
          </tr>
        </tbody>

      </table>
    </div>
  </div>
</div>

</template>

<script setup>
import { ref, onMounted } from 'vue'; // Importar ref y onMounted de Vue 3
import axios from 'axios'; // Importar axios
import Navbar from '@/Components/Navbar.vue'; // Importar el componente Navbar

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
    const response = await axios.get('/api/users/user-data');
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

// Función para formatear fechas
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
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

.card{
  width: 80%;
  background-color:#ffffff;
  border-radius: 10px;
  vertical-align: middle;
  margin: 30px auto 0 auto;
  padding: 20px;
  box-shadow: 0px 0px 11px 4px rgba(0, 0, 0, 0.3); /* Sombra para el contenedor */
}

.background{
  background-color:#f3f3f382;
  min-height: 100vh;
  padding-bottom: 20px;
}

#userTable {
  font-family: Arial;
  border-collapse: collapse;
  width: 90%;
  margin: 20px auto;
  max-width: 1200px;
}

#userTable tr:nth-child(even){background-color: #f2d3bf41;}
#userTable tr:hover {background-color: #f9a1427f;}


#userTable td{
  border: 1px solid #ddd;
  padding: 8px;
}

#userTable th {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
  background-color: rgba(163, 54, 0, 0.539);
  color: white;
  border-radius: 5px;
}
.headLine{
  font-size: 30px;
  font-weight: bold;
  color: #333;
  text-align: center;
  margin-top: 20px;
  background-color: rgba(199, 69, 4, 0.539);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);

}
.loading {
  color: #4c1e01db;
  font-style: oblique;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50vh;
  font-size: 25px;
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

#userTable .accions-cell {
  text-align: center;
  vertical-align: middle;
  width: 100px;
}

.delete-btn {
  background-color: rgba(199, 69, 4, 0.539);
  color: white;
  border: none;
  padding: 8px;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
}

.delete-btn:hover {
  background-color: #c0392b;
}

.delete-btn i {
  font-size: 18px;
}
</style>
