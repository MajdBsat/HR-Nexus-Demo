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
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
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

  login: (credentials) => {
    return apiClient.post("/api/auth/login", credentials);
  },

  logout: () => {
    return apiClient.post("/api/auth/logout").finally(() => {
      localStorage.removeItem("token");
    });
  },
};

export { apiClient, authService };
