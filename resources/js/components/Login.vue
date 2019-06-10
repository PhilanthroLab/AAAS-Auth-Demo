<template>
    <div class="main">
        <div class="logo">
            <img src="/img/logo_small.png">
        </div>
        <div class="article">
            <div class="question">
                <p class="paragraph">Request Permission</p>
            </div>
        </div>
        <div class="form-box">
            <div class="form">
                <p class="heading">LOGIN TO ACCESS</p>
                <form @submit.prevent="login">
                    <div class="form-group">
                        <label>Email:</label>
                        <input v-model="email" type="email" name="" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input v-model="password" type="password" name="" placeholder="Enter Password" required>
                    </div>
                    <a href="#" class="underline">Forgot Password?</a>
                    <div class="form-footer">
                        <div v-if="message" class="noti"><p>{{message}}</p></div>
                        <button class="blue-btn ld-over-inverse" :class="{running: isLoading}" :disabled="isLoading" type="submit">
                            Login
                            <div class="ld ld-ring ld-spin"></div>
                        </button>
                        <span>OR</span>
                        <router-link to="/register" class="underline">Register</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data: () => ({
            isLoading: false,
            email: '',
            password: '',
            status: '',
            message: ''
        }),
        methods: {
            login () {
                let data = {
                    email: this.email,
                    password: this.password
                }
                this.isLoading = true
                axios.post('/internal-api/login', data)
                    .then(res => {
                        if (res.data.status === 'success') {
                            this.$router.push(`/access-granted`)
                        } else {
                            this.message = res.data.message
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {this.isLoading = false})
            }
        }
    }
</script>

<style scoped>
    .noti {
        text-align: center;
    }

    .noti > p {
        color: red !important;
    }
</style>