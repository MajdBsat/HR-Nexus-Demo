import "./index.css"
const Jobs_Card = ({props}) => {
    console.log({props});
    const deleteJob = () =>{
        console.log("deleted")
    }
    return(
        <div className="job_card flex column center item-start">
            <p className="job_title">{props["title"]}</p>
            <p className="job_description">{props["description"]}</p>
            <p className="job_requirements">{props["requirements"]}</p>
            <div className="button flex content-end width100">
                <button className="" onClick={deleteJob}>Delete</button>
            </div>
        </div>
    )
}
export default Jobs_Card