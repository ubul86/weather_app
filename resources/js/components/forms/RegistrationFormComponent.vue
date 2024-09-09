<template>
    <div>
        <v-form @submit.prevent="registration">
            <v-text-field
                v-model="user.name"
                label="Name"
                required
            ></v-text-field>
            <v-text-field
                v-model="user.email"
                label="Email"
                required
            ></v-text-field>
            <v-text-field
                v-model="user.password"
                label="Password"
                type="password"
                required
            ></v-text-field>
            <v-card-actions>
                <v-btn color="primary" type="submit">Registration</v-btn>
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
                name: "",
                email: "",
                password: "",
            },
        };
    },
    computed: {
        ...mapState(["isAuthenticated"]),
    },
    methods: {
        async registration() {
            try {
                await this.$store.dispatch("registration", this.user);
                this.$emit("close-auth-popup");
            } catch (error) {
                console.error("Registration error:", error);
            }
        },
    },
};
</script>
