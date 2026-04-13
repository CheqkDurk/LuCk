# Cheqk - E-commerce de Tecnología de Lujo

## Descripción
Plataforma e-commerce especializada en tecnología premium, gadgets de edición limitada y hardware exclusivo. Diseño minimalista y sofisticado con estética de lujo.

## Tecnologías Utilizadas
- **React 18** - Framework de UI
- **Vite** - Build tool y dev server
- **Tailwind CSS** - Estilos y diseño responsive
- **React Router DOM** - Navegación entre páginas
- **Context API** - Gestión de estado global (auth y carrito)
- **LocalStorage** - Persistencia de datos

## Características Principales

### 🎨 Diseño UI/UX
- Paleta de colores oscura (negro mate, gris carbón) con acentos dorados
- Tipografía luxury (Playfair Display) y moderna (Inter)
- Animaciones suaves y transiciones elegantes
- Diseño completamente responsive

### 👤 Sistema de Usuarios
- Registro de nuevos clientes
- Inicio de sesión (Login)
- Cierre de sesión (Logout)
- Perfil de usuario con historial de pedidos
- Datos persistentes en localStorage

### 🛍️ Catálogo de Productos
- Grid de productos con imágenes de alta calidad
- Filtros por categorías (Smartphones, Wearables, Laptops, Audio, etc.)
- Filtro especial para "Edición Limitada"
- Página de detalle con especificaciones técnicas
- Control de stock y disponibilidad

### 🛒 Carrito de Compras
- Añadir/eliminar productos
- Modificar cantidades
- Resumen de pedido en tiempo real
- Persistencia del carrito

### 💳 Checkout Sin Tarjeta
- Sistema de pago alternativo:
  - Transferencia bancaria
  - Criptomonedas (BTC, ETH, USDT)
  - Wire Transfer internacional
- Generación de orden de compra
- Confirmación con número de pedido
- Instrucciones de pago por email

## Estructura del Proyecto

```
cheqk-store/
├── src/
│   ├── components/
│   │   ├── Navbar.jsx         # Barra de navegación
│   │   └── ProductCard.jsx    # Tarjeta de producto
│   ├── context/
│   │   ├── AuthContext.jsx    # Autenticación
│   │   └── CartContext.jsx    # Carrito de compras
│   ├── data/
│   │   └── products.js        # Catálogo de productos
│   ├── pages/
│   │   ├── HomePage.jsx           # Página principal
│   │   ├── ProductDetailPage.jsx  # Detalle de producto
│   │   ├── CartPage.jsx           # Carrito
│   │   ├── CheckoutPage.jsx       # Checkout
│   │   ├── LoginPage.jsx          # Login/Registro
│   │   ├── ProfilePage.jsx        # Perfil de usuario
│   │   └── LimitedEditionPage.jsx # Edición limitada
│   ├── App.jsx                # Componente principal
│   ├── main.jsx               # Entry point
│   └── index.css              # Estilos globales
├── index.html
├── package.json
├── tailwind.config.js
├── vite.config.js
└── postcss.config.js
```

## Instalación y Ejecución

```bash
# Instalar dependencias
npm install

# Modo desarrollo
npm run dev

# Build para producción
npm run build

# Preview del build
npm run preview
```

## URLs de la Aplicación

- **Inicio**: `/`
- **Edición Limitada**: `/limited`
- **Detalle Producto**: `/product/:id`
- **Carrito**: `/cart`
- **Checkout**: `/checkout`
- **Login/Registro**: `/login`
- **Perfil**: `/profile`

## Funcionalidades Demo

1. **Navegar productos**: Explora el catálogo con filtros
2. **Ver detalles**: Haz clic en un producto para ver especificaciones
3. **Añadir al carrito**: Agrega productos y modifica cantidades
4. **Registrarse**: Crea una cuenta nueva
5. **Iniciar sesión**: Accede con tus credenciales
6. **Checkout**: Finaliza pedido sin tarjeta (transferencia/cripto)
7. **Ver pedidos**: Revisa tu historial en el perfil

## Notas

- Los datos se almacenan en localStorage del navegador
- No hay backend real, toda la lógica es frontend
- Las imágenes son de Unsplash (uso libre)
- Los precios son demostrativos

---

**Cheqk** © 2024 - Tecnología de Lujo
