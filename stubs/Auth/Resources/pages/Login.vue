<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { defineComponent, ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";

const showPassword = ref(false);
const btnLoading = ref(false);
const form = useForm({
    email: "",
    password: "",
});

defineProps({
    logo: String,
    errors: String,
});

const submitForm = () => {
    btnLoading.value = true;
    form.clearErrors();
    form.post("/auth/login", {
        onSuccess: () => {
            form.reset("password");
            btnLoading.value = false;
        },
    });
};
</script>

<style>
.changeFont {
    font-family: "Titillium Web", sans-serif;
}
</style>

<template>
    <head>
        <title>Login</title>
    </head>

    <form @submit.prevent="submitForm">
        <div class="min-h-screen changeFont flex items-center justify-center">
            <div
                class="border p-5 w-1/2 text-center rounded-xl drop-shadow-lg glass"
            >
                <img :src="logo" alt="Logo" class="mb-3 mx-auto" width="200" />
                <article class="prose">
                    <h1 class="font-bold">L O G I N</h1>

                    <div class="alert alert-error shadow-lg" v-if="errors">
                        <div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="stroke-current flex-shrink-0 h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span>{{ errors }}</span>
                        </div>
                    </div>
                    <div class="form-control mb-3">
                        <label class="label">
                            <span class="label-text text-white">Email</span>
                        </label>
                        <label class="">
                            <input
                                type="email"
                                required
                                v-model="form.email"
                                placeholder="user@ladmin.com"
                                class="text-white input input-bordered w-full"
                            />
                        </label>
                    </div>
                    <div class="form-control mb-3">
                        <label class="label">
                            <span class="label-text text-white">Password</span>
                        </label>
                        <div class="input-group">
                            <input
                                v-model="form.password"
                                required
                                :type="showPassword ? 'text' : 'password'"
                                :placeholder="
                                    !showPassword ? '********' : 'Password'
                                "
                                class="input w-full"
                            />
                            <button
                                type="button"
                                class="btn btn-square"
                                @click="
                                    () => {
                                        showPassword = !showPassword;
                                    }
                                "
                            >
                                <font-awesome-icon
                                    class="text-red-500"
                                    :icon="showPassword ? faEyeSlash : faEye"
                                />
                            </button>
                        </div>
                    </div>
                </article>
                <div class="flex justify-between">
                    <Link href="/auth/register" class="text-white"
                        >Register</Link
                    >
                    <Link href="/auth/forgot-password" class="text-white"
                        >Forgot Password</Link
                    >
                </div>
                <div class="mt-5">
                    <button
                        type="submit"
                        class="btn bg-red-500 btn-block text-white"
                        :disabled="form.processing"
                    >
                        Login
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
