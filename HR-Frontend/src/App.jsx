import {Route, Routes} from 'react-router-dom'
import Recruitment from './pages/Recruitment'
import './styles/App.css'
import Jobs from './pages/Jobs'
import Candidates from './pages/Candidates'
import Jobs_Emp from './pages/Jobs_Emp'

function App() {

  return (
    <>
      {/* <>SideBar</> */}
      <Routes>
        <Route path="/hr">
          <Route path="recruitment">
              <Route index element={<Recruitment />} />
              <Route path="jobs" element={<Jobs />} />
              <Route path="candidates" element={<Candidates />} />
          </Route>
        </Route>

        <Route path="/emp">
          <Route path="recruitment">
              <Route path="jobs" element={<Jobs_Emp />} />
          </Route>
        </Route>
        
      </Routes>
    </>
  )
}

export default App
