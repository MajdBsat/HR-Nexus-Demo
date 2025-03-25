import { useState, useEffect, useCallback } from "react";
import { apiClient } from "../services/apiService";

const useUsers = () => {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const fetchUsers = useCallback(async () => {
    try {
      setLoading(true);
      const response = await apiClient.get("/api/users");

      // Format the data for the table
      const formattedData = response.data.map((user) => ({
        id: user.id,
        ID: user.id,
        Name: user.name,
        Email: user.email,
        "User Type": getUserType(user.user_type),
        raw_user_type: user.user_type,
        Department: user.department?.name || "Not Assigned",
        department_id: user.department_id,
        Action: "Edit",
      }));

      setUsers(formattedData);
      setError("");
    } catch (err) {
      setError("Failed to load users. Please try again.");
      console.error("Error fetching users:", err);
    } finally {
      setLoading(false);
    }
  }, []);

  const getUserType = (userType) => {
    switch (userType) {
      case 0:
        return "Guest";
      case 1:
        return "Employee";
      case 2:
        return "HR";
      default:
        return "Unknown";
    }
  };

  // Update user in the local state after editing
  const updateUser = useCallback((userId, updatedUserData) => {
    setUsers((prevUsers) =>
      prevUsers.map((user) =>
        user.id === userId
          ? {
              ...user,
              Name: updatedUserData.name,
              Email: updatedUserData.email,
              "User Type": getUserType(updatedUserData.user_type),
              raw_user_type: updatedUserData.user_type,
              department_id: updatedUserData.department_id,
              Department: updatedUserData.department_name || "Not Assigned",
            }
          : user
      )
    );
  }, []);

  // Update user in the API
  const updateUserApi = useCallback(
    async (userId, userData) => {
      try {
        setLoading(true);
        await apiClient.put(`/api/users/${userId}`, userData);
        // Get department name for the updated user
        if (userData.department_id) {
          try {
            const deptResponse = await apiClient.get(
              `/api/departments/${userData.department_id}`
            );
            const departmentName = deptResponse.data.name;
            updateUser(userId, {
              ...userData,
              department_name: departmentName,
            });
          } catch (err) {
            updateUser(userId, userData);
            console.error("Error fetching department:", err);
          }
        } else {
          updateUser(userId, userData);
        }
        return { success: true };
      } catch (err) {
        const errorMessage =
          err.response?.data?.message ||
          "Failed to update user. Please try again.";
        return { success: false, error: errorMessage };
      } finally {
        setLoading(false);
      }
    },
    [updateUser]
  );

  // Load users on initial mount
  useEffect(() => {
    fetchUsers();
  }, [fetchUsers]);

  return {
    users,
    loading,
    error,
    fetchUsers,
    updateUserApi,
  };
};

export default useUsers;
