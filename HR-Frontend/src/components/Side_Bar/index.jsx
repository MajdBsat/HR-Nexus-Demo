import React, { useState } from "react";
import { FaBars } from "react-icons/fa";
import "./index.css";

const Sidebar = () => {
  const [isOpen, setIsOpen] = useState(true);

  const toggleSidebar = () => {
    setIsOpen(!isOpen);
  };

  return (
    <div className={`sidebar ${isOpen ? "open" : "closed"}`}>
      <button className="toggle-btn" onClick={toggleSidebar}>
        <FaBars />
      </button>
      <ul className="menu">
        <li className="active">HR Projects</li>
        <li>Compliance</li>
        <li>Recruitment</li>
        <li>Dashboard</li>
        <li>Attendance</li>
        <li>KPI Statistics</li>
        <li>Documents</li>
        <li>Add User</li>
        <li>Reviews</li>
        <li>Payroll</li>
        <li>Performance</li>
        <li>Benefits</li>
      </ul>
    </div>
  );
};

export default Sidebar;
