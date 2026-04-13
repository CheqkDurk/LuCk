import { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext(null);

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth debe ser usado dentro de un AuthProvider');
  }
  return context;
};

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(() => {
    const savedUser = localStorage.getItem('cheqk_user');
    return savedUser ? JSON.parse(savedUser) : null;
  });

  const [users, setUsers] = useState(() => {
    const savedUsers = localStorage.getItem('cheqk_users_db');
    return savedUsers ? JSON.parse(savedUsers) : [];
  });

  const [orders, setOrders] = useState(() => {
    const savedOrders = localStorage.getItem('cheqk_orders');
    return savedOrders ? JSON.parse(savedOrders) : [];
  });

  useEffect(() => {
    localStorage.setItem('cheqk_users_db', JSON.stringify(users));
  }, [users]);

  useEffect(() => {
    localStorage.setItem('cheqk_orders', JSON.stringify(orders));
  }, [orders]);

  const register = (email, password, name) => {
    const existingUser = users.find(u => u.email === email);
    if (existingUser) {
      return { success: false, message: 'El email ya está registrado' };
    }

    const newUser = {
      id: Date.now().toString(),
      email,
      password,
      name,
      createdAt: new Date().toISOString(),
      orders: []
    };

    setUsers([...users, newUser]);
    return { success: true, message: 'Registro exitoso' };
  };

  const login = (email, password) => {
    const foundUser = users.find(u => u.email === email && u.password === password);
    if (!foundUser) {
      return { success: false, message: 'Credenciales inválidas' };
    }

    const userData = { ...foundUser };
    delete userData.password;
    setUser(userData);
    localStorage.setItem('cheqk_user', JSON.stringify(userData));
    return { success: true, user: userData };
  };

  const logout = () => {
    setUser(null);
    localStorage.removeItem('cheqk_user');
  };

  const addOrder = (order) => {
    const newOrder = {
      ...order,
      id: `ORD-${Date.now()}`,
      date: new Date().toISOString(),
      status: 'pending'
    };

    setOrders([...orders, newOrder]);

    if (user) {
      const updatedUser = { ...user, orders: [...user.orders, newOrder.id] };
      setUser(updatedUser);
      localStorage.setItem('cheqk_user', JSON.stringify(updatedUser));

      const updatedUsers = users.map(u => 
        u.id === user.id ? { ...u, orders: [...u.orders, newOrder.id] } : u
      );
      setUsers(updatedUsers);
    }

    return newOrder;
  };

  const getUserOrders = () => {
    if (!user) return [];
    return orders.filter(order => order.userId === user.id);
  };

  return (
    <AuthContext.Provider value={{
      user,
      isAuthenticated: !!user,
      register,
      login,
      logout,
      addOrder,
      getUserOrders
    }}>
      {children}
    </AuthContext.Provider>
  );
};
