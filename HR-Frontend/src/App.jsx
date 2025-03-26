import { Route, Routes } from "react-router-dom";
import Recruitment from "./pages/Recruitment";
import "./styles/App.css";
import Jobs from "./pages/Recruitment/Jobs";
import Candidates from "./pages/Recruitment/Candidates";
import Onboarding from "./pages/Recruitment/Onboarding";
import Jobs_Emp from "./pages/Recruitment/Jobs_Emp";
import Add_new_job from "./pages/Recruitment/New_Job";
import Add_New_Onboarding_Task from "./pages/Recruitment/New_Onboarding_Task";
import Apply_To_Job from "./pages/Recruitment/Apply_To_Job";
import Onboarding_Emp from "./pages/Recruitment/Onboarding_Emp";
import PayrollMain from "./pages/Payroll/Payroll_Main_Page";
import Login from "./components/Login";
import Register from "./components/Register";
import EmployeeList from "./pages/EmployeeManagement/EmployeeList";
import UserProfile from "./pages/Profile/UserProfile";
import Dashboard from "./pages/Dashboard/Dashboard";
import Attendance from "./pages/Attendance/Attendance";
import Sidebar from "./components/Side_Bar";
import Document from "./pages/DocumentManagement/Document";

function App() {
  return (
    <div className="width100">
      <Sidebar />
      <div className="page-content">
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/profile" element={<UserProfile />} />
          <Route path="/attendance" element={<Attendance />} />
          <Route path="/document" element={<Document />} />
          <Route path="/hr">
            <Route path="dashboard" element={<Dashboard />} />
            <Route path="employees" element={<EmployeeList />} />
            <Route path="recruitment">
              <Route path="" element={<Recruitment />} />
              <Route path="jobs">
                <Route path="" element={<Jobs />} />
                <Route path="newJob" element={<Add_new_job />} />
              </Route>
              <Route path="candidates" element={<Candidates />} />
              <Route path="onboarding">
                <Route path="" element={<Onboarding />} />
                <Route path="newTask" element={<Add_New_Onboarding_Task />} />
              </Route>
            </Route>
            <Route path="payroll">
              <Route path="" element={<PayrollMain />} />
            </Route>
          </Route>

          <Route path="/emp">
            <Route path="recruitment">
              <Route path="jobs">
                <Route path="" element={<Jobs_Emp />} />
                <Route path="apply" element={<Apply_To_Job />} />
              </Route>
              <Route path="onboarding">
                <Route path="" element={<Onboarding_Emp />} />
              </Route>
            </Route>
          </Route>
        </Routes>
      </div>
    </div>
  );
}

export default App;
