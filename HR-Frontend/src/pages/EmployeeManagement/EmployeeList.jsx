import React, { useState } from "react";
import useUsers from "../../hooks/useUsers";
import Table from "../../components/Table";
import EditUserModal from "./EditUserModal";
import "./EmployeeList.css";

const EmployeeList = () => {
  const { users, loading, error, fetchUsers } = useUsers();
  const [showEditModal, setShowEditModal] = useState(false);
  const [selectedUser, setSelectedUser] = useState(null);

  // Table headers
  const header = ["ID", "Name", "Email", "User Type", "Department", "Action"];

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
        <h1>Employee Management</h1>
      </div>

      {error && <div className="error-message">{error}</div>}

      {loading ? (
        <div className="loading">Loading users...</div>
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
    </div>
  );
};

export default EmployeeList;
