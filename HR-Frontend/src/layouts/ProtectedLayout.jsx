import React, { useState, useEffect } from "react";
import { Navigate, Outlet, useNavigate, useLocation } from "react-router-dom";
import Sidebar from "../components/Sidebar";
import { authService } from "../services/apiService";
import '../styles/ProtectedLayout.css';

const ProtectedLayout = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(true);
  const [isLoading, setIsLoading] = useState(true);
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false);
  const navigate = useNavigate();
  const location = useLocation();

  // Check authentication on component mount and location change
  useEffect(() => {
    const checkAuth = () => {
      const isAuth = authService.isAuthenticated();
      setIsAuthenticated(isAuth);
      setIsLoading(false);
      
      if (!isAuth) {
        navigate('/login');
      }
    };
    
    checkAuth();
  }, [navigate, location]);

  // Handle logout logic
  const handleLogout = async () => {
    try {
      await authService.logout();
      navigate('/login');
    } catch (error) {
      console.error('Logout error:', error);
    }
  };

  // Handle sidebar collapsing
  const toggleSidebar = () => {
    setSidebarCollapsed(!sidebarCollapsed);
    // Store sidebar state in localStorage for persistence
    localStorage.setItem('sidebarCollapsed', !sidebarCollapsed);
  };

  // Initialize sidebar state from localStorage on mount
  useEffect(() => {
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState !== null) {
      setSidebarCollapsed(savedState === 'true');
    }
  }, []);

  if (isLoading) {
    return (
      <div className="loading-screen">
        <div className="loading-spinner"></div>
      </div>
    );
  }

  if (!isAuthenticated) {
    return <Navigate to="/login" />;
  }

  return (
    <div className="app-container">
      <Sidebar
        collapsed={sidebarCollapsed}
        onToggle={toggleSidebar}
        onLogout={handleLogout}
      />
      <main className={`app-content ${sidebarCollapsed ? "expanded" : ""}`}>
        <div className="page-container">
          <Outlet />
        </div>
      </main>
    </div>
  );
};

export default ProtectedLayout;
