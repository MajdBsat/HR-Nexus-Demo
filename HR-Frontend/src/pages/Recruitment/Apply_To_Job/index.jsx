import { useLocation, useNavigate } from "react-router-dom";
import "./index.css"
import { useState } from "react";
import { request } from "../../../utils/axios";
import { requestMethods } from "../../../utils/request_methods";
const Apply_To_Job = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const props = location.state?.props;
    const [form,] = useState({
        job_title: props.title,
        job_description: props.description,
        job_requirement: props.requirement
    });

    console.log("Apply: " + props.id)
    const cancel = (e) =>{
        e.preventDefault()
        console.log('Cancel')
        navigate("/emp/recruitment/jobs/")
    }

    const applyJob = async (e) =>{
        e.preventDefault()
        const base = "http://localhost:8000/api/";
        const response = await request({
            method: requestMethods.POST,
            url: base + 'candidates/',
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
            data:{
                'job_id': props.id  
            }
        });
        if(response.success){
            // alert(response.message)
            navigate("/emp/recruitment/jobs/")
        }else{
            alert(response.errors)
            navigate("/emp/recruitment/jobs/")
        }
        console.log('Applied')
    }

    return(
        <div className="back-div flex column center width100vw height100vh">
            <form className="flex column center">
                <h2 className="form_title">Add New Job</h2>
                <div className="label_input flex column width50">
                    <label htmlFor="title">Job Title</label>
                    <input id="title" type="text" placeholder="Software Engineer"
                    value={form.job_title} readOnly/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="description">Job Description</label>
                    <textarea rows={10} id="description" type="text" placeholder="We are seeking a skilled and detail-oriented Programmer to join our development team."
                    value={form.job_description} readOnly/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="requirements">Job Requirements</label>
                    <textarea rows={10} id="requirements" type="text" placeholder="HTML, CSS, JS, PHP, Laravel"
                    value={form.job_requirement} readOnly/>
                </div>

                <div className="buttons flex row center width50">
                    <button className="cancel-btn" onClick={(e)=>cancel(e)}>Cancel</button>
                    <button className="add-btn" onClick={(e)=>applyJob(e)}>Apply</button>
                </div>
            </form>
        </div>
    )
}
export default Apply_To_Job