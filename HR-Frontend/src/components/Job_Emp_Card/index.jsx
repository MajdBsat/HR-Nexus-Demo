import "./index.css"
const Job_Emp_Card = ({props}) => {
    console.log({props});
    const applyJob = () =>{
        console.log("applied")
    }
    return(
        <div className="emp_job_card flex column center item-start">
            <p className="emp_job_title">{props["title"]}</p>
            <p className="emp_job_description">{props["description"]}</p>
            <p className="emp_job_requirements">{props["requirements"]}</p>
            <div className="emp_button flex content-end width100">
                <button className="" onClick={applyJob}>Apply</button>
            </div>
        </div>
    )
}
export default Job_Emp_Card