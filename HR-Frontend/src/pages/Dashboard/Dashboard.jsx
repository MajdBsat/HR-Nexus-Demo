import React, { useState, useEffect } from "react";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  PieChart,
  Pie,
  Cell,
  LineChart,
  Line,
  ResponsiveContainer,
  AreaChart,
  Area,
  RadarChart,
  PolarGrid,
  PolarAngleAxis,
  PolarRadiusAxis,
  Radar,
  ScatterChart,
  Scatter,
  ZAxis,
} from "recharts";
import api from "../../utils/api";
import "./Dashboard.css";

const Dashboard = () => {
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [dashboardData, setDashboardData] = useState({
    departmentStats: [],
    userTypeDistribution: [],
    employeeGrowth: [],
    attendanceHours: [],
    attendanceLocations: [],
    jobStats: [],
    jobApplicationStats: [],
    projectStats: [],
    onboardingProgress: [],
    departmentManagers: [],
    taskCompletion: [],
  });

  const COLORS = [
    "#3b82f6", // blue
    "#10b981", // emerald
    "#f59e0b", // amber
    "#ef4444", // red
    "#8b5cf6", // violet
    "#06b6d4", // cyan
    "#f97316", // orange
    "#84cc16", // lime
    "#6366f1", // indigo
    "#ec4899", // pink
  ];

  // Safe formatter function that handles non-numeric values
  const safeFormatter = (value, suffix = "", precision = 0) => {
    if (typeof value !== "number" || isNaN(value)) {
      return [`N/A ${suffix}`, "Value"];
    }
    return precision > 0
      ? [`${value.toFixed(precision)} ${suffix}`, "Value"]
      : [`${value} ${suffix}`, "Value"];
  };

  useEffect(() => {
    const fetchDashboardData = async () => {
      try {
        setLoading(true);

        const endpoints = [
          { key: "departmentStats", url: "/api/departments/stats" },
          { key: "userTypeDistribution", url: "/api/users/type-distribution" },
          { key: "employeeGrowth", url: "/api/users/growth" },
          { key: "attendanceHours", url: "/api/attendance/hours" },
          { key: "attendanceLocations", url: "/api/attendance/locations" },
          { key: "jobStats", url: "/api/jobs/stats" },
          { key: "jobApplicationStats", url: "/api/job-applications/stats" },
          { key: "projectStats", url: "/api/projects/stats" },
          { key: "onboardingProgress", url: "/api/onboarding/progress" },
          { key: "departmentManagers", url: "/api/departments/managers" },
          { key: "taskCompletion", url: "/api/tasks/completion" },
        ];

        //test 
        const results = {};

        const responses = await Promise.allSettled(
          endpoints.map((endpoint) => api.get(endpoint.url))
        );

        responses.forEach((response, index) => {
          const key = endpoints[index].key;
          if (response.status === "fulfilled") {
            results[key] = response.value.data || [];
          } else {
            console.error(`Failed to fetch ${key}:`, response.reason);
            // Return empty array instead of fallback data
            results[key] = [];
          }
        });

        setDashboardData(results);
        setLoading(false);
      } catch (error) {
        console.error("Error fetching dashboard data:", error);
        setError("Failed to load dashboard data. Please try again later.");
        setLoading(false);
      }
    };

    fetchDashboardData();
  }, []);

  const renderNoData = () => <div className="no-data">Data invalid</div>;

  const getTotalEmployees = () => {
    if (
      !dashboardData.employeeGrowth ||
      dashboardData.employeeGrowth.length === 0
    )
      return "Data invalid";
    return (
      dashboardData.employeeGrowth[dashboardData.employeeGrowth.length - 1]
        ?.count || "Data invalid"
    );
  };

  const getAverageHours = () => {
    if (
      !dashboardData.attendanceHours ||
      dashboardData.attendanceHours.length === 0
    )
      return "Data invalid";
    const total = dashboardData.attendanceHours.reduce(
      (sum, day) =>
        sum + (typeof day.average_hours === "number" ? day.average_hours : 0),
      0
    );
    return (total / dashboardData.attendanceHours.length).toFixed(1);
  };

  const getOpenJobs = () => {
    if (!dashboardData.jobStats || dashboardData.jobStats.length === 0)
      return "Data invalid";
    const openJobs = dashboardData.jobStats.find(
      (job) => job.status === "Open"
    );
    return openJobs ? openJobs.count : "Data invalid";
  };

  if (loading) {
    return (
      <div className="loading-container">
        <div className="loading-text">Loading dashboard data...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="error-container">
        <div className="error-text">{error}</div>
      </div>
    );
  }

  return (
    <div className="dashboard-container">
      <div className="dashboard-header">
        <h1 className="dashboard-title">HR Dashboard</h1>
      </div>

      {/* Summary cards */}
      <div className="summary-grid">
        <div className="summary-card">
          <div className="summary-card-content">
            <div
              className="summary-icon"
              style={{ backgroundColor: "rgba(59, 130, 246, 0.1)" }}
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="#3b82f6"
                width="24"
                height="24"
              >
                <path d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0112 12.75zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 01-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 002.248-2.354M12 12.75a2.25 2.25 0 01-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 00-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 01.4-2.253M12 8.25a2.25 2.25 0 01-2.248-2.354M12 8.25a2.25 2.25 0 002.248-2.354M12 2.25c-1.135 0-2.504.43-3.378 1.095a4.208 4.208 0 00-1.369 2.303A4.242 4.242 0 005.25 8.25M12 2.25c1.135 0 2.504.43 3.378 1.095a4.208 4.208 0 011.369 2.303 4.242 4.242 0 012.003 2.602M12 2.25a2.25 2.25 0 00-2.248 2.354M12 2.25a2.25 2.25 0 012.248 2.354" />
              </svg>
            </div>
            <div className="summary-data">
              <h3>Total Employees</h3>
              <div className="summary-value">{getTotalEmployees()}</div>
            </div>
          </div>
        </div>

        <div className="summary-card">
          <div className="summary-card-content">
            <div
              className="summary-icon"
              style={{ backgroundColor: "rgba(16, 185, 129, 0.1)" }}
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="#10b981"
                width="24"
                height="24"
              >
                <path
                  fillRule="evenodd"
                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                  clipRule="evenodd"
                />
              </svg>
            </div>
            <div className="summary-data">
              <h3>Avg. Work Hours</h3>
              <div className="summary-value">{getAverageHours()}</div>
            </div>
          </div>
        </div>

        <div className="summary-card">
          <div className="summary-card-content">
            <div
              className="summary-icon"
              style={{ backgroundColor: "rgba(245, 158, 11, 0.1)" }}
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="#f59e0b"
                width="24"
                height="24"
              >
                <path
                  fillRule="evenodd"
                  d="M7.5 5.25a3 3 0 013-3h3a3 3 0 013 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0112 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 017.5 5.455V5.25zm7.5 0v.09a49.488 49.488 0 00-6 0v-.09a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5zm-3 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                  clipRule="evenodd"
                />
                <path d="M3 18.4v-2.796a4.3 4.3 0 00.713.31A26.226 26.226 0 0012 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 01-6.477-.427C4.047 21.128 3 19.852 3 18.4z" />
              </svg>
            </div>
            <div className="summary-data">
              <h3>Open Jobs</h3>
              <div className="summary-value">{getOpenJobs()}</div>
            </div>
          </div>
        </div>

        <div className="summary-card">
          <div className="summary-card-content">
            <div
              className="summary-icon"
              style={{ backgroundColor: "rgba(139, 92, 246, 0.1)" }}
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="#8b5cf6"
                width="24"
                height="24"
              >
                <path
                  fillRule="evenodd"
                  d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm4.5 7.5a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0v-2.25a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0v4.5a.75.75 0 001.5 0V12zm2.25-3a.75.75 0 01.75.75v6.75a.75.75 0 01-1.5 0V9.75A.75.75 0 0113.5 9zm3.75-1.5a.75.75 0 00-1.5 0v9a.75.75 0 001.5 0v-9z"
                  clipRule="evenodd"
                />
              </svg>
            </div>
            <div className="summary-data">
              <h3>Departments</h3>
              <div className="summary-value">
                {dashboardData.departmentStats?.length || "Data invalid"}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="dashboard-grid">
        {/* Department Distribution */}
        <div className="chart-card">
          <h2 className="chart-title">Department Distribution</h2>
          <div className="chart-container pie-chart-container">
            {dashboardData.departmentStats &&
            dashboardData.departmentStats.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <PieChart>
                  <Pie
                    data={dashboardData.departmentStats}
                    dataKey="count"
                    nameKey="name"
                    cx="50%"
                    cy="50%"
                    outerRadius={80}
                    label={({ name, percent }) =>
                      `${name}: ${
                        percent && typeof percent === "number"
                          ? (percent * 100).toFixed(0)
                          : 0
                      }%`
                    }
                  >
                    {dashboardData.departmentStats.map((entry, index) => (
                      <Cell
                        key={`cell-${index}`}
                        fill={COLORS[index % COLORS.length]}
                      />
                    ))}
                  </Pie>
                  <Tooltip
                    formatter={(value) =>
                      typeof value === "number"
                        ? [`${value} employees`, "Count"]
                        : ["N/A", "Count"]
                    }
                  />
                  <Legend />
                </PieChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* User Type Distribution */}
        <div className="chart-card">
          <h2 className="chart-title">User Type Distribution</h2>
          <div className="chart-container bar-chart-container">
            {dashboardData.userTypeDistribution &&
            dashboardData.userTypeDistribution.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <BarChart data={dashboardData.userTypeDistribution}>
                  <CartesianGrid strokeDasharray="3 3" vertical={false} />
                  <XAxis dataKey="type" />
                  <YAxis />
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "users")}
                  />
                  <Legend />
                  <Bar dataKey="count" fill="#3b82f6" radius={[4, 4, 0, 0]} />
                </BarChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Employee Growth Over Time */}
        <div className="chart-card">
          <h2 className="chart-title">Employee Growth</h2>
          <div className="chart-container area-chart-container">
            {dashboardData.employeeGrowth &&
            dashboardData.employeeGrowth.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <AreaChart data={dashboardData.employeeGrowth}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" />
                  <XAxis dataKey="date" />
                  <YAxis />
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "employees")}
                  />
                  <Legend />
                  <Area
                    type="monotone"
                    dataKey="count"
                    stroke="#8b5cf6"
                    fill="#8b5cf6"
                    fillOpacity={0.3}
                    activeDot={{ r: 6 }}
                  />
                </AreaChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Average Work Hours */}
        <div className="chart-card">
          <h2 className="chart-title">Daily Average Work Hours</h2>
          <div className="chart-container line-chart-container">
            {dashboardData.attendanceHours &&
            dashboardData.attendanceHours.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <LineChart data={dashboardData.attendanceHours}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" />
                  <XAxis dataKey="day" />
                  <YAxis domain={[0, "dataMax + 2"]} />
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "hours", 2)}
                  />
                  <Legend />
                  <Line
                    type="monotone"
                    dataKey="average_hours"
                    stroke="#10b981"
                    strokeWidth={2}
                    dot={{ fill: "#10b981", strokeWidth: 2, r: 4 }}
                    activeDot={{ r: 6, fill: "#10b981", stroke: "#fff" }}
                  />
                </LineChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Attendance Locations */}
        <div className="chart-card">
          <h2 className="chart-title">Attendance by Location</h2>
          <div className="chart-container pie-chart-container">
            {dashboardData.attendanceLocations &&
            dashboardData.attendanceLocations.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <PieChart>
                  <Pie
                    data={dashboardData.attendanceLocations}
                    dataKey="count"
                    nameKey="location"
                    cx="50%"
                    cy="50%"
                    outerRadius={80}
                    label={({ name, percent }) =>
                      `${name}: ${
                        percent && typeof percent === "number"
                          ? (percent * 100).toFixed(0)
                          : 0
                      }%`
                    }
                  >
                    {dashboardData.attendanceLocations.map((entry, index) => (
                      <Cell
                        key={`cell-${index}`}
                        fill={COLORS[index % COLORS.length]}
                      />
                    ))}
                  </Pie>
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "employees")}
                  />
                  <Legend />
                </PieChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Job Statistics */}
        <div className="chart-card">
          <h2 className="chart-title">Job Statistics</h2>
          <div className="chart-container bar-chart-container">
            {dashboardData.jobStats && dashboardData.jobStats.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <BarChart data={dashboardData.jobStats}>
                  <CartesianGrid strokeDasharray="3 3" vertical={false} />
                  <XAxis dataKey="status" />
                  <YAxis />
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "jobs")}
                  />
                  <Legend />
                  <Bar dataKey="count" fill="#f59e0b" radius={[4, 4, 0, 0]} />
                </BarChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Job Applications */}
        <div className="chart-card">
          <h2 className="chart-title">Job Applications by Status</h2>
          <div className="chart-container radar-chart-container">
            {dashboardData.jobApplicationStats &&
            dashboardData.jobApplicationStats.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <RadarChart
                  outerRadius={90}
                  data={dashboardData.jobApplicationStats}
                >
                  <PolarGrid />
                  <PolarAngleAxis dataKey="status" />
                  <PolarRadiusAxis angle={30} domain={[0, "auto"]} />
                  <Radar
                    name="Applications"
                    dataKey="count"
                    stroke="#FF8042"
                    fill="#FF8042"
                    fillOpacity={0.6}
                  />
                  <Legend />
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "applications")}
                  />
                </RadarChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Project Status */}
        <div className="chart-card">
          <h2 className="chart-title">Projects by Status</h2>
          <div className="chart-container pie-chart-container">
            {dashboardData.projectStats &&
            dashboardData.projectStats.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <PieChart>
                  <Pie
                    data={dashboardData.projectStats}
                    dataKey="count"
                    nameKey="status"
                    cx="50%"
                    cy="50%"
                    outerRadius={100}
                    label={({ name, percent }) =>
                      name && percent && typeof percent === "number"
                        ? `${name}: ${(percent * 100).toFixed(0)}%`
                        : ""
                    }
                  >
                    {dashboardData.projectStats.map((entry, index) => (
                      <Cell
                        key={`cell-${index}`}
                        fill={COLORS[index % COLORS.length]}
                      />
                    ))}
                  </Pie>
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "projects")}
                  />
                  <Legend />
                </PieChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Onboarding Progress */}
        <div className="chart-card">
          <h2 className="chart-title">Employee Onboarding Progress</h2>
          <div className="chart-container bar-chart-container">
            {dashboardData.onboardingProgress &&
            dashboardData.onboardingProgress.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <BarChart data={dashboardData.onboardingProgress}>
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis dataKey="name" />
                  <YAxis domain={[0, 100]} />
                  <Tooltip formatter={(value) => safeFormatter(value, "%")} />
                  <Legend />
                  <Bar dataKey="percentage" fill="#82ca9d" />
                </BarChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Department Managers */}
        <div className="chart-card">
          <h2 className="chart-title">Department Managers</h2>
          <div className="chart-container table-container">
            {dashboardData.departmentManagers &&
            dashboardData.departmentManagers.length > 0 ? (
              <table className="min-w-full">
                <thead>
                  <tr>
                    <th className="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                      Department
                    </th>
                    <th className="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                      Manager
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {dashboardData.departmentManagers.map((item, index) => (
                    <tr key={index}>
                      <td className="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        {item.department}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        {item.manager}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            ) : (
              renderNoData()
            )}
          </div>
        </div>

        {/* Task Completion */}
        <div className="chart-card">
          <h2 className="chart-title">Task Completion Trends</h2>
          <div className="chart-container area-chart-container">
            {dashboardData.taskCompletion &&
            dashboardData.taskCompletion.length > 0 ? (
              <ResponsiveContainer width="100%" height="100%">
                <AreaChart data={dashboardData.taskCompletion}>
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis dataKey="date" />
                  <YAxis />
                  <Tooltip
                    formatter={(value) => safeFormatter(value, "tasks")}
                  />
                  <Legend />
                  <Area
                    type="monotone"
                    dataKey="completed"
                    stackId="1"
                    stroke="#82ca9d"
                    fill="#82ca9d"
                  />
                  <Area
                    type="monotone"
                    dataKey="pending"
                    stackId="1"
                    stroke="#ffc658"
                    fill="#ffc658"
                  />
                </AreaChart>
              </ResponsiveContainer>
            ) : (
              renderNoData()
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
