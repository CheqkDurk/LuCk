# LuCk — Demo (sitio web del juego)

Este es un ejemplo mínimo de una web para un juego con:
- Página inicial pública con formulario de login.
- Páginas internas públicas (About, Game).
- Página privada (Dashboard) accesible sólo tras autenticación.

Cómo usar:
1. Abrir `home.php` en un navegador (puede servir como SPA estático).
2. Login demo: usuario `player`, contraseña `secret`.
3. Tras el login, l'arxiu `index.php` mostrará contenido privado.

Notas importantes:
- La autenticación está simulada en el cliente (localStorage). No usar así en producción.
- Para producción, mover la verificación de credenciales a un servidor seguro (HTTPS),
  emitir tokens (JWT u otros) y validarlos en el servidor antes de permitir acceso a datos privados.
- Se puede ampliar con backend (Node/Express, Firebase, Supabase, etc.) para persistir usuarios y progreso.
