import { useNavigate } from "react-router-dom";
import "./index.css"
import { request } from "../../utils/axios";
import { requestMethods } from "../../utils/request_methods";
const Job_Emp_Card = ({props}) => {
    const navigate = useNavigate();
    const applyJob = () =>{
        navigate("apply", { state: { props } });
    }

    const getStatus = async () => {
        const base = "http://localhost:8000/api/";
        const response = await request({
            method: requestMethods.GET,
            url: base + 'candidates/getUserCandidateStatus/'+props.id,
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        if(response.success){
            alert("You are in: " + response.data.status)
        }
    }
    return(
        <div className="emp_job_card flex column center item-start" onClick={getStatus}>
            <p className="emp_job_title">{props["title"]}</p>
            <p className="emp_job_description">{props["description"]}</p>
            <p className="emp_job_requirements">{props["requirement"]}</p>
            <div className="emp_button flex content-end width100">
                <button className="" onClick={applyJob}>Apply</button>
            </div>
        </div>
    )
}
export default Job_Emp_Card