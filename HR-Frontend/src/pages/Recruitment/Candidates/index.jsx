import Recruitment_Header_without_new from "../../../components/Recruitment_Header_without_new";
import Table from "../../../components/Table"

const Candidates = () => {
    const header = ['Candidate ID','Employee Name', 'Position', 'Status', 'Action']
    const data=[{"id": 12,
        'Candidate ID':"00011",
        'Employee Name': "haidar", 
        'Position': "Content Creative", 
        'Status': "Applied", 
        'Action': "button"},
        {"id": 13,
            'Candidate ID':"00012",
            'Employee Name': "Mostafa", 
            'Position': "UX Design", 
            'Status': "Interviewed", 
            'Action': "button"},
        {"id": 14,
            'Candidate ID':"00013",
            'Employee Name': "Mohammad", 
            'Position': "UX Testing", 
            'Status': "Hired", 
            'Action': "button"},
        {"id": 15,
            'Candidate ID':"00014",
            'Employee Name': "Majd", 
            'Position': "Graphic Design", 
            'Status': "Rejected", 
            'Action': "button"}
    ];
    const candidateAction = (text) => {
        console.log(text)
    }
    return(
        <>
            <div className="r1 flex center content-end width100 height100">
                <div className='main flex column center width100'>
                    <Recruitment_Header_without_new/>
                </div>
            </div>

            <div className="r1 flex center content-end width100 height100">
                <div className='main flex column center width100'>
                    <Table header={header} data={data} fun={candidateAction}/>
                </div>
            </div>
        </>
    )
}
export default Candidates