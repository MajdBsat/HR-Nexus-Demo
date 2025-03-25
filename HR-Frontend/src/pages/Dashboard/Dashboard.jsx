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
    "#0088FE",
    "#00C49F",
    "#FFBB28",
    "#FF8042",
    "#8884D8",
    "#82ca9d",
    "#ffc658",
    "#d0ed57",
    "#a4de6c",
    "#d0ed57",
  ];

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

        const results = {};

        const responses = await Promise.allSettled(
          endpoints.map((endpoint) => api.get(endpoint.url))
        );

        responses.forEach((response, index) => {
          const key = endpoints[index].key;
          if (response.status === "fulfilled") {
            results[key] = response.value.data;
          } else {
            console.error(`Failed to fetch ${key}:`, response.reason);
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

      <div className="dashboard-grid">
        {/* Department Distribution */}
        <div className="chart-card">
          <h2 className="chart-title">Department Distribution</h2>
          <div className="chart-container pie-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={dashboardData.departmentStats}
                  dataKey="count"
                  nameKey="name"
                  cx="50%"
                  cy="50%"
                  outerRadius={100}
                  label={({ name, percent }) =>
                    `${name}: ${(percent * 100).toFixed(0)}%`
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
                  formatter={(value) => [`${value} employees`, "Count"]}
                />
                <Legend />
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* User Type Distribution */}
        <div className="chart-card">
          <h2 className="chart-title">User Type Distribution</h2>
          <div className="chart-container bar-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={dashboardData.userTypeDistribution}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="type" />
                <YAxis />
                <Tooltip formatter={(value) => [`${value} users`, "Count"]} />
                <Legend />
                <Bar dataKey="count" fill="#8884d8" />
              </BarChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Employee Growth Over Time */}
        <div className="chart-card">
          <h2 className="chart-title">Employee Growth</h2>
          <div className="chart-container area-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <AreaChart data={dashboardData.employeeGrowth}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="date" />
                <YAxis />
                <Tooltip />
                <Legend />
                <Area
                  type="monotone"
                  dataKey="count"
                  stroke="#8884d8"
                  fill="#8884d8"
                  fillOpacity={0.3}
                />
              </AreaChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Average Work Hours */}
        <div className="chart-card">
          <h2 className="chart-title">Daily Average Work Hours</h2>
          <div className="chart-container line-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <LineChart data={dashboardData.attendanceHours}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="day" />
                <YAxis domain={[0, "dataMax + 2"]} />
                <Tooltip
                  formatter={(value) => [
                    `${value.toFixed(2)} hours`,
                    "Average",
                  ]}
                />
                <Legend />
                <Line
                  type="monotone"
                  dataKey="average_hours"
                  stroke="#82ca9d"
                  activeDot={{ r: 8 }}
                />
              </LineChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Attendance Locations */}
        <div className="chart-card">
          <h2 className="chart-title">Attendance by Location</h2>
          <div className="chart-container pie-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={dashboardData.attendanceLocations}
                  dataKey="count"
                  nameKey="location"
                  cx="50%"
                  cy="50%"
                  outerRadius={100}
                  label={({ name, percent }) =>
                    `${name}: ${(percent * 100).toFixed(0)}%`
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
                  formatter={(value) => [`${value} employees`, "Count"]}
                />
                <Legend />
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Job Statistics */}
        <div className="chart-card">
          <h2 className="chart-title">Job Statistics</h2>
          <div className="chart-container bar-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={dashboardData.jobStats}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="status" />
                <YAxis />
                <Tooltip formatter={(value) => [`${value} jobs`, "Count"]} />
                <Legend />
                <Bar dataKey="count" fill="#82ca9d" />
              </BarChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Job Applications */}
        <div className="chart-card">
          <h2 className="chart-title">Job Applications by Status</h2>
          <div className="chart-container radar-chart-container">
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
                <Tooltip />
              </RadarChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Project Status */}
        <div className="chart-card">
          <h2 className="chart-title">Projects by Status</h2>
          <div className="chart-container pie-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={dashboardData.projectStats}
                  dataKey="count"
                  nameKey="status"
                  cx="50%"
                  cy="50%"
                  outerRadius={100}
                  label
                >
                  {dashboardData.projectStats.map((entry, index) => (
                    <Cell
                      key={`cell-${index}`}
                      fill={COLORS[index % COLORS.length]}
                    />
                  ))}
                </Pie>
                <Tooltip />
                <Legend />
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Onboarding Progress */}
        <div className="chart-card">
          <h2 className="chart-title">Employee Onboarding Progress</h2>
          <div className="chart-container bar-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={dashboardData.onboardingProgress}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="name" />
                <YAxis domain={[0, 100]} />
                <Tooltip formatter={(value) => [`${value}%`, "Completion"]} />
                <Legend />
                <Bar dataKey="percentage" fill="#82ca9d" />
              </BarChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Department Managers */}
        <div className="chart-card">
          <h2 className="chart-title">Department Managers</h2>
          <div className="chart-container table-container">
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
          </div>
        </div>

        {/* Task Completion */}
        <div className="chart-card">
          <h2 className="chart-title">Task Completion Trends</h2>
          <div className="chart-container area-chart-container">
            <ResponsiveContainer width="100%" height="100%">
              <AreaChart data={dashboardData.taskCompletion}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="date" />
                <YAxis />
                <Tooltip />
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
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
