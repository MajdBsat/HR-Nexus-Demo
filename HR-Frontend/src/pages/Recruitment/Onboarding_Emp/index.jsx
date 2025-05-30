import { useNavigate } from "react-router-dom";
import Table from "../../../components/Table"
import Emp_Recruitment_Header from "../../../components/Emp_Recruitment_Header";

const Onboarding_Emp = () => {
    const header = ['Employee ID','Task Name', 'Status', 'Priority','Due', 'Assign', 'Action']
    const data=[{"id": 12,
                'Employee ID':'00123',
                'Task Name':'Recruitment & Hiring', 
                'Status':'InProgress', 
                'Priority':'High',
                'Due':'2024, Oct 27', 
                'Assign':'2024, Oct 24', 
                'Action':'button',
            },{"id": 13,
                'Employee ID':'00123',
                'Task Name':'Recruitment & Hiring', 
                'Status':'InProgress', 
                'Priority':'High',
                'Due':'2024, Oct 27', 
                'Assign':'2024, Oct 24', 
                'Action':'button',
            },{"id": 14,
                'Employee ID':'00123',
                'Task Name':'Recruitment & Hiring', 
                'Status':'InProgress', 
                'Priority':'High',
                'Due':'2024, Oct 27', 
                'Assign':'2024, Oct 24', 
                'Action':'button',
            },{"id": 15,
                    'Employee ID':'00123',
                    'Task Name':'Recruitment & Hiring', 
                    'Status':'InProgress', 
                    'Priority':'High',
                    'Due':'2024, Oct 27', 
                    'Assign':'2024, Oct 24', 
                    'Action':'button',
            }];

            const data1=[{"id": 16,
                'Employee ID':'00123',
                'Task Name':'Recruitment & Hiring', 
                'Status':'Pending', 
                'Priority':'High',
                'Due':'2024, Oct 27', 
                'Assign':'2024, Oct 24', 
                'Action':'button',
            },{"id": 17,
                'Employee ID':'00123',
                'Task Name':'Recruitment & Hiring', 
                'Status':'Pending', 
                'Priority':'High',
                'Due':'2024, Oct 27', 
                'Assign':'2024, Oct 24', 
                'Action':'button',
            },{"id": 17,
                'Employee ID':'00123',
                'Task Name':'Recruitment & Hiring', 
                'Status':'Pending', 
                'Priority':'High',
                'Due':'2024, Oct 27', 
                'Assign':'2024, Oct 24', 
                'Action':'button',
            },{"id": 19,
                    'Employee ID':'00123',
                    'Task Name':'Recruitment & Hiring', 
                    'Status':'Pending', 
                    'Priority':'High',
                    'Due':'2024, Oct 27', 
                    'Assign':'2024, Oct 24', 
                    'Action':'button',
            }];
            const onBoardingAction = (text) => {
                console.log(text)
            }
            const navigate = useNavigate();

            const newOnboarding = () => {
                navigate("/hr/recruitment/onboarding/newTask")
            }
    return(
        <>
            <div className="r1 flex center content-end width100 height100">
                <div className='main flex column center'>
                    <Emp_Recruitment_Header fun={newOnboarding}/>
                </div>
            </div>
            <div className="r1 flex center content-end width100 height100">
                <div className="table main flex column center item-start">
                    <h2>In Progress</h2>
                    <div className='flex center width100 height100'>
                        <Table header={header} data={data} fun={onBoardingAction}/>
                    </div>
                    <div className="pagination flex center content-end width100">
                        <div>pagination</div>
                    </div>
                </div>
            </div>

            <div className="r1 flex center content-end width100 height100">
                <div className="table main flex column center item-start">
                    <h2>Pending</h2>
                    <div className='flex center width100 height100'>
                        <Table header={header} data={data1} fun={onBoardingAction}/>
                    </div>
                    <div className="pagination flex center content-end width100">
                        <div>pagination</div>
                    </div>
                </div>
            </div>
        </>
    )
}
export default Onboarding_Emp