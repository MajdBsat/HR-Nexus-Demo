import axios from "axios";

const API_URL = "http://localhost:8000/api";

const jwtService = {
  // Register a new user
  register: async (userData) => {
    try {
      const response = await axios.post(`${API_URL}/auth/register`, userData);
      if (response.data.token) {
        localStorage.setItem("user", JSON.stringify(response.data));
      }
      return response.data;
    } catch (error) {
      throw error.response?.data || { message: "Registration failed" };
    }
  },

  // Login user
  login: async (credentials) => {
    try {
      const response = await axios.post(`${API_URL}/auth/login`, credentials);
      if (response.data.token) {
        localStorage.setItem("user", JSON.stringify(response.data));
      }
      return response.data;
    } catch (error) {
      throw error.response?.data || { message: "Login failed" };
    }
  },

  // Logout user
  logout: () => {
    localStorage.removeItem("user");
  },

  // Get current user
  getCurrentUser: () => {
    return JSON.parse(localStorage.getItem("user"));
  },

  // Get auth header
  getAuthHeader: () => {
    const user = JSON.parse(localStorage.getItem("user"));
    if (user && user.token) {
      return { Authorization: `Bearer ${user.token}` };
    }
    return {};
  },
};

export default jwtService;
