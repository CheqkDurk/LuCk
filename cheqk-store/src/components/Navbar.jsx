import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { useAuth } from '../context/AuthContext';

const Navbar = () => {
  const { getCartCount } = useCart();
  const { user, logout, isAuthenticated } = useAuth();
  const cartCount = getCartCount();

  return (
    <nav className="bg-cheqk-charcoal border-b border-cheqk-dark-gray sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-20">
          {/* Logo */}
          <Link to="/" className="flex items-center space-x-2">
            <span className="text-3xl font-luxury text-cheqk-gold tracking-wider">CHEQK</span>
          </Link>

          {/* Navigation Links */}
          <div className="hidden md:flex items-center space-x-8">
            <Link to="/" className="text-gray-300 hover:text-cheqk-gold transition-colors duration-200">
              Productos
            </Link>
            <Link to="/limited" className="text-gray-300 hover:text-cheqk-gold transition-colors duration-200">
              Edición Limitada
            </Link>
          </div>

          {/* Right Section */}
          <div className="flex items-center space-x-6">
            {/* Cart */}
            <Link to="/cart" className="relative text-gray-300 hover:text-cheqk-gold transition-colors duration-200">
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              {cartCount > 0 && (
                <span className="absolute -top-2 -right-2 bg-cheqk-gold text-cheqk-black text-xs w-5 h-5 rounded-full flex items-center justify-center font-semibold">
                  {cartCount}
                </span>
              )}
            </Link>

            {/* User */}
            {isAuthenticated ? (
              <div className="flex items-center space-x-4">
                <Link to="/profile" className="text-gray-300 hover:text-cheqk-gold transition-colors duration-200">
                  <span className="text-sm">{user.name}</span>
                </Link>
                <button
                  onClick={logout}
                  className="text-gray-300 hover:text-cheqk-gold transition-colors duration-200 text-sm"
                >
                  Salir
                </button>
              </div>
            ) : (
              <Link to="/login" className="btn-outline text-sm">
                Iniciar Sesión
              </Link>
            )}
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
