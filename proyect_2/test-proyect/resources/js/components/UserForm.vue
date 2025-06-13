<template>
  <div>
    <h1>Registrar Usuario</h1>

    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Nombre:</label>
        <input type="text" v-model="form.name" id="name" required>
        <span v-if="errors.name" class="error-message">{{ errors.name[0] }}</span> 
      </div>

      <div>
        <label for="email">Correo electrónico:</label>
        <input type="email" v-model="form.email" id="email" required>
        <span v-if="errors.email" class="error-message">{{ errors.email[0] }}</span> 
      </div>

      <div>
        <label for="password">Contraseña:</label>
        <input type="password" v-model="form.password" id="password" required>
        <span v-if="errors.password" class="error-message">{{ errors.password[0] }}</span> 
      </div>

      <div>
        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" v-model="form.password_confirmation" id="password_confirmation" required>
      </div>

      <button type="submit">Crear Usuario</button>
    </form>

    <p v-if="message" :class="messageClass">{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios'; // Importar axios aquí
export default {

  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      message: '',
      messageClass: '',
      errors: {},
    };
  },
  methods: {
    async submitForm() {
      this.message = ''; // Limpiar mensajes previos
      this.errors = {};  // Limpiar errores previos
      this.messageClass = '';

      try {
        const response = await axios.post('/users', this.form);
        this.message = response.data.message || 'Usuario creado exitosamente!';
        this.messageClass = 'success';
        // Opcional: Limpiar formulario
        this.form.name = '';
        this.form.email = '';
        this.form.password = '';
        this.form.password_confirmation = '';
      } catch (error) {
        this.messageClass = 'error';
        if (error.response) {
          if (error.response.status === 422) {
            // Errores de validación
            this.message = 'Por favor corrige los errores del formulario.';
            this.errors = error.response.data.errors;
          } else {
            // Otros errores del servidor (500, 403, etc.)
            this.message = error.response.data.message || 'Hubo un error al crear el usuario.';
          }
        } else if (error.request) {
          // La petición se hizo pero no se recibió respuesta
          this.message = 'No se pudo conectar con el servidor. Intenta de nuevo.';
        } else {
          // Algo sucedió al configurar la petición
          this.message = 'Error al enviar la petición: ' + error.message;
        }
        console.error('Error submitting form:', error);
      }
    },
 },
}
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
