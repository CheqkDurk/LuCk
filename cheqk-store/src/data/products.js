export const products = [
  {
    id: '1',
    name: 'Quantum Phone X',
    price: 2999,
    category: 'smartphones',
    description: 'El smartphone más avanzado del mundo. Procesador cuántico de 7nm, pantalla OLED de 6.8", 24GB RAM, 1TB almacenamiento. Edición limitada numerada.',
    image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&h=600&fit=crop',
    limited: true,
    specs: ['Procesador Quantum Q1', 'Pantalla OLED 6.8"', '24GB RAM', '1TB Storage', 'Cámara 200MP'],
    stock: 5
  },
  {
    id: '2',
    name: 'Diamond Watch Elite',
    price: 15999,
    category: 'wearables',
    description: 'Reloj inteligente con acabados en oro de 18 quilates y diamantes certificados. Funcionalidades avanzadas de salud y conectividad global.',
    image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop',
    limited: true,
    specs: ['Oro 18K', 'Diamantes VS1', 'Sapphire Crystal', 'Autonomía 30 días', 'GPS + Cellular'],
    stock: 3
  },
  {
    id: '3',
    name: 'Titanium Laptop Pro',
    price: 8999,
    category: 'laptops',
    description: 'Portátil de ultra lujo fabricado en titanio aeroespacial. Rendimiento extremo para profesionales exigentes.',
    image: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=600&fit=crop',
    limited: false,
    specs: ['Chasis Titanio', 'Intel Core i9', '64GB RAM', 'RTX 4090', 'Pantalla Mini-LED 4K'],
    stock: 12
  },
  {
    id: '4',
    name: 'AudioPhile Headphones',
    price: 4599,
    category: 'audio',
    description: 'Auriculares de alta fidelidad con cancelación de ruido adaptativa y materiales premium.',
    image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop',
    limited: true,
    specs: ['Drivers 50mm', 'ANC Adaptativo', '50h batería', 'Cuero italiano', 'Hi-Res Audio'],
    stock: 8
  },
  {
    id: '5',
    name: 'Smart Home Hub Gold',
    price: 3299,
    category: 'home',
    description: 'Centro de control domótico con acabado en oro rosa. Controla tu hogar con elegancia.',
    image: 'https://images.unsplash.com/photo-1558002038-1091a1661116?w=600&h=600&fit=crop',
    limited: false,
    specs: ['Gold Plated', 'Voice AI', 'Matter Compatible', 'Touch Display 10"', 'Security Hub'],
    stock: 20
  },
  {
    id: '6',
    name: 'VR Crown headset',
    price: 6799,
    category: 'gaming',
    description: 'Experiencia de realidad virtual sin precedentes. Resolución 8K por ojo, tracking ocular y háptica avanzada.',
    image: 'https://images.unsplash.com/photo-1622979135225-d2ba269fb1bd?w=600&h=600&fit=crop',
    limited: true,
    specs: ['8K per eye', 'Eye Tracking', 'Haptic Feedback', '120Hz refresh', 'Wireless'],
    stock: 6
  },
  {
    id: '7',
    name: 'Drone Phantom Elite',
    price: 12499,
    category: 'drones',
    description: 'Drone profesional con cámara Hasselblad. Autonomía extendida y sistemas de seguridad redundantes.',
    image: 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=600&h=600&fit=crop',
    limited: false,
    specs: ['Cámara Hasselblad', '45min vuelo', 'Obstacle Avoidance', '8K Video', 'Range 15km'],
    stock: 10
  },
  {
    id: '8',
    name: 'Gaming Console Platinum',
    price: 5999,
    category: 'gaming',
    description: 'Consola de videojuegos edición platino. Incluye controller personalizado y juegos exclusivos.',
    image: 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=600&h=600&fit=crop',
    limited: true,
    specs: ['Platinum Finish', '2TB SSD', '8K Gaming', 'Ray Tracing', 'Exclusive Games'],
    stock: 4
  }
];

export const categories = [
  { id: 'all', name: 'Todos' },
  { id: 'smartphones', name: 'Smartphones' },
  { id: 'wearables', name: 'Wearables' },
  { id: 'laptops', name: 'Laptops' },
  { id: 'audio', name: 'Audio' },
  { id: 'home', name: 'Smart Home' },
  { id: 'gaming', name: 'Gaming' },
  { id: 'drones', name: 'Drones' }
];
