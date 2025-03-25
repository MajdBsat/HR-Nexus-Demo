import React, { useState } from "react";
import Payroll_Main_Header from "../../../components/Payroll_Main_Header";
import Table from "../../../components/Table";

function PayrollMain() {
    const [role, setRole] = useState("Management");
    const [searchQuery, setSearchQuery] = useState("");

    const headers = ["ID", "Name", "Salary", "Department", "Action"];

    const payrollData = [
        { id: 1, name: "John Doe", salary: "$4000", department: "IT", role: "Management", action: "View" },
        { id: 2, name: "Jane Smith", salary: "$3500", department: "HR", role: "Employee", action: "View" },
        { id: 3, name: "Mark Lee", salary: "$4500", department: "Finance", role: "Management", action: "View" }
    ];

    const filteredData = payrollData.filter(item =>
        item.role === role && item.name.toLowerCase().includes(searchQuery.toLowerCase())
    );

    return (
        <div className="payroll-container">

            <Payroll_Main_Header 
                onRoleChange={setRole} 
                onSearch={setSearchQuery} 
            />
            <div className="r1 flex center content-end width100 height100">
                <div className="table main flex column center item-start">
                    <h2>Salaries</h2>
                    <div className='flex center width100 height100'>
                        <Table header={headers} data={filteredData} fun={payrollData}/>
                    </div>
                    <div className="pagination flex center content-end width100">
                        <div>pagination</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default PayrollMain;
