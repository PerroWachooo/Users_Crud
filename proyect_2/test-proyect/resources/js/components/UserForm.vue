<template>
  <div class="d-flex flex-column align-center justify-center pa-4">
    <h1>Registrar Usuario</h1>


    <v-card class="mx-auto" max-width="800" width="100%" elevation="16">
      <form @submit.prevent="submitForm">  
        <v-card-text>  
          <v-text-field
            v-model="form.name"
            label="Nombre"
            required
            :error-messages="errors.name ? errors.name[0] : ''"
          ></v-text-field>
          
          <v-text-field
            v-model="form.email"
            label="Correo Electrónico"
            type="email"
            required
            :error-messages="errors.email ? errors.email[0] : ''"
          ></v-text-field>

          <v-text-field
            v-model="form.password"
            label="Contraseña"
            type="password"
            required
            :error-messages="errors.password ? errors.password[0] : ''"
          ></v-text-field>

          <v-text-field
            v-model="form.password_confirmation"
            label="Confirmar Contraseña"
            type="password"
            required
            :error-messages="errors.password_confirmation ? errors.password_confirmation[0] : ''"
          ></v-text-field>
        </v-card-text>

        <v-card-actions class="d-flex justify-center pa-4">
          <v-btn elevation="7" type="submit" >Crear Usuario</v-btn>
        </v-card-actions>
      </form>
    </v-card>
    <p v-if="message" :class="messageClass">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'; // Importar ref de Vue 3
import axios from 'axios'; // Importar axios aquí

// Declaración de estados reactivos con ref
const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const message = ref('');
const messageClass = ref('');
const errors = ref({});

// Función submitForm para manejar el envío del formulario
const submitForm = async () => {
  message.value = ''; // Limpiar mensajes previos
  errors.value = {};  // Limpiar errores previos
  messageClass.value = '';

  try {
    const response = await axios.post('/users', form.value);
    message.value = response.data.message || 'Usuario creado exitosamente!';
    messageClass.value = 'success';

    // Opcional: Limpiar formulario
    form.value.name = '';
    form.value.email = '';
    form.value.password = '';
    form.value.password_confirmation = '';
  } catch (error) {
    messageClass.value = 'error';
    if (error.response) {
      if (error.response.status === 422) {
        // Errores de validación
        message.value = 'Por favor corrige los errores del formulario.';
        errors.value = error.response.data.errors;
      } else {
        // Otros errores del servidor (500, 403, etc.)
        message.value = error.response.data.message || 'Hubo un error al crear el usuario.';
      }
    } else if (error.request) {
      // La petición se hizo pero no se recibió respuesta
      message.value = 'No se pudo conectar con el servidor. Intenta de nuevo.';
    } else {
      // Algo sucedió al configurar la petición
      message.value = 'Error al enviar la petición: ' + error.message;
    }
    console.error('Error submitting form:', error);
  }
};
</script>

<style scoped>
/* Aquí puedes añadir estilos específicos para el formulario */
.success {
  color: green;
}

.error {
  color: red;
}
</style>
