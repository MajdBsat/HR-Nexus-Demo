import {Route, Routes} from 'react-router-dom'
import Recruitment from './pages/Recruitment'
import './styles/App.css'

function App() {

  return (
    <>
      {/* <>SideBar</> */}
      <Routes>
        <Route path='/recruitment' element={<Recruitment/>}/>
      </Routes>
    </>
  )
}

export default App
