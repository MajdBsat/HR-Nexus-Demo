import { colors } from "../../utils/colors"
import './index.css'
const Table = ({header, data, fun}) => {
    return(
        <div className="table flex column center width100 height100">
                <div className="table-head flex width100">
                    {header.map((header, index) => {
                        return(
                            <div key={index} className="row flex width100">
                                <div className="flex center cell"><p>{header}</p></div>
                            </div>
                        )
                    })}
                </div>

                {data.map((data, index) => {
                    return(
                        <div key={index} className="row flex width100">
                            {Object.keys(data).map((value) => {
                                if(value.toLowerCase()=='id'){
                                    return;
                                }
                                const isColor = Object.prototype.hasOwnProperty.call(colors, data[value].toUpperCase())
                                const color = isColor ? colors[data[value].toUpperCase()] : '#333A40';
                                if(data[value].toLowerCase()=='button'){
                                    return  <div on className="cell btn" key={value}><button onClick={()=>fun(data["id"])} style={{color:color}} key={value}>{data[value]}</button></div>
                                }
                                return  <div className="cell" key={value}><p style={{color:color}} key={value}>{data[value]}</p></div>
                            })}
                        </div>
                    )
                })}
        </div>
    )
}
export default Table