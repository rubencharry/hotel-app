<template>
  <AppPreload v-if="loading" />

  <div v-else class="p-6">
    <!-- Botón para regresar a la vista principal -->
    <button 
      @click="$router.push({ name: 'HotelList' })"
      class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
    >
      Volver a Hoteles
    </button>

    <!-- Información del Hotel -->
    <div v-if="!hotel" class="text-gray-500 mt-6">
      No hay datos o no existe el hotel
    </div>

    <!-- Información del Hotel -->
    <div v-else class="my-6 p-4 border rounded-lg shadow-md bg-gray-50">
      <h2 class="text-xl font-bold mb-4">Bienvenido al hotel: {{ hotel.name }}</h2>
      <p><strong>Dirección:</strong> {{ hotel.address }}</p>
      <p><strong>Ciudad:</strong> {{ hotel.city }}</p>
      <p><strong>NIT:</strong> {{ hotel.nit }}</p>
      <p><strong>Máximo de Habitaciones:</strong> {{ hotel.max_rooms }}</p>
    </div>

    <!-- Tabla de Habitaciones -->
    <h3 class="text-lg font-bold mb-4">Habitaciones</h3>
    <table class="table-auto w-full border border-gray-300 shadow-sm rounded-lg">
      <thead>
        <tr class="bg-gray-100 text-gray-700">
          <th class="px-4 py-2 border border-gray-300">Tipo de Habitación</th>
          <th class="px-4 py-2 border border-gray-300">Acomodación</th>
          <th class="px-4 py-2 border border-gray-300">Cantidad</th>
          <th class="px-4 py-2 border border-gray-300">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr 
          v-for="room in rooms" 
          :key="room.id" 
          class="hover:bg-gray-50 even:bg-gray-100"
        >
          <td class="border px-4 py-2 text-gray-700 text-center">{{ room.room_type.type }}</td>
          <td class="border px-4 py-2 text-gray-700 text-center">{{ room.accommodation.type }}</td>
          <td class="border px-4 py-2 text-gray-700 text-center">{{ room.quantity }}</td>
          <td class="px-4 py-2 border text-center">
            <div class="flex justify-center space-x-2">

              <button
                @click="editRoom(room.id)"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
              >
                Editar
              </button>

              <button
                @click="deleteRoom(room.id)"
                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
              >
                Eliminar
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <button
      @click="createRoom"
      class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 my-4"
    >
      Crear Habitación
    </button>
  </div>
</template>

<script>
import AppPreload from "@/components/Preload.vue";
import HotelService from "@/application/services/HotelService";
import RoomService from "@/application/services/RoomService";

export default {
  data() {
    return {
      hotel: null,
      loading: true, 
      rooms: null,
    };
  },
  components: {
    AppPreload,
  },
  mounted() {
    const hotelId = this.$route.params.id; 
    this.loadHotelDetails(hotelId);
    this.loadRooms(hotelId);
  },
  methods: {
    async loadHotelDetails(hotelId) {
      this.loading = true; 
      try {
        const response = await HotelService.getHotelById(hotelId);
        this.hotel = response;
      } catch (error) {
        console.error("Error al cargar los detalles del hotel:", error);
      } finally {
        this.loading = false; 
      }
    },
    async loadRooms(hotelId) {
      this.loading = true; 
      try {
        const response = await RoomService.getHotelRooms(hotelId);
        this.rooms = response;
      } catch (error) {
        console.error("Error al cargar las habitaciones:", error);
      } finally {
        this.loading = false; 
      }
    },

    createRoom() {
      this.$router.push({ name: "CreateRoom", params: { hotelId: this.$route.params.id } });
    },
    editRoom(roomId) {
      this.$router.push({ name: "EditRoom", params: { hotelId: this.$route.params.id, roomId } });
    },
    async deleteRoom(roomId) {
      if (confirm("¿Estás seguro de que deseas eliminar esta habitación?")) {
        try {
          await RoomService.deleteRoom(roomId);
          this.loadRooms( this.$route.params.id);
        } catch (error) {
          console.error("Error al eliminar la habitación:", error);
        }
      }
    },
  },
};
</script>

