import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useCart } from '../context/CartContext';

const CheckoutPage = () => {
  const { user, addOrder, logout } = useAuth();
  const { cart, getCartTotal, clearCart } = useCart();
  const navigate = useNavigate();
  const [paymentMethod, setPaymentMethod] = useState('bank');
  const [orderPlaced, setOrderPlaced] = useState(false);
  const [orderNumber, setOrderNumber] = useState(null);

  const total = getCartTotal();

  const handleSubmitOrder = (e) => {
    e.preventDefault();
    
    const order = {
      userId: user.id,
      items: [...cart],
      total,
      paymentMethod,
      shippingAddress: {
        name: user.name,
        email: user.email
      }
    };

    const newOrder = addOrder(order);
    setOrderNumber(newOrder.id);
    setOrderPlaced(true);
    clearCart();
  };

  if (orderPlaced) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-cheqk-black">
        <div className="text-center max-w-md mx-auto px-4">
          <div className="text-cheqk-gold text-6xl mb-6">✓</div>
          <h1 className="text-3xl font-luxury text-white mb-4">¡Pedido Confirmado!</h1>
          <p className="text-gray-400 mb-2">Número de orden:</p>
          <p className="text-2xl text-cheqk-gold font-semibold mb-6">{orderNumber}</p>
          
          <div className="card-luxury p-6 mb-8 text-left">
            <h3 className="text-lg font-luxury text-white mb-4">Próximos pasos:</h3>
            <ul className="space-y-3 text-gray-400 text-sm">
              <li className="flex items-start">
                <span className="text-cheqk-gold mr-2">◈</span>
                Recibirás un correo con los detalles de pago para transferencia bancaria o criptomonedas.
              </li>
              <li className="flex items-start">
                <span className="text-cheqk-gold mr-2">◈</span>
                Nuestro equipo de concierge te contactará en menos de 24 horas.
              </li>
              <li className="flex items-start">
                <span className="text-cheqk-gold mr-2">◈</span>
                Una vez confirmado el pago, tu pedido será enviado con seguro incluido.
              </li>
            </ul>
          </div>

          <div className="flex gap-4 justify-center">
            <Link to="/profile" className="btn-gold">
              Ver mis Pedidos
            </Link>
            <Link to="/" className="btn-outline">
              Continuar Comprando
            </Link>
          </div>
        </div>
      </div>
    );
  }

  if (cart.length === 0) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-luxury text-white mb-4">Tu carrito está vacío</h2>
          <Link to="/" className="btn-gold inline-block">Ver Productos</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-cheqk-black py-12">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-4xl font-luxury text-white mb-8">Finalizar Pedido</h1>

        <form onSubmit={handleSubmitOrder}>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {/* Order Details */}
            <div>
              <div className="card-luxury p-6 mb-6">
                <h2 className="text-xl font-luxury text-white mb-4">Información del Cliente</h2>
                <div className="space-y-3 text-gray-400">
                  <p><span className="text-gray-500">Nombre:</span> {user.name}</p>
                  <p><span className="text-gray-500">Email:</span> {user.email}</p>
                </div>
                <button
                  type="button"
                  onClick={logout}
                  className="mt-4 text-sm text-cheqk-gold hover:text-yellow-500 transition-colors"
                >
                  Cerrar sesión
                </button>
              </div>

              <div className="card-luxury p-6">
                <h2 className="text-xl font-luxury text-white mb-4">Método de Pago</h2>
                <p className="text-gray-400 text-sm mb-4">
                  Selecciona cómo deseas realizar el pago. Nuestro equipo te enviará las instrucciones detalladas.
                </p>
                
                <div className="space-y-3">
                  <label className="flex items-center p-4 border border-cheqk-dark-gray cursor-pointer hover:border-cheqk-gold transition-colors">
                    <input
                      type="radio"
                      name="payment"
                      value="bank"
                      checked={paymentMethod === 'bank'}
                      onChange={(e) => setPaymentMethod(e.target.value)}
                      className="text-cheqk-gold focus:ring-cheqk-gold"
                    />
                    <div className="ml-3">
                      <span className="text-white block">Transferencia Bancaria</span>
                      <span className="text-gray-500 text-sm">Recibirás datos bancarios por email</span>
                    </div>
                  </label>

                  <label className="flex items-center p-4 border border-cheqk-dark-gray cursor-pointer hover:border-cheqk-gold transition-colors">
                    <input
                      type="radio"
                      name="payment"
                      value="crypto"
                      checked={paymentMethod === 'crypto'}
                      onChange={(e) => setPaymentMethod(e.target.value)}
                      className="text-cheqk-gold focus:ring-cheqk-gold"
                    />
                    <div className="ml-3">
                      <span className="text-white block">Criptomonedas</span>
                      <span className="text-gray-500 text-sm">BTC, ETH, USDT aceptados</span>
                    </div>
                  </label>

                  <label className="flex items-center p-4 border border-cheqk-dark-gray cursor-pointer hover:border-cheqk-gold transition-colors">
                    <input
                      type="radio"
                      name="payment"
                      value="wire"
                      checked={paymentMethod === 'wire'}
                      onChange={(e) => setPaymentMethod(e.target.value)}
                      className="text-cheqk-gold focus:ring-cheqk-gold"
                    />
                    <div className="ml-3">
                      <span className="text-white block">Wire Transfer Internacional</span>
                      <span className="text-gray-500 text-sm">Para pedidos superiores a $10,000</span>
                    </div>
                  </label>
                </div>
              </div>
            </div>

            {/* Order Summary */}
            <div>
              <div className="card-luxury p-6 sticky top-24">
                <h2 className="text-xl font-luxury text-white mb-6">Resumen del Pedido</h2>

                {/* Items */}
                <div className="space-y-4 mb-6 max-h-64 overflow-y-auto">
                  {cart.map(item => (
                    <div key={item.id} className="flex justify-between text-sm">
                      <span className="text-gray-400">
                        {item.name} x {item.quantity}
                      </span>
                      <span className="text-white">
                        ${(item.price * item.quantity).toLocaleString()}
                      </span>
                    </div>
                  ))}
                </div>

                {/* Totals */}
                <div className="border-t border-cheqk-dark-gray pt-4 space-y-3">
                  <div className="flex justify-between text-gray-400">
                    <span>Subtotal</span>
                    <span>${total.toLocaleString()}</span>
                  </div>
                  <div className="flex justify-between text-gray-400">
                    <span>Envío Asegurado</span>
                    <span className="text-cheqk-gold">Gratis</span>
                  </div>
                  <div className="flex justify-between text-gray-400">
                    <span>Seguro Premium</span>
                    <span className="text-cheqk-gold">Incluido</span>
                  </div>
                  <div className="border-t border-cheqk-dark-gray pt-4 mt-4">
                    <div className="flex justify-between text-xl font-semibold">
                      <span className="text-white">Total</span>
                      <span className="text-cheqk-gold">${total.toLocaleString()}</span>
                    </div>
                  </div>
                </div>

                <button
                  type="submit"
                  className="w-full btn-gold mt-6"
                >
                  Confirmar Pedido
                </button>

                <p className="text-xs text-gray-500 text-center mt-4">
                  Al confirmar, aceptas nuestros términos y condiciones de venta.
                  Un miembro de nuestro equipo te contactará dentro de 24 horas.
                </p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
};

export default CheckoutPage;
