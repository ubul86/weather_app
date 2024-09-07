<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="8" class="text-center">
                <v-card>
                    <v-card-title>{{ message }}</v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

import authService from "@/services/auth.service.js";
export default {
    data() {
        return {
            message: 'Activating your account...',
        };
    },
    created() {
        const token = this.$route.params.token;
        const response = authService.activation(token);

        console.log(response);

    },
};
</script>
