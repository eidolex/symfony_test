import axios from "axios";

const backendClient = axios.create({
  baseURL: "http://localhost:8000",
});

backendClient.interceptors.request.use((config) => {
  config.headers["Accept"] = "application/json";
  return config;
});

export default backendClient;
