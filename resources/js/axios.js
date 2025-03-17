import axios from "axios"
import router from "./router"

const axiosClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        "Content-Type": 'application/json',
        Accept: 'application/json'
    }
})

export default axiosClient;