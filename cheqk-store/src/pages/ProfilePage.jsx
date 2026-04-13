import { Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const ProfilePage = () => {
  const { user, getUserOrders } = useAuth();
  const orders = getUserOrders();

  if (!user) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-luxury text-white mb-4">Debes iniciar sesión</h2>
          <Link to="/login" className="btn-gold inline-block">Iniciar Sesión</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-cheqk-black py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Profile Header */}
        <div className="card-luxury p-8 mb-8">
          <div className="flex items-center gap-6">
            <div className="w-20 h-20 rounded-full bg-gradient-to-br from-cheqk-gold to-yellow-600 flex items-center justify-center text-cheqk-black text-3xl font-luxury font-bold">
              {user.name.charAt(0).toUpperCase()}
            </div>
            <div>
              <h1 className="text-3xl font-luxury text-white mb-2">{user.name}</h1>
              <p className="text-gray-400">{user.email}</p>
              <p className="text-sm text-gray-500 mt-1">
                Miembro desde {new Date(user.createdAt).toLocaleDateString('es-ES', { month: 'long', year: 'numeric' })}
              </p>
            </div>
          </div>
        </div>

        {/* Orders Section */}
        <div className="mb-8">
          <h2 className="text-2xl font-luxury text-white mb-6">Historial de Pedidos</h2>
          
          {orders.length === 0 ? (
            <div className="card-luxury p-12 text-center">
              <svg className="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              <p className="text-gray-400 mb-4">Aún no has realizado ningún pedido</p>
              <Link to="/" className="btn-gold inline-block">Explorar Productos</Link>
            </div>
          ) : (
            <div className="space-y-4">
              {orders.map(order => (
                <div key={order.id} className="card-luxury p-6">
                  <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                    <div>
                      <p className="text-lg font-luxury text-white">{order.id}</p>
                      <p className="text-sm text-gray-400">
                        {new Date(order.date).toLocaleDateString('es-ES', { 
                          day: 'numeric', 
                          month: 'long', 
                          year: 'numeric',
                          hour: '2-digit',
                          minute: '2-digit'
                        })}
                      </p>
                    </div>
                    <div className="text-right">
                      <p className="text-xl text-cheqk-gold font-semibold">${order.total.toLocaleString()}</p>
                      <span className={`inline-block px-3 py-1 text-xs font-semibold ${
                        order.status === 'pending' 
                          ? 'bg-yellow-900/50 text-yellow-400' 
                          : 'bg-green-900/50 text-green-400'
                      }`}>
                        {order.status === 'pending' ? 'Pendiente de Pago' : 'Completado'}
                      </span>
                    </div>
                  </div>

                  {/* Order Items */}
                  <div className="border-t border-cheqk-dark-gray pt-4">
                    <p className="text-sm text-gray-500 mb-3">Productos:</p>
                    <div className="space-y-2">
                      {order.items.map((item, index) => (
                        <div key={index} className="flex justify-between text-sm">
                          <span className="text-gray-400">
                            {item.name} × {item.quantity}
                          </span>
                          <span className="text-white">
                            ${(item.price * item.quantity).toLocaleString()}
                          </span>
                        </div>
                      ))}
                    </div>
                  </div>

                  {/* Payment Method */}
                  <div className="border-t border-cheqk-dark-gray pt-4 mt-4">
                    <p className="text-sm text-gray-500">
                      Método de pago: <span className="text-gray-400 capitalize">{order.paymentMethod}</span>
                    </p>
                  </div>

                  {/* Actions */}
                  {order.status === 'pending' && (
                    <div className="border-t border-cheqk-dark-gray pt-4 mt-4">
                      <p className="text-sm text-gray-400 mb-3">
                        Instrucciones de pago enviadas a tu correo electrónico.
                      </p>
                      <button className="btn-outline text-sm">
                        Ver Instrucciones de Pago
                      </button>
                    </div>
                  )}
                </div>
              ))}
            </div>
          )}
        </div>

        {/* Account Settings */}
        <div className="card-luxury p-6">
          <h2 className="text-xl font-luxury text-white mb-4">Configuración de Cuenta</h2>
          <div className="space-y-4">
            <div className="flex justify-between items-center py-3 border-b border-cheqk-dark-gray">
              <span className="text-gray-400">Notificaciones por email</span>
              <span className="text-cheqk-gold">Activadas</span>
            </div>
            <div className="flex justify-between items-center py-3 border-b border-cheqk-dark-gray">
              <span className="text-gray-400">Acceso anticipado</span>
              <span className="text-cheqk-gold">Disponible</span>
            </div>
            <div className="flex justify-between items-center py-3">
              <span className="text-gray-400">Soporte prioritario</span>
              <span className="text-cheqk-gold">24/7</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProfilePage;
