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

    // Special handling for user updates
    if (config.method === "put" && config.url.includes("/api/users/")) {
      const data = config.data;

      // If this is a JSON payload
      if (typeof data === "object" && data !== null) {
        console.log("⚠️ Special handling for user update:", data);

        // Try treating department_id as a separate param
        // Extract the user ID from the URL for debugging
        // const userId = config.url.split('/').pop();

        // Only include fields that need to be updated
        const updateFields = {
          name: data.name,
          email: data.email,
          user_type: data.user_type,
        };

        // Handle department_id separately depending on if it's provided
        if (data.department_id !== null && data.department_id !== undefined) {
          updateFields.department_id = Number(data.department_id);
        }

        console.log("Simplified update data:", updateFields);

        // Replace the original data with our simplified version
        config.data = updateFields;
      }
    }

    console.log(
      `🚀 [API Request] ${config.method.toUpperCase()} ${config.url}`,
      {
        headers: config.headers,
        data: config.data,
        params: config.params,
      }
    );
    return config;
  },
  (error) => {
    console.error("❌ [API Request Error]", error);
    return Promise.reject(error);
  }
);

// Add a response interceptor to handle common errors
apiClient.interceptors.response.use(
  (response) => {
    console.log(
      `✅ [API Response] ${
        response.status
      } ${response.config.method.toUpperCase()} ${response.config.url}`,
      {
        data: response.data,
        headers: response.headers,
      }
    );
    return response;
  },
  (error) => {
    // Handle 401 Unauthorized errors (expired token, etc.)
    if (error.response && error.response.status === 401) {
      localStorage.removeItem("token");
      // Optionally redirect to login page
      // window.location.href = '/login';
    }
    console.error(
      `❌ [API Response Error] ${
        error.config?.method?.toUpperCase() || "UNKNOWN"
      } ${error.config?.url || "UNKNOWN"}`,
      {
        status: error.response?.status,
        data: error.response?.data,
        headers: error.response?.headers,
        error: error.message,
      }
    );
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
