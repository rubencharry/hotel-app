<template>
    <div class="flex justify-center items-center my-6">
      <div class="loader border-t-4 border-blue-500 rounded-full w-12 h-12 animate-spin"></div>
    </div>
  </template>
  
  <script>
  export default {
    name: "AppPreload",
  };
  </script>

  
  <style scoped>
  .loader {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top-color: #3490dc;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
  </style>
  