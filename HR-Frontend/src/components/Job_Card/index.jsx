import { request } from "../../utils/axios";
import { requestMethods } from "../../utils/request_methods";
import "./index.css"
const Jobs_Card = ({props, f}) => {
    console.log({props});
    const base = "http://localhost:8000/api/";
    const deleteJob = async () =>{
        console.log(props.id)
        console.log("deleted")
        const response = await request({
            method: requestMethods.DELETE,
            url: base + 'jobs/'+props.id,
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        f(response.success)
        if(response.success){
            alert(response.message)
        }else{  
            alert(response.error)
        }
    }
    return(
        <div className="job_card flex column center item-start">
            <p className="job_title">{props["title"]}</p>
            <p className="job_description">{props["description"]}</p>
            <p className="job_requirements">{props["requirement"]}</p>
            <div className="button flex content-end width100">
                <button className="" onClick={deleteJob}>Delete</button>
            </div>
        </div>
    )
}
export default Jobs_Card