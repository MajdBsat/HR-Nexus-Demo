import Recruitment_Header from "../../../components/Recruitment_Header";
import Jobs_Card from "../../../components/Job_Card";
import "./index.css"
import { useNavigate } from "react-router-dom";
const Jobs = () => {
    const jobs = [{'title':'Job Title', 'description':"We are seeking a skilled and detail-oriented Programmer to join our development team. The ideal candidate will be responsible for writing, testing, and maintaining code to develop software applications, websites, or systems. You will work closely with other developers, designers, and stakeholders to create efficient, scalable, and user-friendly solutions.",
                    'requirements':"HTML, CSS, JS, PHP, Laravel"},
                    {'title':'Job Title', 'description':"We are seeking a skilled and detail-oriented Programmer to join our development team. The ideal candidate will be responsible for writing, testing, and maintaining code to develop software applications, websites, or systems. You will work closely with other developers, designers, and stakeholders to create efficient, scalable, and user-friendly solutions.",
                    'requirements':"HTML, CSS, JS, PHP, Laravel"},
                    {'title':'Job Title', 'description':"We are seeking a skilled and detail-oriented Programmer to join our development team. The ideal candidate will be responsible for writing, testing, and maintaining code to develop software applications, websites, or systems. You will work closely with other developers, designers, and stakeholders to create efficient, scalable, and user-friendly solutions.",
                    'requirements':"HTML, CSS, JS, PHP, Laravel"},
                    {'title':'Job Title', 'description':"We are seeking a skilled and detail-oriented Programmer to join our development team. The ideal candidate will be responsible for writing, testing, and maintaining code to develop software applications, websites, or systems. You will work closely with other developers, designers, and stakeholders to create efficient, scalable, and user-friendly solutions.",
                    'requirements':"HTML, CSS, JS, PHP, Laravel"},
                    ];
    const navigate = useNavigate()
    const newJob = () => {
        navigate("/hr/recruitment/jobs/newJob")
    }
    return(
        <>
            <div className="r1 flex center content-end">
                <div className='main flex column center'>
                    <Recruitment_Header fun={newJob}/>
                </div>
            </div>
            
            <div className="r1 flex center content-end">
                <div className='main flex row center wrap'>
                    {
                        jobs.map((job,index) => {
                            return <Jobs_Card key={index} props={job}/>
                        })
                    }
                </div>
            </div>
        </>
    )
}
export default Jobs