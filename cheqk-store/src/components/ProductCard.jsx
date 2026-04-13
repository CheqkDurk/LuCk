import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';

const ProductCard = ({ product }) => {
  const { addToCart } = useCart();

  return (
    <div className="card-luxury rounded-sm overflow-hidden group">
      {/* Image */}
      <div className="relative overflow-hidden aspect-square">
        <img
          src={product.image}
          alt={product.name}
          className="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
        />
        
        {/* Limited Edition Badge */}
        {product.limited && (
          <div className="absolute top-3 right-3 bg-cheqk-gold text-cheqk-black px-3 py-1 text-xs font-semibold tracking-wider">
            EDICIÓN LIMITADA
          </div>
        )}

        {/* Quick Add Button */}
        <div className="absolute inset-x-0 bottom-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <button
            onClick={() => addToCart(product)}
            className="w-full btn-gold text-sm"
          >
            Añadir al Carrito
          </button>
        </div>
      </div>

      {/* Product Info */}
      <div className="p-5">
        <Link to={`/product/${product.id}`}>
          <h3 className="text-lg font-luxury text-white mb-2 group-hover:text-cheqk-gold transition-colors duration-200">
            {product.name}
          </h3>
        </Link>
        
        <p className="text-cheqk-silver text-sm mb-3 line-clamp-2">
          {product.description}
        </p>
        
        <div className="flex justify-between items-center">
          <span className="text-xl font-semibold text-cheqk-gold">
            ${product.price.toLocaleString()}
          </span>
          <span className={`text-xs ${product.stock < 5 ? 'text-red-400' : 'text-gray-500'}`}>
            {product.stock < 5 ? `Solo ${product.stock} restantes` : 'En stock'}
          </span>
        </div>
      </div>
    </div>
  );
};

export default ProductCard;
