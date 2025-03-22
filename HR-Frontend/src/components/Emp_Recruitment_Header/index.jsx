import { useEffect } from 'react';
import './index.css'
import {useNavigate} from 'react-router-dom'
const Emp_Recruitment_Header = () =>{
    const navigate = useNavigate();
    const goToJobs = ()=>{
        navigate("/emp/recruitment/jobs/")
    }
    const goToCandidates = () =>{
        navigate("/emp/recruitment/candidates/")
    } 
    const goToOnboarding = () =>{
        navigate("/emp/recruitment/onboarding/")
    } 

    const getSelected = () =>{
        const tab_arr = window.location.href.split('/').filter(item => item !== "");
        const tab = tab_arr.reverse()[0].toLowerCase();
        const buttons = document.querySelectorAll('.recruitment-nav button');
        let selected_button = null;
        
        buttons.forEach(button => {
            if (button.textContent.trim().toLowerCase() === tab) {
                selected_button = button;
            }
        });

        if(selected_button){
            selected_button.classList.add('selected')
        }
    }

    useEffect(getSelected,[]);

    return(
        <div className='recruitment-head flex row center width100'>
            <div className='recruitment-nav flex row center content-start height100'>
                <button className='' onClick={goToJobs}>Jobs</button>
                <button className='' onClick={goToCandidates}>Candidates</button>
                <button className='' onClick={goToOnboarding}>Onboarding</button>
            </div>

            <div className='recruitment-search-new flex row center content-end height100'>
                <input id='search' type="search" placeholder='Search...'/>
            </div>
        </div>
    )
} 
export default Emp_Recruitment_Header;