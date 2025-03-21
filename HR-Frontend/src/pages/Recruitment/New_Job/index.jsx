import { useNavigate } from "react-router-dom";
import "./index.css"

const Add_new_job = () =>{
    const navigate = useNavigate();
    const cancel = (e) =>{
        e.preventDefault()
        console.log('Cancel')
        navigate("/hr/recruitment/jobs/")
    }

    const addJob = (e) =>{
        e.preventDefault()
        console.log('Add')
    }
    return(
        <div className="back-div flex column center width100vw height100vh">
            <form className="flex column center">
                <h2 className="form_title">Add New Job</h2>
                <div className="label_input flex column width50">
                    <label htmlFor="title">Job Title</label>
                    <input id="title" type="text" placeholder="Software Engineer"/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="description">Job Description</label>
                    <textarea rows={10} id="description" type="text" placeholder="We are seeking a skilled and detail-oriented Programmer to join our development team."/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="requirements">Job Requirements</label>
                    <textarea rows={10} id="requirements" type="text" placeholder="HTML, CSS, JS, PHP, Laravel"/>
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