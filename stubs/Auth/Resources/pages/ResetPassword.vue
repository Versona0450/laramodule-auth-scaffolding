<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { ref } from "vue";
import { faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";

defineProps({
    logo: String,
    errors: Object,
    token: String,
});

const form = useForm({
    password: "",
    password_confirmation: "",
});

const submitForm = (token) => {
    if (form.password !== form.password_confirmation) {
        passwordErr.value = true;
        return;
    }
    form.clearErrors();
    form.post(`/auth/reset-password/${token}`);
};

const passwordErr = ref(false);
const showPassword = ref(false);
const showPasswordConfirm = ref(false);
</script>

<style>
.changeFont {
    font-family: "Titillium Web", sans-serif;
}
</style>

<template>
    <head>
        <title>Reset Password</title>
    </head>

    <form @submit.prevent="submitForm(token)">
        <div class="min-h-screen changeFont flex items-center justify-center">
            <div
                class="border p-5 w-1/2 text-center rounded-xl drop-shadow-lg glass"
            >
                <img :src="logo" alt="Logo" class="mb-3 mx-auto" width="200" />
                <article class="prose mb-5">
                    <h1 class="font-bold">RESET PASSWORD</h1>
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
