import { useState, useEffect, useCallback, useRef } from "react";
import { apiClient } from "../services/apiService";

const useUsers = () => {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const isRequestPending = useRef(false);

  const fetchUsers = useCallback(async () => {
    // Prevent duplicate requests
    if (isRequestPending.current) {
      console.log("Request already in progress, skipping duplicate fetch");
      return;
    }

    try {
      isRequestPending.current = true;
      setLoading(true);
      console.log("Fetching users...");

      // Add a small delay to prevent rapid consecutive requests
      await new Promise((resolve) => setTimeout(resolve, 300));

      const response = await apiClient.get("/api/users");
      console.log("Raw API Response:", response);

      // Handle empty response
      if (!response || !response.data) {
        throw new Error("Empty response from server");
      }

      // Log the full response structure for debugging
      console.log("Response structure:", {
        status: response.status,
        statusText: response.statusText,
        hasData: !!response.data,
        dataType: typeof response.data,
        isDataArray: Array.isArray(response.data),
        hasSuccessFlag: response.data && "success" in response.data,
        successValue: response.data && response.data.success,
      });

      // Check if response has success and data fields
      const responseData =
        response.data && response.data.success !== undefined
          ? response.data.data // New API format with {success: true, data: [...]}
          : response.data; // Fallback to direct array format

      if (!responseData) {
        throw new Error("No data received from server");
      }

      if (!Array.isArray(responseData)) {
        console.error("Response data is not an array:", responseData);
        throw new Error(
          "Invalid data format received from server (not an array)"
        );
      }

      // Format the data for the table
      const formattedData = responseData.map((user) => {
        // Ensure user has all required fields
        const safeUser = {
          id: user.id || 0,
          name: user.name || "",
          email: user.email || "",
          user_type: user.user_type != null ? user.user_type : 0,
          department: user.department || null,
          department_id: user.department_id || null,
        };

        return {
          id: safeUser.id,
          ID: String(safeUser.id), // Convert to string to be safe
          Name: String(safeUser.name),
          Email: String(safeUser.email),
          "User Type": getUserType(safeUser.user_type),
          raw_user_type: safeUser.user_type,
          Department: safeUser.department?.name
            ? String(safeUser.department.name)
            : "Not Assigned",
          department_id: safeUser.department_id,
          Action: "Edit",
        };
      });

      console.log(`Formatted ${formattedData.length} users`);
      setUsers(formattedData);
      setError("");
    } catch (err) {
      console.error("Error fetching users:", err);
      console.error("Error details:", {
        message: err.message,
        response: err.response,
        statusCode: err.response?.status,
        responseData: err.response?.data,
      });

      // Set a more descriptive error message
      if (err.response) {
        // Server responded with an error status
        const serverMessage =
          err.response.data?.message || err.response.statusText;
        setError(`Server error: ${serverMessage} (${err.response.status})`);
      } else if (err.request) {
        // Request was made but no response received
        setError("No response from server. Please check your connection.");
      } else {
        // Error in request setup
        setError(`Error: ${err.message}`);
      }
    } finally {
      setLoading(false);
      isRequestPending.current = false;
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
              Name: String(updatedUserData.name || ""),
              Email: String(updatedUserData.email || ""),
              "User Type": getUserType(updatedUserData.user_type),
              raw_user_type: updatedUserData.user_type,
              department_id: updatedUserData.department_id,
              Department: updatedUserData.department_name
                ? String(updatedUserData.department_name)
                : "Not Assigned",
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

        // Log the request data for debugging
        console.log(`Starting user update for ID ${userId}:`, userData);

        // Simplify data to just what's needed
        const updateData = {
          name: userData.name,
          email: userData.email,
          user_type: userData.user_type,
        };

        // Only include department_id if it's actually set
        if (
          userData.department_id !== null &&
          userData.department_id !== undefined &&
          userData.department_id !== ""
        ) {
          updateData.department_id = Number(userData.department_id);
        }

        console.log(`Simplified update data:`, updateData);

        // Make the API request
        const response = await apiClient.put(
          `/api/users/${userId}`,
          updateData
        );
        console.log("Update response:", response);

        // Parse the response
        const success =
          response.data && typeof response.data.success !== "undefined"
            ? response.data.success
            : true;

        if (!success) {
          console.error(
            "Update failed:",
            response.data?.message || "Unknown error"
          );
          return {
            success: false,
            error: response.data?.message || "Failed to update user",
          };
        }

        // Update UI optimistically
        console.log("Update successful, updating UI");
        updateUser(userId, {
          ...userData,
          department_name: userData.department_id
            ? await getDepartmentName(userData.department_id)
            : null,
        });

        return { success: true };
      } catch (err) {
        console.error("Error updating user:", err);
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

  // Helper function to get department name
  const getDepartmentName = async (departmentId) => {
    try {
      console.log(`Fetching name for department ${departmentId}`);
      const response = await apiClient.get(`/api/departments/${departmentId}`);

      // Handle different response formats
      let departmentData;
      if (response.data && response.data.success && response.data.data) {
        departmentData = response.data.data;
      } else {
        departmentData = response.data;
      }

      console.log(`Department data:`, departmentData);
      return departmentData?.name || "Unknown Department";
    } catch (err) {
      console.error(`Error fetching department ${departmentId}:`, err);
      return "Unknown Department";
    }
  };

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
