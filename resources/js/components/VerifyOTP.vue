<template>
    <div>
        <form @submit.prevent="verifyOtp">
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input type="text" class="form-control" id="otp" v-model="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['email'],
    data() {
        return {
            otp: '',
        };
    },
    methods: {
        async verifyOtp() {
            try {
                const response = await axios.post('/verify-otp', { email: this.email, otp: this.otp });
                if (response.data.message === 'OTP verified successfully, user logged in') {
                    // Redirect to a different page or show a success message
                    alert('OTP verified successfully, user logged in');
                }
            } catch (error) {
                console.error('Failed to verify OTP:', error);
            }
        },
    },
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style>