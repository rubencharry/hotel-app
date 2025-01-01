<template>
  <div id="app" class="container mx-auto">

    <!-- Mostrar el listado si no estamos agregando o editando -->
    <HotelList v-if="!isAdding && !isEditing" ref="hotelList" :hoteles="hoteles" @edit="startEditing"
      @delete="showDeleteConfirmation" />

    <!-- Botón para agregar hotel -->
    <button v-if="!isAdding && !isEditing" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4"
      @click="startAdding">
      Crear Hotel
    </button>

    <!-- Formulario para agregar/editar -->
    <HotelForm v-if="isAdding || isEditing" :isEditing="isEditing" :initialData="currentHotel"
      @submit="handleFormSubmit" @cancel="cancelEditingOrAdding" class="my-4"/>

    <!-- Modal de confirmación para eliminar -->
    <ConfirmationModal v-if="isConfirmingDelete" :visible="isConfirmingDelete" title="Eliminar Hotel"
      :message="`¿Estás seguro de eliminar el hotel seleccionado?`" @confirm="deleteHotel" @cancel="cancelDelete" />
  </div>
</template>

<script>
import HotelList from "./components/HotelList.vue";
import HotelForm from "./components/HotelForm.vue";
import ConfirmationModal from "./components/ConfirmationModal.vue";
import HotelService from "@/application/services/HotelService";

export default {
  components: {
    HotelList,
    HotelForm,
    ConfirmationModal,
  },
  data() {
    return {
      hoteles: [],
      isAdding: false,
      isEditing: false,
      isConfirmingDelete: false,
      currentHotel: null,
      hotelToDelete: null,
    };
  },
  methods: {

    startAdding() {
      this.isAdding = true;
      this.isEditing = false;
      this.currentHotel = null;
    },

    startEditing(hotel) {
      this.isAdding = false;
      this.isEditing = true;
      this.currentHotel = { ...hotel };
    },

    async handleFormSubmit(hotel) {
      try {
        if (this.isSubmitting) return;
        this.isSubmitting = true;

        if (this.isEditing) {
          await HotelService.updateHotel(hotel.id, hotel);
        } else {
          await HotelService.addHotel(hotel);
        }

        this.isAdding = false;
        this.isEditing = false;
        this.currentHotel = null;
      } catch (error) {
        console.error("Error al guardar el hotel:", error);
      } finally {
        this.isSubmitting = false;
      }
    },

    showDeleteConfirmation(id) {
      this.isConfirmingDelete = true;
      this.hotelToDelete = id;
    },

    async deleteHotel() {
      try {
        await HotelService.deleteHotel(this.hotelToDelete);
        this.hotelToDelete = null;
        this.isConfirmingDelete = false;
        this.reloadHotels();
      } catch (error) {
        console.error("Error al eliminar el hotel:", error);
      }
    },

    cancelDelete() {
      this.isConfirmingDelete = false;
      this.hotelToDelete = null;
    },

    cancelEditingOrAdding() {
      this.isAdding = false;
      this.isEditing = false;
      this.currentHotel = null;
    },

    reloadHotels() {
      this.$refs.hotelList.loadHotels();
    },

  },

};
</script>

<style>
.container {
  max-width: 800px;
  margin: 0 auto;
}
</style>
