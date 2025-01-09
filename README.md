# 📢 Laravel Reverb Chat

### 💡 Descripción
**Laravel Reverb Chat** es un sistema de mensajería en tiempo real construido con **Laravel Reverb**, que permite la comunicación instantánea entre usuarios. Este proyecto incorpora buenas prácticas de desarrollo, separación de responsabilidades y funcionalidad extendida mediante integración con la API de OpenAI para respuestas automáticas.

---

### 🚀 Características
- **Eventos en tiempo real**:
  - `MessageReadEvent`
  - `MessageSentEvent`
  - `UserTypingEvent`
- **Controladores**:
  - `ConversationController` para la gestión de conversaciones.
  - `MessageController` para la administración de mensajes.
- **Integración con Axios** para manejar los datos JSON en las vistas.
- **Laravel Echo** para gestionar las suscripciones en tiempo real.
- **Chatbot** integrado usando la API de OpenAI con el modelo GPT-4o-mini.
- **Autorización de conversaciones** mediante policies.

---

### 📋 Requisitos
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL/SQLite
- Laravel 10/11
- Laravel Reverb
- Laravel Echo JS
- Axios

---

### 🛠 Instalación
1. **Clonar el repositorio**
```bash
 git clone https://github.com/StevenU21/laravel-reverb-chat.git
```

2. **Instalar dependencias**
```bash
composer install
npm install
```

3. **Configurar el entorno**
Copiar el archivo `.env.example` y renombrarlo como `.env`. Luego, configurar las siguientes variables:
```env
BROADCAST_DRIVER=redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
LARAVEL_ECHO_SERVER_PORT=6001
OPENAI_API_KEY=tu-clave-api
```

4. **Migrar la base de datos**
```bash
php artisan migrate
```

5. **Levantar el servidor**
- Para iniciar el servicio Reverb en modo normal:
  ```bash
  php artisan reverb:start
  ```
- Para iniciar con depuración:
  ```bash
  php artisan reverb:start ---debug
  ```

---

### 🌟 Uso
1. **Crear una conversación**:
   - Una conversación solo puede incluir a dos participantes.
2. **Enviar y recibir mensajes**:
   - Los mensajes se sincronizan en tiempo real entre ambos usuarios.
3. **Interacciones con el chatbot**:
   - Haz preguntas al chatbot integrado y recibe respuestas basadas en GPT-4o-mini.

---

### 📦 Arquitectura
- **Services**:
  - `ChatbotService` para manejar la lógica del chatbot.
- **Requests personalizados**:
  - `ChatbotRequest`
  - `MessageRequest`
  - `ConversationRequest`
- **Policies**:
  - `ConversationPolicy` asegura que solo los usuarios participantes puedan acceder a una conversación.
- **Eventos**:
  - Manejo eficiente de eventos en tiempo real.

---

### 💻 Tecnologías
- **Laravel Reverb**: Comunicación en tiempo real.
- **Laravel Echo**: Integración con WebSockets.
- **Axios**: Para manejar solicitudes HTTP desde las vistas.
- **Redis**: Como backend para colas y broadcasting.
- **OpenAI GPT-4o-mini**: Para funcionalidades de chatbot.

---

### 🛡 Seguridad
- **Policies**:
  - Implementadas para asegurar que solo los usuarios autorizados puedan acceder a sus respectivas conversaciones.
- **Validación de Requests**:
  - Uso de Requests personalizados para garantizar datos consistentes y seguros.

---

### 🔧 Comandos útiles
- **Iniciar el servicio Reverb**:
  ```bash
  php artisan reverb:start
  ```
- **Modo depuración**:
  ```bash
  php artisan reverb:start ---debug
  ```

---
