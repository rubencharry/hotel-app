<template>
  <div class="p-4 border rounded-lg shadow-md">
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
      <button class="bg-gray-500 text-white mx-1 px-4 py-2 rounded hover:bg-gray-600"  @click.prevent="cancel">
        Cancelar
      </button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    isEditing: {
      type: Boolean,
      default: false,
    },
    initialData: {
      type: Object,
      default: () => ({
        name: "",
        address: "",
        city: "",
        nit: "",
        max_rooms: null,
      }),
    },
  },
  data() {
    return {
      hotel: { ...this.initialData },
      isSubmitting: false,
    };
  },
  methods: {
    async handleSubmit() {
      if (this.isSubmitting) return;

      this.isSubmitting = true; 
      await this.$emit("submit", this.hotel); 
      this.isSubmitting = false; 
    },
    cancel() {
      this.$emit("cancel");
    },
  },
};
</script>
