import { useState } from 'react';
import { products, categories } from '../data/products';
import ProductCard from '../components/ProductCard';

const HomePage = () => {
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [showLimitedOnly, setShowLimitedOnly] = useState(false);

  const filteredProducts = products.filter(product => {
    const categoryMatch = selectedCategory === 'all' || product.category === selectedCategory;
    const limitedMatch = !showLimitedOnly || product.limited;
    return categoryMatch && limitedMatch;
  });

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-b from-cheqk-charcoal to-cheqk-black opacity-90"></div>
        <img
          src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1920&h=1080&fit=crop"
          alt="Hero"
          className="absolute inset-0 w-full h-full object-cover opacity-30"
        />
        <div className="relative z-10 text-center px-4">
          <h1 className="text-5xl md:text-7xl font-luxury text-white mb-6 tracking-wider">
            CHEQK
          </h1>
          <p className="text-xl md:text-2xl text-cheqk-silver mb-8 font-light max-w-2xl mx-auto">
            Tecnología de lujo para quienes exigen lo extraordinario
          </p>
          <a href="#products" className="btn-gold inline-block">
            Explorar Colección
          </a>
        </div>
      </section>

      {/* Products Section */}
      <section id="products" className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {/* Filters */}
        <div className="flex flex-col md:flex-row justify-between items-center mb-12 gap-4">
          {/* Category Filter */}
          <div className="flex flex-wrap gap-2 justify-center">
            {categories.map(category => (
              <button
                key={category.id}
                onClick={() => setSelectedCategory(category.id)}
                className={`px-4 py-2 text-sm transition-all duration-200 ${
                  selectedCategory === category.id
                    ? 'bg-cheqk-gold text-cheqk-black'
                    : 'bg-cheqk-dark-gray text-gray-300 hover:bg-cheqk-charcoal'
                }`}
              >
                {category.name}
              </button>
            ))}
          </div>

          {/* Limited Edition Toggle */}
          <button
            onClick={() => setShowLimitedOnly(!showLimitedOnly)}
            className={`px-6 py-2 text-sm font-semibold transition-all duration-200 ${
              showLimitedOnly
                ? 'bg-cheqk-gold text-cheqk-black'
                : 'border border-cheqk-gold text-cheqk-gold hover:bg-cheqk-gold hover:text-cheqk-black'
            }`}
          >
            {showLimitedOnly ? 'Ver Todos' : 'Solo Edición Limitada'}
          </button>
        </div>

        {/* Products Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          {filteredProducts.map(product => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>

        {filteredProducts.length === 0 && (
          <div className="text-center py-20">
            <p className="text-gray-400 text-lg">No se encontraron productos con estos filtros.</p>
          </div>
        )}
      </section>

      {/* Features Section */}
      <section className="bg-cheqk-charcoal py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
              <div className="text-cheqk-gold text-4xl mb-4">✦</div>
              <h3 className="text-xl font-luxury text-white mb-2">Exclusividad</h3>
              <p className="text-gray-400">Productos de edición limitada y acceso anticipado</p>
            </div>
            <div>
              <div className="text-cheqk-gold text-4xl mb-4">◆</div>
              <h3 className="text-xl font-luxury text-white mb-2">Calidad Premium</h3>
              <p className="text-gray-400">Materiales de la más alta calidad y acabados perfectos</p>
            </div>
            <div>
              <div className="text-cheqk-gold text-4xl mb-4">◈</div>
              <h3 className="text-xl font-luxury text-white mb-2">Servicio Concierge</h3>
              <p className="text-gray-400">Atención personalizada 24/7 para clientes VIP</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default HomePage;
