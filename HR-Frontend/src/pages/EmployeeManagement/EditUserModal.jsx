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
      console.log("Fetching departments...");
      const response = await apiClient.get("/api/departments");
      console.log("Departments response:", response);

      // Check for different response formats
      let departmentsData;

      if (response.data && Array.isArray(response.data)) {
        // Direct array format
        departmentsData = response.data;
      } else if (
        response.data &&
        response.data.success &&
        Array.isArray(response.data.data)
      ) {
        // {success: true, data: [...]} format
        departmentsData = response.data.data;
      } else if (response.data && typeof response.data === "object") {
        // If it's an object but not in expected format, try to extract array
        const possibleArrays = Object.values(response.data).filter((val) =>
          Array.isArray(val)
        );
        if (possibleArrays.length > 0) {
          departmentsData = possibleArrays[0];
        } else {
          console.error(
            "Could not find departments array in response:",
            response.data
          );
          departmentsData = [];
        }
      } else {
        console.error("Unexpected departments response format:", response.data);
        departmentsData = [];
      }

      // Ensure it's an array of objects with id and name
      const validDepartments = departmentsData.filter(
        (dept) =>
          dept &&
          typeof dept === "object" &&
          dept.id !== undefined &&
          dept.name !== undefined
      );

      console.log(`Processed ${validDepartments.length} valid departments`);
      setDepartments(validDepartments);
    } catch (err) {
      console.error("Error fetching departments:", err);
      setDepartments([]); // Set to empty array on error
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
      // Create a copy of the formData to ensure proper formatting
      const formattedData = { ...formData };

      // Ensure department_id is sent as a number, null, or undefined based on what the API expects
      if (
        formattedData.department_id === "" ||
        formattedData.department_id === null
      ) {
        console.log("No department selected, setting to null");
        formattedData.department_id = null;
      } else {
        // Ensure it's a number
        console.log(`Department selected: ${formattedData.department_id}`);
        formattedData.department_id = parseInt(formattedData.department_id, 10);

        // Add explicit department relation for Laravel - some APIs need this format
        formattedData.department = {
          id: formattedData.department_id,
        };
      }

      console.log("Submitting user data:", formattedData);

      const result = await updateUserApi(user.id, formattedData);

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
              {Array.isArray(departments) && departments.length > 0 ? (
                departments.map((dept) => (
                  <option key={dept.id} value={dept.id}>
                    {dept.name}
                  </option>
                ))
              ) : (
                <option disabled>Loading departments...</option>
              )}
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
