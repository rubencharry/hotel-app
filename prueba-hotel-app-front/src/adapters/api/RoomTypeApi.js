import axiosInstance from "./AxiosInstance";

const RoomTypeApi = {
  async getRoomTypes() {
    try {
      const response = await axiosInstance.get('/get-room-types/');
      return response.data;
    } catch (error) {
      console.error("Error al obtener los tipos de habitación:", error.response || error.message);
      throw new Error("No se pudo obtener la lista de tipos de habitaciones.");
    }
  },
}

export default RoomTypeApi;
