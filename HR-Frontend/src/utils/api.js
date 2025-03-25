import axios from "axios";

// Define the API base URL
const API_BASE_URL = "http://localhost:8000";

// Create axios instance with default config
const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
  },
  withCredentials: true, // Include cookies in cross-site requests
});

// Add a request interceptor to include auth token
api.interceptors.request.use(
  (config) => {
    // Get JWT token from localStorage
    const token = localStorage.getItem("token");

    // If token exists, add it to the authorization header
    if (token) {
      // Use Bearer format for auth:api middleware
      config.headers.Authorization = `Bearer ${token}`;
    }

    console.log(
      "API Request:",
      config.method.toUpperCase(),
      config.baseURL + config.url
    );
    return config;
  },
  (error) => {
    console.error("API Request Error:", error);
    return Promise.reject(error);
  }
);

// Add a response interceptor to handle common errors
api.interceptors.response.use(
  (response) => {
    console.log("API Response:", response.status, response.config.url);
    return response;
  },
  (error) => {
    console.error(
      "API Response Error:",
      error.response?.status,
      error.config?.url,
      error
    );

    // Handle specific error cases
    if (error.response) {
      // Handle 401 Unauthorized errors (token expired, etc.)
      if (error.response.status === 401) {
        console.log("Auth error - clearing token and redirecting to login");
        localStorage.removeItem("token");
        window.location.href = "/login";
      }

      // Handle 403 Forbidden errors
      if (error.response.status === 403) {
        console.error("Permission denied");
      }

      // Handle 500 Internal Server Error
      if (error.response.status === 500) {
        console.error("Server error:", error.response.data);
      }
    }

    return Promise.reject(error);
  }
);

export default api;
