import AccommodationApi from "@/adapters/api/AccommodationApi";

const AccommodationService = {
    async getAccommodationsByRoomType(id) {
        return await AccommodationApi.getAccommodationsByTypeId(id);
    },
};

export default AccommodationService;
