import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { authService } from "../../services/apiService";
import "./index.css";

const Login = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      await authService.login(formData);

      // The token, user, and other data are already stored in localStorage by authService

      // Check user type to determine redirect
      const user = authService.getCurrentUser();
      if (user && user.user_type !== undefined) {
        // Redirect based on user type
        switch (user.user_type) {
          case 0: // Guest
            navigate("/emp/recruitment/jobs");
            break;
          case 1: // Employee
            navigate("/emp/recruitment/jobs");
            break;
          case 2: // HR
            navigate("/hr/recruitment");
            break;
          default:
            navigate("/login");
        }
      } else {
        // Default redirect
        navigate("/hr/recruitment");
      }
    } catch (err) {
      setError(
        err.response?.data?.message || "Login failed. Please try again."
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-container">
      <div className="login-box">
        <h2>Login to HR-Nexus</h2>
        {error && <div className="error-message">{error}</div>}
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </div>
          <div className="form-group">
            <label htmlFor="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              value={formData.password}
              onChange={handleChange}
              required
            />
          </div>
          <button type="submit" disabled={loading}>
            {loading ? "Logging in..." : "Login"}
          </button>
        </form>
        <div className="register-link">
          Don't have an account? <a href="/register">Register here</a>
        </div>
      </div>
    </div>
  );
};

export default Login;
