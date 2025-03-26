import React, { useState } from "react";
import { FaBars } from "react-icons/fa";
import "./index.css";

const Sidebar = () => {
  const [isOpen, setIsOpen] = useState(true);

  const toggleSidebar = () => {
    setIsOpen(!isOpen);
  };
  const menuItems = [
    { name: "HR Projects", link: "/hr-projects" },
    { name: "Compliance", link: "/compliance" },
    { name: "Recruitment", link: "/recruitment" },
    { name: "Dashboard", link: "/dashboard" },
    { name: "Attendance", link: "/attendance" },
    { name: "KPI Statistics", link: "/kpi-statistics" },
    { name: "Documents", link: "/document" },
    { name: "Add User", link: "/add-user" },
    { name: "Reviews", link: "/reviews" },
    { name: "Payroll", link: "/payroll" },
    { name: "Performance", link: "/performance" },
    { name: "Benefits", link: "/benefits" },
  ];

  return (
    <div className={`sidebar ${isOpen ? "open" : "closed"}`}>
      <button className="toggle-btn" onClick={toggleSidebar}>
        <FaBars />
      </button>
      <ul className="menu">
        {menuItems.map((item, index) => (
          <li key={index}>
            <a href={item.link}>{item.name}</a>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Sidebar;
