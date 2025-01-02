import axiosInstance from "./AxiosInstance";

const AccommodationApi = {
  async getAccommodationsByTypeId(id) {
    try {
      const response = await axiosInstance.get(`/get-accommodation-by-room-type/${id}`);
      return response.data;
    } catch (error) {
      console.error("Error al obtener las acomodaciones:", error.response || error.message);
      throw new Error("No se pudo obtener la lista de acomodaciones.");
    }
  },
}

export default AccommodationApi;
