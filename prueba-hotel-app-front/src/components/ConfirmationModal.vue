<template>
    <div
      v-if="visible"
      class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
    >
      <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4 text-gray-800">{{ title }}</h2>
        <p class="text-gray-600 mb-6">{{ message }}</p>
        <div class="flex justify-end gap-4">
          <button
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            @click="cancel"
          >
            Cancelar
          </button>
          <button
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            @click="confirm"
          >
            Confirmar
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      visible: {
        type: Boolean,
        required: true,
      },
      title: {
        type: String,
        default: "Confirmar acción",
      },
      message: {
        type: String,
        default: "¿Estás seguro de realizar esta acción?",
      },
    },
    methods: {
      confirm() {
        this.$emit("confirm");
      },
      cancel() {
        this.$emit("cancel");
      },
    },
  };
  </script>
  