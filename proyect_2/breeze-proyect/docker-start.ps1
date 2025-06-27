Write-Host "🐳 Iniciando dockerización del proyecto Laravel..." -ForegroundColor Cyan

# Construir la imagen
Write-Host "📦 Construyendo la imagen Docker..." -ForegroundColor Yellow
docker-compose build

# Iniciar los contenedores
Write-Host "🚀 Iniciando los contenedores..." -ForegroundColor Yellow
docker-compose up -d

# Esperar a que la base de datos esté lista
Write-Host "⏳ Esperando a que la base de datos esté lista..." -ForegroundColor Yellow
Start-Sleep -Seconds 10

# Ejecutar migraciones
Write-Host "🗃️ Ejecutando migraciones de base de datos..." -ForegroundColor Yellow
docker-compose exec app php artisan migrate --force

# Ejecutar seeders (opcional)
Write-Host "🌱 Ejecutando seeders..." -ForegroundColor Yellow
docker-compose exec app php artisan db:seed --force

Write-Host "✅ ¡Proyecto dockerizado exitosamente!" -ForegroundColor Green
Write-Host "🌐 La aplicación está disponible en: http://localhost:8080" -ForegroundColor Green
Write-Host "🗃️ Base de datos MySQL disponible en puerto 3306" -ForegroundColor Green
Write-Host ""
Write-Host "Comandos útiles:" -ForegroundColor White
Write-Host "  Ver logs: docker-compose logs -f" -ForegroundColor Gray
Write-Host "  Parar contenedores: docker-compose down" -ForegroundColor Gray
Write-Host "  Acceder al contenedor: docker-compose exec app bash" -ForegroundColor Gray
