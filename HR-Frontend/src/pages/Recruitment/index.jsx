import {Routes, Route, useNavigate} from 'react-router-dom'
const Recruitment = () =>{
    const navigate = useNavigate();
    const goToJobs = ()=>{
        // navigate("/recruitment/jobs")
        navigate("jobs")
    }
    const goToCandidates = () =>{
        // navigate("/recruitment/candidates")
        navigate("candidates")

    } 
    return(
        <>
            <h1>Hello from Recruitment</h1>
            <button onClick={goToJobs}>Jobs</button>
            <button onClick={goToCandidates}>Candidates</button>
        </>
    )
} 
export default Recruitment;