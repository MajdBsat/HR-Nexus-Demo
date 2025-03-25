import React, { useState, useEffect } from "react";
import useUsers from "../../hooks/useUsers";
import Table from "../../components/Table";
import EditUserModal from "./EditUserModal";
import "./EmployeeList.css";
import { Link } from "react-router-dom";

const EmployeeList = () => {
  const { users, loading, error, fetchUsers } = useUsers();
  const [showEditModal, setShowEditModal] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);
  const [retryCount, setRetryCount] = useState(0);

  // Table headers
  const header = ["ID", "Name", "Email", "User Type", "Department", "Action"];

  // Initial data fetch
  useEffect(() => {
    console.log("EmployeeList mounted");
  }, []);

  // Add a manual retry button for when loading fails
  const handleRetry = () => {
    setRetryCount((prev) => prev + 1);
    fetchUsers();
  };

  const handleEditUser = (userId) => {
    const user = users.find((user) => user.id === userId);
    if (user) {
      setSelectedUser(user);
      setShowEditModal(true);
    }
  };

  const handleCloseModal = () => {
    setShowEditModal(false);
    setSelectedUser(null);
  };

  const handleUserUpdated = () => {
    fetchUsers();
    handleCloseModal();
  };

  return (
    <div className="employee-list-container">
      <div className="header-section">
        <h2>Employee Management</h2>
        <div className="header-actions">
          <button
            className="refresh-button"
            onClick={handleRetry}
            disabled={loading}
          >
            {loading ? "Loading..." : "Refresh"}
          </button>
          <Link to="/profile" className="btn-secondary">
            My Profile
          </Link>
        </div>
      </div>

      {error && (
        <div className="error-message">
          <p>{error}</p>
          <button onClick={handleRetry} disabled={loading}>
            {loading ? "Retrying..." : "Retry"}
          </button>
        </div>
      )}

      {loading ? (
        <div className="loading">Loading users...</div>
      ) : users.length === 0 ? (
        <div className="no-data">
          <p>
            No users found.{" "}
            {error ? "There was an error loading the data." : ""}
          </p>
          <button onClick={handleRetry}>Retry</button>
        </div>
      ) : (
        <div className="table-container">
          <Table header={header} data={users} fun={handleEditUser} />
        </div>
      )}

      {showEditModal && selectedUser && (
        <EditUserModal
          user={selectedUser}
          onClose={handleCloseModal}
          onUserUpdated={handleUserUpdated}
        />
      )}

      {/* Debug info - remove in production */}
      <div
        className="debug-info"
        style={{
          margin: "20px",
          padding: "10px",
          border: "1px solid #ddd",
          borderRadius: "4px",
          fontSize: "12px",
          display: "none",
        }}
      >
        <h4>Debug Info</h4>
        <p>Users: {users.length}</p>
        <p>Loading: {loading ? "true" : "false"}</p>
        <p>Error: {error ? error : "none"}</p>
        <p>Retry Count: {retryCount}</p>
      </div>
    </div>
  );
};

export default EmployeeList;
