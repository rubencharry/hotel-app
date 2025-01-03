import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://18.117.160.225/api",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

export default axiosInstance;
