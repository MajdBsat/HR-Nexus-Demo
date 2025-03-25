import { colors } from "../../utils/colors";
import "./index.css";

const Table = ({ header, data, fun }) => {
  return (
    <div className="table flex column center width100 height100">
      <div className="table-head flex width100">
        {header.map((header, index) => {
          return (
            <div key={index} className="row flex width100">
              <div className="flex center cell">
                <p>{header}</p>
              </div>
            </div>
          );
        })}
      </div>

      {data.map((data, index) => {
        return (
          <div key={index} className="row flex width100">
            {Object.keys(data).map((value) => {
              if (value.toLowerCase() == "id") {
                return null;
              }

              // Check if data[value] is a string before calling toUpperCase
              const cellValue = data[value];
              const isString = typeof cellValue === "string";
              const upperCaseValue = isString ? cellValue.toUpperCase() : "";

              // Only look up color if it's a string
              const isColor =
                isString &&
                Object.prototype.hasOwnProperty.call(colors, upperCaseValue);
              const color = isColor ? colors[upperCaseValue] : "#333A40";

              if (value.toLowerCase() == "action") {
                return (
                  <div className="cell btn" key={value}>
                    <button onClick={() => fun(data["id"])} key={value}>
                      {cellValue}
                    </button>
                  </div>
                );
              }
              return (
                <div className="cell flex center" key={value}>
                  <p style={{ color: color }} key={value}>
                    {cellValue !== null && cellValue !== undefined
                      ? cellValue
                      : ""}
                  </p>
                </div>
              );
            })}
          </div>
        );
      })}
    </div>
  );
};
export default Table;
