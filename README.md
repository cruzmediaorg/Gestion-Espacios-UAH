# Aplicación web para la gestión de espacios de la Universidad de Alcalá.


# Espacios UAH

Aplicación web para la gestión de espacios de la Universidad de Alcalá.

## Descripción
Este proyecto forma parte del Trabajo de Fin del Máster Desarrollo Ágil de Software para la Web. Es una aplicación web desarrollada para gestionar y reservar espacios en la Universidad de Alcalá. Proporciona una interfaz amigable para los usuarios, permitiéndoles consultar la disponibilidad de los espacios y realizar reservas de manera eficiente.

## Instalación

Para clonar y ejecutar esta aplicación, sigue estos pasos:

1. Clona el repositorio:
    ```bash
    git clone https://github.com/cruzmediaorg/espacios-uah.git
    ```
2. Navega al directorio del proyecto:
    ```bash
    cd espacios-uah
    ```
3. Instala las dependencias:
    ```bash
    composer install
    npm install
    ```
4. Configura el archivo de entorno:
    ```bash
    cp .env.example .env
    ```
5. Genera la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```
6. Ejecuta las migraciones y seedeers:
    ```bash
    php artisan migrate --seed
    ```
7. Inicia el servidor de desarrollo:
    ```bash
    php artisan serve
    npm run dev
    ```
7. Inicia el supervisor de colas:
    ```bash
    php artisan queue:listen
    ```
8. Inicia el servidor de WebSockets Laravel Reverb:
    ```bash
    php artisan reverb:start
    ```

## Uso

1. Accede a la aplicación en tu navegador web:
    ```
    http://localhost:8000
    ```
    
2. Regístrate o inicia sesión.
3. Navega a la sección de reservas para gestionar los espacios disponibles.
do bajo la Licencia MIT. Consulta el archivo `LICENSE` para obtener más detalles.

## Contacto

luis@cruzmediadigital.com
---
