import { useParams, Link } from 'react-router-dom';
import { useState } from 'react';
import { products } from '../data/products';
import { useCart } from '../context/CartContext';

const ProductDetailPage = () => {
  const { id } = useParams();
  const { addToCart } = useCart();
  const [quantity, setQuantity] = useState(1);
  const [added, setAdded] = useState(false);

  const product = products.find(p => p.id === id);

  if (!product) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-luxury text-white mb-4">Producto no encontrado</h2>
          <Link to="/" className="btn-outline">Volver al inicio</Link>
        </div>
      </div>
    );
  }

  const handleAddToCart = () => {
    for (let i = 0; i < quantity; i++) {
      addToCart(product);
    }
    setAdded(true);
    setTimeout(() => setAdded(false), 2000);
  };

  return (
    <div className="min-h-screen bg-cheqk-black">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Breadcrumb */}
        <nav className="mb-8">
          <Link to="/" className="text-gray-400 hover:text-cheqk-gold transition-colors">
            Inicio
          </Link>
          <span className="mx-2 text-gray-600">/</span>
          <span className="text-gray-400">{product.name}</span>
        </nav>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Image */}
          <div className="relative aspect-square rounded-sm overflow-hidden card-luxury">
            <img
              src={product.image}
              alt={product.name}
              className="w-full h-full object-cover"
            />
            {product.limited && (
              <div className="absolute top-4 right-4 bg-cheqk-gold text-cheqk-black px-4 py-2 text-sm font-semibold tracking-wider">
                EDICIÓN LIMITADA
              </div>
            )}
          </div>

          {/* Product Info */}
          <div className="flex flex-col justify-center">
            <h1 className="text-4xl md:text-5xl font-luxury text-white mb-4">
              {product.name}
            </h1>

            <p className="text-3xl text-cheqk-gold font-semibold mb-6">
              ${product.price.toLocaleString()}
            </p>

            <p className="text-gray-300 text-lg mb-8 leading-relaxed">
              {product.description}
            </p>

            {/* Specifications */}
            <div className="mb-8">
              <h3 className="text-xl font-luxury text-white mb-4">Especificaciones Técnicas</h3>
              <ul className="space-y-2">
                {product.specs.map((spec, index) => (
                  <li key={index} className="flex items-center text-gray-400">
                    <span className="text-cheqk-gold mr-3">◈</span>
                    {spec}
                  </li>
                ))}
              </ul>
            </div>

            {/* Stock Status */}
            <div className={`mb-6 text-sm ${product.stock < 5 ? 'text-red-400' : 'text-green-400'}`}>
              {product.stock < 5 
                ? `⚠ Solo ${product.stock} unidades disponibles` 
                : '✓ Disponible para envío inmediato'}
            </div>

            {/* Quantity & Add to Cart */}
            <div className="flex gap-4 mb-6">
              <div className="flex items-center border border-cheqk-dark-gray">
                <button
                  onClick={() => setQuantity(Math.max(1, quantity - 1))}
                  className="px-4 py-3 text-gray-400 hover:text-white transition-colors"
                >
                  −
                </button>
                <span className="px-6 py-3 text-white">{quantity}</span>
                <button
                  onClick={() => setQuantity(Math.min(product.stock, quantity + 1))}
                  className="px-4 py-3 text-gray-400 hover:text-white transition-colors"
                >
                  +
                </button>
              </div>

              <button
                onClick={handleAddToCart}
                disabled={added}
                className={`flex-1 btn-gold ${added ? 'opacity-75' : ''}`}
              >
                {added ? '¡Añadido!' : 'Añadir al Carrito'}
              </button>
            </div>

            {/* Additional Info */}
            <div className="border-t border-cheqk-dark-gray pt-6 space-y-3 text-sm text-gray-400">
              <div className="flex justify-between">
                <span>Envío asegurado incluido</span>
                <span className="text-cheqk-gold">Gratis</span>
              </div>
              <div className="flex justify-between">
                <span>Garantía extendida</span>
                <span className="text-cheqk-gold">3 años</span>
              </div>
              <div className="flex justify-between">
                <span>Soporte prioritario</span>
                <span className="text-cheqk-gold">24/7</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductDetailPage;
