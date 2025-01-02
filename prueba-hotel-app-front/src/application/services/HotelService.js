import HotelApi from "@/adapters/api/HotelApi";

const HotelService = {
  async fetchHotels() {
    return await HotelApi.getAllHotels();
  },

  async getHotelById(id) {
    return await HotelApi.getHotelById(id);
  },

  async addHotel(hotel) {
    return await HotelApi.createHotel(hotel);
  },

  async updateHotel(id, hotel) {
    return await HotelApi.updateHotel(id, hotel);
  },

  async deleteHotel(id) {
    await HotelApi.deleteHotel(id);
  },
};

export default HotelService;
