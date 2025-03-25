import axios from "axios";

// Create a custom axios instance with base configuration
const apiClient = axios.create({
  baseURL: "http://localhost:8000",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
  withCredentials: true, // Important for cookies, authorization headers with CORS
});

// Add a request interceptor to set the auth token if available
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    const tokenType = localStorage.getItem("token_type") || "bearer";

    if (token) {
      config.headers["Authorization"] = `${
        tokenType.charAt(0).toUpperCase() + tokenType.slice(1)
      } ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Add a response interceptor to handle common errors
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    // Handle 401 Unauthorized errors (expired token, etc.)
    if (error.response && error.response.status === 401) {
      localStorage.removeItem("token");
      // Optionally redirect to login page
      // window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

// Auth service functions
const authService = {
  register: (userData) => {
    return apiClient.post("/api/auth/register", userData);
  },

  login: async (credentials) => {
    const response = await apiClient.post("/api/auth/login", credentials);

    // Extract the token and other data
    const { token, token_type, user, expires_in } = response.data;

    if (token) {
      // Store token with type in localStorage
      localStorage.setItem("token", token);
      localStorage.setItem("token_type", token_type || "bearer");

      // Store user data
      localStorage.setItem("user", JSON.stringify(user));

      // Set token expiration time
      if (expires_in) {
        const expiresAt = new Date(new Date().getTime() + expires_in * 1000);
        localStorage.setItem("expires_at", expiresAt.toISOString());
      }
    }

    return response;
  },

  logout: () => {
    return apiClient.post("/api/auth/logout").finally(() => {
      localStorage.removeItem("token");
      localStorage.removeItem("token_type");
      localStorage.removeItem("user");
      localStorage.removeItem("expires_at");
    });
  },

  // Get the current authenticated user from localStorage
  getCurrentUser: () => {
    const userStr = localStorage.getItem("user");
    return userStr ? JSON.parse(userStr) : null;
  },

  // Check if the user is authenticated
  isAuthenticated: () => {
    const token = localStorage.getItem("token");
    const expiresAt = localStorage.getItem("expires_at");

    if (!token) return false;

    // Check if token is expired
    if (expiresAt) {
      return new Date().getTime() < new Date(expiresAt).getTime();
    }

    return true;
  },
};

export { apiClient, authService };
