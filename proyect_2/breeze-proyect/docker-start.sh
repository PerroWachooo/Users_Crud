#!/bin/bash

echo "🐳 Iniciando dockerización del proyecto Laravel..."

# Construir la imagen
echo "📦 Construyendo la imagen Docker..."
docker-compose build

# Iniciar los contenedores
echo "🚀 Iniciando los contenedores..."
docker-compose up -d

# Esperar a que la base de datos esté lista
echo "⏳ Esperando a que la base de datos esté lista..."
sleep 10

# Ejecutar migraciones
echo "🗃️ Ejecutando migraciones de base de datos..."
docker-compose exec app php artisan migrate --force

# Ejecutar seeders (opcional)
echo "🌱 Ejecutando seeders..."
docker-compose exec app php artisan db:seed --force

echo "✅ ¡Proyecto dockerizado exitosamente!"
echo "🌐 La aplicación está disponible en: http://localhost:8080"
echo "🗃️ Base de datos MySQL disponible en puerto 3306"
echo ""
echo "Comandos útiles:"
echo "  Ver logs: docker-compose logs -f"
echo "  Parar contenedores: docker-compose down"
echo "  Acceder al contenedor: docker-compose exec app bash"
