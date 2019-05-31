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
                <p class="heading">REGISTER TO ACCESS</p>
                <form @submit.prevent="register">
                    <div class="form-group">
                        <label>Full Name:</label>
                        <div class="input-group">
                            <input v-model="firstname" type="text" name="" placeholder="First Name" required>
                            <input v-model="lastname" type="text" name="" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input v-model="email" type="email" name="" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input v-model="password" type="password" name="" placeholder="Enter Password">
                    </div>
                    <div class="form-footer">
                        <div v-if="message && status === 'error'" class="noti red"><p>{{message}}</p></div>
                        <div v-if="message && status === 'success'" class="noti green"><p>{{message}}</p></div>
                        <button class="blue-btn ld-over-inverse" :class="{running: isLoading}" :disabled="isLoading" type="submit">
                            Register
                            <div class="ld ld-ring ld-spin"></div>
                        </button>
                        <span>OR</span>
                        <router-link to="login" class="underline">Login</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register.vue",
        data: () => ({
            isLoading: false,
            firstname: '',
            lastname: '',
            email: '',
            password: '',
            status: '',
            message: ''
        }),
        methods: {
            register () {
                let data = {
                    first_name: this.firstname,
                    last_name: this.lastname,
                    email: this.email,
                    password: this.password
                }
                this.isLoading = true
                axios.post('/internal-api/register', data)
                    .then(res => {
                        this.status = res.data.status
                        this.message = res.data.message

                        if (res.data.status === 'success') {
                            this.$router.push('/access-granted')
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

    .noti.red > p {
        color: red !important;
    }

    .noti.green > p {
        color: green !important;
    }
</style>