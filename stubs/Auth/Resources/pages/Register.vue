<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import { defineComponent, reactive, ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";

defineProps({
    logo: String,
    errors: Object,
});
const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submitForm = () => {
    btnLoading.value = true;
    if (form.password !== form.password_confirmation) {
        passwordErr.value = true;
        btnLoading.value = false;
        return;
    }
    passwordErr.value = false;

    form.clearErrors();
    form.post("/auth/register", {
        onSuccess: () => {
            form.reset("password");
            form.reset("password_confirmation");
            btnLoading.value = false;
        },
    });
};

const passwordErr = ref(false);
const showPassword = ref(false);
const showPasswordConfirm = ref(false);
const btnLoading = ref(false);
</script>

<style>
.changeFont {
    font-family: "Titillium Web", sans-serif;
}
</style>

<template>
    <head>
        <title>Register</title>
    </head>
    <form @submit.prevent="submitForm">
        <div class="min-h-screen changeFont flex items-center justify-center">
            <div
                class="border p-5 w-1/2 text-center rounded-xl drop-shadow-lg glass"
            >
                <img :src="logo" alt="Logo" class="mb-3 mx-auto" width="200" />

                <article class="prose">
                    <h1 class="font-bold">R E G I S T E R</h1>
                    <div class="flex justify-content-between">
                        <div class="form-control w-1/2 m-1 mb-3">
                            <label class="label">
                                <span class="label-text text-white">Nama</span>
                            </label>
                            <label class="">
                                <input
                                    type="text"
                                    required
                                    placeholder="Jhon Doe"
                                    class="input input-bordered w-full"
                                    v-model="form.name"
                                />
                            </label>
                            <div v-if="errors" class="text-red-500">
                                {{ errors.name ? errors.name[0] : "" }}
                            </div>
                        </div>
                        <div class="form-control w-1/2 m-1 mb-3">
                            <label class="label">
                                <span class="label-text text-white">Email</span>
                            </label>
                            <label class="">
                                <input
                                    type="email"
                                    required
                                    placeholder="user@ladmin.com"
                                    class="input input-bordered w-full"
                                    v-model="form.email"
                                />
                            </label>
                            <div v-if="errors" class="text-red-500">
                                {{ errors.email ? errors.email[0] : "" }}
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-content-between">
                        <div class="form-control w-1/2 m-1 mb-3">
                            <label class="label">
                                <span class="label-text text-white"
                                    >Password</span
                                >
                            </label>
                            <div class="input-group">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    :placeholder="
                                        !showPassword ? '********' : 'Password'
                                    "
                                    class="input w-full"
                                    :class="passwordErr ? 'input-error' : ''"
                                    v-model="form.password"
                                />
                                <button
                                    class="btn btn-square"
                                    type="button"
                                    @click="
                                        () => {
                                            showPassword = !showPassword;
                                        }
                                    "
                                >
                                    <font-awesome-icon
                                        class="text-red-500"
                                        :icon="
                                            showPassword ? faEyeSlash : faEye
                                        "
                                    />
                                </button>
                            </div>
                            <div class="text-red-500" v-if="errors">
                                {{ errors.password ? errors.password[0] : "" }}
                            </div>
                        </div>
                        <div class="form-control w-1/2 m-1 mb-3">
                            <label class="label">
                                <span class="label-text text-white"
                                    >Confirm Password</span
                                >
                            </label>
                            <div class="input-group">
                                <input
                                    required
                                    :type="
                                        showPasswordConfirm
                                            ? 'text'
                                            : 'password'
                                    "
                                    :placeholder="
                                        !showPasswordConfirm
                                            ? '********'
                                            : 'Password'
                                    "
                                    class="input w-full"
                                    :class="passwordErr ? 'input-error' : ''"
                                    v-model="form.password_confirmation"
                                />
                                <button
                                    class="btn btn-square"
                                    type="button"
                                    @click="
                                        () => {
                                            showPasswordConfirm =
                                                !showPasswordConfirm;
                                        }
                                    "
                                >
                                    <font-awesome-icon
                                        class="text-red-500"
                                        :icon="
                                            showPasswordConfirm
                                                ? faEyeSlash
                                                : faEye
                                        "
                                    />
                                </button>
                            </div>
                            <div class="text-red-500" v-if="errors">
                                {{
                                    errors.password_confirmation
                                        ? errors.password_confirmation[0]
                                        : ""
                                }}
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="passwordErr"
                        class="text-red-500 text-sm font-bold"
                    >
                        Password doesn't match
                    </div>
                </article>
                <div class="flex justify-between">
                    <Link href="/auth/login" class="text-white">Login</Link>
                </div>
                <div class="mt-5">
                    <button
                        class="btn bg-red-500 text-white btn-block"
                        :disabled="form.processing"
                        type="submit"
                    >
                        Register
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
