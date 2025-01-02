import { createRouter, createWebHistory } from "vue-router";
import HotelList from "../views/HotelList.view.vue";
import HotelForm from "../components/HotelForm.vue";
import HotelDetail from "../views/HotelDetail.view.vue";
import RoomForm from "../components/RoomForm.vue";

const routes = [
  { path: "/", name: "HotelList", component: HotelList },
  { path: "/hotel/create", name: "CreateHotel", component: HotelForm },
  { path: "/hotel/edit/:id", name: "EditHotel", component: HotelForm },
  { path: "/hotel/:id", name: "HotelDetail", component: HotelDetail },
  { path: "/hotel/:hotelId/room/create", name: "CreateRoom", component: RoomForm },
  { path: "/hotel/:hotelId/room/edit/:roomId", name: "EditRoom", component: RoomForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
