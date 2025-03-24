import { useNavigate } from "react-router-dom";
import "./index.css"
const Add_New_Onboarding_Task = () => {
    const navigate = useNavigate();
    const cancel = (e) =>{
        e.preventDefault()
        console.log('Cancel')
        navigate("/hr/recruitment/onboarding/")
    }

    const addTask = (e) =>{
        e.preventDefault()
        console.log('Add')
    }
    return(
        <div className="onboarding-task back-div flex column center width100vw height100vh">
            <form className="flex column center">
                <h2 className="form_title">Add New Task</h2>
                <div className="label_input flex column width50">
                    <label htmlFor="title">Task Title</label>
                    <input id="title" name="title" type="text" placeholder="Deploy on server"/>
                </div>
                <div className="label_input flex column width50">
                    <label htmlFor="assign_to">Assign To</label>
                    <input id="title" name="assign_to" type="text" placeholder="Deploy on server"/>
                </div>

                <div className="label_input flex column width50">
                    <label>Due Date</label>
                    <div className="input-group flex row center">
                            <input type="date" id="date" className="width50"/>
                            <input type="time" id="time" className="width50"/>
                    </div>
                </div>

                <div className="label_input flex column width50">
                    <label htmlFor="description">Priority</label>
                    <select id="spinner-select" name="description" onchange="updateSpinner()">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div className="buttons flex row center width50">
                    <button className="cancel-btn" onClick={(e)=>cancel(e)}>Cancel</button>
                    <button className="add-btn" onClick={(e)=>addTask(e)}>Add</button>
                </div>
            </form>
        </div>
    )
}
export default Add_New_Onboarding_Task