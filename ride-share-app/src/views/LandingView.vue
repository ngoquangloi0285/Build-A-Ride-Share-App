<template>
  <div
    class="flex flex-col items-center justify-center px-6 py-8 mx-auto"
  >
    <h1 class="text-black text-3xl font-semibold mb-4">RideShare</h1>
    <div class="overflow-hidden shadow rounded-md mx-auto">
      <div class="bg-white px-4 p-6">
        <div class="flex justify-between gap-10">
          <button
            type="button"
            class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
          >
            Start Driving
          </button>
          <button
            type="button"
            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
          >
            Find A Ride
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup></script>

<style scoped>

button {
    margin: 0;
}

</style>
