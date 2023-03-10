<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { defineComponent, ref } from "vue";

defineProps({
    logo: String,
    errors: Boolean,
    success: Boolean,
});

const form = useForm({
    email: "",
});

const submitForm = () => {
    form.post("/auth/forgot-password");
};
</script>

<style>
.changeFont {
    font-family: "Titillium Web", sans-serif;
}
</style>

<template>
    <head>
        <title>Forgot Password</title>
    </head>

    <form @submit.prevent="submitForm">
        <div class="min-h-screen changeFont flex items-center justify-center">
            <div
                class="border p-5 w-1/2 text-center rounded-xl drop-shadow-lg glass"
            >
                <img :src="logo" alt="Logo" class="mb-3 mx-auto" width="200" />
                <article class="prose mb-5">
                    <h1 class="font-bold">FORGOT PASSWORD</h1>
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
                            <span
                                >These Credentials do not match our
                                records.</span
                            >
                        </div>
                    </div>
                    <div class="alert alert-success shadow-lg" v-if="success">
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
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span
                                >Your password reset link has been sent to your
                                email.</span
                            >
                        </div>
                    </div>
                    <div class="form-control mb-3">
                        <label class="label">
                            <span class="label-text text-white">Email</span>
                        </label>
                        <label class="">
                            <input
                                required
                                type="text"
                                placeholder="user@ladmin.com"
                                class="text-white input input-bordered w-full"
                                v-model="form.email"
                            />
                        </label>
                    </div>
                </article>
                <div class="flex justify-between">
                    <Link href="/auth/login" class="text-white">Login</Link>
                    <Link href="/auth/register" class="text-white"
                        >Register</Link
                    >
                </div>
                <div class="mt-5">
                    <button
                        type="submit"
                        class="btn bg-red-500 btn-block text-white"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
