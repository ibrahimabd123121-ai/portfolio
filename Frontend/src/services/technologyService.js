import api from "./api";

export const getTechnologies = async () => {
    const response = await api.get("/technologies");
    return response.data.data ?? response.data ?? [];
};

export const getProfile = getTechnologies;

export default getTechnologies;