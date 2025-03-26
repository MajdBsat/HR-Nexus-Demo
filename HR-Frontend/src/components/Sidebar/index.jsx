import React, { useState, useEffect } from "react";
import { Link, useLocation } from "react-router-dom";
import "../../styles/Sidebar.css";

const Sidebar = ({ collapsed = false, onToggle, onLogout }) => {
  const location = useLocation();
  const [isCollapsed, setIsCollapsed] = useState(collapsed);
  const [isMobileVisible, setIsMobileVisible] = useState(false);

  // Handle window resize to detect mobile view
  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth > 992 && isMobileVisible) {
        setIsMobileVisible(false);
      }
    };

    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, [isMobileVisible]);

  const toggleSidebar = () => {
    setIsCollapsed(!isCollapsed);
    if (onToggle) {
      onToggle();
    }
  };

  const toggleMobileSidebar = () => {
    setIsMobileVisible(!isMobileVisible);
  };

  const isActive = (path) => {
    return location.pathname.startsWith(path);
  };

  const handleLogout = () => {
    if (onLogout) {
      onLogout();
    }
  };

  // Get user info from localStorage
  const userString = localStorage.getItem("user");
  const user = userString ? JSON.parse(userString) : null;
  const isHR = user?.user_type === 2;

  return (
    <>
      {/* Mobile menu trigger */}
      <button
        className="mobile-menu-trigger"
        onClick={toggleMobileSidebar}
        aria-label="Toggle menu"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          strokeLinecap="round"
          strokeLinejoin="round"
        >
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>

      {/* Overlay for mobile */}
      <div
        className={`sidebar-overlay ${isMobileVisible ? "visible" : ""}`}
        onClick={toggleMobileSidebar}
      ></div>

      {/* Sidebar */}
      <div
        className={`sidebar ${isCollapsed ? "collapsed" : ""} ${
          isMobileVisible ? "mobile-visible" : ""
        }`}
      >
        <div className="sidebar-header">
          <div className="sidebar-logo">
            <span className="logo-icon">HR</span>
            {!isCollapsed && <span className="logo-text">HR Nexus</span>}
          </div>
          <button className="sidebar-toggle" onClick={toggleSidebar}>
            {isCollapsed ? (
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
                <polyline points="13 17 18 12 13 7"></polyline>
                <polyline points="6 17 11 12 6 7"></polyline>
              </svg>
            ) : (
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
                <polyline points="15 18 9 12 15 6"></polyline>
              </svg>
            )}
          </button>
        </div>

        <div className="sidebar-nav">
          <ul className="sidebar-menu">
            {/* HR Routes */}
            {isHR && (
              <>
                <li
                  className={`sidebar-item ${
                    isActive("/hr/dashboard") ? "active" : ""
                  }`}
                >
                  <Link to="/hr/dashboard" className="sidebar-link">
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
                      <rect x="3" y="3" width="7" height="7"></rect>
                      <rect x="14" y="3" width="7" height="7"></rect>
                      <rect x="14" y="14" width="7" height="7"></rect>
                      <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    {!isCollapsed && <span>Dashboard</span>}
                  </Link>
                </li>

                <li
                  className={`sidebar-item ${
                    isActive("/hr/employees") ? "active" : ""
                  }`}
                >
                  <Link to="/hr/employees" className="sidebar-link">
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
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                      <circle cx="9" cy="7" r="4"></circle>
                      <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    {!isCollapsed && <span>Employees</span>}
                  </Link>
                </li>

                <li
                  className={`sidebar-item ${
                    isActive("/hr/recruitment/jobs") ? "active" : ""
                  }`}
                >
                  <Link to="/hr/recruitment/jobs" className="sidebar-link">
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
                      <rect
                        x="2"
                        y="7"
                        width="20"
                        height="14"
                        rx="2"
                        ry="2"
                      ></rect>
                      <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    {!isCollapsed && <span>Jobs</span>}
                  </Link>
                </li>

                <li
                  className={`sidebar-item ${
                    isActive("/hr/recruitment/candidates") ? "active" : ""
                  }`}
                >
                  <Link
                    to="/hr/recruitment/candidates"
                    className="sidebar-link"
                  >
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
                    {!isCollapsed && <span>Candidates</span>}
                  </Link>
                </li>

                <li
                  className={`sidebar-item ${
                    isActive("/hr/recruitment/onboarding") ? "active" : ""
                  }`}
                >
                  <Link
                    to="/hr/recruitment/onboarding"
                    className="sidebar-link"
                  >
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
                      <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                      <rect
                        x="8"
                        y="2"
                        width="8"
                        height="4"
                        rx="1"
                        ry="1"
                      ></rect>
                      <path d="M9 14l2 2 4-4"></path>
                    </svg>
                    {!isCollapsed && <span>Onboarding</span>}
                  </Link>
                </li>
              </>
            )}

            {/* Employee Routes */}
            {!isHR && (
              <>
                <li
                  className={`sidebar-item ${
                    isActive("/emp/recruitment/jobs") ? "active" : ""
                  }`}
                >
                  <Link to="/emp/recruitment/jobs" className="sidebar-link">
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
                      <rect
                        x="2"
                        y="7"
                        width="20"
                        height="14"
                        rx="2"
                        ry="2"
                      ></rect>
                      <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    {!isCollapsed && <span>Jobs</span>}
                  </Link>
                </li>

                <li
                  className={`sidebar-item ${
                    isActive("/emp/recruitment/jobs/apply") ? "active" : ""
                  }`}
                >
                  <Link
                    to="/emp/recruitment/jobs/apply"
                    className="sidebar-link"
                  >
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
                      <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                      <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                    </svg>
                    {!isCollapsed && <span>Apply to Jobs</span>}
                  </Link>
                </li>

                <li
                  className={`sidebar-item ${
                    isActive("/emp/recruitment/onboarding") ? "active" : ""
                  }`}
                >
                  <Link
                    to="/emp/recruitment/onboarding"
                    className="sidebar-link"
                  >
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
                      <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                      <rect
                        x="8"
                        y="2"
                        width="8"
                        height="4"
                        rx="1"
                        ry="1"
                      ></rect>
                      <path d="M9 14l2 2 4-4"></path>
                    </svg>
                    {!isCollapsed && <span>Onboarding</span>}
                  </Link>
                </li>
              </>
            )}

            {/* Common Routes (for both HR and Employees) */}
            <li
              className={`sidebar-item ${isActive("/profile") ? "active" : ""}`}
            >
              <Link to="/profile" className="sidebar-link">
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
                {!isCollapsed && <span>Profile</span>}
              </Link>
            </li>
          </ul>
        </div>

        <div className="sidebar-footer">
          <button className="sidebar-logout" onClick={handleLogout}>
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
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            {!isCollapsed && <span>Logout</span>}
          </button>
        </div>
      </div>
    </>
  );
};

export default Sidebar;
