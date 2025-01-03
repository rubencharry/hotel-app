<template>
  <AppPreload v-if="loading" />

  <div v-else class="p-4 border rounded-lg shadow-md">
    <h2 class="text-lg font-bold mb-4">{{ isEditing ? "Editar Hotel" : "Agregar Hotel" }}</h2>
    <form @submit.prevent="handleSubmit" class="my-4">
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">Nombre</label>
        <input v-model="hotel.name" type="text" class="border px-4 py-2 w-full rounded" placeholder="Nombre del hotel"
          required />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">Dirección</label>
        <input v-model="hotel.address" type="text" class="border px-4 py-2 w-full rounded" placeholder="Dirección"
          required />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">Ciudad</label>
        <input v-model="hotel.city" type="text" class="border px-4 py-2 w-full rounded" placeholder="Ciudad" required />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">NIT</label>
        <input v-model="hotel.nit" type="text" class="border px-4 py-2 w-full rounded" placeholder="NIT" required />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">Número Máximo de Habitaciones</label>
        <input v-model="hotel.max_rooms" type="number" class="border px-4 py-2 w-full rounded"
          placeholder="Número máximo de habitaciones" required />
      </div>
      <button type="submit" class="bg-green-500 text-white mx-1 px-4 py-2 rounded hover:bg-green-600">
        {{ isEditing ? "Actualizar" : "Guardar" }}
      </button>
      <button class="bg-gray-500 text-white mx-1 px-4 py-2 rounded hover:bg-gray-600"  @click="cancel">
        Cancelar
      </button>
    </form>
  </div>
</template>

<script>
import AppPreload from "@/components/Preload.vue";
import HotelService from "@/application/services/HotelService";

export default {
  data() {
    return {
      hotel: {
        name: "",
        address: "",
        city: "",
        nit: "",
        max_rooms: null,
      },
      loading: true, 
    };
  },
  components: {
    AppPreload,
  },
  computed: {
    isEditing() {
      return this.$route.name === "EditHotel";
    },
  },
  mounted() {
    if (this.isEditing) {
      this.loadHotel();
    }else{
      this.loading = false;
    }
  },
  methods: {
    async loadHotel() {
      this.loading = true; 
      const hotelId = this.$route.params.id;
      try {
        const hotel = await HotelService.getHotelById(hotelId);
        this.hotel = { ...hotel };
      } catch (error) {
        console.error("Error al cargar el hotel:", error);
      }finally{
        this.loading = false; 
      }
    },
    async handleSubmit() {
      this.loading = true; 
      try {
        if (this.isEditing) {
          await HotelService.updateHotel(this.$route.params.id, this.hotel);
        } else {
          await HotelService.addHotel(this.hotel);
        }
        this.$router.push({ name: "HotelList" });
      } catch (error) {
        console.error("Error al guardar el hotel:", error);
        alert("Verifica que no exista un hotel ya registrado con este nombre o NIT.");
      } finally{
        this.loading = false; 
      }
    },
    cancel() {
      this.$router.push({ name: "HotelList" });
    },
  },
};
</script>
