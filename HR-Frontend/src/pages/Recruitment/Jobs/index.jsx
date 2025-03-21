import Recruitment_Header from "../../../components/Recruitment_Header";
import Jobs_Card from "../../../components/Job_Card";
import "./index.css"
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
    return(
        <>
            <div className="r1 flex center content-end width100 height100">
                <div className='recruitment flex column center width100'>
                    <Recruitment_Header/>
                </div>
            </div>
            
            <div className="r1 flex center content-end width100 height100">
                <div className='jobs flex row center wrap width100'>
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