<template>
  <AppPreload v-if="loading" />
  <div v-else class="p-4">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Lista de Hoteles</h1>

    <!-- Mensaje de error si no se pueden cargar los hoteles -->
    <div v-if="error" class="text-red-500 mb-4">
      Error al cargar los hoteles: {{ error }}
    </div>

    <!-- Tabla de hoteles -->
    <table v-if="hoteles.length" class="table-auto w-full border border-gray-300 shadow-sm rounded-lg">
      <thead>
        <tr class="bg-gray-100 text-gray-700">
          <th class="px-4 py-2 border border-gray-300">Nombre</th>
          <th class="px-4 py-2 border border-gray-300">NIT</th>
          <th class="px-4 py-2 border border-gray-300">Ciudad</th>
          <th class="px-4 py-2 border border-gray-300">Num. de habitaciones</th>
          <th class="px-4 py-2 border border-gray-300">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="hotel in hoteles" :key="hotel.id" class="hover:bg-gray-50 even:bg-gray-100">
          <td class="border px-4 py-2 text-gray-600">{{ hotel.name }}</td>
          <td class="border px-4 py-2 text-gray-600">{{ hotel.nit }}</td>
          <td class="border px-4 py-2 text-gray-600">{{ hotel.city }}</td>
          <td class="border px-4 py-2 text-gray-600 text-center">{{ hotel.max_rooms }}</td>
          <td class="border px-4 py-2 text-center">
            <button @click="editHotel(hotel.id)"
              class="bg-blue-500 text-white px-2 py-1 my-1 rounded ml-2 hover:bg-blue-600">
              Editar
            </button>
            <button @click="showDeleteConfirmation(hotel.id)"
              class="bg-red-500 text-white px-2 py-1 my-1 rounded ml-2 hover:bg-red-600">
              Eliminar
            </button>
            <button @click="viewDetail(hotel.id)"
              class="bg-yellow-500 text-white px-2 py-1 my-1 rounded ml-2 hover:bg-yellow-600">
              Ver detalle
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Botón para agregar hotel -->
    <button class="bg-green-500 text-white px-4 py-2 my-3 rounded hover:bg-green-600 mb-4" @click="createHotel()">
      Crear Hotel
    </button>

    <!-- Modal de confirmación -->
    <ConfirmationModal v-if="showModal" :visible="showModal" title="Confirmación de Eliminación"
      :message="'¿Estás seguro de que deseas eliminar este hotel?'" @confirm="deleteHotel" @cancel="closeModal" />
  </div>
</template>

<script>

import AppPreload from "@/components/Preload.vue";
import ConfirmationModal from "@/components/ConfirmationModal.vue";
import HotelService from "@/application/services/HotelService";

export default {
  data() {
    return {
      error: null,
      hoteles: [],
      hotelToDelete: null,
      loading: true,
      showModal: false,
    };
  },
  components: {
    ConfirmationModal,
    AppPreload,
  },
  created() {
    this.loadHotels();
  },
  methods: {
    async loadHotels() {
      this.loading = true;
      try {
        this.hoteles = await HotelService.fetchHotels();
        this.error = null;
      } catch (error) {
        console.error("Error al cargar los hoteles:", error);
        this.error = "No se pudo cargar la lista de hoteles.";
      } finally{
        this.loading = false;
      }
    },
    createHotel() {
      try {
    this.$router.push({ name: "CreateHotel" });
    } catch (error) {
      console.error("Error al redirigir a CreateHotel:", error);
    }
    },
    viewDetail(hotelId) {
      this.$router.push({ name: "HotelDetail", params: { id: hotelId } });
    },
    editHotel(hotelId) {
      this.$router.push({ name: "EditHotel", params: { id: hotelId } });
    },

    async deleteHotel() {
      console.log("Eliminando hotel con ID:", this.hotelToDelete);
      try {
        await HotelService.deleteHotel(this.hotelToDelete);
        this.hoteles = this.hoteles.filter(hotel => hotel.id !== this.hotelToDelete);
        this.closeModal();
      } catch (error) {
        console.error("Error al eliminar el hotel:", error);
      }
    },

    showDeleteConfirmation(hotelId) {
      console.log("ID del hotel:", hotelId);
      console.log("Estado de showModal:", this.showModal);
      this.hotelToDelete = hotelId;
      this.showModal = true;
    },

    closeModal() {
      console.log("Cerrando el modal");
      this.showModal = false;
      this.hotelToDelete = null;
    },

  },
  mounted() {
    this.loadHotels();
  },
};
</script>
