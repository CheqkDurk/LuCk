# LuCk - Blackjack Game

Un juego de Blackjack interactivo desarrollado con PHP, JavaScript, HTML y CSS. Incluye autenticación simple de usuario y lógica completa de juego.

## Archivos del Proyecto

### Archivos PHP
- **`login.php`** - Página de login con autenticación simple
- **`index.php`** - Página principal del juego (protegida por sesión)

### Archivos de Estilos
- **`styles.css`** - Estilos CSS para la interfaz completa y el juego de Blackjack

### Archivos JavaScript
- **`blackjack.js`** - Lógica completa del juego de Blackjack

## Credenciales de Prueba

```
Usuario: player    | Contraseña: secret
Usuario: admin     | Contraseña: 1234
Usuario: user      | Contraseña: pass
```

## Cómo Jugar

1. **Accede a la página principal:**
   ```
   http://localhost:8080/home.php
   ```

2. **Inicia sesión** con cualquiera de las credenciales de prueba
   ```
   http://localhost:8080/login.php
   ```

4. **Juega Blackjack:**
   - Ingresa tu apuesta en el campo "Apuesta"
   - Haz click en "Deal!" para empezar una mano
   - Usa "Hit" para pedir una carta más
   - Usa "Stand" para parar y dejar que el crupier juegue
   - "Double Down" duplica tu apuesta y recibes una carta más
   - "Insurance" te protege si el crupier tiene un As

5. **Objetivo:** Sumar 21 o más que el crupier sin pasarse de 21

## Sistema de Dinero

- **Cash Inicial:** $1,000
- **Apuesta Mínima:** $1
- **Ganancias:** Se muestran en tiempo real
- **Game Over:** Cuando se agota el dinero, se puede pedir prestamos con un màximo de 20,000 €

## Requisitos

- PHP 5.4+ (con soporte para server de desarrollo)
- Navegador moderno con soporte para:
  - ES6 JavaScript
  - CSS3
  - jQuery 1.11.3
  - Bootstrap 3.3.7

## Inicio del Servidor

```bash
cd /workspaces/LuCk
php -S localhost:8080
```

Luego accede a: `http://localhost:8080/home.php`

## Características

- ✅ Autenticación de usuario con sesiones PHP
- ✅ Juego de Blackjack completamente funcional
- ✅ Animaciones de cartas
- ✅ Sistema de apuestas
- ✅ Cálculo automático de puntuaciones
- ✅ Historial de ganancias/pérdidas
- ✅ Modal para recargar dinero
- ✅ Interfaz responsiva
- ✅ Soporte para todas las acciones de Blackjack (Hit, Stand, Double, Insurance)

## Notas Importantes

- Este es un sistema de estudio/demostración
- La autenticación es simple y NO es segura para producción
- Usa `session_start()` y `$_SESSION` para manejar el estado del usuario
- Las credenciales se guardan en memoria durante la sesión
- No hay persistencia de datos en base de datos

## Personalización

Puedes modificar los estilos en `styles.css` o la lógica del juego en `blackjack.js`.

## Limitaciones Conocidas

- La función "Split" aún no está implementada completamente
- El juego no guarda estadísticas de dinero permanentes
- La apuesta no se valida en el servidor (solo en cliente)

---

**Desarrollado para propósitos educativos** 🎓
