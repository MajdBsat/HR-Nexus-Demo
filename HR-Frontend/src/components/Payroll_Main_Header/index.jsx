import React, { useState } from "react";
import './index.css'

function Payroll_Main_Header({ onSearch, onRoleChange }) {
    const [selectedRole, setSelectedRole] = useState("Management");
    const [searchQuery, setSearchQuery] = useState("");

    const handleRoleChange = (event) => {
        setSelectedRole(event.target.value);
        onRoleChange(event.target.value);
    };

    const handleSearchChange = (event) => {
        setSearchQuery(event.target.value);
        onSearch(event.target.value);
    };

    return (
        <div className="payroll-header flex space-between align-center">
            <select className="dropdown" value={selectedRole} onChange={handleRoleChange}>
                <option value="Management">Management</option>
                <option value="Employee">Employee</option>
            </select>

            <div className="payroll-search-new flex row center content-end height100" >
            <input
                type="text"
                className="search-bar"
                placeholder="Search..."
                value={searchQuery}
                onChange={handleSearchChange}
            />
            </div>
        </div>
    );
}

export default Payroll_Main_Header;
