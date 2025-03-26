import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../utils/api";
import "../../styles/UserProfile.css";

const UserProfile = () => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(false);
  const [updateLoading, setUpdateLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");
  const [formData, setFormData] = useState({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const navigate = useNavigate();

  useEffect(() => {
    const fetchUserData = async () => {
      setLoading(true);
      try {
        // Get user ID from localStorage
        const userInfo = JSON.parse(localStorage.getItem("user"));
        const token = localStorage.getItem("token");

        if (!userInfo || !token) {
          throw new Error("Authentication required");
        }

        const response = await api.get("/api/users/" + userInfo.id, {
          headers: {
            Authorization: "Bearer " + token,
          },
        });

        const userData = response.data.data;
        setUser(userData);
        setFormData({
          first_name: userData.first_name || "",
          last_name: userData.last_name || "",
          email: userData.email || "",
          password: "",
          password_confirmation: "",
        });
      } catch (error) {
        console.error("Error fetching user profile:", error);
        setErrorMessage("Failed to load your profile. Please try again later.");
      } finally {
        setLoading(false);
      }
    };

    fetchUserData();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setUpdateLoading(true);
    setErrorMessage("");
    setSuccessMessage("");

    try {
      const token = localStorage.getItem("token");
      const userInfo = JSON.parse(localStorage.getItem("user"));

      if (!userInfo || !token) {
        throw new Error("Authentication required");
      }

      // Only include password fields if they are filled
      const updateData = {
        first_name: formData.first_name,
        last_name: formData.last_name,
        email: formData.email,
      };

      if (formData.password) {
        if (formData.password !== formData.password_confirmation) {
          throw new Error("Passwords do not match");
        }
        updateData.password = formData.password;
        updateData.password_confirmation = formData.password_confirmation;
      }

      const response = await api.put("/api/users/" + userInfo.id, updateData, {
        headers: {
          Authorization: "Bearer " + token,
        },
      });

      const updatedUser = response.data.data;
      setUser(updatedUser);

      // Update user in localStorage
      localStorage.setItem(
        "user",
        JSON.stringify({
          ...userInfo,
          first_name: updatedUser.first_name,
          last_name: updatedUser.last_name,
          email: updatedUser.email,
        })
      );

      setSuccessMessage("Profile updated successfully!");

      // Clear password fields after successful update
      setFormData({
        ...formData,
        password: "",
        password_confirmation: "",
      });
    } catch (error) {
      console.error("Error updating profile:", error);
      setErrorMessage(
        error.message ||
          error.response?.data?.message ||
          "Failed to update profile. Please try again."
      );
    } finally {
      setUpdateLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="profile-container">
        <div className="profile-loading">Loading your profile...</div>
      </div>
    );
  }

  if (!user) {
    return (
      <div className="profile-container">
        <div className="profile-error">
          Unable to load profile. Please try again later.
        </div>
      </div>
    );
  }

  // Create initials for avatar
  const getInitials = () => {
    return `${user.first_name?.charAt(0) || ""}${
      user.last_name?.charAt(0) || ""
    }`.toUpperCase();
  };

  return (
    <div className="profile-container">
      <div className="profile-header">
        <div className="profile-avatar">{getInitials()}</div>
        <h1 className="profile-name">{`${user.first_name} ${user.last_name}`}</h1>
        <p className="profile-email">{user.email}</p>

        <div className="profile-stats">
          <div className="profile-stat">
            <span className="profile-stat-value">HR</span>
            <span className="profile-stat-label">Department</span>
          </div>
          <div className="profile-stat">
            <span className="profile-stat-value">
              {user.created_at
                ? new Date(user.created_at).getFullYear()
                : "N/A"}
            </span>
            <span className="profile-stat-label">Joined</span>
          </div>
          <div className="profile-stat">
            <span className="profile-stat-value">Active</span>
            <span className="profile-stat-label">Status</span>
          </div>
        </div>
      </div>

      <div className="profile-content">
        <div className="profile-card">
          <div className="profile-card-header">
            <h2 className="profile-card-title">
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
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              Personal Information
            </h2>
          </div>

          {errorMessage && (
            <div className="profile-message profile-message-error">
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
              {errorMessage}
            </div>
          )}

          {successMessage && (
            <div className="profile-message profile-message-success">
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
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
              {successMessage}
            </div>
          )}

          <form className="profile-form" onSubmit={handleSubmit}>
            <div className="profile-form-row">
              <div className="profile-form-group">
                <label htmlFor="first_name" className="profile-form-label">
                  First Name
                </label>
                <input
                  id="first_name"
                  name="first_name"
                  type="text"
                  className="profile-form-input"
                  value={formData.first_name}
                  onChange={handleChange}
                  required
                />
              </div>

              <div className="profile-form-group">
                <label htmlFor="last_name" className="profile-form-label">
                  Last Name
                </label>
                <input
                  id="last_name"
                  name="last_name"
                  type="text"
                  className="profile-form-input"
                  value={formData.last_name}
                  onChange={handleChange}
                  required
                />
              </div>
            </div>

            <div className="profile-form-group">
              <label htmlFor="email" className="profile-form-label">
                Email Address
              </label>
              <input
                id="email"
                name="email"
                type="email"
                className="profile-form-input"
                value={formData.email}
                onChange={handleChange}
                required
              />
            </div>

            <div className="profile-form-row">
              <div className="profile-form-group">
                <label htmlFor="password" className="profile-form-label">
                  New Password
                </label>
                <input
                  id="password"
                  name="password"
                  type="password"
                  className="profile-form-input"
                  value={formData.password}
                  onChange={handleChange}
                  placeholder="Leave blank to keep current password"
                />
              </div>

              <div className="profile-form-group">
                <label
                  htmlFor="password_confirmation"
                  className="profile-form-label"
                >
                  Confirm Password
                </label>
                <input
                  id="password_confirmation"
                  name="password_confirmation"
                  type="password"
                  className="profile-form-input"
                  value={formData.password_confirmation}
                  onChange={handleChange}
                  placeholder="Leave blank to keep current password"
                />
              </div>
            </div>

            <button
              type="submit"
              className={`profile-btn profile-btn-primary ${
                updateLoading ? "profile-btn-loading" : ""
              }`}
              disabled={updateLoading}
            >
              {updateLoading ? "Saving..." : "Save Changes"}
            </button>
          </form>
        </div>

        <div className="profile-card">
          <div className="profile-card-header">
            <h2 className="profile-card-title">
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
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              Account Information
            </h2>
          </div>

          <div className="profile-form">
            <div className="profile-form-group">
              <label className="profile-form-label">Account Created</label>
              <input
                type="text"
                className="profile-form-input"
                value={
                  user.created_at
                    ? new Date(user.created_at).toLocaleDateString()
                    : "N/A"
                }
                disabled
              />
            </div>

            <div className="profile-form-group">
              <label className="profile-form-label">Last Updated</label>
              <input
                type="text"
                className="profile-form-input"
                value={
                  user.updated_at
                    ? new Date(user.updated_at).toLocaleDateString()
                    : "N/A"
                }
                disabled
              />
            </div>

            <div className="profile-form-group">
              <label className="profile-form-label">Department</label>
              <input
                type="text"
                className="profile-form-input"
                value={user.department?.name || "Not assigned"}
                disabled
              />
            </div>

            <div className="profile-form-group">
              <label className="profile-form-label">Role</label>
              <input
                type="text"
                className="profile-form-input"
                value="Employee"
                disabled
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default UserProfile;
