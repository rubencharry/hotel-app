<template>
  <AppPreload v-if="loading" />

  <div v-else class="my-4">
    <h2 class="text-lg font-bold mb-4">{{ isEditing ? "Editar Habitación" : "Crear Habitación" }}</h2>
    <form @submit.prevent="handleSubmit" class="my-4">
      <!-- Tipo de habitación -->
      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">
          Tipo de Habitación
        </label>
        <select v-model="room.room_type_id" @change="fetchAccommodations"
          class="block w-full p-2 border border-gray-300 rounded" :disabled="isEditing" required>
          <option value="" disabled>Selecciona un tipo de habitación</option>
          <option v-for="type in roomTypes" :key="type.id" :value="type.id">
            {{ type.type }}
          </option>
        </select>
      </div>
      <!-- Acomodación -->
      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">Acomodación</label>
        <select v-model="room.accommodation_id" class="block w-full p-2 border border-gray-300 rounded"
          :disabled="isEditing" required>
          <option value="" disabled>Selecciona una acomodación</option>
          <option v-for="accommodation in accommodations" :key="accommodation.id" :value="accommodation.id">
            {{ accommodation.type }}
          </option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">Cantidad</label>
        <input v-model="room.quantity" type="text" class="border px-4 py-2 w-full rounded" placeholder="Cantidad"
          required />
      </div>
      <button type="submit" class="bg-green-500 text-white mx-1 px-4 py-2 rounded hover:bg-green-600">
        {{ isEditing ? "Actualizar" : "Guardar" }}
      </button>
      <button class="bg-gray-500 text-white mx-1 px-4 py-2 rounded hover:bg-gray-600" @click="cancel">
        Cancelar
      </button>

      <p v-if="!room.room_type_id" class="text-red-500 text-sm">Por favor selecciona un tipo de habitación.</p>
      <p v-if="!room.accommodation_id" class="text-red-500 text-sm">Por favor selecciona una acomodación.</p>
      <p v-if="!room.quantity" class="text-red-500 text-sm">Por favor ingresa la cantidad.</p>

    </form>
  </div>
</template>

<script>
import AccommodationService from "@/application/services/AccommodationService";
import AppPreload from "@/components/Preload.vue";
import RoomService from "@/application/services/RoomService";
import RoomTypeService from "@/application/services/RoomTypeService";

export default {
  data() {
    return {
      room: {
        room_type_id: "",
        accommodation_id: "",
        quantity: null,
      },
      accommodations: [],
      loading: true,
      roomTypes: [],
    };
  },
  components: {
    AppPreload,
  },
  computed: {
    isEditing() {
      return this.$route.name === "EditRoom";
    },
    hotelId() {
      return this.$route.params.hotelId;
    },
    roomId() {
      return this.$route.params.roomId;
    },
  },
  mounted() {
    this.initializeComponent();
  },
  methods: {
    async initializeComponent() {
      this.loading = true;
      try {
        await this.fetchRoomTypes();

        if (this.isEditing) {
          await this.loadRoom();
          await this.fetchAccommodations();
        }
      } catch (error) {
        console.error("Error durante la inicialización del componente:", error);
      } finally {
        this.loading = false;
      }
    },

    async loadRoom() {
      try {
        const response = await RoomService.getRoomById(this.roomId);
        this.room = response;

      } catch (error) {
        console.error("Error al cargar la habitación:", error);
      }
    },

    async fetchRoomTypes() {
      try {
        const response = await RoomTypeService.getRoomTypes();
        this.roomTypes = response;
      } catch (error) {
        console.error("Error al cargar los tipos de habitación:", error);
      } 
    },

    async fetchAccommodations() {
      try {
        if (!this.room.room_type_id) {
          this.accommodations = [];
          return;
        }

        const response = await AccommodationService.getAccommodationsByRoomType(
          this.room.room_type_id
        );

        this.accommodations = response.original;
      } catch (error) {
        console.error("Error al cargar las acomodaciones:", error);
      } 
    },

    async handleSubmit() {
      const payload = {
        ...this.room,
        hotel_id: this.hotelId,
      };
      this.loading = true;
      try {
        if (this.isEditing) {
          await RoomService.updateRoom(this.roomId, payload);
        } else {
          await RoomService.addRoom(payload);
        }
        this.$router.push({ name: "HotelDetail", params: { id: this.hotelId } });
      } catch (error) {
        this.loading = false;
        alert('Error al guardar habitación, verifica que sea una acomodación válida o que no hayas excedido la capadida máxima del hotel.');
      } finally {
        this.loading = false;
      }
    },

    cancel() {
      this.$router.push({ name: "HotelDetail", params: { id: this.hotelId } });
    },
  },
};
</script>