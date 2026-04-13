import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import { CartProvider } from './context/CartContext';
import Navbar from './components/Navbar';
import HomePage from './pages/HomePage';
import ProductDetailPage from './pages/ProductDetailPage';
import CartPage from './pages/CartPage';
import CheckoutPage from './pages/CheckoutPage';
import LoginPage from './pages/LoginPage';
import ProfilePage from './pages/ProfilePage';
import LimitedEditionPage from './pages/LimitedEditionPage';

const Footer = () => (
  <footer className="bg-cheqk-charcoal border-t border-cheqk-dark-gray py-12">
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
        {/* Brand */}
        <div>
          <h3 className="text-2xl font-luxury text-cheqk-gold mb-4">CHEQK</h3>
          <p className="text-gray-400 text-sm">
            Tecnología de lujo para quienes exigen lo extraordinario.
          </p>
        </div>
        
        {/* Links */}
        <div>
          <h4 className="text-white font-semibold mb-4">Colección</h4>
          <ul className="space-y-2 text-gray-400 text-sm">
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Smartphones</a></li>
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Wearables</a></li>
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Audio</a></li>
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Edición Limitada</a></li>
          </ul>
        </div>
        
        {/* Services */}
        <div>
          <h4 className="text-white font-semibold mb-4">Servicios</h4>
          <ul className="space-y-2 text-gray-400 text-sm">
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Concierge</a></li>
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Envío Asegurado</a></li>
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Garantía Extendida</a></li>
            <li><a href="#" className="hover:text-cheqk-gold transition-colors">Soporte 24/7</a></li>
          </ul>
        </div>
        
        {/* Contact */}
        <div>
          <h4 className="text-white font-semibold mb-4">Contacto</h4>
          <ul className="space-y-2 text-gray-400 text-sm">
            <li>concierge@cheqk.com</li>
            <li>+1 (888) CHEQK-LUX</li>
            <li>Beverly Hills, CA</li>
          </ul>
        </div>
      </div>
      
      <div className="border-t border-cheqk-dark-gray mt-8 pt-8 text-center text-gray-500 text-sm">
        <p>&copy; {new Date().getFullYear()} Cheqk. Todos los derechos reservados.</p>
        <p className="mt-2">Términos y Condiciones | Política de Privacidad</p>
      </div>
    </div>
  </footer>
);

function App() {
  return (
    <AuthProvider>
      <CartProvider>
        <Router>
          <div className="min-h-screen bg-cheqk-black flex flex-col">
            <Navbar />
            <main className="flex-grow">
              <Routes>
                <Route path="/" element={<HomePage />} />
                <Route path="/limited" element={<LimitedEditionPage />} />
                <Route path="/product/:id" element={<ProductDetailPage />} />
                <Route path="/cart" element={<CartPage />} />
                <Route path="/checkout" element={<CheckoutPage />} />
                <Route path="/login" element={<LoginPage />} />
                <Route path="/profile" element={<ProfilePage />} />
              </Routes>
            </main>
            <Footer />
          </div>
        </Router>
      </CartProvider>
    </AuthProvider>
  );
}

export default App;
