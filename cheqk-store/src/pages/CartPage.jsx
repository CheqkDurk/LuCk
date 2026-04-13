import { Link, useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { useAuth } from '../context/AuthContext';

const CartPage = () => {
  const { cart, removeFromCart, updateQuantity, getCartTotal, clearCart } = useCart();
  const { isAuthenticated } = useAuth();
  const navigate = useNavigate();

  const total = getCartTotal();

  const handleCheckout = () => {
    if (!isAuthenticated) {
      navigate('/login');
      return;
    }
    navigate('/checkout');
  };

  if (cart.length === 0) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <svg className="w-24 h-24 mx-auto text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          <h2 className="text-2xl font-luxury text-white mb-4">Tu carrito está vacío</h2>
          <p className="text-gray-400 mb-8">Explora nuestra colección de productos exclusivos</p>
          <Link to="/" className="btn-gold inline-block">
            Ver Productos
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-cheqk-black py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-4xl font-luxury text-white mb-8">Carrito de Compras</h1>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Cart Items */}
          <div className="lg:col-span-2 space-y-4">
            {cart.map(item => (
              <div key={item.id} className="card-luxury p-6 flex gap-6">
                {/* Product Image */}
                <div className="w-32 h-32 flex-shrink-0 rounded-sm overflow-hidden">
                  <img
                    src={item.image}
                    alt={item.name}
                    className="w-full h-full object-cover"
                  />
                </div>

                {/* Product Info */}
                <div className="flex-1 flex flex-col justify-between">
                  <div>
                    <Link 
                      to={`/product/${item.id}`}
                      className="text-lg font-luxury text-white hover:text-cheqk-gold transition-colors"
                    >
                      {item.name}
                    </Link>
                    {item.limited && (
                      <span className="ml-2 text-xs bg-cheqk-gold text-cheqk-black px-2 py-0.5">
                        EDICIÓN LIMITADA
                      </span>
                    )}
                  </div>

                  <div className="flex justify-between items-end">
                    {/* Quantity Controls */}
                    <div className="flex items-center border border-cheqk-dark-gray">
                      <button
                        onClick={() => updateQuantity(item.id, item.quantity - 1)}
                        className="px-3 py-2 text-gray-400 hover:text-white transition-colors"
                      >
                        −
                      </button>
                      <span className="px-4 text-white">{item.quantity}</span>
                      <button
                        onClick={() => updateQuantity(item.id, item.quantity + 1)}
                        className="px-3 py-2 text-gray-400 hover:text-white transition-colors"
                      >
                        +
                      </button>
                    </div>

                    {/* Price & Remove */}
                    <div className="text-right">
                      <p className="text-xl text-cheqk-gold font-semibold mb-2">
                        ${(item.price * item.quantity).toLocaleString()}
                      </p>
                      <button
                        onClick={() => removeFromCart(item.id)}
                        className="text-sm text-gray-400 hover:text-red-400 transition-colors"
                      >
                        Eliminar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            ))}

            {/* Clear Cart Button */}
            <button
              onClick={clearCart}
              className="text-gray-400 hover:text-red-400 transition-colors text-sm"
            >
              Vaciar carrito
            </button>
          </div>

          {/* Order Summary */}
          <div className="lg:col-span-1">
            <div className="card-luxury p-6 sticky top-24">
              <h2 className="text-2xl font-luxury text-white mb-6">Resumen del Pedido</h2>

              <div className="space-y-4 mb-6">
                <div className="flex justify-between text-gray-400">
                  <span>Subtotal</span>
                  <span>${total.toLocaleString()}</span>
                </div>
                <div className="flex justify-between text-gray-400">
                  <span>Envío</span>
                  <span className="text-cheqk-gold">Gratis</span>
                </div>
                <div className="flex justify-between text-gray-400">
                  <span>Seguro</span>
                  <span className="text-cheqk-gold">Incluido</span>
                </div>
                <div className="border-t border-cheqk-dark-gray pt-4">
                  <div className="flex justify-between text-xl font-semibold">
                    <span className="text-white">Total</span>
                    <span className="text-cheqk-gold">${total.toLocaleString()}</span>
                  </div>
                </div>
              </div>

              <button
                onClick={handleCheckout}
                className="w-full btn-gold mb-4"
              >
                {isAuthenticated ? 'Proceder al Pago' : 'Iniciar Sesión para Continuar'}
              </button>

              <p className="text-xs text-gray-500 text-center">
                Envío asegurado y gratuito a todo el mundo
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CartPage;
