import axiosInstance from "./AxiosInstance";

const RoomApi = {
  async getHotelRooms(id) {
    try {
      const response = await axiosInstance.get(`/get-rooms/${id}`);
      return response.data;
    } catch (error) {
      console.error("Error al obtener las habitaciones del hotel:", error.response || error.message);
      throw new Error("No se pudo obtener la lista de habitaciones de este hoteles.");
    }
  },

  async getRoomById(id) {
    try {
      const response = await axiosInstance.get(`/get-room-by-id/${id}`);
      return response.data;
    } catch (error) {
      console.error("Error al obtener la habitación:", error.response || error.message);
      throw new Error("No se pudo obtener la habitación.");
    }
  },

  async createRoom(room) {
    try {
      const response = await axiosInstance.post("/create-room", room);
      return response.data;
    } catch (error) {
      console.log("Error al crear la habitación:", error.response || error.message);
      throw new Error("No se pudo crear la habitación.");
    }
  },

  async updateRoom(id, room) {
    try {
      const response = await axiosInstance.post(`/update-room/${id}`, room);
      return response.data;
    } catch (error) {
      console.error("Error al actualizar la habitación:", error.response || error.message);
      throw new Error("No se pudo actualizar la habitación. Verifique los datos ingresados.");
    }
  },

  async deleteRoom(id) {
    try {
      await axiosInstance.delete(`/delete-room/${id}`);
    } catch (error) {
      console.error("Error al eliminar la habitación:", error.response || error.message);
      throw new Error("No se pudo eliminar la habitación. Intente de nuevo.");
    }
  },
};

export default RoomApi;
