import api from "./api";

export const getSkills = async () => {
    const response = await api.get("/skills");
    return response.data.data ?? response.data ?? [];
};

export const getProfile = getSkills;

export default getSkills;