import { useNavigate } from "react-router-dom";
import Table from "../../components/Table";
import { useEffect, useState } from "react";
import api from "../../utils/api";

const Attendance = () => {
  const [clockedIn, setClockedIn] = useState(false);
  const [clockInTime, setClockInTime] = useState(null);
  const [clockOutTime, setClockOutTime] = useState(null);
  const [onBreak, setOnBreak] = useState(false);
  const [breakStartTime, setBreakStartTime] = useState(null);
  const [breakEndTime, setBreakEndTime] = useState(0);
  const [location, setLocation] = useState(null);
  const [totalHours, setTotalHours] = useState(0);
  const [timeRecords, setTimeRecords] = useState([]);

  const navigate = useNavigate();

  // clock in function
  const clockIn = () => {
    const currentTime = new Date();
    setClockedIn(true);
    setClockInTime(currentTime);
    getLocation();
  };

  // start break
  const startBreak = () => {
    if (!onBreak) {
      setBreakStartTime(new Date());
      setOnBreak(true);
    }
  };

  // end break
  const endBreak = () => {
    if (onBreak) {
      const breakEndTime = new Date();
      const breakTime = (breakEndTime - breakStartTime) / 1000 / 60; // convert miliseconds to minutes
      setBreakEndTime((prev) => prev + breakTime);
      setOnBreak(false);
      setBreakStartTime(null);
    }
  };

  // clock out function
  const clockOut = () => {
    if (clockedIn) {
      const currentTime = new Date();
      setClockedIn(false);
      setClockOutTime(currentTime);

      // calculate total work hours excluding break time
      const totalWorkHours =
        (currentTime - clockInTime) / 1000 / 60 / 60 - breakEndTime / 60;
      setTotalHours(totalWorkHours);

      // add record to time tracking table
      setTimeRecords([
        ...timeRecords,
        {
          date: clockInTime.toLocaleDateString(),
          clockIn: clockInTime.toLocaleTimeString(),
          clockOut: currentTime.toLocaleTimeString(),
          location: location || "Unknown",
          totalHours: totalWorkHours.toFixed(2),
        },
      ]);

      // reset break duration
      setBreakEndTime(0);
    }
  };

  // function to get geolocation
  const getLocation = () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        setLocation(
          `${position.coords.latitude}, ${position.coords.longitude}`
        );
      });
    }
  };

  const header = ["Date", "Clock In", "Clock Out", "Location", "Total Hours"];
  const data = timeRecords;
  useEffect(() => {
    const sendAttendanceData = async () => {
      if (clockInTime) { 
        try {
          await api.post(
            "/api/clock-in",
            {
              attendance_date: new Date().toISOString(),
              clock_in: clockInTime,
            },
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
                "Content-Type": "application/json",
              },
            }
          );
        } catch (error) {
          console.error("Error sending attendance data:", error);
        }
      }
    };
  
    sendAttendanceData();
  }, [clockInTime]);
  useEffect(() => {
    const sendAttendanceData = async () => {
      if (clockOutTime, breakStartTime, breakEndTime) { 
        try {
          await api.post(
            "/api/clock-update",
            {
              attendance_date: new Date().toISOString(),
              clock_in: clockInTime,
            },
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
                "Content-Type": "application/json",
              },
            }
          );
        } catch (error) {
          console.error("Error sending attendance data:", error);
        }
      }
    };
  
    sendAttendanceData();
  }, [clockOutTime, breakStartTime, breakEndTime]);


  
  return (
    <>
      <div className="r1 flex center content-end width100 height100">
        <div className="main flex column center"></div>
      </div>

      <div className="r1 flex center content-end width100 height100">
        <div className="table main flex column center item-start">
          <h2>Time Tracking and Geolocation</h2>

          <div className="flex center width100 height100">
            <button onClick={clockIn} disabled={clockedIn}>
              Clock In
            </button>
            <button onClick={startBreak} disabled={!clockedIn || onBreak}>
              Start Break
            </button>
            <button onClick={endBreak} disabled={!onBreak}>
              End Break
            </button>
            <button onClick={clockOut} disabled={!clockedIn || onBreak}>
              Clock Out
            </button>
          </div>

          <Table header={header} data={data} />

          <div className="pagination flex center content-end width100">
            <div>pagination</div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Attendance;
