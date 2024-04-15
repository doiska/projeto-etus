<script setup lang="ts">
import Input from "./components/input.vue";
import { ref } from "vue";

const formStatus = ref<{
  status: "idle" | "pending"
} | {
  status: "success" | "error";
  message: string;
}>({
  status: "idle"
});

async function onSubmit(event: Event) {
  if (!(event instanceof SubmitEvent)) {
    return;
  }

  event.preventDefault();

  if (!event.target) {
    return;
  }

  const formData = new FormData(event.target as HTMLFormElement);
  const email = formData.get("email");

  if (!email) {
    return;
  }

  formStatus.value = {
    status: "pending"
  };

  const result = await fetch("http://localhost/api/subscribe", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    body: JSON.stringify({
      email
    })
  });

  const response = await result.json();
  const hasErrors = "errors" in response;

  if (!result.ok || hasErrors) {
    formStatus.value = {
      status: "error",
      message: response.message || "Ocorreu um erro inesperado, tente novamente mais tarde."
    };
    return;
  }

  formStatus.value = {
    status: "success",
    message: response.message || "Seu email foi cadastrado com sucesso, bem vindo (a)!"
  };
}

</script>

<template>
  <div
      class="relative min-h-screen flex flex-col items-center justify-center bg-[#5b3a89] overflow-hidden"
  >
    <main class="flex flex-col size-full items-center">
      <form
          @submit="onSubmit"
          class="relative flex flex-col items-center gap-2 p-8 md:p-24 rounded shadow-2xl border-white border-2 w-full max-w-2xl bg-[#43296d]"
      >
        <div class="flex justify-center items-center h-32 w-48 overflow-hidden">
          <img
              src="https://etus.com.br/img/logo-etus-social-site.webp"
              class="size-full object-contain"
              alt="etus social logo"
          />
        </div>
        <span class="text-white my-2 p-2 font-medium bg-[#bf4574] rounded text-center">
          Participe de nossa comunidade e receba dicas sobre como alavancar seu perfil nas redes sociais!
        </span>
        <div class="flex flex-col gap-2 my-4 w-full">
          <label class="text-white" for="email">
            Email
          </label>
          <Input
              id="email"
              name="email"
              type="email"
              placeholder="Use o seu melhor email!"
              required="required"
          />
          <button
              class="bg-[#bf4574] text-white py-2 px-4 inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
              :disabled="formStatus.status === 'pending'"
          >
            Quero fazer parte!
          </button>
        </div>
        <img
            alt="background shape"
            src="https://etus.com.br/img/shape1.webp"
            class="absolute -bottom-24 left-0"
        />
        <img
            alt="background shape"
            src="https://etus.com.br/img/shape1.webp"
            class="absolute -bottom-24 -right-2 -scale-x-100"
        />
        <div
            class="bg-[#5b3a89] rounded p-2 border-purple-500 shadow text-white"
            v-if="formStatus.status === 'error' || formStatus.status === 'success'"
        >
          <span class="font-medium text-sm">{{ formStatus.message }}</span>
        </div>
      </form>
    </main>
    <span class="absolute top-10 text-white p-2 text-center underline underline-offset-4">
      Este é apenas um site demonstrativo e não possui qualquer relação com a Etus.
    </span>
  </div>
</template>
