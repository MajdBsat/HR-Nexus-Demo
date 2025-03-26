import { useNavigate } from "react-router-dom";
import "./index.css"
import { request } from "../../../utils/axios";
import { requestMethods } from "../../../utils/request_methods";
import { useState } from "react";

const Add_new_job = () =>{
    const navigate = useNavigate();
    const base = "http://localhost:8000/api/";
    const[form, setForm] = useState({
        title:"",
        description:"",
        requirement:"",

    })
    const addJob = async (e) =>{
        console.log("Bearer " + localStorage.getItem("token"))
        console.log(form)

        e.preventDefault()      
        const response = await request({    
            method: requestMethods.POST,
            url: base + 'jobs',
            data: form,
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
            },
        });
        if(response.success){
            alert(response.message)
            navigate("/hr/recruitment/jobs/")
        }else{
            alert(response.errors)
            navigate("/hr/recruitment/jobs/")
        }
    }

    const cancel = (e) =>{
        e.preventDefault()
        console.log('Cancel')
        navigate("/hr/recruitment/jobs/")
    }

    return(
        <div className="back-div flex column center width100vw height100vh">
            <form className="flex column center">
                <h2 className="form_title">Add New Job</h2>
                <div className="label_input flex column width50">
                    <label htmlFor="title">Job Title</label>
                    <input id="title" type="text" placeholder="Software Engineer"
                    onChange={(e)=>{
                        setForm({
                            ...form,
                            title: e.target.value
                        })
                    }}/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="description">Job Description</label>
                    <textarea rows={10} id="description" type="text" placeholder="We are seeking a skilled and detail-oriented Programmer to join our development team."
                    onChange={(e)=>{
                        setForm({
                            ...form,
                            description: e.target.value
                        })
                    }}/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="requirements">Job Requirements</label>
                    <textarea rows={10} id="requirements" type="text" placeholder="HTML, CSS, JS, PHP, Laravel"
                    onChange={(e)=>{
                        setForm({
                            ...form,
                            requirement: e.target.value
                        })
                    }}/>
                </div>

                <div className="buttons flex row center width50">
                    <button className="cancel-btn" onClick={(e)=>cancel(e)}>Cancel</button>
                    <button className="add-btn" onClick={(e)=>addJob(e)}>Add</button>
                </div>
            </form>
        </div>
    )
}
export default Add_new_job