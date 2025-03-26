import axios from "axios";

axios.defaults.baseURL = "";
axios.defaults.headers = {
    "Content-Type": "application/json",
};

export const request = async ({ method, url, data, headers }) => {
    try {
        const response = await axios.request({
        method,
        headers,
        url,
        data,
        });

        return response.data;
    } catch (error) {
        return {
            error: true,
            message: error.message,
        };
    }
};
