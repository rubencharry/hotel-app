import RoomApi from "@/adapters/api/RoomApi";

const RoomService = {
    async getHotelRooms(id) {
        return await RoomApi.getHotelRooms(id);
    },

    async getRoomById(id) {
        return await RoomApi.getRoomById(id);
    },

    async addRoom(room) {
        return await RoomApi.createRoom(room);
    },

    async updateRoom(id, room) {
        return await RoomApi.updateRoom(id, room);
    },

    async deleteRoom(id) {
        await RoomApi.deleteRoom(id)
    },
};

export default RoomService;
