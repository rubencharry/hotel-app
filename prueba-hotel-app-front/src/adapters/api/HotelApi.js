import axiosInstance from "./AxiosInstance";

const HotelApi = {
  async getAllHotels() {
    try {
      const response = await axiosInstance.get("/get-all-hotels");
      return response.data;
    } catch (error) {
      console.error("Error al obtener los hoteles:", error.response || error.message);
      throw new Error("No se pudo obtener la lista de hoteles.");
    }
  },

  async getHotelById(id) {
    try {
      const response = await axiosInstance.get(`/get-hotel-by-id/${id}`);
      return response.data;
    } catch (error) {
      console.error("Error al obtener hotel:", error.response || error.message);
      throw new Error("No se pudo obtener el hotel.");
    }
  },

  async createHotel(hotel) {
    try {
      const response = await axiosInstance.post("/create-hotel", hotel);
      return response.data;
    } catch (error) {
      console.error("Error al crear el hotel:", error.response || error.message);
      throw new Error("No se pudo crear el hotel. Verifique los datos ingresados.");
    }
  },

  async updateHotel(id, hotel) {
    try {
      const response = await axiosInstance.put(`/update-hotel/${id}`, hotel);
      return response.data;
    } catch (error) {
      console.error("Error al actualizar el hotel:", error.response || error.message);
      throw new Error("No se pudo actualizar el hotel. Verifique los datos ingresados.");
    }
  },

  async deleteHotel(id) {
    try {
      await axiosInstance.delete(`/delete-hotel/${id}`);
    } catch (error) {
      console.error("Error al eliminar el hotel:", error.response || error.message);
      throw new Error("No se pudo eliminar el hotel. Intente de nuevo.");
    }
  },
};

export default HotelApi;
