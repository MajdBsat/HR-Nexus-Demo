import React, { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import "../../styles/Register.css";

const Register = () => {
  const [formData, setFormData] = useState({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
    password_confirmation: "",
    department_id: "",
  });
  const [departments, setDepartments] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [validationErrors, setValidationErrors] = useState({});
  const navigate = useNavigate();

  useEffect(() => {
    const fetchDepartments = async () => {
      try {
        const response = await axios.get(
          "http://localhost:8000/api/departments"
        );
        setDepartments(response.data.data);
      } catch (err) {
        console.error("Error fetching departments:", err);
        setError("Failed to load departments. Please try again later.");
      }
    };

    fetchDepartments();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });

    // Clear validation error for this field when user types
    if (validationErrors[name]) {
      setValidationErrors({
        ...validationErrors,
        [name]: "",
      });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");
    setValidationErrors({});

    // Basic validation
    if (formData.password !== formData.password_confirmation) {
      setValidationErrors({
        ...validationErrors,
        password_confirmation: "Passwords do not match",
      });
      setLoading(false);
      return;
    }

    try {
      const response = await axios.post(
        "http://localhost:8000/api/auth/register",
        formData
      );
      localStorage.setItem("token", response.data.token);
      localStorage.setItem("user", JSON.stringify(response.data.user));
      navigate("/dashboard");
    } catch (err) {
      console.error("Registration error:", err);

      if (err.response?.data?.errors) {
        setValidationErrors(err.response.data.errors);
      } else {
        setError(
          err.response?.data?.message ||
            "Registration failed. Please check your information and try again."
        );
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="register-container">
      <div className="register-card">
        <div className="register-header">
          <h1 className="register-title">Create Your Account</h1>
          <p className="register-subtitle">
            Join HR Nexus to manage your HR needs
          </p>
        </div>

        {error && (
          <div className="register-error">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="2"
              strokeLinecap="round"
              strokeLinejoin="round"
            >
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="8" x2="12" y2="12"></line>
              <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            {error}
          </div>
        )}

        <form className="register-form" onSubmit={handleSubmit}>
          <div className="register-form-row">
            <div className="register-form-group">
              <label htmlFor="first_name" className="register-form-label">
                First Name
              </label>
              <input
                id="first_name"
                name="first_name"
                type="text"
                required
                className="register-form-input"
                value={formData.first_name}
                onChange={handleChange}
              />
              {validationErrors.first_name && (
                <div className="register-form-error">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {validationErrors.first_name}
                </div>
              )}
            </div>

            <div className="register-form-group">
              <label htmlFor="last_name" className="register-form-label">
                Last Name
              </label>
              <input
                id="last_name"
                name="last_name"
                type="text"
                required
                className="register-form-input"
                value={formData.last_name}
                onChange={handleChange}
              />
              {validationErrors.last_name && (
                <div className="register-form-error">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {validationErrors.last_name}
                </div>
              )}
            </div>
          </div>

          <div className="register-form-group">
            <label htmlFor="email" className="register-form-label">
              Email Address
            </label>
            <input
              id="email"
              name="email"
              type="email"
              required
              className="register-form-input"
              placeholder="yourname@company.com"
              value={formData.email}
              onChange={handleChange}
            />
            {validationErrors.email && (
              <div className="register-form-error">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="8" x2="12" y2="12"></line>
                  <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                {validationErrors.email}
              </div>
            )}
          </div>

          <div className="register-form-group">
            <label htmlFor="department_id" className="register-form-label">
              Department
            </label>
            <select
              id="department_id"
              name="department_id"
              required
              className="register-form-select"
              value={formData.department_id}
              onChange={handleChange}
            >
              <option value="">Select a department</option>
              {departments.map((dept) => (
                <option key={dept.id} value={dept.id}>
                  {dept.name}
                </option>
              ))}
            </select>
            {validationErrors.department_id && (
              <div className="register-form-error">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="8" x2="12" y2="12"></line>
                  <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                {validationErrors.department_id}
              </div>
            )}
          </div>

          <div className="register-form-row">
            <div className="register-form-group">
              <label htmlFor="password" className="register-form-label">
                Password
              </label>
              <input
                id="password"
                name="password"
                type="password"
                required
                className="register-form-input"
                placeholder="••••••••"
                value={formData.password}
                onChange={handleChange}
              />
              {validationErrors.password && (
                <div className="register-form-error">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {validationErrors.password}
                </div>
              )}
            </div>

            <div className="register-form-group">
              <label
                htmlFor="password_confirmation"
                className="register-form-label"
              >
                Confirm Password
              </label>
              <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                className="register-form-input"
                placeholder="••••••••"
                value={formData.password_confirmation}
                onChange={handleChange}
              />
              {validationErrors.password_confirmation && (
                <div className="register-form-error">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="14"
                    height="14"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {validationErrors.password_confirmation}
                </div>
              )}
            </div>
          </div>

          <button
            type="submit"
            className={`register-btn ${loading ? "register-btn-loading" : ""}`}
            disabled={loading}
          >
            {loading ? "Creating account..." : "Create Account"}
          </button>
        </form>

        <div className="register-footer">
          Already have an account?{" "}
          <Link to="/login" className="register-link">
            Sign in
          </Link>
        </div>
      </div>
    </div>
  );
};

export default Register;
