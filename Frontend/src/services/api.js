import axios from "axios";

const api = axios.create({
  baseURL: "https://hero-dev.alwaysdata.net/api",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

export default api;