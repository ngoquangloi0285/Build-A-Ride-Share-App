<template>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div
      class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <a
        href="#"
        class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
      >
        <img
          class="w-8 h-8 mr-2"
          src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
          alt="logo"
        />
        RideShare
      </a>
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <div
          v-if="!waitingOnVerification"
          class="p-6 space-y-4 md:space-y-6 sm:p-8"
        >
          <h1
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
          >
            Enter your phone number
          </h1>
          <div
            v-if="credentials.message"
            class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert"
          >
            <svg
              class="flex-shrink-0 inline w-4 h-4 me-3"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
              />
            </svg>
            <span class="sr-only">Info</span>
            <div>
              <span class="font-medium">Success alert!</span>
              {{ credentials.message }}.
            </div>
          </div>

          <form class="space-y-4 md:space-y-6" @submit.prevent="handleLogin">
            <div>
              <label
                for="phone"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your phone</label
              >
              <input
                v-model="credentials.phone"
                v-maska
                data-maska="#### ### ###"
                type="text"
                inputmode="numeric"
                name="phone"
                id="phone"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="(+84) 0123 456 789"
                required=""
              />
            </div>
            <button
              type="submit"
              @submit.prevent="handleLogin"
              :disabled="credentials.isSubmitting"
              class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
              {{ credentials.isSubmitting ? "Continue..." : "Continue" }}
            </button>
          </form>
        </div>

        <div v-else class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
          >
            Enter your code
          </h1>
          <div
            v-if="credentials.message"
            class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert"
          >
            <svg
              class="flex-shrink-0 inline w-4 h-4 me-3"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
              />
            </svg>
            <span class="sr-only">Info</span>
            <div>
              <span class="font-medium">Success alert!</span>
              {{ credentials.message }}.
            </div>
          </div>

          <form
            class="space-y-4 md:space-y-6"
            @submit.prevent="handleVerification"
          >
            <div>
              <label
                for="login_code"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your Code</label
              >
              <input
                v-model="credentials.login_code"
                v-maska
                data-maska="### ###"
                type="text"
                inputmode="numeric"
                name="login_code"
                id="login_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="123 654"
                required=""
              />
            </div>
            <button
              type="submit"
              @submit.prevent="handleVerification"
              :disabled="credentials.isSubmitting"
              class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
              {{ credentials.isSubmitting ? "Verify..." : "Verify" }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { vMaska } from "maska";
import { onMounted, reactive, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const waitingOnVerification = ref(false);

const localStorage = window.localStorage;

onMounted(() => {
  if (localStorage.getItem("token")) {
    router.push({
      name: "landing",
    });
  }
});

const credentials = reactive({
  phone: null,
  login_code: null,
  message: null,
  isSubmitting: false,
});

const handleLogin = () => {
  credentials.isSubmitting = true;
  axios
    .post("http://127.0.0.1:8000/api/login", {
      phone: credentials.phone.replace(/\s/g, ""),
    })
    .then((response) => {
      if (response.status == 200) {
        credentials.message = response.data.message;
        waitingOnVerification.value = true;
        // Reset giá trị sau 5 giây (hoặc thời gian bạn muốn)
        setTimeout(() => {
          credentials.message = null;
        }, 5000); // Reset sau 5 giây
      }
    })
    .catch((err) => {
      console.log(err);
      alert(err.response.data.message);
    })
    .finally(() => {
      // Kết thúc thực hiện, set trạng thái về false
      credentials.isSubmitting = false;
    });
};

const handleVerification = () => {
  credentials.isSubmitting = true;
  axios
    .post("http://127.0.0.1:8000/api/login/verify", {
      phone: credentials.phone.replace(/\s/g, ""),
      login_code: credentials.login_code.replace(/\s/g, ""),
    })
    .then((response) => {
      if (response.status == 200) {
        credentials.message = response.data.message;
        waitingOnVerification.value = true;
        // console.log(response.data.token);
        localStorage.setItem("token", response.data.token);
        router.push({
          name: "landing",
        });

        // Reset giá trị sau 5 giây (hoặc thời gian bạn muốn)
        setTimeout(() => {
          credentials.message = null;
        }, 5000); // Reset sau 5 giây
      }
    })
    .catch((err) => {
      console.log(err);
      alert(err.response.data.message);
    })
    .finally(() => {
      // Kết thúc thực hiện, set trạng thái về false
      credentials.isSubmitting = false;
    });
};
</script>

<style scoped></style>
