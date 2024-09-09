<template>
    <div>
        <v-form @submit.prevent="login">
            <v-text-field
                v-model="user.username"
                label="Username"
                required
            ></v-text-field>
            <v-text-field
                v-model="user.password"
                label="Password"
                type="password"
                required
            ></v-text-field>
            <v-card-actions>
                <v-btn color="primary" type="submit">Login</v-btn>
            </v-card-actions>
        </v-form>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    data() {
        return {
            user: {
                username: "",
                password: "",
            },
        };
    },
    computed: {
        ...mapState(["isAuthenticated"]),
    },
    methods: {
        async login() {
            try {
                await this.$store.dispatch("login", this.user);
                this.$emit("close-auth-popup");
            } catch (error) {
                console.error("Login error:", error);
            }
        },

        close() {
            this.dialog = false;
        },
    },
};
</script>
