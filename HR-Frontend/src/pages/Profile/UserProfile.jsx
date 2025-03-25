import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../utils/api";
import "../../styles/UserProfile.css";

const UserProfile = () => {
  const [user, setUser] = useState(null);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(false);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [offline, setOffline] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const token = localStorage.getItem("token");
        if (!token) {
          navigate("/login");
          return;
        }

        console.log("Fetching profile data...");

        // Set a timeout to detect if the request is taking too long
        const timeoutId = setTimeout(() => {
          console.log("Request timeout - switching to offline mode");
          setOffline(true);
          setLoading(false);

          // Use mock data in offline mode
          const mockUserData = {
            name: "User (Offline Mode)",
            email: "offline@example.com",
          };

          setUser(mockUserData);
          setFormData({
            name: mockUserData.name,
            email: mockUserData.email,
            password: "",
            password_confirmation: "",
          });
        }, 5000); // 5 second timeout

        try {
          const response = await api.get("/api/profile");
          clearTimeout(timeoutId);

          if (response.data) {
            setUser(response.data);
            setFormData({
              name: response.data.name,
              email: response.data.email,
              password: "",
              password_confirmation: "",
            });
          }
          setLoading(false);
        } catch (apiError) {
          clearTimeout(timeoutId);
          throw apiError;
        }
      } catch (err) {
        console.error("Profile fetch error:", err);
        setError("Failed to load profile data. Please try again later.");
        setLoading(false);
      }
    };

    fetchUserData();
  }, [navigate]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");
    setUpdating(true);

    // Validate passwords match if changing password
    if (
      formData.password &&
      formData.password !== formData.password_confirmation
    ) {
      setError("Passwords do not match");
      setUpdating(false);
      return;
    }

    if (offline) {
      setTimeout(() => {
        setSuccess("Profile would be updated (currently in offline mode)");
        setUpdating(false);
      }, 1000);
      return;
    }

    try {
      const dataToSend = {
        name: formData.name,
        email: formData.email,
      };

      // Only include password if it was provided
      if (formData.password) {
        dataToSend.password = formData.password;
        dataToSend.password_confirmation = formData.password_confirmation;
      }

      console.log("Updating profile...");

      await api.put("/api/profile", dataToSend);

      setSuccess("Profile updated successfully");
      // Reset password fields after successful update
      setFormData({
        ...formData,
        password: "",
        password_confirmation: "",
      });
    } catch (err) {
      console.error("Profile update error:", err);
      setError(
        err.response?.data?.message ||
          "Failed to update profile. Please try again."
      );
    } finally {
      setUpdating(false);
    }
  };

  if (loading) {
    return (
      <div className="loading-container">
        <div className="loader"></div>
        <span className="visually-hidden">Loading...</span>
      </div>
    );
  }

  return (
    <div className="user-profile-container">
      <h2 className="profile-title">
        Your Profile {offline && "(Offline Mode)"}
      </h2>
      <div className="profile-card">
        <div className="card-body">
          {error && <div className="error-message">{error}</div>}
          {success && <div className="success-message">{success}</div>}
          {offline && (
            <div className="warning-message">
              You are in offline mode because the server is not available.
              Changes will not be saved until you reconnect.
            </div>
          )}

          <form onSubmit={handleSubmit} className="profile-form">
            <div className="form-group">
              <label htmlFor="name">Name</label>
              <input
                type="text"
                id="name"
                name="name"
                value={formData.name}
                onChange={handleChange}
                required
                className="form-input"
              />
            </div>

            <div className="form-group">
              <label htmlFor="email">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                required
                className="form-input"
              />
            </div>

            <div className="form-group">
              <label htmlFor="password">
                New Password (leave blank to keep current)
              </label>
              <input
                type="password"
                id="password"
                name="password"
                value={formData.password}
                onChange={handleChange}
                autoComplete="new-password"
                className="form-input"
              />
            </div>

            <div className="form-group">
              <label htmlFor="password_confirmation">
                Confirm New Password
              </label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                value={formData.password_confirmation}
                onChange={handleChange}
                autoComplete="new-password"
                className="form-input"
              />
            </div>

            <div className="form-submit">
              <button
                type="submit"
                className="submit-button"
                disabled={updating}
              >
                {updating ? "Updating..." : "Update Profile"}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default UserProfile;
