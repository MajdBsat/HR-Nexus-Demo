import React, { useState, useEffect } from "react";
import { apiClient } from "../../services/apiService";
import useUsers from "../../hooks/useUsers";
import "./EditUserModal.css";

const EditUserModal = ({ user, onClose, onUserUpdated }) => {
  const { updateUserApi } = useUsers();
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    user_type: 0,
    department_id: null,
  });
  const [departments, setDepartments] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
    if (user) {
      setFormData({
        name: user.Name,
        email: user.Email,
        user_type: user.raw_user_type || getUserTypeValue(user["User Type"]),
        department_id: user.department_id || null,
      });
    }

    fetchDepartments();
  }, [user]);

  const fetchDepartments = async () => {
    try {
      const response = await apiClient.get("/api/departments");
      setDepartments(response.data);
    } catch (err) {
      console.error("Error fetching departments:", err);
    }
  };

  const getUserTypeValue = (userTypeText) => {
    switch (userTypeText) {
      case "Guest":
        return 0;
      case "Employee":
        return 1;
      case "HR":
        return 2;
      default:
        return 0;
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;

    // Convert user_type and department_id to numbers if needed
    if (name === "user_type" || name === "department_id") {
      setFormData({
        ...formData,
        [name]: value === "" ? null : parseInt(value, 10),
      });
    } else {
      setFormData({
        ...formData,
        [name]: value,
      });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const result = await updateUserApi(user.id, formData);

      if (result.success) {
        onUserUpdated();
      } else {
        setError(result.error);
        setLoading(false);
      }
    } catch (err) {
      setError("Failed to update user. Please try again.");
      setLoading(false);
    }
  };

  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <div className="modal-header">
          <h2>Edit User</h2>
          <button className="close-button" onClick={onClose}>
            &times;
          </button>
        </div>

        {error && <div className="error-message">{error}</div>}

        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="name">Name</label>
            <input
              type="text"
              id="name"
              name="name"
              value={formData.name}
              onChange={handleChange}
              required
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
            />
          </div>

          <div className="form-group">
            <label htmlFor="user_type">User Type</label>
            <select
              id="user_type"
              name="user_type"
              value={formData.user_type}
              onChange={handleChange}
              required
            >
              <option value={0}>Guest</option>
              <option value={1}>Employee</option>
              <option value={2}>HR</option>
            </select>
          </div>

          <div className="form-group">
            <label htmlFor="department_id">Department</label>
            <select
              id="department_id"
              name="department_id"
              value={formData.department_id || ""}
              onChange={handleChange}
            >
              <option value="">Not Assigned</option>
              {departments.map((dept) => (
                <option key={dept.id} value={dept.id}>
                  {dept.name}
                </option>
              ))}
            </select>
          </div>

          <div className="form-actions">
            <button type="button" onClick={onClose} disabled={loading}>
              Cancel
            </button>
            <button type="submit" disabled={loading}>
              {loading ? "Saving..." : "Save Changes"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EditUserModal;
