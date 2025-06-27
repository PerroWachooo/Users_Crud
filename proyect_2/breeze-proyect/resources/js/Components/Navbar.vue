<template>
  <nav class="navbar">
    <!-- Header principal con logo y título -->
    <div class="navbar-header">
      <div class="logo-section">
        <div class="logo-circle">
          <i class="material-icons">account_circle</i>
        </div>
        <div class="title-section">
          <h1>DEPARTAMENTO DE</h1>
          <h1>USUARIOS</h1>
        </div>
      </div>
    </div>

    

    <!-- Toolbar de accesibilidad -->
    
  </nav>
</template>

<script setup>
// Aquí puedes agregar la lógica del navbar si es necesario
</script>

<style scoped>
.navbar {
  width: 100%;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Header principal */
.navbar-header {
  background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
  padding: 15px 30px;
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 20px;
}

.logo-circle {
  width: 80px;
  height: 80px;
  background-color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 3px solid #16a085;
}

.logo-circle i {
  font-size: 40px;
  color: #16a085;
}

.title-section h1 {
  margin: 0;
  color: white;
  font-size: 28px;
  font-weight: bold;
  letter-spacing: 2px;
  line-height: 1.2;
}



/* Toolbar de accesibilidad */
.accessibility-toolbar {
  background-color: #f8f9fa;
  padding: 8px 30px;
  display: flex;
  align-items: center;
  gap: 15px;
  border-bottom: 1px solid #e9ecef;
}

.accessibility-btn {
  background: none;
  border: none;
  color: #6c757d;
  font-size: 12px;
  display: flex;
  align-items: center;
  gap: 5px;
  cursor: pointer;
  padding: 5px 10px;
  border-radius: 4px;
  transition: background-color 0.2s ease;
}

.accessibility-btn:hover {
  background-color: #e9ecef;
}

.accessibility-btn i {
  font-size: 16px;
}

/* Responsive */
@media (max-width: 768px) {
  .navbar-header {
    padding: 10px 15px;
  }
  
  .logo-circle {
    width: 60px;
    height: 60px;
  }
  
  .logo-circle i {
    font-size: 30px;
  }
  
  .title-section h1 {
    font-size: 20px;
  }
  
  .menu-items {
    flex-wrap: wrap;
  }
  
  .menu-item {
    padding: 12px 15px;
    font-size: 12px;
  }
  
  .accessibility-toolbar {
    padding: 5px 15px;
    flex-wrap: wrap;
  }
}
</style>
