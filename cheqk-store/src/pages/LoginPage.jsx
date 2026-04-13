import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const LoginPage = () => {
  const [isLogin, setIsLogin] = useState(true);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [name, setName] = useState('');
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  const { login, register } = useAuth();
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    setError('');
    setSuccess('');

    if (isLogin) {
      const result = login(email, password);
      if (result.success) {
        navigate('/');
      } else {
        setError(result.message);
      }
    } else {
      if (!name || !email || !password) {
        setError('Todos los campos son requeridos');
        return;
      }
      const result = register(email, password, name);
      if (result.success) {
        setSuccess('Registro exitoso. Ahora puedes iniciar sesión.');
        setIsLogin(true);
        setEmail('');
        setPassword('');
        setName('');
      } else {
        setError(result.message);
      }
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-cheqk-black py-12 px-4">
      <div className="max-w-md w-full">
        {/* Logo */}
        <div className="text-center mb-8">
          <Link to="/" className="text-4xl font-luxury text-cheqk-gold tracking-wider">
            CHEQK
          </Link>
        </div>

        {/* Form Card */}
        <div className="card-luxury p-8 rounded-sm">
          <h2 className="text-2xl font-luxury text-white mb-6 text-center">
            {isLogin ? 'Iniciar Sesión' : 'Crear Cuenta'}
          </h2>

          {error && (
            <div className="bg-red-900/30 border border-red-500 text-red-400 px-4 py-3 mb-6 text-sm">
              {error}
            </div>
          )}

          {success && (
            <div className="bg-green-900/30 border border-green-500 text-green-400 px-4 py-3 mb-6 text-sm">
              {success}
            </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-6">
            {!isLogin && (
              <div>
                <label htmlFor="name" className="block text-sm text-gray-400 mb-2">
                  Nombre Completo
                </label>
                <input
                  type="text"
                  id="name"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full bg-cheqk-dark-gray border border-cheqk-dark-gray text-white px-4 py-3 focus:outline-none focus:border-cheqk-gold transition-colors"
                  placeholder="Tu nombre"
                />
              </div>
            )}

            <div>
              <label htmlFor="email" className="block text-sm text-gray-400 mb-2">
                Email
              </label>
              <input
                type="email"
                id="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full bg-cheqk-dark-gray border border-cheqk-dark-gray text-white px-4 py-3 focus:outline-none focus:border-cheqk-gold transition-colors"
                placeholder="tu@email.com"
                required
              />
            </div>

            <div>
              <label htmlFor="password" className="block text-sm text-gray-400 mb-2">
                Contraseña
              </label>
              <input
                type="password"
                id="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full bg-cheqk-dark-gray border border-cheqk-dark-gray text-white px-4 py-3 focus:outline-none focus:border-cheqk-gold transition-colors"
                placeholder="••••••••"
                required
              />
            </div>

            <button type="submit" className="w-full btn-gold">
              {isLogin ? 'Iniciar Sesión' : 'Registrarse'}
            </button>
          </form>

          {/* Toggle Login/Register */}
          <div className="mt-6 text-center">
            <p className="text-gray-400 text-sm">
              {isLogin ? '¿No tienes cuenta?' : '¿Ya tienes cuenta?'}{' '}
              <button
                onClick={() => {
                  setIsLogin(!isLogin);
                  setError('');
                  setSuccess('');
                }}
                className="text-cheqk-gold hover:text-yellow-500 transition-colors font-semibold"
              >
                {isLogin ? 'Regístrate aquí' : 'Inicia sesión'}
              </button>
            </p>
          </div>
        </div>

        {/* Benefits */}
        <div className="mt-8 text-center text-gray-500 text-sm">
          <p>Al crear una cuenta aceptas nuestros términos y condiciones</p>
          <p className="mt-2">Acceso exclusivo a ediciones limitadas y lanzamientos anticipados</p>
        </div>
      </div>
    </div>
  );
};

export default LoginPage;
