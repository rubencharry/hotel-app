import RoomTypeApi from "@/adapters/api/RoomTypeApi";

const RoomTypeService = {
    async getRoomTypes() {
        return await RoomTypeApi.getRoomTypes();
    },
};

export default RoomTypeService;
