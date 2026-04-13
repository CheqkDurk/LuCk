import { products } from '../data/products';
import ProductCard from '../components/ProductCard';

const LimitedEditionPage = () => {
  const limitedProducts = products.filter(p => p.limited);

  return (
    <div className="min-h-screen bg-cheqk-black py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h1 className="text-4xl md:text-5xl font-luxury text-white mb-4">
            Edición Limitada
          </h1>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Piezas exclusivas disponibles en cantidades restringidas. 
            Cada producto es numerado y certificado para garantizar su autenticidad.
          </p>
        </div>

        {/* Featured Badge */}
        <div className="bg-gradient-to-r from-cheqk-gold/20 via-cheqk-gold/10 to-cheqk-gold/20 border border-cheqk-gold/30 p-6 mb-12 text-center">
          <p className="text-cheqk-gold font-semibold tracking-wider">
            ✦ SOLO PARA MIEMBROS CHEQK ✦
          </p>
          <p className="text-gray-400 text-sm mt-2">
            Registro requerido para comprar productos de edición limitada
          </p>
        </div>

        {/* Products Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          {limitedProducts.map(product => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>

        {/* Info Section */}
        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="card-luxury p-6 text-center">
            <div className="text-cheqk-gold text-3xl mb-4">🏆</div>
            <h3 className="text-lg font-luxury text-white mb-2">Autenticidad Certificada</h3>
            <p className="text-gray-400 text-sm">
              Cada pieza incluye certificado de autenticidad y número de serie único.
            </p>
          </div>
          <div className="card-luxury p-6 text-center">
            <div className="text-cheqk-gold text-3xl mb-4">📦</div>
            <h3 className="text-lg font-luxury text-white mb-2">Embalaje Premium</h3>
            <p className="text-gray-400 text-sm">
              Presentación en caja de lujo diseñada específicamente para cada producto.
            </p>
          </div>
          <div className="card-luxury p-6 text-center">
            <div className="text-cheqk-gold text-3xl mb-4">💎</div>
            <h3 className="text-lg font-luxury text-white mb-2">Valor de Inversión</h3>
            <p className="text-gray-400 text-sm">
              Productos que mantienen y aumentan su valor con el tiempo.
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LimitedEditionPage;
