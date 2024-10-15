<template>
    <div>
        <form @submit.prevent="sendOtp">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" v-model="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
        };
    },
    methods: {
        async sendOtp() {
            try {
                const response = await axios.post('/send-otp', { email: this.email });
                if (response.data.message === 'OTP sent successfully') {

                    
                    this.$router.push({ name: 'VerifyOtp', params: { email: this.email } });
                }
            } catch (error) {
                console.error('Failed to send OTP:', error);
            }
        },
    },
};
</script>