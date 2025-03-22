import {Route, Routes} from 'react-router-dom'
import Recruitment from './pages/Recruitment'
import './styles/App.css'
import Jobs from './pages/Recruitment/Jobs'
import Candidates from './pages/Recruitment/Candidates'
import Onboarding from './pages/Recruitment/Onboarding'
import Jobs_Emp from './pages/Recruitment/Jobs_Emp'
import Add_new_job from './pages/Recruitment/New_Job'
import Add_New_Onboarding_Task from './pages/Recruitment/New_Onboarding_Task'

function App() {

  return (
    <>
      {/* <>SideBar</> */}
      <Routes>
        <Route path="/hr">
          <Route path="recruitment">
              <Route path='' element={<Recruitment />} />
              <Route path="jobs">
                <Route path='' element={<Jobs/>} />
                <Route path='newJob' element={<Add_new_job/>}/>
              </Route>
              <Route path="candidates" element={<Candidates />} />
              <Route path="onboarding" >
                <Route path='' element={<Onboarding />} />
                <Route path='newTask' element={<Add_New_Onboarding_Task/>}/>
              </Route>
          </Route>
        </Route>

        <Route path="/emp">
          <Route path="recruitment">
              <Route path="jobs" element={<Jobs_Emp />}>
                
              </Route>
          </Route>
        </Route>
        
      </Routes>
    </>
  )
}

export default App
