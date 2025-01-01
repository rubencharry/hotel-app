<template>
  <div class="p-4">
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
        <tr
          v-for="hotel in hoteles"
          :key="hotel.id"
          class="hover:bg-gray-50 even:bg-gray-100"
        >
          <td class="border px-4 py-2 text-gray-600">{{ hotel.name }}</td>
          <td class="border px-4 py-2 text-gray-600">{{ hotel.nit }}</td>
          <td class="border px-4 py-2 text-gray-600">{{ hotel.city }}</td>
          <td class="border px-4 py-2 text-gray-600 text-center">{{ hotel.max_rooms }}</td>
          <td class="border px-4 py-2 text-center">
            <button
              class="bg-blue-500 text-white px-2 py-1 my-2 rounded hover:bg-blue-600"
              @click="$emit('edit', hotel)"
            >
              Editar
            </button>
            <button
              class="bg-red-500 text-white px-2 py-1 my-2 rounded ml-2 hover:bg-red-600"
              @click="$emit('delete', hotel.id)"
            >
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- <p v-else class="text-gray-500">No hay hoteles disponibles.</p> -->
  </div>
</template>

<script>
import HotelService from "@/application/services/HotelService";

export default {
  data() {
    return {
      hoteles: [], 
      error: null, 
    };
  },
  created() {
    this.loadHotels();
  },
  methods: {
    async loadHotels() {
      try {
        this.hoteles = await HotelService.fetchHotels();
        this.error = null;
      } catch (error) {
        console.error("Error al cargar los hoteles:", error);
        this.error = "No se pudo cargar la lista de hoteles.";
      }
    },

  },
};
</script>

